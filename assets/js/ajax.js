// Ajax utility functions for CDHCS

// Function to make AJAX requests
function ajaxRequest(url, method = 'GET', data = null, callback = null) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                if (callback) {
                    callback(JSON.parse(xhr.responseText));
                }
            } else {
                console.error('AJAX Error:', xhr.status, xhr.responseText);
                alert('An error occurred. Please try again.');
            }
        }
    };

    if (data) {
        const params = new URLSearchParams(data).toString();
        xhr.send(params);
    } else {
        xhr.send();
    }
}

// Accept request for volunteers
function acceptRequest(requestId) {
    if (confirm('Are you sure you want to accept this request?')) {
        ajaxRequest('/dashboard?action=accept-request&id=' + requestId, 'GET', null, function(response) {
            if (response.success) {
                alert('Request accepted successfully!');
                location.reload(); // Reload to update the list
            } else {
                alert('Failed to accept request: ' + response.message);
            }
        });
    }
}

// Delete user for admins
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        ajaxRequest('/dashboard?action=delete-user&id=' + userId, 'GET', null, function(response) {
            if (response.success) {
                alert('User deleted successfully!');
                location.reload(); // Reload to update the list
            } else {
                alert('Failed to delete user: ' + response.message);
            }
        });
    }
}

// Delete request for admins
function deleteRequest(requestId) {
    if (confirm('Are you sure you want to delete this request?')) {
        ajaxRequest('/dashboard?action=delete-request&id=' + requestId, 'GET', null, function(response) {
            if (response.success) {
                alert('Request deleted successfully!');
                location.reload(); // Reload to update the list
            } else {
                alert('Failed to delete request: ' + response.message);
            }
        });
    }
}

// Reset password
function resetPassword(email) {
    ajaxRequest('/forget-password', 'POST', { email: email }, function(response) {
        if (response.success) {
            alert('Password reset successful! Check your email.');
        } else {
            alert('Password reset failed: ' + response.message);
        }
    });
}

// Attach event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // For volunteer dashboard accept buttons
    const acceptButtons = document.querySelectorAll('.accept-btn');
    acceptButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const requestId = this.getAttribute('data-id');
            acceptRequest(requestId);
        });
    });

    // For admin dashboard delete user buttons
    const deleteUserButtons = document.querySelectorAll('.delete-user-btn');
    deleteUserButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = this.getAttribute('data-id');
            deleteUser(userId);
        });
    });

    // For admin dashboard delete request buttons
    const deleteRequestButtons = document.querySelectorAll('.delete-request-btn');
    deleteRequestButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const requestId = this.getAttribute('data-id');
            deleteRequest(requestId);
        });
    });

    // For forget password form
    const forgetForm = document.getElementById('forget-password-form');
    if (forgetForm) {
        forgetForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            resetPassword(email);
        });
    }
});