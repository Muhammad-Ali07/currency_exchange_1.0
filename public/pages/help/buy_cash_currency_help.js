var help_buy_cash_currency_url = '/help/buyCashCurrencyHelp';
var help_buy_cash_currency_id = 'buy_cash_chart_name';
var help_buy_cash_currency_surname = 'buyCashCurrencyHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_buy_cash_currency_surname).length;
    console.log(valid);
    if(valid) {
        var create_new_buy_cash_currency = thix.find('td').attr('data-field');

        if(create_new_buy_cash_currency == 'create_new_buy_cash_currency'){
            $('#createNewbuy_cash_currency').modal('show')
            var name = $(document).find('#buy_cash_currency_name').val();
            $(document).find('#buy_cash_currency_create #name').val(name);
        }else{
            var chart_name = thix.find('td[data-field="buy_cash_chart_name"]').text();
            // var buy_cash_currency_phone = thix.find('td[data-field="buy_cash_currency_phone"]').text();
            var chart_id = thix.find('td[data-field="buy_cash_chart_id"]').text();
            var product_id = thix.find('td[data-field="product_id"]').text();

            $('form').find('#buy_cash_chart_name').val(chart_name);
            $('form').find('#buy_cash_chart_id').val(chart_id);
            $('#buy_cash_chart_name').focus();

            if($('#form_type').val() !== undefined){
                if($('#form_type').val() == 'sale_invoice'){
                    funcGetBuyProductChartDetail(product_id);
                }
            }


        }
        $('#inLineHelp').remove();
    }
});

$('#'+help_buy_cash_currency_id).on('focusin keyup',function(e){
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
        var url2 = help_buy_cash_currency_url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 30;
        var offsetLeft = thix.offset().left - eg_help_block.offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    }

});
$(document).on('click',function(e){
    if($(e.target).attr('id') != help_buy_cash_currency_id) {
        $("#inLineHelp[data-id='buy_cash_currency_help']").remove();
    }
});

$(document).on('click','#addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});

function funcGetBuyProductChartDetail(product_id) {
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
            url: routeGetBuyProductDetail,
            dataType	: 'json',
            data        : formData,
            success: function(response,data) {
                if(response.status == 'success'){
                    var vouchers_sum = response.data['vouchers_sum'];
                    console.log(vouchers_sum);
                    $('form').find('#stock_in').val(vouchers_sum);
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

