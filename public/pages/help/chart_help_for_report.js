// var url = '/help/reportChart';
// var id = 'chartHelpForReport';

// $(document).on('click','.data_tbody_row',function(e){
//     var thix = $(this);

//     var chart_code = thix.find('td[data-field="chart_code"]').text();
//     var chart_name = thix.find('td[data-field="chart_name"]').text();
//     var chart_id = thix.find('td[data-field="chart_id"]').text();

//     $('.egt_form_header_input').find('.chart_code').val(chart_code);
//     $('.egt_form_header_input').find('.chart_name').val(chart_name);
//     $('.egt_form_header_input').find('.chart_id').val(chart_id);

// });

// $('#'+id).keyup(function(e){
//     var thix = $(this);
//     var val = thix.val();
//     var inLIneHelpLength = $('#erp_grid_table>.erp_form___block').find('#inLineHelp').length;
//     if (e.which === 113 && inLIneHelpLength == 0 && val.length < 3 ) {
//         e.preventDefault();
//         $('#erp_grid_table>.erp_form___block').append('<div id="inLineHelp"></div>');
//         var inLineHelp = $('#erp_grid_table>.erp_form___block').find('#inLineHelp');
//         inLineHelp.load(url);
//         var offsetTop = 64;
//         var offsetLeft = thix.offset().left - $('.erp_form___block').offset().left;
//         $('#inLineHelp').css({top:offsetTop+'px'});
//         $('#inLineHelp').css({left:offsetLeft+'px'});
//     } else if (e.which === 113 && inLIneHelpLength == 0 && val.length > 3) {
//         e.preventDefault();
//         $('#erp_grid_table>.erp_form___block').append('<div id="inLineHelp"></div>');
//         var inLineHelp = $('#erp_grid_table>.erp_form___block').find('#inLineHelp');
//         url2 = url +'/'+val
//         inLineHelp.load(url2);
//         var offsetTop = 64;
//         var offsetLeft = thix.offset().left - $('.erp_form___block').offset().left;
//         $('#inLineHelp').css({top:offsetTop+'px'});
//         $('#inLineHelp').css({left:offsetLeft+'px'});
//     } else {
//         var value = val.toLowerCase();
//         $(".val_table").filter(function(){
//             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
//         });

//         if(e.which === 8 && val.length < 9){
//             thix.parents('tr').find('.chart_name').val('');
//         }
//     }
// });
// $(document).on('click',function(e){
//     if($(e.target).attr('id') != id) {
//         $('#inLineHelp').remove();
//     }
// });



var help_customer_url = '/help/reportChart';
var help_customer_id = 'chartHelpForReport';
var help_customer_surname = 'reportChart';

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
