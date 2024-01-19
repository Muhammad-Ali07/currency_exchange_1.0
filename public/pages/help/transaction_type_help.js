var help_transaction_type_url = '/help/transactionTypeHelp';
var help_transaction_type_id = 'transaction_type';
var help_transaction_type_surname = 'transactionTypeHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_transaction_type_surname).length;
    if(valid) {
        var transaction_type = thix.find('td[data-field="transaction_type"]').text();
        // var transaction_type_name = thix.find('td[data-field="transaction_type_name"]').text();
        // var transaction_type_id = thix.find('td[data-field="transaction_type_id"]').text();

        $('form').find('#transaction_type').val(transaction_type);
        // $('form').find('#transaction_type_id').val(transaction_type_id);

        if($('#form_type').val() !== undefined){
            if($('#form_type').val() == 'sale_invoice'){
                // funcGetProductDetail(product_id);
            }
        }

        $('#inLineHelp').remove();
    }
});

$('#'+help_transaction_type_id).on('focusin keyup',function(e){
    $('#inLineHelp').remove();
    var validate = true;
    var project_id = 1;

    if(valueEmpty(project_id)){
        ntoastr.error("First Select Any Project");
        validate = false;
        return false;
    }
    if(validate){
        e.preventDefault();
        var thix = $(this);
        var val = thix.val();
        var eg_help_block = thix.parents('.eg_help_block');
        var inLIneHelpLength = eg_help_block.find('#inLineHelp').length;
        if ((val || !val) && inLIneHelpLength == 0){
            eg_help_block.append('<div id="inLineHelp"></div>');
            var inLineHelp = eg_help_block.find('#inLineHelp');
            val = val.replace(/\s/g,'%20');
            // var setval = "?project_id="+project_id
            // setval += "&search="+val
            // var url2 = help_product_url +'/'+setval
            var url2 = help_transaction_type_url

            inLineHelp.load(url2);
            var offsetTop = 30;
            var offsetLeft = thix.offset().left - eg_help_block.offset().left;
            eg_help_block.find('#inLineHelp').css({top:offsetTop+'px'});
            eg_help_block.find('#inLineHelp').css({left:offsetLeft+'px'});
        }
    }
});

$(document).on('click',function(e){
    if($(e.target).attr('id') != help_transaction_type_id) {
        $("#inLineHelp[data-id='transaction_type']").remove();
    }
});

$(document).on('click','#addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});

function funcGetProductDetail(product_id) {
    var validate = true;
    if(valueEmpty(product_id)){
        //  ntoastr.error("Select Any Product");
        validate = false;
        return false;
    }
    if(validate){
        var formData = {
            product_id : product_id
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: routeGetProductDetail,
            dataType	: 'json',
            data        : formData,
            success: function(response,data) {
                if(response.status == 'success'){
                    var product = response.data['product'];

                    $('form').find('#sale_price').val(product.default_sale_price);
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

