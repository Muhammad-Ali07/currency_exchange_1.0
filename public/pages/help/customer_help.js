var help_customer_url = '/help/customer';
var help_customer_id = 'customer_name';
var help_customer_surname = 'customerHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_customer_surname).length;
    console.log(valid);
    if(valid) {
        var create_new_customer = thix.find('td').attr('data-field');

        if(create_new_customer == 'create_new_customer'){
            $('#createNewCustomer').modal('show')
            var name = $(document).find('#customer_name').val();
            $(document).find('#customer_create #name').val(name);
        }else{
            var customer_name = thix.find('td[data-field="customer_name"]').text();
            var customer_phone = thix.find('td[data-field="customer_phone"]').text();
            var customer_id = thix.find('td[data-field="customer_id"]').text();
            $('form').find('#customer_name').val(customer_name);
            $('form').find('#customer_id').val(customer_id);
            $('#customer_name').focus();

            if($('#form_type').val() !== undefined){
                if($('#form_type').val() == 'sale_invoice'){
                    funcGetCstVoucherDetail(customer_id);
                }
            }

        }
        $('#inLineHelp').remove();
    }
});

$('#'+help_customer_id).on('focusin keyup',function(e){
    $('#inLineHelp').remove();
    e.preventDefault();
    var thix = $(this);
    var val = thix.val();
    var eg_help_block = thix.parents('.eg_help_block');
    var inLIneHelpLength = eg_help_block.find('#inLineHelp').length;

    if ((val || !val) && inLIneHelpLength == 0){
        eg_help_block.append('<div id="inLineHelp"></div>');
        var inLineHelp = eg_help_block.find('#inLineHelp');
        val = val.replace(/\s/g,'%20');
        var url2 = help_customer_url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 30;
        var offsetLeft = thix.offset().left - eg_help_block.offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    }

});
$(document).on('click',function(e){
    if($(e.target).attr('id') != help_customer_id) {
        $("#inLineHelp[data-id='customer']").remove();
    }
});

$(document).on('click','#addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});

function funcGetCstVoucherDetail(customer_id) {
    var validate = true;
    if(valueEmpty(customer_id)){
        //  ntoastr.error("Select Any Product");
        validate = false;
        return false;
    }
    if(validate){
        var formData = {
            customer_id : customer_id
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: routeGetCstVoucherDetail,
            dataType	: 'json',
            data        : formData,
            success: function(response,data) {
                if(response.status == 'success'){
                    var balance_amount = response.data['balance_amount'];

                    $('form').find('#customer_balance').val(balance_amount);
                }else{
                    ntoastr.error(response.message);
                }
            },
            error: function(response,status) {
                ntoastr.error('server error..404');
            }
        });
    }
}
