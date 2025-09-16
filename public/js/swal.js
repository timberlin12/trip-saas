// Make sure jQuery and SweetAlert2 are loaded before this script
$(document).ready(function () {

    // === Flash messages from Laravel session ===
    if (window.Laravel && window.Laravel.flash) {
        const flash = window.Laravel.flash;

        if (flash.success) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: flash.success,
                showConfirmButton: false,
                timer: 3000
            });
        }

        if (flash.error) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: flash.error,
                showConfirmButton: false,
                timer: 3000
            });
        }
    }

    // === Helper function to show toast from JS/AJAX ===
    window.showSwalToast = function(type, message) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 3000
        });
    }
    // === Helper function to show delete confirmation ===
    window.confirmDelete = function(id, url, onSuccess, are_you_sure, you_will_not_be_able_to_recover_the_deleted_record, yes_delete_it, cancel) {
        Swal.fire({
            title: are_you_sure,
            text: you_will_not_be_able_to_recover_the_deleted_record,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: yes_delete_it,
            cancelButtonText: cancel,
            customClass: { confirmButton:'btn btn-danger', cancelButton:'btn btn-secondary' },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: url.replace(':id', id),
                    method: 'POST',
                    data: { _method: 'DELETE' },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        if (response.success) {
                            showSwalToast('success', response.message);
                            if (typeof onSuccess === 'function') onSuccess();
                        } else if (response.error) {
                            showSwalToast('error', response.error);
                        }
                    }
                });
            }
        });
    }
});
