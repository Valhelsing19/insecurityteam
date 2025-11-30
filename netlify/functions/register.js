const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const { getSupabaseClient } = require('./supabase');

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

  // Only allow POST requests
  if (event.httpMethod !== 'POST') {
    return {
      statusCode: 405,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({ error: 'Method Not Allowed' })
    };
  }

  // Validate required environment variables
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

    const {
      first_name,
      last_name,
      username,
      email,
      phone,
      password,
      address
    } = body;

    // Validate required fields
    if (!first_name || !last_name || !username || !email || !phone || !password || !address) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'All fields are required' })
      };
    }

    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Invalid email format' })
      };
    }

    // Validate password length
    if (password.length < 6) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Password must be at least 6 characters long' })
      };
    }

    const supabase = getSupabaseClient();

    // Check if email already exists
    const { data: existingEmail, error: emailError } = await supabase
      .from('users')
      .select('id')
      .eq('email', email)
      .limit(1);

    if (emailError) {
      throw emailError;
    }

    if (existingEmail && existingEmail.length > 0) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Email already registered' })
      };
    }

    // Check if username already exists
    const { data: existingUsername, error: usernameError } = await supabase
      .from('users')
      .select('id')
      .eq('username', username)
      .limit(1);

    if (usernameError) {
      throw usernameError;
    }

    if (existingUsername && existingUsername.length > 0) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Username already taken' })
      };
    }

    // Hash password
    let hashedPassword;
    try {
      hashedPassword = await bcrypt.hash(password, 10);
    } catch (hashError) {
      console.error('Password hashing error:', hashError);
      return {
        statusCode: 500,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Failed to process password. Please try again.' })
      };
    }

    // Insert new user
    const { data: result, error: insertError } = await supabase
      .from('users')
      .insert([{
        name: `${first_name} ${last_name}`,
        username,
        email,
        phone,
        password: hashedPassword,
        address,
        is_official: false
      }])
      .select()
      .single();

    if (insertError) {
      console.error('User insertion error:', insertError);
      let errorMsg = 'Failed to create account. Please try again.';
      if (insertError.code === '23505') { // PostgreSQL unique violation
        errorMsg = 'Email or username already exists.';
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

    // Generate JWT token
    let token;
    try {
      token = jwt.sign(
        { 
          id: result.id, 
          email: email, 
          isOfficial: false 
        },
        process.env.JWT_SECRET,
        { expiresIn: '7d' }
      );
    } catch (jwtError) {
      console.error('JWT generation error:', jwtError);
      return {
        statusCode: 500,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Failed to generate authentication token. Please try again.' })
      };
    }

    return {
      statusCode: 201,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({
        success: true,
        token,
        user: {
          id: result.id,
          email: email,
          name: `${first_name} ${last_name}`,
          username: username,
          phone: phone,
          address: address,
          isOfficial: false
        }
      })
    };
  } catch (error) {
    console.error('Registration error:', error);
    
    let errorMessage = 'Registration failed. Please try again.';
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

