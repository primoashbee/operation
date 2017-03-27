$.ajaxSetup({

headers: {

'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

}

})

function showProfile(){
    $.ajax({
        url:'/Auth/Info',
        data:{},
        dataType:'JSON',
        type:'GET',
        success:function(data){
            console.log(data)
        }
    })
}
function negateExponent(x) {
    var result = '';
    var xStr = x.toString(10);
    var digitCount = xStr.indexOf('e') === -1 ? xStr.length : (parseInt(xStr.substr(xStr.indexOf('e') + 1)) + 1);

    for (var i = 1; i <= digitCount; i++) {
        var mod = (x % Math.pow(10, i)).toString(10);
        var exponent = (mod.indexOf('e') === -1) ? 0 : parseInt(mod.substr(mod.indexOf('e')+1));
        if ((exponent === 0 && mod.length !== i) || (exponent > 0 && exponent !== i-1)) {
            result = '0' + result;
        }
        else {
            result = mod.charAt(0) + result;
        }
    }
    return result;
}


(function (exports) {
    function valOrFunction(val, ctx, args) {
        if (typeof val == "function") {
            return val.apply(ctx, args);
        } else {
            return val;
        }
    }

    function InvalidInputHelper(input, options) {
        input.setCustomValidity(valOrFunction(options.defaultText, window, [input]));

        function changeOrInput() {
            if (input.value == "") {
                input.setCustomValidity(valOrFunction(options.emptyText, window, [input]));
            } else {
                input.setCustomValidity("");
            }
        }

        function invalid() {
            if (input.value == "") {
                input.setCustomValidity(valOrFunction(options.emptyText, window, [input]));
            } else {
               input.setCustomValidity(valOrFunction(options.invalidText, window, [input]));
            }
        }

        input.addEventListener("change", changeOrInput);
        input.addEventListener("input", changeOrInput);
        input.addEventListener("invalid", invalid);
    }
    exports.InvalidInputHelper = InvalidInputHelper;
})(window);
var oldJqTrigger = jQuery.fn.trigger;
jQuery.fn.trigger = function()
{
    if ( arguments && arguments.length > 0) {
        if (typeof arguments[0] == "object") {
            if (typeof arguments[0].type == "string") {
                if (arguments[0].type == "show.bs.modal") {
                    var ret = oldJqTrigger.apply(this, arguments);
                    if ($('.modal:visible').length) {
                        $('.modal-backdrop.in').first().css('z-index', parseInt($('.modal:visible').last().css('z-index')) + 10);
                        $(this).css('z-index', parseInt($('.modal-backdrop.in').first().css('z-index')) + 10);
                    }
                    return ret;
                }
            }
        }
        else if (typeof arguments[0] == "string") {
            if (arguments[0] == "hidden.bs.modal") {
                if ($('.modal:visible').length) {
                    $('.modal-backdrop').first().css('z-index', parseInt($('.modal:visible').last().css('z-index')) - 10);
                    $('body').addClass('modal-open');
                }
            }
        }
    }
    return oldJqTrigger.apply(this, arguments);
};