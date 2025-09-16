var successMessage = localStorage.getItem('success');
if (successMessage) {
    Swal.fire({
        title: 'Great!',
        text: successMessage,
        icon: 'success',
        showConfirmButton: false,
        timer: 3000
    });
    localStorage.removeItem('success');
}
$(document).ready(function() {
    $('#submitLoginDetails').click(function (e) {
        e.preventDefault();

        $('#emailMsg').text('');
        $('#passwordMsg').text('');
        $('#errorAlert').addClass('d-none');

        var formData = $(this).closest('form').serialize();

        $.ajax({
            method: 'POST',
            url: loginUrl,
            data: formData,
            success: function (data) {
                localStorage.setItem('success', 'You have been logged in successfully.');
                window.location.href = data.redirect_url;
            },
            error: function (xhr) {
                $('#errorAlert').removeClass('d-none');
                $('#emailMsg').text('');
                $('#passwordMsg').text('');
                var messages = xhr.responseJSON.messages;
                if (xhr.responseJSON && xhr.responseJSON.messages) {
                    if (messages.hasOwnProperty('email')) {
                        $('#emailMsg').text(messages.email[0]);
                    }
                    if (messages.hasOwnProperty('password')) {
                        $('#passwordMsg').text(messages.password[0]);
                    }
                } else {
                    $('#emailMsg').text('');
                    $('#passwordMsg').text('');
                    $('#errorAlert').text('Something went wrong. Please try again.');
                }
            }
        });
    });

    $('#logoutButton').click(function(e) {
        e.preventDefault();
        var loginUrl = $(this).data('login-url');
        var logoutUrl = $(this).data('url');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: logoutUrl,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function() {
                window.location.href = loginUrl;
            },
            error: function() {
                alert("Logout failed. Please try again.");
            }
        });
    });
});

