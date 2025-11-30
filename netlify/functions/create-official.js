const bcrypt = require('bcryptjs');
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

  try {
    const body = JSON.parse(event.body || '{}');
    const { 
      name, 
      username, 
      password, 
      department,
      position,
      phone,
      email,
      admin_key
    } = body;

    // Verify admin key
    const requiredAdminKey = process.env.ADMIN_CREATE_KEY || 'your-secret-admin-key-change-this';
    if (admin_key !== requiredAdminKey) {
      return {
        statusCode: 403,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Unauthorized. Invalid admin key.' })
      };
    }

    // Validate required fields
    if (!name || !username || !password) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Name, username, and password are required' })
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

    // Check if username already exists
    const { data: existingOfficial, error: checkError } = await supabase
      .from('officials')
      .select('id')
      .eq('username', username)
      .limit(1);

    if (checkError) {
      throw checkError;
    }

    if (existingOfficial && existingOfficial.length > 0) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Username already exists' })
      };
    }

    // Hash password
    const hashedPassword = await bcrypt.hash(password, 10);

    // Create official account
    const { data: result, error: insertError } = await supabase
      .from('officials')
      .insert([{
        name: name,
        username: username,
        password: hashedPassword,
        department: department || null,
        position: position || null,
        phone: phone || null,
        email: email || null,
        is_active: true
      }])
      .select()
      .single();

    if (insertError) {
      console.error('Error creating official:', insertError);
      return {
        statusCode: 500,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ 
          error: 'Failed to create official account',
          details: process.env.NODE_ENV === 'development' ? insertError.message : undefined
        })
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
        message: 'Official account created successfully',
        user: {
          id: result.id,
          name: result.name,
          username: result.username,
          department: result.department,
          position: result.position
        }
      })
    };
  } catch (error) {
    console.error('Create official account error:', error);
    return {
      statusCode: 500,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({ 
        error: 'Internal server error',
        details: process.env.NODE_ENV === 'development' ? error.message : undefined
      })
    };
  }
};

