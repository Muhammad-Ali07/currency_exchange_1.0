$('.datatables-ajax').on('click', '.delete-record', function (e) {
    var url = $(this).attr('data-url');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(function(result) {
        if (result.value) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url:url,
                data:{_token: CSRF_TOKEN},
                success: function(response, status){
                    if ( response.status === 'success' ) {
                        Swal.fire({
                            title:  'Deleted!',
                            text:   response.message,
                            type:   'success',
                            showConfirmButton: false,
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 2000);

                    }else{
                        Swal.fire({
                            title:  'Not Deleted!',
                            text:   response.message,
                            type:   'error',
                        });
                    }
                }
            });
        }
    });
});
