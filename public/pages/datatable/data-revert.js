$('.datatables-ajax').on('click', '.revert-record', function (e) {
    var url = $(this).attr('data-url');
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, revert it!'
    }).then(function(result) {
        if (result.value) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url:url,
                data:{_token: CSRF_TOKEN},
                success: function(response, status){
                    if ( response.status === 'success' ) {
                        Swal.fire({
                            title:  'Revert!',
                            text:   response.message,
                            type:   'success',
                            showConfirmButton: false,
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 2000);

                    }else{
                        Swal.fire({
                            title:  'Not Revert!',
                            text:   response.message,
                            type:   'error',
                        });
                    }
                }
            });
        }
    });
});
