var help_cash_currency_url = '/help/cashCurrencyHelp';
var help_cash_currency_id = 'cash_chart_name';
var help_cash_currency_surname = 'cashCurrencyHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_cash_currency_surname).length;
    console.log(valid);
    if(valid) {
        var create_new_cash_currency = thix.find('td').attr('data-field');

        if(create_new_cash_currency == 'create_new_cash_currency'){
            $('#createNewcash_currency').modal('show')
            var name = $(document).find('#cash_currency_name').val();
            $(document).find('#cash_currency_create #name').val(name);
        }else{
            var chart_name = thix.find('td[data-field="cash_chart_name"]').text();
            // var cash_currency_phone = thix.find('td[data-field="cash_currency_phone"]').text();
            var chart_id = thix.find('td[data-field="cash_chart_id"]').text();
            var product_id = thix.find('td[data-field="cash_product_id"]').text();

            $('form').find('#cash_chart_name').val(chart_name);
            $('form').find('#cash_chart_id').val(chart_id);
            $('#cash_chart_name').focus();

            if($('#form_type').val() !== undefined){
                if($('#form_type').val() == 'sale_invoice'){
                    funcGetProductChartDetail(chart_id);
                }
            }


        }
        $('#inLineHelp').remove();
    }
});

$('#'+help_cash_currency_id).on('focusin keyup',function(e){
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
        var url2 = help_cash_currency_url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 30;
        var offsetLeft = thix.offset().left - eg_help_block.offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    }

});
$(document).on('click',function(e){
    if($(e.target).attr('id') != help_cash_currency_id) {
        $("#inLineHelp[data-id='cash_currency_help']").remove();
    }
});

$(document).on('click','#addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});

function funcGetProductChartDetail(chart_id) {
    var validate = true;
    if(valueEmpty(chart_id)){
        //  ntoastr.error("Select Any Product");
        validate = false;
        return false;
    }
    if(validate){
        var formData = {
            chart_id : chart_id
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
                    var vouchers_sum = response.data['vouchers_sum'];
                    console.log(vouchers_sum);
                    $('form').find('#bank_code').find('#bank_balance').val('');
                    $('form').find('#bank_code').find('#bank_chart_name').val('');
                    $('form').find('#bank_code').find('#bank_chart_id').val('');

                    $('form').find('#cash_code').find('#cih_balance').val(vouchers_sum);
                    var buy_rate = $('form').find('#buy_rate').val();
                    var quantity = $('form').find('#quantity').val();
                    var total_amount = parseFloat(buy_rate) * parseFloat(quantity);
                    var amount_to_be_paid = '$' + total_amount;
                    $('form').find('#amount').text(amount_to_be_paid);
                    $('form').find('.amount').val(total_amount);
                    if(total_amount > vouchers_sum){
                        $('form').find('#transaction_save_btn').prop('disabled',true);
                        ntoastr.error('Cash in hand is less then the amount to be paid...');
                    }else if(vouchers_sum == 0){
                        $('form').find('#transaction_save_btn').prop('disabled',true);
                        ntoastr.error('Cash in hand is not enough...');
                    }else{
                        $('form').find('#transaction_save_btn').prop('disabled',false);
                        // funcGetProductQtyDetail(chart_id,total_amount);
                    }
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

function funcGetProductQtyDetail(chart_id,total_amount) {
    var validate = true;
    if(valueEmpty(chart_id)){
        //  ntoastr.error("Select Any Product");
        validate = false;
        return false;
    }
    if(validate){
        var formData = {
            chart_id : chart_id,
            total_amount : total_amount
        };
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: routeGetProductQtyDetail,
            dataType	: 'json',
            data        : formData,
            success: function(response,data) {
                if(response.status == 'success'){
                    var vouchers_sum = response.data['vouchers_sum'];
                    console.log(vouchers_sum);
                    $('form').find('#cash_code').find('#cih_balance').val(vouchers_sum);
                    var buy_rate = $('form').find('#buy_rate').val();
                    var quantity = $('form').find('#quantity').val();
                    var total_amount = parseFloat(buy_rate) * parseFloat(quantity);
                    var amount_to_be_paid = '$' + total_amount;
                    $('form').find('#amount').text(amount_to_be_paid);
                    $('form').find('.amount').val(total_amount);

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


