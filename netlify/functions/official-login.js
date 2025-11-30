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
    const { username, password } = JSON.parse(event.body || '{}');

    if (!username || !password) {
      return {
        statusCode: 400,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Username and password are required' })
      };
    }

    const supabase = getSupabaseClient();

    // Query official from database
    const { data: officials, error } = await supabase
      .from('officials')
      .select('*')
      .eq('username', username)
      .eq('is_active', true)
      .limit(1);

    if (error) {
      console.error('Database query error:', error);
      throw error;
    }

    if (!officials || officials.length === 0) {
      return {
        statusCode: 401,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Invalid username or password' })
      };
    }

    const official = officials[0];

    // Verify password
    const isValidPassword = await bcrypt.compare(password, official.password);

    if (!isValidPassword) {
      return {
        statusCode: 401,
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Invalid username or password' })
      };
    }

    // Generate JWT token
    const token = jwt.sign(
      { 
        id: official.id, 
        username: official.username,
        isOfficial: true
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
        token,
        user: {
          id: official.id,
          username: official.username,
          name: official.name,
          department: official.department,
          position: official.position,
          isOfficial: true
        }
      })
    };
  } catch (error) {
    console.error('Official login error:', error);
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

