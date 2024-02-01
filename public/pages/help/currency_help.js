var help_customer_url = '/help/currencyChartHelp';
var help_customer_id = 'chart_name';
var help_customer_surname = 'currencyChartHelp';

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
            var chart_name = thix.find('td[data-field="chart_name"]').text();
            // var customer_phone = thix.find('td[data-field="customer_phone"]').text();
            var chart_id = thix.find('td[data-field="chart_id"]').text();
            $('form').find('#chart_name').val(chart_name);
            $('form').find('#chart_id').val(chart_id);
            $('#chart_name').focus();

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
        $("#inLineHelp[data-id='chart_help_for_report']").remove();
    }
});

$(document).on('click','#addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});
