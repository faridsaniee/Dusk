$().ready(function () {
    func_page_size();
    $( window ).resize(function() {func_page_size();});
    $(".noaction").submit(function(e){
        e.preventDefault();
        return false;
    });
    $(window).scroll(function() {
            var nav = $('body');
            var top = 0;
            if ($(window).scrollTop() > top){nav.addClass('scroll');}
            else {nav.removeClass('scroll');}
    });
    $('.data_tables').DataTable();
} );
function func_page_size()
{
    var menu_height = $("#menu").outerHeight();
    var footer_height = $("#footer").outerHeight();
    if(!footer_height){footer_height = 0;}
    var breadcrumb_height = $("#breadcrumb").outerHeight();
    if(!breadcrumb_height){breadcrumb_height = 0;}
    var width = (window.innerWidth);
    var height = (window.innerHeight - (menu_height + footer_height + breadcrumb_height + 16));
    $("#body").attr("height",height);
    $("#body").attr("min-height",height);
    $("#body").css("min-height",height);
    $("#body-min").css("min-height",height);
    $("#body-min").attr("min-height",height);
    $('#body-min').attr('style','min-height:'+height+'px;');
    if(document.body.scrollHeight > window.innerHeight){$("body").addClass("has_scroll"); }
}

function func_form_validate(form_id)
{
    var forms = $("#"+form_id);
    var validation = Array.prototype.filter.call(forms, function(form) {
        form.classList.remove('was-validated');;
        var validate = form.checkValidity();
        if(validate)
        {
            form.classList.add('was-validated');
        }
    });
}
function func_date() {
    var today = new Date();
    var h     = today.getHours();
    var m     = today.getMinutes();
    var s     = today.getSeconds();
    m         = checkTime(m);
    s         = checkTime(s);
    document.getElementById("time").innerHTML = h + ":" + m + ":" + s;
    var t     = setTimeout(func_date, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i}; 
    return i;
}
function func_copy_clipboard(str) 
{
    var el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.setAttribute('type', 'text');
    el.style = {position: 'absolute', left: '0px'};
    document.body.appendChild(el);
    el.select();
    document.execCommand("copy");
    document.body.removeChild(el);
}
function func_loading(status) 
{
    if(status){$( "body" ).append( $( "<div id=\"loading\"><i class=\"fa fa-spinner fa-pulse fa-3x fa-fw\"></i></div>" ) );}
    else{$( "body #loading" ).remove();}
}
function validate_email($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
function validate_phone($phone) {
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    return filter.test($phone);
}
function number_format(n, sep, decimals) 
{
    sep = sep || "."; // Default to period as decimal separator
    decimals = decimals || 2; // Default to 2 decimals
    return n.toLocaleString().split(sep)[0]
}
function func_url_param_remove(parameter)
{
    var currentUrlWithOutHash = window.location.origin + window.location.pathname + window.location.search;
        var hash = window.location.hash
    var currentUrlWithOutHash = func_url_param_remover(currentUrlWithOutHash, parameter);
    var queryStart;
    if(currentUrlWithOutHash.indexOf('?') !== -1){
        queryStart = '&';
    } else {
        queryStart = '?';
    }
    var newurl = currentUrlWithOutHash + queryStart
    window.history.pushState({path:newurl},'',newurl);
}

function func_url_param_remover(url, parameter) {
    var urlparts = url.split('?');   
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
}

function func_url_param_insert(key, value) {
    if (history.pushState) {
        var currentUrlWithOutHash = window.location.origin + window.location.pathname + window.location.search;
        var hash = window.location.hash
        var currentUrlWithOutHash = func_url_param_remover(currentUrlWithOutHash, key);
        var queryStart;
        if(currentUrlWithOutHash.indexOf('?') !== -1){
            queryStart = '&';
        } else {
            queryStart = '?';
        }
        var newurl = currentUrlWithOutHash + queryStart + key + '=' + value + hash
        window.history.pushState({path:newurl},'',newurl);
    }
}
function func_url_param() {
     var searchString = window.location.search.substring(1),
       params = searchString.split("&"),
       hash = {};

     if (searchString == "") return {};
     for (var i = 0; i < params.length; i++) {
       var val = params[i].split("=");
       hash[unescape(val[0])] = unescape(val[1]);
     }

     return hash;
};
function func_validate_field(field_id)
{
    var fld_val = $(field_id).val();
    var fld_type = $(field_id).attr("type");
    var fld_status = false;
    if(fld_type == "phone"){fld_status = validate_phone(fld_val);  }
    if(fld_type == "otp"){fld_status = validate_otp(fld_val);  }

    if(fld_status)
    {
        $(field_id).removeClass("is-invalid");
        $(field_id).addClass("is-valid");
    }
    else
    {
        $(field_id).removeClass("is-valid");
        $(field_id).addClass("is-invalid"); 
    }
    return fld_status;
}