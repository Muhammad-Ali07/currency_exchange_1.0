$(document).on('keyup blur','.egt_qty,.egt_rate,.egt_disc_perc,.egt_disc_amount,.egt_tax_perc,.egt_tax_amount',function(){
    var thix = $(this);
    var id = thix.attr('id');
    if(!id){
        id = thix.attr('data-id');
    }
    console.log(id);
    var tr = thix.parents('tr');
    rowCalc(tr,id)
    totalAmt()
});
function rowCalc(tr,id){
    // debugger
    var qty = tr.find('.egt_qty').val();
    var rate = tr.find('.egt_rate').val();
    var calc_amount =  parseFloat(qty) * parseFloat(rate);
    if(calc_amount){
        tr.find('.egt_amount').val(float2(calc_amount));
    }else{
        tr.find('.egt_amount').val(float2(0));
    }
    var amount = tr.find('.egt_amount').val();
    var disc_perc = tr.find('.egt_disc_perc').val();
    var disc_amount = 0;
    if(disc_perc && id != 'egt_disc_amount'){
        var calc_disc_amount = parseFloat(amount) * parseFloat(disc_perc) / 100;
        if(calc_disc_amount){
            tr.find('.egt_disc_amount').val(float2(calc_disc_amount));
            var disc_amount = tr.find('.egt_disc_amount').val();
        }else{
            tr.find('.egt_disc_amount').val(float2(0));
        }
    }else{
        disc_amount = tr.find('.egt_disc_amount').val();
        if(disc_amount){
            var calc_disc_perc = parseFloat(disc_amount) * 100 / parseFloat(amount);
            if(calc_disc_perc){
                tr.find('.egt_disc_perc').val(float2(calc_disc_perc));
            }else{
                tr.find('.egt_disc_perc').val(float2(0));
            }
        }else{
            disc_amount = 0;
        }
    }
    var tax_perc = tr.find('.egt_tax_perc').val();
    var tax_amount = 0;
    if(tax_perc && id != 'egt_tax_amount'){
        var calc_tax_amount = parseFloat(amount) * parseFloat(tax_perc) / 100;
        if(calc_tax_amount){
            tr.find('.egt_tax_amount').val(float2(calc_tax_amount));
            var tax_amount = tr.find('.egt_tax_amount').val();
        }else{
            tr.find('.egt_tax_amount').val(float2(0));
        }
    }else{
        tax_amount = tr.find('.egt_tax_amount').val();
        if(tax_amount){
            var calc_tax_perc = parseFloat(tax_amount) * 100 / parseFloat(amount);
            if(calc_tax_perc){
                tr.find('.egt_tax_perc').val(float2(calc_tax_perc));
            }else{
                tr.find('.egt_tax_perc').val(float2(0));
            }
        }else{
            tax_amount = 0;
        }
    }
    var net_amount = (parseFloat(amount) - parseFloat(disc_amount)) + parseFloat(tax_amount) ;
    if(net_amount){
        tr.find('.egt_net_amount').val(float2(net_amount));
    }else{
        tr.find('.egt_net_amount').val(float2(0));
    }
}
$(document).on('keyup blur','.freight_charges,.other_charges',function(){
    totalAmt()
});
function totalAmt(){
    var egt_net_amount = 0;
    var other_charges = 0;
    var freight_charges = 0;
    var current_form = $('form');
    $('.egt_form_body>tr').each(function(){
        var thix = $(this);
        egt_net_amount += parseFloat(thix.find('.egt_net_amount').val());
    })
    current_form.find('.total_net_amount').val(float2(egt_net_amount));
    if(current_form.find('.freight_charges').length != 0){
        var freight_charges = current_form.find('.freight_charges').val();
    }
    if(current_form.find('.other_charges').length != 0){
        var other_charges =   current_form.find('.other_charges').val();
    }
    var total_amount = parseFloat(egt_net_amount) + parseFloat(freight_charges) +  parseFloat(other_charges)
    current_form.find('.total_amount').val(float2(total_amount));
}
function float2(num){
    if(num == null){
        return parseFloat(0).toFixed(2);
    }else{
        return parseFloat(num).toFixed(2);
    }
}
$('.egt_qty,.egt_rate,.egt_disc_perc,.egt_disc_amount,.egt_tax_perc,.egt_tax_amount,.freight_charges,.other_charges').blur(function(){
    //debugger
    var val = $(this).val();
    var num = float2(val);
    $(this).val(float2(num));
    cd(num);
    if(num == 'NaN' || num == NaN){
        $(this).val(float2(0));
    }
});
$('.egt_qty,.egt_rate,.egt_disc_perc,.egt_disc_amount,.egt_tax_perc,.egt_tax_amount,.freight_charges,.other_charges').on('input', function () {
    this.value = this.value.match(/^\d+\.?\d{0,2}/);
});
