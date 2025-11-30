const jwt = require('jsonwebtoken');
const { getSupabaseClient } = require('./supabase');

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

    const supabase = getSupabaseClient();

    // Get user dashboard data
    if (path === '/dashboard' && method === 'GET') {
      // Get user's requests
      const { data: requests, error: reqError } = await supabase
        .from('maintenance_requests')
        .select('*')
        .eq('user_id', user.id)
        .order('created_at', { ascending: false })
        .limit(10);

      if (reqError) {
        throw reqError;
      }

      // Get statistics
      const { data: allRequests, error: statsError } = await supabase
        .from('maintenance_requests')
        .select('status')
        .eq('user_id', user.id);

      if (statsError) {
        throw statsError;
      }

      const stats = {
        total: allRequests?.length || 0,
        active: allRequests?.filter(r => r.status === 'active').length || 0,
        completed: allRequests?.filter(r => r.status === 'completed').length || 0,
        pending: allRequests?.filter(r => r.status === 'pending').length || 0
      };

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          requests: requests || [],
          stats
        })
      };
    }

    // Get all requests (for officials)
    if (path === '/requests' && method === 'GET' && user.isOfficial) {
      const { data: requests, error } = await supabase
        .from('maintenance_requests')
        .select(`
          *,
          users!inner(name, email)
        `)
        .order('created_at', { ascending: false });

      if (error) {
        throw error;
      }

      // Transform data to match expected format
      const formattedRequests = requests?.map(req => ({
        ...req,
        user_name: req.users?.name,
        user_email: req.users?.email
      })) || [];

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ requests: formattedRequests })
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

      const { data: result, error } = await supabase
        .from('maintenance_requests')
        .insert([{
          user_id: user.id,
          title,
          description,
          location,
          category: category || 'general',
          status: 'pending'
        }])
        .select()
        .single();

      if (error) {
        throw error;
      }

      return {
        statusCode: 201,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
          success: true, 
          id: result.id,
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

      const { error } = await supabase
        .from('maintenance_requests')
        .update({ status })
        .eq('id', requestId);

      if (error) {
        throw error;
      }

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
      body: JSON.stringify({ 
        error: 'Internal server error',
        details: process.env.NODE_ENV === 'development' ? error.message : undefined
      })
    };
  }
};

