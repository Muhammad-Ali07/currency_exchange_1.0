var help_ledger_url = '/help/chartVoucherHelp';
var help_ledger_id = 'ledger_name';
var help_ledger_surname = 'chartVoucherHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_ledger_surname).length;
    console.log(valid);
    if(valid) {
        // var create_new_customer = thix.find('td').attr('data-field');

        // if(create_new_customer == 'create_new_customer'){
        //     $('#createNewCustomer').modal('show')
        //     var name = $(document).find('#ledger_name').val();
        //     $(document).find('#customer_create #name').val(name);
        // }else{
            var ledger_name = thix.find('td[data-field="ledger_name"]').text();
            var ledger_id = thix.find('td[data-field="ledger_id"]').text();

            $('form').find('#ledger_name').val(ledger_name);
            $('form').find('#ledger_id').val(ledger_id);
            $('#ledger_name').focus();

        // }
        $('#inLineHelp').remove();
    }
});

$('#'+help_ledger_id).on('focusin keyup',function(e){
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
        var url2 = help_ledger_url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 30;
        var offsetLeft = thix.offset().left - eg_help_block.offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    }

});
$(document).on('click',function(e){
    if($(e.target).attr('id') != help_ledger_id) {
        $("#inLineHelp[data-id='chart_voucher_help']").remove();
    }
});

$(document).on('click','#om_addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});
