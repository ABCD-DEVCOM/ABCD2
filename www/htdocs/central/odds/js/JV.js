/* FORM VALIDATION FUNCTIONS
/* MENSAJES DE ERROR, UN ARRAY PARA CADA IDIOMA */
var gap_between_pages = 30;
var jv_errors_en = {
    "required": "This field is required.", 
    "uint": "Please enter only numerical letters here.",    
    "no_trim": "No spaces at beginning and end of field allowed.",
    "email": "Please enter a valid e-mail.",
    "min_length": "This field needs to be at least $ characters long.",
    "year": "The year must be four digits.",
    "years_validate_majority": "The year cannot exceed the current year.",
    "years_validate_minority": "The year cannot be less than 1850.",
    "pages_initial": "The end page cannot be less than the initial page.",
    "pages_initial_gap": "The maximum request cannot exceed " + gap_between_pages + " pages.",
    "pages_end": "The initial page cannot be greater than the end page.",
    "pages_end_gap": "The maximum request cannot exceed " + gap_between_pages + " pages.",
    "max_length": "This field must have no more than $ characters in it."
}; 
var jv_errors_es = {
    "required": "Este campo es requerido.", 
    "uint": "El número de identificación debe esta compuesto únicamente por dígitos",    
    "no_trim": "No spaces at beginning and end of field allowed.",
    "email": "El E-mail tiene un formato inválido.",
    "min_length": "Este campo debe tener al menos $ caracteres",
    "year": "El año debe tener cuatro dígitos.",
    "years_validate_majority": "El año no puede ser superior al año actual.",
    "years_validate_minority": "El año no puede ser inferior a 1850.",
    "pages_initial": "La página final no puede ser menor que la página inicial.",
    "pages_initial_gap": "La solicitud no puede execer las " + gap_between_pages + " páginas.",
    "pages_end": "La página inicial no puede ser mayor que la página final.",
    "pages_end_gap": "La solicitud no puede execer las " + gap_between_pages + " páginas.",
    "max_length": "This field must have no more than $ characters in it."
}; 

var jv_cur_check = null;
var already_one_error = false;
var jv_err_open = '<span style="color:red" id="jv_error">';
var jv_err_close = '</span>';
var jv =
{
    uint: function(lang) {
        if($(jv_cur_check).val() && !$(jv_cur_check).val().match(/^[0-9]+$/)) {
            if(lang=='es') 
                return jv_errors_es["uint"];
            else
                return jv_errors_en["uint"];            
        }
    },
    required: function(lang) {         
        if(!$(jv_cur_check).val()) {
            if (!already_one_error) {
                $(jv_cur_check).focus();
                already_one_error = true;
            }
            if(lang=='es') 
                return jv_errors_es["required"];
            else
                return jv_errors_en["required"]; 
        }
    },
    pages_initial: function(lang) {        
        if($(jv_cur_check).val() && $("#tag021").val()){
            if(parseInt($(jv_cur_check).val()) > parseInt($("#tag021").val())) {
                if (!already_one_error) {
                    $(jv_cur_check).focus();
                    already_one_error = true;
                }                
                if(lang=='es') 
                    return jv_errors_es["pages_initial"];
                else
                    return jv_errors_en["pages_initial"]; 
            } 
        }
    }, 
    pages_initial_gap: function(lang) { 
        if($(jv_cur_check).val() && $("#tag021").val()){
            if(parseInt($(jv_cur_check).val()) < parseInt($("#tag021").val())) {
                if((parseInt($("#tag021").val()) - parseInt($(jv_cur_check).val())) > 30) {
                    if (!already_one_error) {
                        $(jv_cur_check).focus();
                        already_one_error = true;
                    }                                

                    if(lang=='es') 
                        return jv_errors_es["pages_initial_gap"];
                    else
                        return jv_errors_en["pages_initial_gap"]; 
                }    
            } 
        }
    },     
    pages_end: function(lang) { 
            if($(jv_cur_check).val() && $("#tag020").val()){
                if(parseInt($(jv_cur_check).val()) < parseInt($("#tag020").val())) {                    
                    if (!already_one_error) {
                        $(jv_cur_check).focus();
                        already_one_error = true;
                    }                    
                    if(lang=='es') 
                        return jv_errors_es["pages_end"];
                    else
                        return jv_errors_en["pages_end"]; 
                } 
            } 
    }, 
    pages_end_gap: function(lang) { 
            if($(jv_cur_check).val() && $("#tag020").val()){
                if(parseInt($(jv_cur_check).val()) > parseInt($("#tag020").val())) {                    
                    if((parseInt($(jv_cur_check).val()) - parseInt($("#tag020").val())) > 30) {                        
                        if (!already_one_error) {
                            $(jv_cur_check).focus();
                            already_one_error = true;
                        }                        
                        if(lang=='es') 
                            return jv_errors_es["pages_end_gap"];
                        else
                            return jv_errors_en["pages_end_gap"]; 
                    }
                } 
            } 
    },     
    years_validate_majority: function(lang) {
        if($(jv_cur_check).val()) {
            current_year = new Date().getFullYear()
            if($(jv_cur_check).val() > current_year) {
                if (!already_one_error) {
                    $(jv_cur_check).focus();
                    already_one_error = true;
                }
                if(lang=='es') 
                    return jv_errors_es["years_validate_majority"];
                else
                    return jv_errors_en["years_validate_majority"]; 
            }
        }    
    },     
    years_validate_minority: function(lang) { 
        if($(jv_cur_check).val()) {
            var old_year  = 1850;
            if($(jv_cur_check).val() < old_year) {
                if (!already_one_error) {
                    $(jv_cur_check).focus();
                    already_one_error = true;
                }
                if(lang=='es') 
                    return jv_errors_es["years_validate_minority"];
                else
                    return jv_errors_en["years_validate_minority"]; 
            }
        }    
    },    
    year: function(lang) {
        if($(jv_cur_check).val()) {
            if($(jv_cur_check).val().length != 4) {
                    if (!already_one_error) {
                        $(jv_cur_check).focus();
                        already_one_error = true;
                    }
                    if(lang=='es') 
                        return jv_errors_es["year"];
                    else
                        return jv_errors_en["year"]; 
            }
        }        
    },   
    no_trim: function() {
        if($(jv_cur_check).val() && ($(jv_cur_check).val().charAt(0) == " " || $(jv_cur_check).val().charAt($(jv_cur_check).val().length-1) == " "))
            return jv_errors["no_trim"];
    },
    email: function(lang) {
        if ( ($(jv_cur_check).val().indexOf(", ") )== -1) {
            var re = /^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i;
            if($(jv_cur_check).val() && !re.test($(jv_cur_check).val())) {
                if(lang=='es') 
                    return jv_errors_es["email"];
                else
                    return jv_errors_en["email"];
            }
        }
    },
    file: function(file) {
        $.post("/"+file, $(jv_cur_check).attr("name")+"="+$(jv_cur_check).val(), function(data) {
            if($(jv_cur_check).next().attr("id") == "jv_error")
                $(jv_cur_check).next().remove();
            if(data)
                $(jv_cur_check).after(jv_err_open+data+jv_err_close);
        });
            return "";
    },
    min_length_3: function(lang){
        len = 3;
        if($(jv_cur_check).val().length < len){
            if(lang=='es') 
                return jv_errors_es["min_length"].replace("$",len);
            else
                return jv_errors_en["min_length"].replace("$",len);
        }
    },    
    max_length: function(len){
        if($(jv_cur_check).val().length > len)
            return jv_errors["max_length"].replace("$",len);        
    }
}

$(document).ready(function() {
    $('form').submit(function(event) {        
        if ($("#level").val() != "") { 
            already_one_error = false;
            $('[data-jv]').each(function() {
                check_field(this);
            })
            if($("#jv_error").length) {                
                event.preventDefault();
                 $('html, body').animate({
                     scrollTop: $("#jv_error").offset().top
                 }, "fast"); 
            } else  {
                // ready to send!                
                if ($("#level").val() != "") {
                    sendForm();
                } 
            }
        }
    })
    
    $("[data-jv]").keyup(function() {             
            check_field(this);        
    }) 

    $("[data-jv]").bind("input", function(){
        check_field(this);
    })

    function check_field(check) {         
        jv_cur_check = check;        
        if($(jv_cur_check).next().attr("id") == "jv_error") {
            $(jv_cur_check).next().remove();
        }
        var check_arr = $(jv_cur_check).attr('data-jv').split(" ")
        for(i in check_arr) {
            var error = "";
            var func_name = check_arr[i].match(/^\w+/);
            var params = check_arr[i].substr(String(func_name).length+1);
            params = params.substr(0, params.length-1)
            if(error = eval("jv."+func_name).call(undefined, eval("params"))){ 
                $(jv_cur_check).after(jv_err_open+error+jv_err_close); 
                $(jv_cur_check).attr('readonly', false);
                return;
            }
        }        
    }
})