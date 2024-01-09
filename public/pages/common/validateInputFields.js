
// number validator
function FloatValidate(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
    {
        return false;
    }
    return true;
}
// number validator
function NumberValidate(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 47 && charCode <58)
    {
        return true;
    }
    return false;
}
//end number  validator

//phone number pattern validator
function allowNumberDash(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 47 && charCode <58) || (charCode == 45 || charCode == 43))
    {
        return true;
    }
    return false;
}
//end number pattern validator



$(document).ready(function() {
    $(document).find('.FloatValidate').keypress(FloatValidate);
    $(document).find('.NumberValidate').keypress(NumberValidate);
    $(document).find('.AllowNumberDash').keypress(allowNumberDash);
});

