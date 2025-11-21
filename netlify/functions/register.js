const mysql = require('mysql2/promise');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');

exports.handler = async (event, context) => {
  // Only allow POST requests
  if (event.httpMethod !== 'POST') {
    return {
      statusCode: 405,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ error: 'Method Not Allowed' })
    };
  }

  try {
    const {
      first_name,
      last_name,
      username,
      email,
      phone,
      password,
      address
    } = JSON.parse(event.body);

    // Validate required fields
    if (!first_name || !last_name || !username || !email || !phone || !password || !address) {
      return {
        statusCode: 400,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ error: 'All fields are required' })
      };
    }

    // Create MySQL connection
    const connection = await mysql.createConnection({
      host: process.env.DB_HOST,
      user: process.env.DB_USER,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_NAME,
      ssl: process.env.DB_SSL === 'true' ? { rejectUnauthorized: false } : false
    });

    // Check if email already exists
    const [existingEmail] = await connection.execute(
      'SELECT id FROM users WHERE email = ?',
      [email]
    );

    if (existingEmail.length > 0) {
      await connection.end();
      return {
        statusCode: 400,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ error: 'Email already registered' })
      };
    }

    // Check if username already exists
    const [existingUsername] = await connection.execute(
      'SELECT id FROM users WHERE username = ?',
      [username]
    );

    if (existingUsername.length > 0) {
      await connection.end();
      return {
        statusCode: 400,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ error: 'Username already taken' })
      };
    }

    // Hash password
    const hashedPassword = await bcrypt.hash(password, 10);

    // Insert new user
    const [result] = await connection.execute(
      `INSERT INTO users (name, username, email, phone, password, address, is_official, created_at, updated_at) 
       VALUES (?, ?, ?, ?, ?, ?, 0, NOW(), NOW())`,
      [`${first_name} ${last_name}`, username, email, phone, hashedPassword, address]
    );

    // Generate JWT token
    const token = jwt.sign(
      { 
        id: result.insertId, 
        email: email, 
        isOfficial: false 
      },
      process.env.JWT_SECRET,
      { expiresIn: '7d' }
    );

    await connection.end();

    return {
      statusCode: 201,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        success: true,
        token,
        user: {
          id: result.insertId,
          email: email,
          name: `${first_name} ${last_name}`,
          username: username,
          isOfficial: false
        }
      })
    };
  } catch (error) {
    console.error('Registration error:', error);
    return {
      statusCode: 500,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ error: 'Internal server error' })
    };
  }
};

