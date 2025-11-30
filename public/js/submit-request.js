console.log('=== submit-request.js LOADED ===');
// File upload preview - Multiple Images and Videos
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DOM Content Loaded ===');
    
    // Logout handler
    const logoutBtn = document.querySelector('.logout-button');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            // Clear authentication data
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            // Redirect to login page
            window.location.href = '/login';
        });
    }
    // Image upload handler - Multiple files
    const imageInput = document.getElementById('photo');
    const imageUpload = imageInput ? imageInput.closest('.file-upload') : null;
    const imageUploadContent = imageUpload ? imageUpload.querySelector('.file-upload-content') : null;

    // Create preview container if it doesn't exist
    let imagePreviewContainer = imageUpload ? imageUpload.querySelector('.image-preview-container') : null;
    if (imageUpload && !imagePreviewContainer) {
        const container = document.createElement('div');
        container.className = 'image-preview-container';
        imageUpload.appendChild(container);
        imagePreviewContainer = container;
    }

    if (imageInput && imageUpload) {
        imageInput.addEventListener('change', function(e) {
            console.log('=== IMAGE INPUT CHANGED ===');
            console.log('Files selected:', e.target.files.length);
            console.log('File names:', Array.from(e.target.files).map(f => f.name));

            if (e.target.files.length > 0) {
                const files = Array.from(e.target.files);

                // Hide default content after first file
                if (imageUploadContent) {
                    imageUploadContent.style.display = 'none';
                }

                files.forEach((file, index) => {
                    // Check if it's an image
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            // Create preview container for this image
                            const previewContainer = document.createElement('div');
                            previewContainer.className = 'file-preview';
                            previewContainer.dataset.fileIndex = index;

                            // Prevent clicks on preview from triggering file input
                            previewContainer.addEventListener('click', function(e) {
                                e.stopPropagation();
                            });

                            // Create image element
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = 'Preview';
                            img.className = 'file-preview-image';

                            // Create remove button
                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.className = 'file-remove-btn';
                            removeBtn.innerHTML = '×';
                            removeBtn.setAttribute('aria-label', 'Remove image');

                            removeBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                e.stopImmediatePropagation();
                                removeFileFromInput(imageInput, file);
                                previewContainer.remove();

                                // Show default content if no files left
                                if (imagePreviewContainer && imagePreviewContainer.children.length === 0 && imageUploadContent) {
                                    imageUploadContent.style.display = 'flex';
                                }
                                return false;
                            });

                            previewContainer.appendChild(img);
                            previewContainer.appendChild(removeBtn);
                            if (imagePreviewContainer) {
                                imagePreviewContainer.appendChild(previewContainer);
                            }
                        };

                        reader.readAsDataURL(file);
                    } else {
                        alert(`File "${file.name}" is not an image. Skipping...`);
                    }
                });
            }
        });
    }

    // Video upload handler - Multiple files with 25MB limit each
    const videoInput = document.getElementById('video');
    const videoUpload = videoInput ? videoInput.closest('.file-upload') : null;
    const videoUploadContent = videoUpload ? videoUpload.querySelector('.file-upload-content') : null;

    const MAX_VIDEO_SIZE = 25 * 1024 * 1024; // 25MB

    // Create preview container if it doesn't exist
    let videoPreviewContainer = videoUpload ? videoUpload.querySelector('.video-preview-container') : null;
    if (videoUpload && !videoPreviewContainer) {
        const container = document.createElement('div');
        container.className = 'video-preview-container';
        videoUpload.appendChild(container);
        videoPreviewContainer = container;
    }

    if (videoInput && videoUpload) {
        videoInput.addEventListener('change', function(e) {
            console.log('=== VIDEO INPUT CHANGED ===');
            console.log('Files selected:', e.target.files.length);
            console.log('File names:', Array.from(e.target.files).map(f => f.name));

            if (e.target.files.length > 0) {
                const files = Array.from(e.target.files);

                // Hide default content after first file
                if (videoUploadContent) {
                    videoUploadContent.style.display = 'none';
                }

                files.forEach((file, index) => {
                    // Check file size
                    if (file.size > MAX_VIDEO_SIZE) {
                        alert(`Video "${file.name}" exceeds 25MB limit. Skipping...`);
                        return;
                    }

                    // Check if it's a video
                    if (file.type.startsWith('video/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            // Create preview container for this video
                            const previewContainer = document.createElement('div');
                            previewContainer.className = 'file-preview';
                            previewContainer.dataset.fileIndex = index;

                            // Prevent clicks on preview from triggering file input
                            previewContainer.addEventListener('click', function(e) {
                                e.stopPropagation();
                            });

                            // Create video element
                            const video = document.createElement('video');
                            video.src = e.target.result;
                            video.controls = true;
                            video.className = 'file-preview-video';
                            video.style.cssText = 'width: 100%; max-height: 300px; border-radius: 4px; display: block; background: #000;';

                            // Create file info
                            const fileInfo = document.createElement('div');
                            fileInfo.className = 'file-info';
                            fileInfo.textContent = `${file.name} (${formatFileSize(file.size)})`;

                            // Create remove button
                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.className = 'file-remove-btn';
                            removeBtn.innerHTML = '×';
                            removeBtn.setAttribute('aria-label', 'Remove video');

                            removeBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                e.stopImmediatePropagation();
                                removeFileFromInput(videoInput, file);
                                previewContainer.remove();

                                // Show default content if no files left
                                if (videoPreviewContainer && videoPreviewContainer.children.length === 0 && videoUploadContent) {
                                    videoUploadContent.style.display = 'flex';
                                }
                                return false;
                            });

                            previewContainer.appendChild(video);
                            previewContainer.appendChild(fileInfo);
                            previewContainer.appendChild(removeBtn);
                            if (videoPreviewContainer) {
                                videoPreviewContainer.appendChild(previewContainer);
                            }
                        };

                        reader.readAsDataURL(file);
                    } else {
                        alert(`File "${file.name}" is not a video. Skipping...`);
                    }
                });
            }
        });
    }

    // Helper function to remove file from input
    function removeFileFromInput(input, fileToRemove) {
        const dt = new DataTransfer();
        const files = Array.from(input.files);

        files.forEach((file) => {
            if (file !== fileToRemove) {
                dt.items.add(file);
            }
        });

        input.files = dt.files;
    }

    // Helper function to format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Select styling and display
    const select = document.querySelector('.form-select select');
    const formSelect = document.querySelector('.form-select');

    if (select && formSelect) {
        // Update color when value changes
        function updateSelectDisplay() {
            if (select.value) {
                select.style.color = '#0A0A0A';
            } else {
                select.style.color = '#717182';
            }
        }

        // Initial display update
        updateSelectDisplay();

        // Update on change
        select.addEventListener('change', updateSelectDisplay);

        // Make the entire select container clickable
        formSelect.addEventListener('click', function(e) {
            if (e.target !== select) {
                select.focus();
                select.click();
            }
        });

        // Ensure select is visible and clickable
        select.style.pointerEvents = 'auto';
        select.style.cursor = 'pointer';
    }

    // ============================================
    // NLP Analysis and Form Submission Handler
    // ============================================

    const descriptionTextarea = document.getElementById('description');
    const issueTypeSelect = document.getElementById('issue_type');
    const locationInput = document.getElementById('location');

    // Store analyzed priority and category
    let analyzedPriority = null;
    let analyzedCategory = null;
    let analysisTimeout;

    // Real-time analysis on description input (debounced)
    if (descriptionTextarea) {
        descriptionTextarea.addEventListener('input', function() {
            clearTimeout(analysisTimeout);
            const text = descriptionTextarea.value.trim();

            // Only analyze if text is meaningful (at least 10 characters)
            if (text.length >= 10) {
                analysisTimeout = setTimeout(() => {
                    analyzeRequest(text, '');
                }, 1000); // Wait 1 second after user stops typing
            } else {
                // Remove badge if text is too short
                const existingBadge = document.querySelector('.ai-suggestion-badge');
                if (existingBadge) {
                    existingBadge.remove();
                }
            }
        });
    }

    // Form submission handler
    const form = document.querySelector('.form-content');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Get form values
            const description = descriptionTextarea ? descriptionTextarea.value.trim() : '';
            const location = locationInput ? locationInput.value.trim() : '';
            const category = issueTypeSelect ? issueTypeSelect.value : 'other';

            // Validation
            if (!description) {
                alert('Please provide a description of the problem.');
                if (descriptionTextarea) descriptionTextarea.focus();
                return;
            }

            if (!location) {
                alert('Please provide a location.');
                if (locationInput) locationInput.focus();
                return;
            }

            // Generate title from description (first 50 characters)
            const title = description.length > 50
                ? description.substring(0, 47) + '...'
                : description;

            // Get auth token
            const token = localStorage.getItem('auth_token');
            if (!token) {
                alert('Please login first');
                window.location.href = '/login';
                return;
            }

            // Use analyzed priority if available, otherwise default to medium
            const priority = analyzedPriority || 'medium';
            // Use analyzed category if form is empty, otherwise use form selection
            const finalCategory = category || analyzedCategory || 'other';

            console.log('Submitting with:', {
                category: finalCategory,
                priority: priority,
                analyzedPriority: analyzedPriority,
                analyzedCategory: analyzedCategory
            });

            // Show loading state
            const submitButton = form.querySelector('.submit-button');
            const originalButtonText = submitButton ? submitButton.innerHTML : '';
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span>Submitting...</span>';
            }

            try {
                console.log('Submitting request...');

                // ADD THIS - Check files BEFORE the detection code
                const photoInputCheck = document.getElementById('photo');
                const videoInputCheck = document.getElementById('video');
                console.log('=== BEFORE FILE DETECTION ===');
                console.log('photoInputCheck?.files?.length:', photoInputCheck?.files?.length);
                console.log('videoInputCheck?.files?.length:', videoInputCheck?.files?.length);

                // Check if there are files to upload
                const photoInput = document.getElementById('photo');
                const videoInput = document.getElementById('video');
                const hasPhotos = photoInput && photoInput.files && photoInput.files.length > 0;
                const hasVideos = videoInput && videoInput.files && videoInput.files.length > 0;
                const hasFiles = hasPhotos || hasVideos;

                // ADD THIS DEBUGGING:
                console.log('File detection debug:');
                console.log('photoInput:', photoInput);
                console.log('videoInput:', videoInput);
                console.log('photoInput?.files:', photoInput?.files);
                console.log('videoInput?.files:', videoInput?.files);
                console.log('photoInput?.files?.length:', photoInput?.files?.length);
                console.log('videoInput?.files?.length:', videoInput?.files?.length);
                console.log('hasPhotos:', hasPhotos);
                console.log('hasVideos:', hasVideos);
                console.log('hasFiles:', hasFiles);

                let response;

                if (hasFiles) {
                    // Use FormData for file uploads
                    const formData = new FormData();
                    formData.append('title', title);
                    formData.append('description', description);
                    formData.append('location', location);
                    formData.append('category', finalCategory);
                    formData.append('priority', priority);

                    // Add photos
                    if (hasPhotos) {
                        for (let i = 0; i < photoInput.files.length; i++) {
                            formData.append('photo[]', photoInput.files[i]);
                        }
                    }

                    // Add videos
                    if (hasVideos) {
                        for (let i = 0; i < videoInput.files.length; i++) {
                            formData.append('video[]', videoInput.files[i]);
                        }
                    }

                    response = await fetch('/.netlify/functions/api/requests', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`
                            // Don't set Content-Type - browser will set it with boundary
                        },
                        body: formData
                    });
                } else {
                    // Use JSON for requests without files
                    response = await fetch('/.netlify/functions/api/requests', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify({
                            title: title,
                            description: description,
                            location: location,
                            category: finalCategory,
                            priority: priority
                        })
                    });
                }

                console.log('Response status:', response.status);

                let data;
                try {
                    const text = await response.text();
                    console.log('Response text:', text);
                    data = JSON.parse(text);
                } catch (parseError) {
                    console.error('Failed to parse response:', parseError);
                    throw new Error('Invalid response from server');
                }

                if (response.ok) {
                    // Check for both success flag and message
                    if (data.success || data.message) {
                        console.log('Request submitted successfully:', data.request?.id || data.id);
                        // Remove suggestion badge
                        const existingBadge = document.querySelector('.ai-suggestion-badge');
                        if (existingBadge) {
                            existingBadge.remove();
                        }

                        alert('Request submitted successfully!');
                        // Reset form and analyzed values
                        form.reset();
                        analyzedPriority = null;
                        analyzedCategory = null;
                        // Clear file previews
                        const imagePreviewContainer = document.querySelector('.image-preview-container');
                        const videoPreviewContainer = document.querySelector('.video-preview-container');
                        if (imagePreviewContainer) imagePreviewContainer.innerHTML = '';
                        if (videoPreviewContainer) videoPreviewContainer.innerHTML = '';
                        // Show default upload content
                        const imageUploadContent = document.querySelector('#photo').closest('.file-upload')?.querySelector('.file-upload-content');
                        const videoUploadContent = document.querySelector('#video').closest('.file-upload')?.querySelector('.file-upload-content');
                        if (imageUploadContent) imageUploadContent.style.display = 'flex';
                        if (videoUploadContent) videoUploadContent.style.display = 'flex';
                        // Redirect to dashboard - it will automatically load the new request
                        window.location.href = '/dashboard';
                    } else {
                        const errorMsg = data.error || data.details || 'Failed to submit request. Please try again.';
                        console.error('Submit failed:', errorMsg);
                        alert(`Error: ${errorMsg}`);
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalButtonText;
                        }
                    }
                } else {
                    const errorMsg = data.error || data.details || 'Failed to submit request. Please try again.';
                    console.error('Submit failed:', errorMsg);
                    alert(`Error: ${errorMsg}`);
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonText;
                    }
                }
            } catch (error) {
                console.error('Submit error:', error);
                let errorMsg = 'Error submitting request. ';
                if (error.message && error.message.includes('fetch')) {
                    errorMsg += 'Cannot connect to server. Make sure the Functions server is running on port 8889.';
                } else {
                    errorMsg += error.message || 'Please check your internet connection and try again.';
                }
                alert(errorMsg);
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            }
        });
    }

    // Analysis function
    async function analyzeRequest(description, title) {
        try {
            const response = await fetch('/.netlify/functions/analyze-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ description, title })
            });

            const data = await response.json();

            if (data.success) {
                // Store analyzed values
                analyzedPriority = data.priority || 'medium';
                analyzedCategory = data.category || 'other';

                console.log('ML Analysis results:', {
                    category: analyzedCategory,
                    priority: analyzedPriority,
                    language: data.detectedLanguage
                });

                // Auto-fill category if empty
                if (issueTypeSelect && !issueTypeSelect.value && analyzedCategory && analyzedCategory !== 'other') {
                    issueTypeSelect.value = analyzedCategory;
                    // Trigger change event to update styling
                    const changeEvent = new Event('change', { bubbles: true });
                    issueTypeSelect.dispatchEvent(changeEvent);
                }

                // Show suggestion badge
                showSuggestionBadge(analyzedCategory, analyzedPriority, data.detectedLanguage);
            }
        } catch (error) {
            console.error('Analysis error:', error);
            // Silently fail - don't interrupt user experience
            // Reset analyzed values on error
            analyzedPriority = null;
            analyzedCategory = null;
        }
    }

    // Show suggestion badge
    function showSuggestionBadge(category, priority, detectedLanguage) {
        // Remove existing badge
        const existingBadge = document.querySelector('.ai-suggestion-badge');
        if (existingBadge) {
            existingBadge.remove();
        }

        // Format category name
        const categoryName = category.charAt(0).toUpperCase() + category.slice(1);
        const priorityName = priority.charAt(0).toUpperCase() + priority.slice(1);

        // Language indicator
        const langIndicator = detectedLanguage && detectedLanguage.startsWith('war')
            ? ' (Waray-Waray detected)'
            : '';

        // Create badge
        const badge = document.createElement('div');
        badge.className = 'ai-suggestion-badge';
        badge.innerHTML = `
            <span class="badge-icon">🤖</span>
            <span class="badge-text">AI suggests: <strong>${categoryName}</strong> (<strong>${priorityName}</strong> priority)${langIndicator}</span>
            <button class="badge-close" onclick="this.parentElement.remove()" aria-label="Close">×</button>
        `;

        // Add styles
        badge.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            max-width: 400px;
            animation: slideIn 0.3s ease-out;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        `;

        // Add close button styles
        const closeBtn = badge.querySelector('.badge-close');
        if (closeBtn) {
            closeBtn.style.cssText = `
                background: rgba(255,255,255,0.2);
                border: none;
                color: white;
                font-size: 20px;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                margin-left: auto;
                transition: background 0.2s;
            `;
            closeBtn.addEventListener('mouseenter', function() {
                this.style.background = 'rgba(255,255,255,0.3)';
            });
            closeBtn.addEventListener('mouseleave', function() {
                this.style.background = 'rgba(255,255,255,0.2)';
            });
        }

        // Add animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        if (!document.head.querySelector('style[data-badge-animation]')) {
            style.setAttribute('data-badge-animation', 'true');
            document.head.appendChild(style);
        }

        document.body.appendChild(badge);

        // Auto-remove after 8 seconds
        setTimeout(() => {
            if (badge.parentElement) {
                badge.style.animation = 'slideIn 0.3s ease-out reverse';
                setTimeout(() => badge.remove(), 300);
            }
        }, 8000);
    }
});
