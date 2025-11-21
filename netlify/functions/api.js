const mysql = require('mysql2/promise');
const jwt = require('jsonwebtoken');

// Helper function to verify JWT token
function verifyToken(event) {
  const authHeader = event.headers.authorization || event.headers.Authorization;
  
  if (!authHeader || !authHeader.startsWith('Bearer ')) {
    return null;
  }

  const token = authHeader.substring(7);
  
  try {
    return jwt.verify(token, process.env.JWT_SECRET);
  } catch (error) {
    return null;
  }
}

// Helper function to get database connection
async function getConnection() {
  return await mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
    ssl: process.env.DB_SSL === 'true' ? { rejectUnauthorized: false } : false
  });
}

exports.handler = async (event, context) => {
  const path = event.path.replace('/.netlify/functions/api', '');
  const method = event.httpMethod;

  // Verify authentication for protected routes
  const user = verifyToken(event);
  
  if (!user && path !== '/health') {
    return {
      statusCode: 401,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ error: 'Unauthorized' })
    };
  }

  try {
    // Health check endpoint
    if (path === '/health' && method === 'GET') {
      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: 'ok' })
      };
    }

    // Get user dashboard data
    if (path === '/dashboard' && method === 'GET') {
      const connection = await getConnection();
      
      // Get user's requests
      const [requests] = await connection.execute(
        `SELECT * FROM maintenance_requests WHERE user_id = ? ORDER BY created_at DESC LIMIT 10`,
        [user.id]
      );

      // Get statistics
      const [stats] = await connection.execute(
        `SELECT 
          COUNT(*) as total,
          SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
          SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
          SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
         FROM maintenance_requests WHERE user_id = ?`,
        [user.id]
      );

      await connection.end();

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          requests,
          stats: stats[0] || { total: 0, active: 0, completed: 0, pending: 0 }
        })
      };
    }

    // Get all requests (for officials)
    if (path === '/requests' && method === 'GET' && user.isOfficial) {
      const connection = await getConnection();
      
      const [requests] = await connection.execute(
        `SELECT mr.*, u.name as user_name, u.email as user_email 
         FROM maintenance_requests mr 
         JOIN users u ON mr.user_id = u.id 
         ORDER BY mr.created_at DESC`
      );

      await connection.end();

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ requests })
      };
    }

    // Submit new maintenance request
    if (path === '/requests' && method === 'POST') {
      const { title, description, location, category } = JSON.parse(event.body);

      if (!title || !description || !location) {
        return {
          statusCode: 400,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ error: 'Title, description, and location are required' })
        };
      }

      const connection = await getConnection();
      
      const [result] = await connection.execute(
        `INSERT INTO maintenance_requests (user_id, title, description, location, category, status, created_at, updated_at) 
         VALUES (?, ?, ?, ?, ?, 'pending', NOW(), NOW())`,
        [user.id, title, description, location, category || 'general']
      );

      await connection.end();

      return {
        statusCode: 201,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
          success: true, 
          id: result.insertId,
          message: 'Request submitted successfully' 
        })
      };
    }

    // Update request status (for officials)
    if (path.startsWith('/requests/') && method === 'PATCH' && user.isOfficial) {
      const requestId = path.split('/')[2];
      const { status } = JSON.parse(event.body);

      if (!['pending', 'active', 'completed', 'cancelled'].includes(status)) {
        return {
          statusCode: 400,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ error: 'Invalid status' })
        };
      }

      const connection = await getConnection();
      
      await connection.execute(
        'UPDATE maintenance_requests SET status = ?, updated_at = NOW() WHERE id = ?',
        [status, requestId]
      );

      await connection.end();

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ success: true, message: 'Request updated successfully' })
      };
    }

    return {
      statusCode: 404,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ error: 'Not found' })
    };
  } catch (error) {
    console.error('API error:', error);
    return {
      statusCode: 500,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ error: 'Internal server error' })
    };
  }
};

