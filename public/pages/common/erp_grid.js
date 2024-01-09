if (typeof var_egt_fields !== 'undefined'){
    var egt_fields = var_egt_fields;
}else{
    var egt_fields = [];
}
if (typeof var_egt_readonly_fields !== 'undefined'){
    var egt_readonly_fields = var_egt_readonly_fields;
}else{
    var egt_readonly_fields = [];
}
if (typeof var_egt_required_fields !== 'undefined'){
    var egt_required_fields = var_egt_required_fields;
}else{
    var egt_required_fields = [];
}
$(document).ready(function(){
    table_td_sortable();
    grid_fun();
});
$(document).on('click','#egt_add',function(){
    var thix = $(this);
    for(var i=0;i < egt_required_fields.length; i++){
        var rf_val = $('#'+egt_required_fields[i].id).val();
        if(rf_val == ""){
            alert(egt_required_fields[i].message);
            return false;
        }
    }
    add_row(thix);
    formClear();
    grid_fun();
});
$(document).on('click','.egt_del',function(){
    $(this).parents("tr").remove();
    updateKeys();
    grid_fun();
});
function add_row(thix){
    var tr = thix.parents('tr');
    var tds = "";
    var nameAttrPrefix = 'pd';
    var trLength = $('.egt_form_body>tr').length + 1;
    var total_tds_length =  tr.find('td').length;
    $('.egt_form_body').append('<tr></tr>');
    var lastTr = $('.egt_form_body>tr:last-child');
    for(var i=0;i < total_tds_length;i++){
        var field = tr.find('td:eq('+i+')').clone();
        field = field[0];
        if(i == 0){
            field.setAttribute('class','handle');
            var newItem = document.createElement("i");
            newItem.setAttribute('class','handle egt_handle');
            newItem.setAttribute('data-feather','move');

            for(var o=0;o<field.children.length;o++) {
                if(field.children[o].id == 'egt_sr_no'){
                    field.children[o].value = trLength;
                }
                field.children[o].setAttribute('name',nameAttrPrefix+"["+trLength+"]["+field.children[o].id+"]")
                field.children[o].setAttribute('data-id',field.children[o].id)
                field.children[o].removeAttribute("id");
            }
            field.insertBefore(newItem, field.childNodes[0])
        }else if(i == (total_tds_length-1) ){
            field = "<td class=\"text-center\">\n" +
                "<div class=\"egt_btn-group\">\n" +
                "<button type=\"button\" class=\"btn btn-danger btn-sm egt_del\">\n" +
                "<i data-feather=\"trash-2\"></i>\n" +
                "</button>\n" +
                "</div>\n" +
                "</td>";
        }else{
            var childEle = field.children[0];
            childEle.setAttribute('name',nameAttrPrefix+"["+trLength+"]["+childEle.id+"]")
            childEle.setAttribute('data-id',childEle.id)
            if(childEle.nodeName == "SELECT"){
                var val =  tr.find('select#'+childEle.id).val();
                childEle.value = val;
            }
            if(childEle.nodeName == "INPUT"){

            }
            childEle.removeAttribute("id");
        }
        lastTr.append(field);

        feather.replace({
            width: 14,
            height: 14
        });
    }
    for(var i=0;i < egt_fields.length; i++){
        var sel_field = lastTr.find('input[data-id='+egt_fields[i].id+']');
        if(egt_fields[i].classNames !== undefined){
            sel_field.addClass(egt_fields[i].classNames);
        }
        if(egt_fields[i].data_url !== undefined){
            sel_field.attr('data-url',egt_fields[i].data_url);
        }
    }
    for(var i=0;i < egt_readonly_fields.length; i++){
        var sel_field = lastTr.find('input[data-id='+egt_readonly_fields[i]+']');
        sel_field.attr('readonly',true);
    }
}
function updateKeys(){
    var total_length = $('.egt_form_body>tr').length + 1;
    var nameAttrPrefix = 'pd';
    if(total_length != 0){
        for(var i=0;total_length > i; i++){
            var td = '.egt_form_body tr:eq('+i+') td';
            var j = i+1;
            $($(td+':eq(0)').find('input[type="hidden"]')).each(function(){
                var data_id = $(this).attr('data-id');
                $(this).attr('name','');
                $(this).attr('name',nameAttrPrefix+'['+j+']['+data_id+']');
            });
            $($(td).find('input[type="text"]')).each(function(){
                var data_id = $(this).attr('data-id');
                $(this).attr('name',nameAttrPrefix+'['+j+']['+data_id+']');
            });
            $($(td).find('input[type="radio"]')).each(function(){
                var data_id = $(this).attr('data-id');
                $(this).attr('name',nameAttrPrefix+'['+j+'][action]');
            });
            $($(td).find('select')).each(function(){
                var data_id = $(this).attr('data-id');
                $(this).attr('name',nameAttrPrefix+'['+j+']['+data_id+']');
            });
            $(td+':eq(0)').find('input[type="text"]').attr('name',nameAttrPrefix+'['+j+'][egt_sr_no]').val(j);
        }
    }
}
function table_td_sortable(){
    $( ".egt_form_body" ).sortable({
        handle: ".handle",
        update: function (e,ui) {
            updateKeys();
        }
    });
    $( ".egt_form_body>tr" ).disableSelection();
}
function formClear(){
    $('.egt_form_table .egt_form_header').find('input').val("");
    $('.egt_form_table .egt_form_header').find('input[type="radio"]').prop('checked', false);
    $('.egt_form_table .egt_form_header').find('select').prop('selectedIndex',0);
}

function grid_fun(){
    if (typeof calcDC !== 'undefined'){
        calcDC();
    }
    if (typeof totalAmt !== 'undefined'){
        totalAmt();
    }
    $('.egt_qty,.egt_rate,.egt_disc_perc,.egt_disc_amount,.egt_tax_perc,.egt_tax_amount').blur(function(){
        var num = float2($(this).val());
        $(this).val(float2(num));
        cd(num);
        if(num == 'NaN' || num == NaN){
            $(this).val(float2(0));
        }
    });
    $('.egt_qty,.egt_rate,.egt_disc_perc,.egt_disc_amount,.egt_tax_perc,.egt_tax_amount').on('input', function () {
        this.value = this.value.match(/^\d+\.?\d{0,2}/);
    });
}
