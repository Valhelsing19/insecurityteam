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

// Helper function to log activity
async function logActivity(supabase, requestId, officialId, actionType, oldValue, newValue, description = null) {
  try {
    const { error } = await supabase
      .from('request_activity_log')
      .insert([{
        request_id: requestId,
        official_id: officialId,
        action_type: actionType,
        old_value: oldValue,
        new_value: newValue,
        description: description
      }]);

    if (error) {
      console.error('Error logging activity:', error);
      // Don't throw - activity logging shouldn't break the main operation
    }
  } catch (error) {
    console.error('Exception logging activity:', error);
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
      // Get ALL requests (from all users) with user information
      const { data: requests, error: reqError } = await supabase
        .from('maintenance_requests')
        .select('*, users:user_id(id, name, email)')
        .order('created_at', { ascending: false })
        .limit(50);

      if (reqError) {
        throw reqError;
      }

      // Get statistics from ALL requests
      const { data: allRequests, error: statsError } = await supabase
        .from('maintenance_requests')
        .select('status');

      if (statsError) {
        throw statsError;
      }

      const stats = {
        total: allRequests?.length || 0,
        active: allRequests?.filter(r => r.status === 'active' || r.status === 'in-progress').length || 0,
        completed: allRequests?.filter(r => r.status === 'completed').length || 0,
        pending: allRequests?.filter(r => r.status === 'pending').length || 0
      };

      // Format requests to include user_name
      const formattedRequests = (requests || []).map(req => ({
        ...req,
        user_name: req.users?.name || 'Unknown User'
      }));

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          requests: formattedRequests || [],
          stats
        })
      };
    }

    // Get announcements (user requests + official activities)
    if (path === '/announcements' && method === 'GET') {
      try {
        const announcements = [];

        // Get ALL recent requests (last 50) with user information and media files
        const { data: allRequests, error: reqError } = await supabase
          .from('maintenance_requests')
          .select('id, title, description, status, category, created_at, location, user_id, media_files, users:user_id(id, name, email)')
          .order('created_at', { ascending: false })
          .limit(50);

        if (reqError) {
          console.error('Error fetching requests:', reqError);
        } else if (allRequests) {
          allRequests.forEach(req => {
            announcements.push({
              id: `request-${req.id}`,
              type: 'user_request',
              title: req.title || `${req.category || 'Request'} Submitted`,
              description: req.description || '',
              category: req.category,
              status: req.status,
              location: req.location,
              created_at: req.created_at,
              actor: req.users?.name || 'Unknown User',  // Show actual user name
              media_files: req.media_files || []  // Include media files
            });
          });
        }

        // Get official activities related to ALL requests
        if (allRequests && allRequests.length > 0) {
          const requestIds = allRequests.map(r => r.id);

          // Create a map of requests for quick lookup
          const requestsMap = {};
          allRequests.forEach(req => {
            requestsMap[req.id] = req;
          });

          const { data: activities, error: activityError } = await supabase
            .from('request_activity_log')
            .select('*')
            .in('request_id', requestIds)
            .order('created_at', { ascending: false })
            .limit(50);

          if (!activityError && activities && activities.length > 0) {
            // Get unique official IDs
            const officialIds = [...new Set(activities.map(a => a.official_id).filter(Boolean))];

            // Fetch officials data
            let officialsMap = {};
            if (officialIds.length > 0) {
              const { data: officials, error: officialsError } = await supabase
                .from('officials')
                .select('id, name, department')
                .in('id', officialIds);

              if (!officialsError && officials) {
                officialsMap = officials.reduce((acc, o) => {
                  acc[o.id] = { name: o.name, department: o.department };
                  return acc;
                }, {});
              }
            }

            activities.forEach(activity => {
              const request = requestsMap[activity.request_id];
              const official = activity.official_id ? officialsMap[activity.official_id] : null;

              if (request) {
                const requestUser = request.users?.name || 'Unknown User';
                let title = '';
                let description = '';

                switch(activity.action_type) {
                  case 'status_changed':
                    title = `Request Status Updated`;
                    description = `${requestUser}'s ${request.category || 'request'} "${request.title || 'Request'}" status changed from ${activity.old_value || 'N/A'} to ${activity.new_value || 'N/A'}`;
                    break;
                  case 'priority_set':
                    title = `Priority Updated`;
                    description = `Priority for ${requestUser}'s "${request.title || 'Request'}" set to ${activity.new_value || 'N/A'}`;
                    break;
                  case 'assigned':
                    title = `Request Assigned`;
                    description = `${requestUser}'s request "${request.title || 'Request'}" has been assigned to an official`;
                    break;
                  case 'note_added':
                    title = `Note Added`;
                    description = activity.description || `An official added a note to ${requestUser}'s request`;
                    break;
                  default:
                    title = `Activity Update`;
                    description = activity.description || `${requestUser}'s request has been updated`;
                }

                announcements.push({
                  id: `activity-${activity.id}`,
                  type: 'official_activity',
                  title: title,
                  description: description,
                  category: request.category,
                  status: activity.new_value || request.status,
                  location: request.location,
                  created_at: activity.created_at,
                  actor: official ? official.name : 'System',
                  department: official ? official.department : null,
                  action_type: activity.action_type,
                  old_value: activity.old_value,
                  new_value: activity.new_value
                });
              }
            });
          }
        }

        // Sort by created_at (most recent first)
        announcements.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

        // Limit to 10 most recent
        const recentAnnouncements = announcements.slice(0, 10);

        return {
          statusCode: 200,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ announcements: recentAnnouncements })
        };
      } catch (error) {
        console.error('Error fetching announcements:', error);
        return {
          statusCode: 500,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ error: 'Failed to fetch announcements', message: error.message })
        };
      }
    }

    // Get all activity logs (for officials)
    if (path === '/activity-log' && method === 'GET' && user.isOfficial) {
      try {
        // Get all activity logs
        const { data: activities, error: activityError } = await supabase
          .from('request_activity_log')
          .select('*')
          .order('created_at', { ascending: false })
          .limit(500); // Limit to recent 500 activities

        if (activityError) {
          console.error('Error fetching activity logs:', activityError);
          throw activityError;
        }

        if (!activities || activities.length === 0) {
          return {
            statusCode: 200,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ activities: [] })
          };
        }

        // Get unique IDs for related data
        const officialIds = [...new Set(activities.map(a => a.official_id).filter(Boolean))];
        const requestIds = [...new Set(activities.map(a => a.request_id).filter(Boolean))];

        // Fetch officials data
        let officialsMap = {};
        if (officialIds.length > 0) {
          const { data: officials, error: officialsError } = await supabase
            .from('officials')
            .select('id, name, department')
            .in('id', officialIds);

          if (!officialsError && officials) {
            officialsMap = officials.reduce((acc, o) => {
              acc[o.id] = { name: o.name, department: o.department };
              return acc;
            }, {});
          }
        }

        // Fetch requests data
        let requestsMap = {};
        if (requestIds.length > 0) {
          const { data: requests, error: requestsError } = await supabase
            .from('maintenance_requests')
            .select('id, title, description')
            .in('id', requestIds);

          if (!requestsError && requests) {
            requestsMap = requests.reduce((acc, r) => {
              acc[r.id] = { title: r.title, description: r.description };
              return acc;
            }, {});
          }
        }

        // Format activities
        const formattedActivities = activities.map(activity => {
          const requestInfo = requestsMap[activity.request_id] || null;
          const officialInfo = activity.official_id ? officialsMap[activity.official_id] : null;

          return {
            id: activity.id,
            request_id: activity.request_id,
            request_title: requestInfo?.title || requestInfo?.description || `Request #${activity.request_id}`,
            action_type: activity.action_type,
            old_value: activity.old_value,
            new_value: activity.new_value,
            description: activity.description,
            created_at: activity.created_at,
            official: officialInfo ? {
              name: officialInfo.name,
              department: officialInfo.department
            } : null
          };
        });

        return {
          statusCode: 200,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ activities: formattedActivities })
        };
      } catch (error) {
        console.error('Error in /activity-log endpoint:', error);
        throw error;
      }
    }

    // Get all requests (for officials)
    if (path === '/requests' && method === 'GET' && user.isOfficial) {
      try {
        // First, get all requests
        const { data: requests, error: requestsError } = await supabase
          .from('maintenance_requests')
          .select('*')
          .order('created_at', { ascending: false });

        if (requestsError) {
          console.error('Error fetching requests:', requestsError);
          throw requestsError;
        }

        if (!requests || requests.length === 0) {
          return {
            statusCode: 200,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ requests: [] })
          };
        }

        // Get user IDs and official IDs to fetch related data
        const userIds = [...new Set(requests.map(r => r.user_id).filter(Boolean))];
        const officialIds = [...new Set(requests.map(r => r.assigned_to).filter(Boolean))];

        // Fetch users data
        let usersMap = {};
        if (userIds.length > 0) {
          const { data: users, error: usersError } = await supabase
            .from('users')
            .select('id, name, email, picture')
            .in('id', userIds);

          if (!usersError && users) {
            usersMap = users.reduce((acc, u) => {
              acc[u.id] = { name: u.name, email: u.email, picture: u.picture };
              return acc;
            }, {});
          }
        }

        // Fetch officials data
        let officialsMap = {};
        if (officialIds.length > 0) {
          const { data: officials, error: officialsError } = await supabase
            .from('officials')
            .select('id, name, department')
            .in('id', officialIds);

          if (!officialsError && officials) {
            officialsMap = officials.reduce((acc, o) => {
              acc[o.id] = { name: o.name, department: o.department };
              return acc;
            }, {});
          }
        }

        // Transform data to match expected format
        const formattedRequests = requests.map(req => {
          const userInfo = usersMap[req.user_id] || null;
          const officialInfo = req.assigned_to ? officialsMap[req.assigned_to] : null;

          return {
            ...req,
            user_name: userInfo?.name || null,
            user_email: userInfo?.email || null,
            user_picture: userInfo?.picture || null,
            assigned_official: officialInfo ? {
              name: officialInfo.name,
              department: officialInfo.department
            } : null
          };
        });

        return {
          statusCode: 200,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ requests: formattedRequests })
        };
      } catch (error) {
        console.error('Error in /requests endpoint:', error);
        throw error;
      }
    }

    // Submit new maintenance request
    if (path === '/requests' && method === 'POST') {
      try {
        if (!user || !user.id) {
          return {
            statusCode: 401,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ error: 'User not authenticated' })
          };
        }

        // Check if request contains multipart/form-data (file upload)
        const contentType = event.headers['content-type'] || event.headers['Content-Type'] || '';
        const isMultipart = contentType.includes('multipart/form-data');

        console.log('Content-Type:', contentType);
        console.log('Is multipart:', isMultipart);
        console.log('Event body type:', typeof event.body);
        console.log('Event body length:', event.body ? event.body.length : 0);
        console.log('Is base64 encoded:', event.isBase64Encoded);

        let title, description, location, category, priority, mediaFiles = [];

        if (isMultipart) {
          // Handle multipart/form-data with file uploads
          const Busboy = require('busboy');
          const busboy = Busboy({ headers: event.headers });

          const fields = {};
          const files = [];

          return new Promise((resolve) => {
            busboy.on('file', (fieldname, file, info) => {
              console.log(`File received: ${fieldname}`, info);
              const { filename, encoding, mimeType } = info;
              const chunks = [];

              file.on('data', (chunk) => {
                chunks.push(chunk);
              });

              file.on('end', () => {
                const buffer = Buffer.concat(chunks);
                console.log(`File ${filename} fully received, size: ${buffer.length} bytes`);
                files.push({
                  fieldname,
                  filename,
                  encoding,
                  mimeType,
                  buffer
                });
              });

              file.on('error', (err) => {
                console.error(`Error reading file ${filename}:`, err);
              });
            });

            busboy.on('field', (fieldname, value) => {
              fields[fieldname] = value;
            });

            busboy.on('finish', async () => {
              try {
                console.log('Busboy finished parsing. Fields:', Object.keys(fields));
                console.log('Files received:', files.length);

                title = fields.title;
                description = fields.description;
                location = fields.location;
                category = fields.category;
                priority = fields.priority;

                console.log('Parsed fields:', { title, description, location, category, priority });

                if (!title || !description || !location) {
                  resolve({
                    statusCode: 400,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ error: 'Title, description, and location are required' })
                  });
                  return;
                }

                // Upload files to Supabase Storage
                if (files.length > 0) {
                  console.log(`Processing ${files.length} file(s) for upload`);
                  const uploadedFiles = [];

                  for (const file of files) {
                    try {
                      console.log(`Uploading file: ${file.filename}, type: ${file.mimeType}, size: ${file.buffer.length}`);

                      // Generate unique filename
                      const timestamp = Date.now();
                      const randomStr = Math.random().toString(36).substring(2, 15);
                      const fileExt = file.filename.split('.').pop();
                      const fileName = `${user.id}/${timestamp}-${randomStr}.${fileExt}`;

                      console.log(`Generated filename: ${fileName}`);

                      // Determine file type
                      const fileType = file.mimeType.startsWith('image/') ? 'image' :
                                      file.mimeType.startsWith('video/') ? 'video' : 'other';

                      // Upload to Supabase Storage
                      const { data: uploadData, error: uploadError } = await supabase.storage
                        .from('request-media')
                        .upload(fileName, file.buffer, {
                          contentType: file.mimeType,
                          upsert: false
                        });

                      if (uploadError) {
                        console.error('Error uploading file to Supabase Storage:', uploadError);
                        console.error('Error details:', JSON.stringify(uploadError, null, 2));
                        continue;
                      }

                      console.log('File uploaded successfully:', uploadData);

                      // Get public URL - Supabase getPublicUrl returns { data: { publicUrl: string } }
                      const urlResponse = supabase.storage
                        .from('request-media')
                        .getPublicUrl(fileName);

                      console.log('URL response:', urlResponse);

                      // Handle different response formats
                      const publicUrl = urlResponse?.data?.publicUrl || urlResponse?.publicUrl || urlResponse?.data || '';

                      if (!publicUrl) {
                        console.error('Failed to get public URL for file:', fileName);
                        console.error('URL response:', JSON.stringify(urlResponse, null, 2));
                        continue;
                      }

                      console.log('Public URL:', publicUrl);

                      uploadedFiles.push({
                        type: fileType,
                        url: publicUrl,
                        filename: file.filename,
                        size: file.buffer.length,
                        uploaded_at: new Date().toISOString()
                      });

                      console.log('File added to uploadedFiles array');
                    } catch (fileError) {
                      console.error('Error processing file:', fileError);
                      console.error('Error stack:', fileError.stack);
                    }
                  }

                  console.log(`Total files uploaded: ${uploadedFiles.length} out of ${files.length}`);
                  mediaFiles = uploadedFiles;
                } else {
                  console.log('No files to upload');
                }
              } catch (parseError) {
                console.error('Error parsing multipart data:', parseError);
                resolve({
                  statusCode: 400,
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({ error: 'Error processing file uploads' })
                });
                return;
              }

              // Continue with request creation...
              const response = await processRequestCreation();
              resolve(response);
            });

            // Parse the body
            console.log('Starting to parse body with busboy...');
            if (event.isBase64Encoded) {
              console.log('Body is base64 encoded, decoding...');
              busboy.end(Buffer.from(event.body, 'base64'));
            } else {
              console.log('Body is not base64, using as-is...');
              // For multipart, body might be a string or buffer
              if (typeof event.body === 'string') {
                busboy.end(Buffer.from(event.body, 'binary'));
              } else {
                busboy.end(event.body);
              }
            }
          });

          busboy.on('error', (err) => {
            console.error('Busboy error:', err);
            resolve({
              statusCode: 400,
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ error: 'Error parsing multipart data', details: err.message })
            });
          });

          // Helper function to process request creation
          async function processRequestCreation() {
            // Validate priority if provided
            const validPriorities = ['low', 'medium', 'high', 'urgent'];
            const finalPriority = priority && validPriorities.includes(priority.toLowerCase())
              ? priority.toLowerCase()
              : 'medium';

            console.log('Submitting request for user:', user.id);
            console.log('Request data:', { title, description, location, category, priority: finalPriority });
            console.log('Media files count:', mediaFiles.length);
            console.log('Media files data:', JSON.stringify(mediaFiles, null, 2));

            // Verify user exists in database before inserting
            const { data: existingUser, error: userError } = await supabase
              .from('users')
              .select('id')
              .eq('id', user.id)
              .single();

            if (userError || !existingUser) {
              console.error('User not found in database:', user.id);
              return {
                statusCode: 401,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                  error: 'User account not found. Please log in again.',
                  details: 'Your session may have expired or your account was removed.'
                })
              };
            }

            const { data: result, error } = await supabase
              .from('maintenance_requests')
              .insert([{
                user_id: user.id,
                title,
                description,
                location,
                category: category || 'other',
                priority: finalPriority,
                status: 'pending',
                media_files: mediaFiles.length > 0 ? mediaFiles : null
              }])
              .select()
              .single();

            if (error) {
              console.error('Supabase insert error:', error);
              return {
                statusCode: 500,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                  error: 'Failed to save request',
                  details: error.message || error.details || 'Database error'
                })
              };
            }

            console.log('Request created successfully:', result?.id || 'unknown');
            return {
              statusCode: 201,
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                message: 'Request submitted successfully',
                request: result
              })
            };
          }

          return; // Return early, promise will resolve
        } else {
          // Handle JSON request (backward compatibility)
          try {
            const { title: jsonTitle, description: jsonDescription, location: jsonLocation, category: jsonCategory, priority: jsonPriority } = JSON.parse(event.body);

            title = jsonTitle;
            description = jsonDescription;
            location = jsonLocation;
            category = jsonCategory;
            priority = jsonPriority;

            if (!title || !description || !location) {
              return {
                statusCode: 400,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ error: 'Title, description, and location are required' })
              };
            }

            // Validate priority if provided
            const validPriorities = ['low', 'medium', 'high', 'urgent'];
            const finalPriority = priority && validPriorities.includes(priority.toLowerCase())
              ? priority.toLowerCase()
              : 'medium';

            console.log('Submitting request for user:', user.id);
            console.log('Request data:', { title, description, location, category, priority: finalPriority });

            // Verify user exists in database before inserting
            const { data: existingUser, error: userError } = await supabase
              .from('users')
              .select('id')
              .eq('id', user.id)
              .single();

            if (userError || !existingUser) {
              console.error('User not found in database:', user.id);
              console.error('User error:', userError);
              return {
                statusCode: 401,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                  error: 'User account not found. Please log in again.',
                  details: 'Your session may have expired or your account was removed.'
                })
              };
            }

            const { data: result, error } = await supabase
              .from('maintenance_requests')
              .insert([{
                user_id: user.id,
                title,
                description,
                location,
                category: category || 'other',
                priority: finalPriority,
                status: 'pending',
                media_files: null
              }])
              .select()
              .single();

            if (error) {
              console.error('Supabase insert error:', error);
              console.error('Error details:', JSON.stringify(error, null, 2));
              return {
                statusCode: 500,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                  error: 'Failed to save request',
                  details: error.message || error.details || 'Database error'
                })
              };
            }

            console.log('Request created successfully:', result?.id || 'unknown');
            console.log('Result data:', JSON.stringify(result, null, 2));

            return {
              statusCode: 201,
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                success: true,
                id: result?.id,
                message: 'Request submitted successfully'
              })
            };
          } catch (parseError) {
            console.error('JSON parse error:', parseError);
            return {
              statusCode: 400,
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ error: 'Invalid request data', details: parseError.message })
            };
          }
        }
      } catch (error) {
        console.error('Error in POST /requests:', error);
        return {
          statusCode: 500,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            error: 'Internal server error',
            details: error.message || 'An unexpected error occurred'
          })
        };
      }
    }

    // Update request status (for officials)
    if (path.startsWith('/requests/') && path.endsWith('/status') && method === 'PATCH' && user.isOfficial) {
      const requestId = path.split('/')[2];
      const { status, description } = JSON.parse(event.body);

      if (!['pending', 'active', 'completed', 'cancelled'].includes(status)) {
        return {
          statusCode: 400,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ error: 'Invalid status' })
        };
      }

      // Get current request to log old value
      const { data: currentRequest, error: fetchError } = await supabase
        .from('maintenance_requests')
        .select('status')
        .eq('id', requestId)
        .single();

      if (fetchError) {
        throw fetchError;
      }

      const oldStatus = currentRequest?.status || null;

      // Update status
      const { error } = await supabase
        .from('maintenance_requests')
        .update({ status })
        .eq('id', requestId);

      if (error) {
        throw error;
      }

      // Log activity
      await logActivity(
        supabase,
        requestId,
        user.id,
        'status_changed',
        oldStatus,
        status,
        description
      );

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ success: true, message: 'Request status updated successfully' })
      };
    }

    // Update request priority (for officials)
    if (path.startsWith('/requests/') && path.endsWith('/priority') && method === 'PATCH' && user.isOfficial) {
      const requestId = path.split('/')[2];
      const { priority, description } = JSON.parse(event.body);

      if (!['low', 'medium', 'high', 'urgent'].includes(priority)) {
        return {
          statusCode: 400,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ error: 'Invalid priority' })
        };
      }

      // Get current request to log old value
      const { data: currentRequest, error: fetchError } = await supabase
        .from('maintenance_requests')
        .select('priority')
        .eq('id', requestId)
        .single();

      if (fetchError) {
        throw fetchError;
      }

      const oldPriority = currentRequest?.priority || null;

      // Update priority
      const { error } = await supabase
        .from('maintenance_requests')
        .update({ priority })
        .eq('id', requestId);

      if (error) {
        throw error;
      }

      // Log activity
      await logActivity(
        supabase,
        requestId,
        user.id,
        'priority_set',
        oldPriority,
        priority,
        description
      );

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ success: true, message: 'Request priority updated successfully' })
      };
    }

    // Assign request to official (for officials)
    if (path.startsWith('/requests/') && path.endsWith('/assign') && method === 'PATCH' && user.isOfficial) {
      const requestId = path.split('/')[2];
      const { assigned_to, description } = JSON.parse(event.body);

      // Get current request to log old value
      const { data: currentRequest, error: fetchError } = await supabase
        .from('maintenance_requests')
        .select('assigned_to')
        .eq('id', requestId)
        .single();

      if (fetchError) {
        throw fetchError;
      }

      const oldAssignedTo = currentRequest?.assigned_to || null;

      // Update assignment
      const updateData = {
        assigned_to: assigned_to || null,
        assigned_at: assigned_to ? new Date().toISOString() : null
      };

      const { error } = await supabase
        .from('maintenance_requests')
        .update(updateData)
        .eq('id', requestId);

      if (error) {
        throw error;
      }

      // Get official name for logging
      let officialName = null;
      if (assigned_to) {
        const { data: official } = await supabase
          .from('officials')
          .select('name')
          .eq('id', assigned_to)
          .single();
        officialName = official?.name || null;
      }

      // Log activity
      await logActivity(
        supabase,
        requestId,
        user.id,
        assigned_to ? 'assigned' : 'unassigned',
        oldAssignedTo?.toString() || null,
        assigned_to?.toString() || null,
        description || (assigned_to ? `Assigned to ${officialName || 'official'}` : 'Unassigned')
      );

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ success: true, message: assigned_to ? 'Request assigned successfully' : 'Request unassigned successfully' })
      };
    }

    // Get activity log for a request
    if (path.startsWith('/requests/') && path.endsWith('/activity') && method === 'GET') {
      const requestId = path.split('/')[2];

      // Check if user has permission (official or request owner)
      const { data: request, error: reqError } = await supabase
        .from('maintenance_requests')
        .select('user_id')
        .eq('id', requestId)
        .single();

      if (reqError) {
        throw reqError;
      }

      // Allow if user is official or owns the request
      if (!user.isOfficial && request.user_id !== user.id) {
        return {
          statusCode: 403,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ error: 'Forbidden' })
        };
      }

      // Get activity log with official names
      const { data: activities, error: activityError } = await supabase
        .from('request_activity_log')
        .select(`
          *,
          officials(name, department)
        `)
        .eq('request_id', requestId)
        .order('created_at', { ascending: false });

      if (activityError) {
        throw activityError;
      }

      // Format activities
      const formattedActivities = activities?.map(activity => ({
        id: activity.id,
        action_type: activity.action_type,
        old_value: activity.old_value,
        new_value: activity.new_value,
        description: activity.description,
        created_at: activity.created_at,
        official: activity.officials ? {
          name: activity.officials.name,
          department: activity.officials.department
        } : null
      })) || [];

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ activities: formattedActivities })
      };
    }

    // Legacy endpoint: Update request (supports status, priority, assigned_to)
    if (path.startsWith('/requests/') && method === 'PATCH' && user.isOfficial) {
      const requestId = path.split('/')[2];
      const updateData = JSON.parse(event.body);
      const { status, priority, assigned_to, description } = updateData;

      // Get current request values
      const { data: currentRequest, error: fetchError } = await supabase
        .from('maintenance_requests')
        .select('status, priority, assigned_to')
        .eq('id', requestId)
        .single();

      if (fetchError) {
        throw fetchError;
      }

      // Prepare update object
      const updates = {};
      if (status && ['pending', 'active', 'completed', 'cancelled'].includes(status)) {
        updates.status = status;
      }
      if (priority && ['low', 'medium', 'high', 'urgent'].includes(priority)) {
        updates.priority = priority;
      }
      if (assigned_to !== undefined) {
        updates.assigned_to = assigned_to || null;
        updates.assigned_at = assigned_to ? new Date().toISOString() : null;
      }

      if (Object.keys(updates).length === 0) {
        return {
          statusCode: 400,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ error: 'No valid fields to update' })
        };
      }

      // Update request
      const { error } = await supabase
        .from('maintenance_requests')
        .update(updates)
        .eq('id', requestId);

      if (error) {
        throw error;
      }

      // Log activities
      if (status && status !== currentRequest.status) {
        await logActivity(supabase, requestId, user.id, 'status_changed', currentRequest.status, status, description);
      }
      if (priority && priority !== currentRequest.priority) {
        await logActivity(supabase, requestId, user.id, 'priority_set', currentRequest.priority, priority, description);
      }
      if (assigned_to !== undefined && assigned_to !== currentRequest.assigned_to) {
        const actionType = assigned_to ? 'assigned' : 'unassigned';
        await logActivity(supabase, requestId, user.id, actionType, currentRequest.assigned_to?.toString() || null, assigned_to?.toString() || null, description);
      }

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ success: true, message: 'Request updated successfully' })
      };
    }

    // Update user profile
    if (path === '/user/profile' && method === 'PATCH') {
      const { first_name, last_name, email, phone, address } = JSON.parse(event.body);

      // Prepare update object
      const updateData = {};

      // Combine first_name and last_name into name field (database only has 'name' column)
      if (first_name !== undefined || last_name !== undefined) {
        const firstName = first_name || '';
        const lastName = last_name || '';
        updateData.name = `${firstName} ${lastName}`.trim();
      }

      if (email !== undefined) updateData.email = email;
      if (phone !== undefined) updateData.phone = phone;
      if (address !== undefined) updateData.address = address;

      // Update user in database
      const { data: updatedUser, error: updateError } = await supabase
        .from('users')
        .update(updateData)
        .eq('id', user.id)
        .select()
        .single();

      if (updateError) {
        console.error('Error updating user profile:', updateError);
        return {
          statusCode: 500,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            error: 'Failed to update profile',
            details: process.env.NODE_ENV === 'development' ? updateError.message : undefined
          })
        };
      }

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          success: true,
          message: 'Profile updated successfully',
          user: {
            id: updatedUser.id,
            email: updatedUser.email,
            name: updatedUser.name,
            phone: updatedUser.phone || updatedUser.phone_number,
            address: updatedUser.address
          }
        })
      };
    }

    // Update user contact information
    if (path === '/user/contact-info' && method === 'PATCH') {
      const {
        emergency_contact_name,
        emergency_contact_phone,
        preferred_contact_method,
        contact_time_preference
      } = JSON.parse(event.body);

      // Prepare update object
      const updateData = {};
      if (emergency_contact_name !== undefined) updateData.emergency_contact_name = emergency_contact_name;
      if (emergency_contact_phone !== undefined) updateData.emergency_contact_phone = emergency_contact_phone;
      if (preferred_contact_method !== undefined) updateData.preferred_contact_method = preferred_contact_method;
      if (contact_time_preference !== undefined) updateData.contact_time_preference = contact_time_preference;

      // Update user in database
      const { data: updatedUser, error: updateError } = await supabase
        .from('users')
        .update(updateData)
        .eq('id', user.id)
        .select()
        .single();

      if (updateError) {
        console.error('Error updating contact information:', updateError);
        return {
          statusCode: 500,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            error: 'Failed to update contact information',
            details: process.env.NODE_ENV === 'development' ? updateError.message : undefined
          })
        };
      }

      return {
        statusCode: 200,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          success: true,
          message: 'Contact information updated successfully',
          user: {
            id: updatedUser.id,
            emergency_contact_name: updatedUser.emergency_contact_name,
            emergency_contact_phone: updatedUser.emergency_contact_phone,
            preferred_contact_method: updatedUser.preferred_contact_method,
            contact_time_preference: updatedUser.contact_time_preference
          }
        })
      };
    }

    // Upload profile picture
    if (path === '/user/profile-picture' && method === 'POST') {
      const contentType = event.headers['content-type'] || event.headers['Content-Type'] || '';
      const isMultipart = contentType.includes('multipart/form-data');

      if (!isMultipart) {
        return {
          statusCode: 400,
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ error: 'Request must be multipart/form-data' })
        };
      }

      return new Promise((resolve) => {
        const Busboy = require('busboy');
        const busboy = Busboy({ headers: event.headers });
        let profilePictureFile = null;

        busboy.on('file', (fieldname, file, info) => {
          if (fieldname === 'profile_picture') {
            const chunks = [];
            file.on('data', (chunk) => {
              chunks.push(chunk);
            });
            file.on('end', () => {
              profilePictureFile = {
                buffer: Buffer.concat(chunks),
                filename: info.filename,
                mimeType: info.mimeType
              };
            });
          } else {
            file.resume(); // Ignore other fields
          }
        });

        busboy.on('finish', async () => {
          try {
            // Validate user.id exists
            if (!user || !user.id) {
              console.error('User authentication failed - user.id is missing');
              return resolve({
                statusCode: 401,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ error: 'User authentication failed. Please log in again.' })
              });
            }

            if (!profilePictureFile) {
              return resolve({
                statusCode: 400,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ error: 'No profile picture file provided' })
              });
            }

            // Validate file was actually received
            if (!profilePictureFile.buffer || profilePictureFile.buffer.length === 0) {
              return resolve({
                statusCode: 400,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ error: 'Profile picture file is empty or corrupted' })
              });
            }

            // Generate unique filename
            const timestamp = Date.now();
            const randomStr = Math.random().toString(36).substring(2, 15);
            const fileExt = profilePictureFile.filename.split('.').pop() || 'jpg';
            const fileName = `${user.id}/profile-${timestamp}-${randomStr}.${fileExt}`;

            console.log('Uploading profile picture for user:', user.id);
            console.log('File size:', profilePictureFile.buffer.length, 'bytes');
            console.log('File type:', profilePictureFile.mimeType);
            console.log('Target filename:', fileName);

            // Upload to Supabase Storage
            const { data: uploadData, error: uploadError } = await supabase.storage
              .from('profile-pictures')
              .upload(fileName, profilePictureFile.buffer, {
                contentType: profilePictureFile.mimeType,
                upsert: true // Allow overwriting existing profile pictures
              });

            if (uploadError) {
              console.error('Error uploading profile picture:', uploadError);
              console.error('Upload error details:', JSON.stringify(uploadError, null, 2));

              // More specific error messages based on error type
              let errorMessage = 'Failed to upload profile picture';
              if (uploadError.message) {
                const errorMsg = uploadError.message.toLowerCase();
                if (errorMsg.includes('bucket not found') || errorMsg.includes('does not exist')) {
                  errorMessage = 'Profile pictures storage bucket not found. Please create the "profile-pictures" bucket in Supabase Storage. See PROFILE_PICTURE_SETUP.md for instructions.';
                } else if (errorMsg.includes('row-level security') || errorMsg.includes('policy')) {
                  errorMessage = 'Storage policy error. Please check Supabase Storage policies for the "profile-pictures" bucket. Make sure "Authenticated Upload" policy is set up.';
                } else if (errorMsg.includes('jwt') || errorMsg.includes('unauthorized')) {
                  errorMessage = 'Authentication error. Please check Supabase configuration and ensure SUPABASE_SERVICE_ROLE_KEY is set correctly.';
                } else if (errorMsg.includes('duplicate') || errorMsg.includes('already exists')) {
                  // This shouldn't happen with upsert: true, but handle it anyway
                  errorMessage = 'File already exists. Trying to overwrite...';
                  // Continue to get URL and update database
                } else {
                  errorMessage = `Failed to upload profile picture: ${uploadError.message}`;
                }
              }

              // Only return error if it's not a duplicate (which we'll handle)
              if (!uploadError.message || !uploadError.message.toLowerCase().includes('duplicate')) {
                return resolve({
                  statusCode: 500,
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({
                    error: errorMessage,
                    details: process.env.NODE_ENV === 'development' ? uploadError.message : undefined
                  })
                });
              }
            }

            console.log('Profile picture uploaded successfully:', uploadData);

            // Get public URL
            const urlResponse = supabase.storage
              .from('profile-pictures')
              .getPublicUrl(fileName);

            const publicUrl = urlResponse?.data?.publicUrl || urlResponse?.publicUrl || urlResponse?.data || '';

            if (!publicUrl) {
              console.error('Failed to get public URL for profile picture');
              return resolve({
                statusCode: 500,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ error: 'Failed to get profile picture URL' })
              });
            }

            console.log('Profile picture public URL:', publicUrl);

            // Update user's picture in database
            const { data: updatedUser, error: updateError } = await supabase
              .from('users')
              .update({ picture: publicUrl })
              .eq('id', user.id)
              .select()
              .single();

            if (updateError) {
              console.error('Error updating user picture:', updateError);
              return resolve({
                statusCode: 500,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ error: 'Failed to update profile picture in database', details: updateError.message })
              });
            }

            console.log('Profile picture updated in database successfully');

            return resolve({
              statusCode: 200,
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                success: true,
                message: 'Profile picture uploaded successfully',
                picture_url: publicUrl
              })
            });
          } catch (error) {
            console.error('Error processing profile picture upload:', error);
            console.error('Error stack:', error.stack);
            return resolve({
              statusCode: 500,
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                error: 'Error processing profile picture upload',
                details: process.env.NODE_ENV === 'development' ? error.message : 'Please check server logs for details'
              })
            });
          }
        });

        busboy.on('error', (err) => {
          console.error('Busboy error:', err);
          resolve({
            statusCode: 400,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ error: 'Error parsing multipart data', details: err.message })
          });
        });

        // Parse the body
        if (event.isBase64Encoded) {
          busboy.end(Buffer.from(event.body, 'base64'));
        } else {
          if (typeof event.body === 'string') {
            busboy.end(Buffer.from(event.body, 'binary'));
          } else {
            busboy.end(event.body);
          }
        }
      });
    }

    return {
      statusCode: 404,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ error: 'Not found' })
    };
  } catch (error) {
    console.error('API error:', error);
    console.error('Error stack:', error.stack);
    return {
      statusCode: 500,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({
        error: 'Internal server error',
        message: error.message || 'An unexpected error occurred',
        details: process.env.NODE_ENV === 'development' || process.env.NETLIFY_DEV ? error.message : undefined
      })
    };
  }
};

