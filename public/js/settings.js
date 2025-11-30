// Settings JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Load and populate user data from localStorage
    function loadUserData() {
        try {
            const userData = localStorage.getItem('user_data');
            if (!userData) return;

            const user = JSON.parse(userData);

            // Update avatar - show profile picture if available, otherwise show initials
            const avatar = document.querySelector('.avatar');
            const profilePicture = document.getElementById('profile-picture');

            if (user.picture && profilePicture) {
                profilePicture.src = user.picture;
                profilePicture.style.display = 'block';
                if (avatar) avatar.style.display = 'none';
            } else if (avatar && user.name) {
                // Show initials if no picture
                const nameParts = user.name.trim().split(' ');
                let initials = '';
                if (nameParts.length >= 2) {
                    initials = (nameParts[0][0] + nameParts[nameParts.length - 1][0]).toUpperCase();
                } else if (nameParts.length === 1) {
                    initials = nameParts[0][0].toUpperCase();
                }
                avatar.textContent = initials || 'U';
                if (profilePicture) profilePicture.style.display = 'none';
            }

            // Make profile picture/avatar clickable to upload new image
            const avatarContainer = document.querySelector('.avatar-container');
            const profilePictureInput = document.getElementById('profile-picture-input');

            if (avatarContainer && profilePictureInput) {
                avatarContainer.addEventListener('click', () => {
                    profilePictureInput.click();
                });

                profilePictureInput.addEventListener('change', async function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Validate file type
                        if (!file.type.startsWith('image/')) {
                            alert('Please select an image file.');
                            return;
                        }

                        // Validate file size (max 5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Image size must be less than 5MB.');
                            return;
                        }

                        // Read and display the image
                        const reader = new FileReader();
                        reader.onload = async function(e) {
                            if (profilePicture) {
                                profilePicture.src = e.target.result;
                                profilePicture.style.display = 'block';
                                if (avatar) avatar.style.display = 'none';
                            }

                            // Upload to server
                            try {
                                const token = localStorage.getItem('auth_token');
                                if (!token) {
                                    throw new Error('Not authenticated. Please log in again.');
                                }

                                const userData = localStorage.getItem('user_data');
                                const user = userData ? JSON.parse(userData) : null;
                                if (!user) {
                                    throw new Error('User data not found. Please log in again.');
                                }

                                // Create FormData for file upload
                                const formData = new FormData();
                                formData.append('profile_picture', file);

                                // Upload profile picture
                                const uploadResponse = await fetch('/.netlify/functions/api/user/profile-picture', {
                                    method: 'POST',
                                    headers: {
                                        'Authorization': `Bearer ${token}`
                                    },
                                    body: formData
                                });

                                const uploadResult = await uploadResponse.json();

                                if (uploadResponse.ok && uploadResult.success) {
                                    // Update localStorage with new picture URL
                                    const updatedUser = {
                                        ...user,
                                        picture: uploadResult.picture_url
                                    };
                                    localStorage.setItem('user_data', JSON.stringify(updatedUser));
                                    console.log('Profile picture uploaded successfully');
                                } else {
                                    throw new Error(uploadResult.error || 'Failed to upload profile picture');
                                }
                            } catch (error) {
                                console.error('Error uploading profile picture:', error);
                                alert('Failed to upload profile picture: ' + error.message);
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Update profile display
            const profileName = document.querySelector('.profile-name');
            if (profileName && user.name) {
                profileName.textContent = user.name;
            }

            const profileEmail = document.querySelector('.profile-email');
            if (profileEmail && user.email) {
                profileEmail.textContent = user.email;
            }

            // Parse full name into first/last if not separately available
            let firstName = user.firstName || user.first_name || '';
            let lastName = user.lastName || user.last_name || '';

            // Always re-parse from full name if available (to fix incorrect saved values)
            // This ensures the name fields always match the current full name
            if (user.name) {
                const nameParts = user.name.trim().split(' ').filter(part => part.length > 0);

                // Common suffixes to ignore when determining last name
                const suffixes = ['jr', 'sr', 'ii', 'iii', 'iv', 'v', 'jr.', 'sr.', 'ii.', 'iii.', 'iv.', 'v.'];

                // Check if last part is a suffix (single letter with period or common suffix)
                let lastPart = nameParts[nameParts.length - 1].toLowerCase();
                let isSuffix = false;
                let namePartsWithoutSuffix = [...nameParts];

                // Check if it's a single letter with period (like "O.")
                if (nameParts[nameParts.length - 1].length === 2 && nameParts[nameParts.length - 1].endsWith('.')) {
                    isSuffix = true;
                    namePartsWithoutSuffix = nameParts.slice(0, -1);
                } else if (suffixes.includes(lastPart)) {
                    isSuffix = true;
                    namePartsWithoutSuffix = nameParts.slice(0, -1);
                }

                if (namePartsWithoutSuffix.length >= 2) {
                    if (namePartsWithoutSuffix.length === 2) {
                        // Two words: first = first name, second = last name
                        firstName = namePartsWithoutSuffix[0];
                        lastName = namePartsWithoutSuffix[1];
                    } else if (namePartsWithoutSuffix.length >= 3) {
                        // Three or more words:
                        // Try to detect if surname comes first (common in some cultures)
                        // For now, use: first word = last name, rest = first name
                        // This handles cases like "Montallana Val John" where Montallana is the surname
                        lastName = namePartsWithoutSuffix[0];
                        firstName = namePartsWithoutSuffix.slice(1).join(' ');
                    }
                } else if (namePartsWithoutSuffix.length === 1) {
                    // Only one name part - use as first name
                    firstName = namePartsWithoutSuffix[0];
                    lastName = '';
                }
            }

            // Populate form fields
            const firstNameInput = document.getElementById('first_name');
            if (firstNameInput) {
                firstNameInput.value = firstName;
            }

            const lastNameInput = document.getElementById('last_name');
            if (lastNameInput) {
                lastNameInput.value = lastName;
            }

            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.value = user.email || '';
            }

            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.value = user.phone || user.phone_number || '';
            }

            const addressInput = document.getElementById('address');
            if (addressInput) {
                addressInput.value = user.address || '';
            }
        } catch (error) {
            console.error('Error loading user data:', error);
        }
    }

    // Load user data on page load
    loadUserData();

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



    // Password visibility toggle
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
        const wrapper = input.closest('.input-wrapper');
        if (wrapper) {
            const icon = wrapper.querySelector('.input-icon');
            if (icon) {
                icon.style.cursor = 'pointer';
                icon.addEventListener('click', () => {
                    if (input.type === 'password') {
                        input.type = 'text';
                    } else {
                        input.type = 'password';
                    }
                });
            }
        }
    });

    // Handle profile form submission
    const profileForm = document.querySelector('#profile-tab form');
    if (profileForm) {
        profileForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const saveButton = profileForm.querySelector('.save-button');
            const originalButtonText = saveButton.innerHTML;

            // Disable button and show loading state
            saveButton.disabled = true;
            saveButton.innerHTML = '<span>Saving...</span>';

            try {
                // Get form values
                const firstName = document.getElementById('first_name').value.trim();
                const lastName = document.getElementById('last_name').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();
                const address = document.getElementById('address').value.trim();

                // Get auth token
                const token = localStorage.getItem('auth_token');
                if (!token) {
                    throw new Error('Not authenticated. Please log in again.');
                }

                // Get user data
                const userData = localStorage.getItem('user_data');
                if (!userData) {
                    throw new Error('User data not found. Please log in again.');
                }
                const user = JSON.parse(userData);

                // Prepare update data
                const updateData = {
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    phone: phone,
                    address: address
                };

                // Send update request
                const response = await fetch('/.netlify/functions/api/user/profile', {
                    method: 'PATCH',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(updateData)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Update localStorage with new data - preserve picture field
                    const updatedUser = {
                        ...user,
                        firstName: firstName,
                        lastName: lastName,
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        phone: phone,
                        address: address,
                        picture: user.picture || null  // Preserve existing picture
                    };
                    localStorage.setItem('user_data', JSON.stringify(updatedUser));

                    // Update displayed name if it changed
                    const profileName = document.querySelector('.profile-name');
                    if (profileName && (firstName || lastName)) {
                        profileName.textContent = `${firstName} ${lastName}`.trim() || user.name;
                    }

                    // Ensure profile picture display is maintained after form submission
                    const avatar = document.querySelector('.avatar');
                    const profilePicture = document.getElementById('profile-picture');
                    if (updatedUser.picture && profilePicture) {
                        profilePicture.src = updatedUser.picture;
                        profilePicture.style.display = 'block';
                        if (avatar) avatar.style.display = 'none';
                    } else if (avatar && updatedUser.name) {
                        // Show initials if no picture
                        const nameParts = updatedUser.name.trim().split(' ');
                        let initials = '';
                        if (nameParts.length >= 2) {
                            initials = (nameParts[0][0] + nameParts[nameParts.length - 1][0]).toUpperCase();
                        } else if (nameParts.length === 1) {
                            initials = nameParts[0][0].toUpperCase();
                        }
                        avatar.textContent = initials || 'U';
                        if (profilePicture) profilePicture.style.display = 'none';
                    }

                    // Remove focus from all input fields
                    const allInputs = profileForm.querySelectorAll('input');
                    allInputs.forEach(input => {
                        input.blur();
                    });

                    // Show success message
                    alert('Profile updated successfully!');
                } else {
                    throw new Error(result.error || 'Failed to update profile');
                }
            } catch (error) {
                console.error('Error updating profile:', error);
                alert('Failed to update profile: ' + error.message);
            } finally {
                // Re-enable button
                saveButton.disabled = false;
                saveButton.innerHTML = originalButtonText;
            }
        });
    }

    // Handle contact information form submission
    const contactInfoForm = document.getElementById('contact-info-form');
    if (contactInfoForm) {
        // Load contact information on page load
        function loadContactInfo() {
            try {
                const userData = localStorage.getItem('user_data');
                if (!userData) return;

                const user = JSON.parse(userData);

                // Populate contact information fields
                const emergencyContactName = document.getElementById('emergency_contact_name');
                if (emergencyContactName) {
                    emergencyContactName.value = user.emergency_contact_name || '';
                }

                const emergencyContactPhone = document.getElementById('emergency_contact_phone');
                if (emergencyContactPhone) {
                    emergencyContactPhone.value = user.emergency_contact_phone || '';
                }

                const preferredContactMethod = document.getElementById('preferred_contact_method');
                if (preferredContactMethod) {
                    preferredContactMethod.value = user.preferred_contact_method || 'phone';
                }

                const contactTimePreference = document.getElementById('contact_time_preference');
                if (contactTimePreference) {
                    contactTimePreference.value = user.contact_time_preference || 'anytime';
                }
            } catch (error) {
                console.error('Error loading contact information:', error);
            }
        }

        // Load contact info on page load
        loadContactInfo();

        // Handle form submission
        contactInfoForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const saveButton = contactInfoForm.querySelector('.update-button');
            const originalButtonText = saveButton.innerHTML;

            // Disable button and show loading state
            saveButton.disabled = true;
            saveButton.innerHTML = '<span>Saving...</span>';

            try {
                // Get form values
                const emergencyContactName = document.getElementById('emergency_contact_name').value.trim();
                const emergencyContactPhone = document.getElementById('emergency_contact_phone').value.trim();
                const preferredContactMethod = document.getElementById('preferred_contact_method').value;
                const contactTimePreference = document.getElementById('contact_time_preference').value;

                // Get auth token
                const token = localStorage.getItem('auth_token');
                if (!token) {
                    throw new Error('Not authenticated. Please log in again.');
                }

                // Get user data
                const userData = localStorage.getItem('user_data');
                if (!userData) {
                    throw new Error('User data not found. Please log in again.');
                }
                const user = JSON.parse(userData);

                // Prepare update data
                const updateData = {
                    emergency_contact_name: emergencyContactName,
                    emergency_contact_phone: emergencyContactPhone,
                    preferred_contact_method: preferredContactMethod,
                    contact_time_preference: contactTimePreference
                };

                // Send update request
                const response = await fetch('/.netlify/functions/api/user/contact-info', {
                    method: 'PATCH',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(updateData)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Update localStorage with new data
                    const updatedUser = {
                        ...user,
                        emergency_contact_name: emergencyContactName,
                        emergency_contact_phone: emergencyContactPhone,
                        preferred_contact_method: preferredContactMethod,
                        contact_time_preference: contactTimePreference
                    };
                    localStorage.setItem('user_data', JSON.stringify(updatedUser));

                    // Remove focus from all input fields
                    const allInputs = contactInfoForm.querySelectorAll('input, select');
                    allInputs.forEach(input => {
                        input.blur();
                    });

                    // Show success message
                    alert('Contact information updated successfully!');
                } else {
                    throw new Error(result.error || 'Failed to update contact information');
                }
            } catch (error) {
                console.error('Error updating contact information:', error);
                alert('Failed to update contact information: ' + error.message);
            } finally {
                // Re-enable button
                saveButton.disabled = false;
                saveButton.innerHTML = originalButtonText;
            }
        });
    }
});

