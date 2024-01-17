var help_product_url = '/help/property-product';
var help_product_id = 'product_name';
var help_product_surname = 'productHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_product_surname).length;
    if(valid) {
        var product_code = thix.find('td[data-field="product_code"]').text();
        var product_name = thix.find('td[data-field="product_name"]').text();
        var product_id = thix.find('td[data-field="product_id"]').text();

        $('form').find('#product_name').val(product_name);
        $('form').find('#product_id').val(product_id);

        if($('#form_type').val() !== undefined){
            if($('#form_type').val() == 'sale_invoice'){
                funcGetProductDetail(product_id);
            }
        }

        $('#inLineHelp').remove();
    }
});

$('#'+help_product_id).on('focusin keyup',function(e){
    $('#inLineHelp').remove();
    var validate = true;
    var project_id = current_project_id;

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
            var setval = "?project_id="+project_id
            setval += "&search="+val
            var url2 = help_product_url +'/'+setval
            inLineHelp.load(url2);
            var offsetTop = 30;
            var offsetLeft = thix.offset().left - eg_help_block.offset().left;
            eg_help_block.find('#inLineHelp').css({top:offsetTop+'px'});
            eg_help_block.find('#inLineHelp').css({left:offsetLeft+'px'});
        }
    }
});

$(document).on('click',function(e){
    if($(e.target).attr('id') != help_product_id) {
        $("#inLineHelp[data-id='product']").remove();
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

