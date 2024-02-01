var url = '/help/chart';
var id = 'egt_chart_code';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);

    var chart_code = thix.find('td[data-field="chart_code"]').text();
    var chart_name = thix.find('td[data-field="chart_name"]').text();
    var chart_id = thix.find('td[data-field="chart_id"]').text();

    $('.egt_form_header_input').find('.chart_code').val(chart_code);
    $('.egt_form_header_input').find('.chart_name').val(chart_name);
    $('.egt_form_header_input').find('.chart_id').val(chart_id);

    
});

$('#'+id).keyup(function(e){
    var thix = $(this);
    var val = thix.val();
    var inLIneHelpLength = $('#erp_grid_table>.erp_form___block').find('#inLineHelp').length;
    if (e.which === 113 && inLIneHelpLength == 0 && val.length < 3 ) {
        e.preventDefault();
        $('#erp_grid_table>.erp_form___block').append('<div id="inLineHelp"></div>');
        var inLineHelp = $('#erp_grid_table>.erp_form___block').find('#inLineHelp');
        inLineHelp.load(url);
        var offsetTop = 64;
        var offsetLeft = thix.offset().left - $('.erp_form___block').offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    } else if (e.which === 113 && inLIneHelpLength == 0 && val.length > 3) {
        e.preventDefault();
        $('#erp_grid_table>.erp_form___block').append('<div id="inLineHelp"></div>');
        var inLineHelp = $('#erp_grid_table>.erp_form___block').find('#inLineHelp');
        url2 = url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 64;
        var offsetLeft = thix.offset().left - $('.erp_form___block').offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    } else {
        var value = val.toLowerCase();
        $(".val_table").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });

        if(e.which === 8 && val.length < 9){
            thix.parents('tr').find('.chart_name').val('');
        }
    }
});
$(document).on('click',function(e){
    if($(e.target).attr('id') != id) {
        $('#inLineHelp').remove();
    }
});
