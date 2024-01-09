<script>
    var project_id = '';
    function project_name(project_id){
        // alert(project_id);
        // e.preventDefault();
            // var thix = $(this);
            // alert(thix.$('.project_id').val());
            var branch = project_id;
            // console.log(branch);
            var formData = {
                branches : branch
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url         : '{{ route('branchStore') }}',
                type        : 'POST',
                data        : formData,
                success: function(response,status) {
                    if(response.status == 'success'){
                        toastr.success('Branch Switch Successfully');
                            location.reload();
                    }else{
                        toastr.error(response.message);
                    }
                },
                error: function(response,status) {
                    // console.log(response.responseJSON);
                    $('body').removeClass('pointerEventsNone');
                    toastr.error(response.responseJSON.message);
                },
            });

    }

</script>
