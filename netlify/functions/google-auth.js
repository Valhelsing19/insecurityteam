const jwt = require('jsonwebtoken');
const { OAuth2Client } = require('google-auth-library');
const { getSupabaseClient } = require('./supabase');

const client = new OAuth2Client(process.env.GOOGLE_CLIENT_ID);

exports.handler = async (event, context) => {
  // Handle CORS preflight
  if (event.httpMethod === 'OPTIONS') {
    return {
      statusCode: 200,
      headers: {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Headers': 'Content-Type',
        'Access-Control-Allow-Methods': 'POST, OPTIONS'
      },
      body: ''
    };
  }

  if (event.httpMethod !== 'POST') {
    return {
      statusCode: 405,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ error: 'Method Not Allowed' })
    };
  }

  // Validate required environment variables
  if (!process.env.GOOGLE_CLIENT_ID) {
    return {
      statusCode: 500,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({ error: 'GOOGLE_CLIENT_ID environment variable is not set' })
    };
  }

  if (!process.env.JWT_SECRET) {
    return {
      statusCode: 500,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({ error: 'JWT_SECRET environment variable is not set' })
    };
  }

  try {
    // Parse request body with error handling
    let body;
    try {
      body = JSON.parse(event.body || '{}');
    } catch (parseError) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Invalid request format. Expected JSON.' })
      };
    }

    const { token, isOfficial = false } = body;

    if (!token || typeof token !== 'string') {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Google token is required and must be a string' })
      };
    }

    // Verify Google token with timeout
    let ticket;
    try {
      ticket = await Promise.race([
        client.verifyIdToken({
          idToken: token,
          audience: process.env.GOOGLE_CLIENT_ID
        }),
        new Promise((_, reject) => 
          setTimeout(() => reject(new Error('Google token verification timeout')), 10000)
        )
      ]);
    } catch (verifyError) {
      console.error('Google token verification error:', verifyError);
      let errorMsg = 'Failed to verify Google token';
      if (verifyError.message && verifyError.message.includes('audience')) {
        errorMsg = 'Invalid Google token. Please sign in again.';
      } else if (verifyError.message && verifyError.message.includes('expired')) {
        errorMsg = 'Google token has expired. Please sign in again.';
      } else if (verifyError.message && verifyError.message.includes('timeout')) {
        errorMsg = 'Token verification timed out. Please try again.';
      }
      return {
        statusCode: 401,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: errorMsg })
      };
    }

    const payload = ticket.getPayload();
    
    // Validate required fields from Google payload
    if (!payload) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Invalid Google token payload' })
      };
    }

    const { email, name, picture, sub: googleId } = payload;

    if (!email || !googleId) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Missing required information from Google account' })
      };
    }

    const supabase = getSupabaseClient();

    // Check if user exists
    const { data: users, error: queryError } = await supabase
      .from('users')
      .select('*')
      .eq('email', email)
      .limit(1);

    if (queryError) {
      console.error('Database query error:', queryError);
      return {
        statusCode: 500,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Database query failed. Please try again.' })
      };
    }

    let user;

    if (!users || users.length === 0) {
      // Create new user
      const { data: result, error: insertError } = await supabase
        .from('users')
        .insert([{
          name: name || email.split('@')[0],
          email,
          google_id: googleId,
          picture: picture || null,
          is_official: isOfficial
        }])
        .select()
        .single();

      if (insertError) {
        console.error('User creation error:', insertError);
        let errorMsg = 'Failed to create user account';
        if (insertError.code === '23505') { // PostgreSQL unique violation
          errorMsg = 'An account with this email already exists.';
        }
        return {
          statusCode: 500,
          headers: {
            'Content-Type': 'application/json',
            'Access-Control-Allow-Origin': '*'
          },
          body: JSON.stringify({ error: errorMsg })
        };
      }

      user = result;
    } else {
      // Update existing user with Google ID if not set
      user = users[0];
      if (!user.google_id) {
        const { error: updateError } = await supabase
          .from('users')
          .update({ 
            google_id: googleId, 
            picture: picture || null 
          })
          .eq('id', user.id);

        if (updateError) {
          console.error('User update error:', updateError);
          // Continue anyway - user exists, just couldn't update Google ID
        } else {
          user.google_id = googleId;
          user.picture = picture || null;
        }
      }
    }

    // Get full user profile including phone/address from database
    const { data: fullUserProfile, error: profileError } = await supabase
      .from('users')
      .select('phone, address, unit, phone_number, unit_apt')
      .eq('id', user.id)
      .single();

    // Generate JWT token
    const jwtToken = jwt.sign(
      {
        id: user.id,
        email: user.email,
        isOfficial: user.is_official === true
      },
      process.env.JWT_SECRET,
      { expiresIn: '7d' }
    );

    return {
      statusCode: 200,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({
        success: true,
        token: jwtToken,
        user: {
          id: user.id,
          email: user.email,
          name: user.name,
          picture: user.picture,
          phone: fullUserProfile?.phone || fullUserProfile?.phone_number || null,
          address: fullUserProfile?.address || null,
          unit: fullUserProfile?.unit || fullUserProfile?.unit_apt || null,
          isOfficial: user.is_official === true
        }
      })
    };
  } catch (error) {
    console.error('Google auth error:', error);
    
    // Provide more specific error messages
    let errorMessage = 'Authentication failed';
    
    if (error.message) {
      errorMessage = error.message;
    }
    
    return {
      statusCode: 500,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({ 
        error: errorMessage,
        details: process.env.NODE_ENV === 'development' ? error.stack : undefined
      })
    };
  }
};

