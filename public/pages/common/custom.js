$(document).ready(function(){
    $('.validate_amount').keypress(validateAmount);
    $('.validate_number').keypress(validateNumber);
})
function validateAmount(e){
    var key = window.event ? event.keyCode : event.which;
    var allow_val = ['0','1','2','3','4','5','6','7','8','9','.']
    var val = String.fromCharCode(key);
    if(allow_val.includes(val)){
        return true;
    }
    return false;
}

function validateNumber(e){
    var key = window.event ? event.keyCode : event.which;
    var allow_val = ['0','1','2','3','4','5','6','7','8','9']
    var val = String.fromCharCode(key);
    if(allow_val.includes(val)){
        return true;
    }
    return false;
}
