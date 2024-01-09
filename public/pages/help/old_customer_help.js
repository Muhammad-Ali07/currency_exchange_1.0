var help_om_customer_url = '/help/oldCustomerHelp';
var help_om_customer_id = 'om_customer_name';
var help_om_customer_surname = 'oldCustomerHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_om_customer_surname).length;
    console.log(valid);
    if(valid) {
        var create_new_customer = thix.find('td').attr('data-field');

        if(create_new_customer == 'create_new_customer'){
            $('#createNewCustomer').modal('show')
            var name = $(document).find('#om_customer_name').val();
            $(document).find('#customer_create #name').val(name);
        }else{
            var customer_name = thix.find('td[data-field="customer_name"]').text();
            var customer_phone = thix.find('td[data-field="customer_phone"]').text();
            var customer_id = thix.find('td[data-field="customer_id"]').text();
            $('form').find('#om_customer_name').val(customer_name);
            $('form').find('#om_customer_id').val(customer_id);
            $('#om_customer_name').focus();

        }
        $('#inLineHelp').remove();
    }
});

$('#'+help_om_customer_id).on('focusin keyup',function(e){
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
        var url2 = help_om_customer_url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 30;
        var offsetLeft = thix.offset().left - eg_help_block.offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    }

});
$(document).on('click',function(e){
    if($(e.target).attr('id') != help_om_customer_id) {
        $("#inLineHelp[data-id='old_customer']").remove();
    }
});

$(document).on('click','#om_addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});
