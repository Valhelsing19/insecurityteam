const mysql = require('mysql2/promise');
const jwt = require('jsonwebtoken');
const { OAuth2Client } = require('google-auth-library');

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

  try {
    const { token, isOfficial = false } = JSON.parse(event.body);

    if (!token) {
      return {
        statusCode: 400,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ error: 'Google token is required' })
      };
    }

    // Verify Google token
    const ticket = await client.verifyIdToken({
      idToken: token,
      audience: process.env.GOOGLE_CLIENT_ID
    });

    const payload = ticket.getPayload();
    const { email, name, picture, sub: googleId } = payload;

    // Create MySQL connection
    const connection = await mysql.createConnection({
      host: process.env.DB_HOST,
      user: process.env.DB_USER,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_NAME,
      ssl: process.env.DB_SSL === 'true' ? { rejectUnauthorized: false } : false
    });

    // Check if user exists
    const [users] = await connection.execute(
      'SELECT * FROM users WHERE email = ?',
      [email]
    );

    let user;

    if (users.length === 0) {
      // Create new user
      const [result] = await connection.execute(
        `INSERT INTO users (name, email, google_id, picture, is_official, created_at, updated_at) 
         VALUES (?, ?, ?, ?, ?, NOW(), NOW())`,
        [name, email, googleId, picture || null, isOfficial ? 1 : 0]
      );

      user = {
        id: result.insertId,
        name,
        email,
        google_id: googleId,
        picture: picture || null,
        is_official: isOfficial ? 1 : 0
      };
    } else {
      // Update existing user with Google ID if not set
      user = users[0];
      if (!user.google_id) {
        await connection.execute(
          'UPDATE users SET google_id = ?, picture = ? WHERE id = ?',
          [googleId, picture || null, user.id]
        );
        user.google_id = googleId;
        user.picture = picture || null;
      }
    }

    await connection.end();

    // Generate JWT token
    const jwtToken = jwt.sign(
      {
        id: user.id,
        email: user.email,
        isOfficial: user.is_official === 1
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
          isOfficial: user.is_official === 1
        }
      })
    };
  } catch (error) {
    console.error('Google auth error:', error);
    return {
      statusCode: 500,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({ error: 'Authentication failed' })
    };
  }
};

