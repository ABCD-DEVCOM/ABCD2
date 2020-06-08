// Get the document object to work on several navigators.

if (document.all && !document.getElementById) {
	doc = document.all;
    doc.getElementById = function(id) { return document.all[id] }
} else {
	doc = document;
}	

/* Set true if it is an Internet Explorer */
var IE = document.all? true: false;

/* Information about browser */
var ua = ' ' + navigator.userAgent.toLowerCase();
var operating_system;
if (navigator.appVersion.indexOf("Win") > 0) {
	operating_system = "Win";
}	
if (navigator.appVersion.indexOf("Mac") > 0) {
	operating_system = "Mac";
}
var is_id = (document.getElementById) ? true : false;
var is_IE = ua.indexOf('msie') >= 0;
var is_NN = (ua.indexOf('netscape') >= 0 || ua.indexOf('gecko') >= 0);
var iVersion = parseFloat(navigator.appVersion);
var sInfo;
if (is_IE) {
	sInfo    = navigator.appVersion.toLowerCase().indexOf('msie') + 5;
	iVersion = parseFloat(navigator.appVersion.substring(sInfo));
} else if (is_NN){
	sInfo    = ua.lastIndexOf('/') + 1;
	iVersion = parseFloat(ua.substring(sInfo,ua.length));
}
var version = iVersion;

// Capture events
/*if (document.layers) { // Netscape
	document.captureEvents(Event.KEYDOWN);
	document.onkeydown = captureShortKey;
	document.onfocus = function() { return false;};	
} else if (document.all) { // Internet Explorer
	document.onkeydown = captureShortKey;
	document.onfocus = function() { return false;};	
} else if (document.getElementById) { // Netcsape 6
	document.onkeydown = captureShortKey;
	document.onfocus = function() { return false;};	
}*/

/* Global Variables */
var subfields  = new Array(); // This array stores subfields data. Each line simbolized an occurrence.
var errors     = new Array(); // This array stores errors about subfields type.

function captureShortKey(e) {
	if (IE) {
		switch(event.keyCode) {
			case 113: {
					   delete_last_occurrence();
					   break;
					  }
		}
	} else {
		switch(e.keyCode) {
			case 113: {
					   delete_last_occurrence();
					   break;
					  }
		}
	}
}

function sprintf() {
	if (!arguments || arguments.length < 1 || !RegExp)
	{
		return;
	}
	var str = arguments[0];
	var re = /([^%]*)%('.|0|\x20)?(-)?(\d+)?(\.\d+)?(%|b|c|d|u|f|o|s|x|X)(.*)/;
	var a = b = [], numSubstitutions = 0, numMatches = 0;
	while (a = re.exec(str))
	{
		var leftpart = a[1], pPad = a[2], pJustify = a[3], pMinLength = a[4];
		var pPrecision = a[5], pType = a[6], rightPart = a[7];
		
		//alert(a + '\n' + [a[0], leftpart, pPad, pJustify, pMinLength, pPrecision);

		numMatches++;
		if (pType == '%')
		{
			subst = '%';
		}
		else
		{
			numSubstitutions++;
			if (numSubstitutions >= arguments.length)
			{
				alert('Error! Not enough function arguments (' + (arguments.length - 1) + ', excluding the string)\nfor the number of substitution parameters in string (' + numSubstitutions + ' so far).');
			}
			var param = arguments[numSubstitutions];
			var pad = '';
				   if (pPad && pPad.substr(0,1) == "'") pad = leftpart.substr(1,1);
			  else if (pPad) pad = pPad;
			var justifyRight = true;
				   if (pJustify && pJustify === "-") justifyRight = false;
			var minLength = -1;
				   if (pMinLength) minLength = parseInt(pMinLength);
			var precision = -1;
				   if (pPrecision && pType == 'f') precision = parseInt(pPrecision.substring(1));
			var subst = param;
				   if (pType == 'b') subst = parseInt(param).toString(2);
			  else if (pType == 'c') subst = String.fromCharCode(parseInt(param));
			  else if (pType == 'd') subst = parseInt(param) ? parseInt(param) : 0;
			  else if (pType == 'u') subst = Math.abs(param);
			  else if (pType == 'f') subst = (precision > -1) ? Math.round(parseFloat(param) * Math.pow(10, precision)) / Math.pow(10, precision): parseFloat(param);
			  else if (pType == 'o') subst = parseInt(param).toString(8);
			  else if (pType == 's') subst = param;
			  else if (pType == 'x') subst = ('' + parseInt(param).toString(16)).toLowerCase();
			  else if (pType == 'X') subst = ('' + parseInt(param).toString(16)).toUpperCase();
		}
		str = leftpart + subst + rightPart;
	}
	return str;
}

function change_field_text(objectField) {
	var index      = objectField.name.indexOf("_");
	var number_id  = objectField.name.substring((index + 1), objectField.name.length); 				
	var name	   = ("inputTL_" + number_id);
    var name_text  = ("input_" + number_id);  

	var objeto = doc.getElementsByName("input_" + number_id)[0].name;
	var value_text = doc.getElementsByName("input_" + number_id)[0].value;
	var value = doc.getElementsByName("inputTL_" + number_id)[0].selectedIndex;
	var teste = (objeto)[0].value;
	
	//alert(objeto +", "+ teste +", "+ number_id +", "+ value_text +", "+ value);	
}


function change_class_over(objectField) {
	var index      = objectField.name.indexOf("_");
	var number_id  = objectField.name.substring((index + 1), objectField.name.length); 				
	if (doc.getElementById("div_" + number_id)) {
		var objectDiv = doc.getElementById("div_" + number_id);
		if (rules[inverse[objectField.name]][1] != "0") {				
			if (objectField.value.length > rules[inverse[objectField.name]][1]) {		
				objectDiv.className     = 'field_edit_holder_red';			
				objectField.className = 'field_edit_red';			
			} else {
				objectDiv.className   = 'field_edit_holder_over';		
				objectField.className = 'field_edit_over';			
			}				
		} else {
			objectDiv.className   = 'field_edit_holder_over';		
			objectField.className = 'field_edit_over';			
		}	
	}	
	return true;
}

function selecionado(objectField)
{ 
	var index      = objectField.name.indexOf("_");
	var number_id  = objectField.name.substring((index + 1), objectField.name.length); 		

	alert(number_id);
	this.form.input_03.value = this.selectedIndex >= 0 ? this.options[this.selectedIndex].value : '``';
}

function BuscaSelect(objectField)
{
	var index      = objectField.name.indexOf("_");
	var number_id  = objectField.name.substring((index + 1), objectField.name.length); 		
	var name	   = ("inputTL_" + number_id);	

	var1 = objectField.value;
	var1 = var1.toUpperCase()
	var2 = ("forml."+name);
	var4 = var2.length;

	for(i=0;i<var4;i++)
	{
		aux = var2+".options["+i+"].text";
		aux1 = aux1.toUpperCase();
		aux2 = eval(aux1);
		alert(aux2);
		if(aux2.indexOf(var1)==0)
		{
			var2.selectedIndex=i;
			i=var4;
		}
	}
}

function change_class_out(objectField) {
	var index      = objectField.name.indexOf("_");
	var number_id  = objectField.name.substring((index + 1), objectField.name.length); 					
	if (doc.getElementById("div_" + number_id)) {
		var objectDiv   = doc.getElementById("div_" + number_id);
		if (rules[inverse[objectField.name]][1] != "0") {						
			if (objectField.value.length > rules[inverse[objectField.name]][1]) {			
				objectDiv.className     = 'field_edit_holder_red';			
				objectField.className = 'field_edit_red';		
			} else {
				objectDiv.className   = 'field_edit_holder';			
				objectField.className = 'field_edit';		
			}	
		} else {
			objectDiv.className   = 'field_edit_holder';			
			objectField.className = 'field_edit';			
		}				
	}
	return true;
}

function get_first_focus() {
	if (doc.getElementById("input_01")) {
		var input = doc.getElementById("input_01");
		input.focus();
	}
}

function accept_num(e, input, length) {	
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	e = e || window.event;
	var key  = window.Event ? e.which : e.keyCode;
	if (key == 0) {	
		return true;
	} else if (key == 8) {
		return true;
	} else if (key == 13 ) {
		var index_field  = 0;
		var keep_seeking = true;
		var tabindex_to_seek = input.tabIndex + 1;
		while ((keep_seeking) && (index_field < subfields.length)) {
			var index = 0;
			var subfields_data = subfields[index_field];
			while ((keep_seeking) && (index < subfields_data.length)) {		
				var id = index + 1;		
				if (doc.getElementsByName("input_" + index_field + id).length > 0) {
					if (doc.getElementsByName("input_" + index_field + id)[0].tabIndex == tabindex_to_seek) {	
						doc.getElementsByName("input_" + index_field + id)[0].focus();
						keep_seeking = false;
					}			
				}	
				index++;
			}	
			index_field++;	
		}		
		if (keep_seeking) {
			doc.getElementById("save").focus();
		}
		return false;
	} else if ((key < 48) || (key > 57)) {
		alert(messages[2]);
		return false;
	} else {
		return true;
	}
}

function accept_alphanum(e, input, length) {	
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	e        = e || window.event;
	var key  = window.Event ? e.which : e.keyCode;
	if (key == 13 ) {
		var index_field  = 0;
		var keep_seeking = true;
		var tabindex_to_seek = input.tabIndex + 1;
		while ((keep_seeking) && (index_field < subfields.length)) {
			var index = 0;
			var subfields_data = subfields[index_field];
			while ((keep_seeking) && (index < subfields_data.length)) {		
				var id = index + 1;
				if (doc.getElementsByName("input_" + index_field + id).length > 0) {
					if (doc.getElementsByName("input_" + index_field + id)[0].tabIndex == tabindex_to_seek) {	
						doc.getElementsByName("input_" + index_field + id)[0].focus();
						keep_seeking = false;
					}			
				}	
				index++;
			}	
			index_field++;	
		}		
		if (keep_seeking) {
			doc.getElementById("save").focus();
		}
		return false;
	} else {
/*		var strtocount = input.value;
		var cols       = input.cols;
		var hard_lines = 0;
		var last       = 0;
		while ( true ) {
			last = strtocount.indexOf("\n", last+1);
			hard_lines ++;
			if ( last == -1 ) break;
		}
		var soft_lines = Math.floor(strtocount.length / (cols-1));
		alert("SOFT LINES: " + soft_lines);
		eval("var hard = hard_lines " + unescape("%3e") + "soft_lines;");
		if ( hard ) soft_lines = hard_lines;*/
//		alert("SCROLL: " + input.scrollHeight + " :: HEIGHT: " +  parseInt(input.style.height));
//		alert("OFFSET: " + input.offsetHeight + " :: HEIGHT: " +  parseInt(input.style.height));		
		
		return true;		
	}		
}

function countLines(strtocount, cols) {
	var hard_lines = 0;
	var last       = 0;
	while ( true ) {
		last = strtocount.indexOf("\n", last+1);
		hard_lines ++;
		if ( last == -1 ) break;
	}
	var soft_lines = Math.round(strtocount.length / (cols - 1));
	eval("var hard = hard_lines " + unescape("%3e") + "soft_lines;");
	if (hard) {
		soft_lines = hard_lines;

	}	
	return soft_lines;				
}

function test() {
	var t = doc.getElementsByName("input_01")[0];
	alert("Altura: " + t.style.height + "\nOffset: " + t.offsetHeight + "\nScroll: " + t.scrollHeight + "\nAltura Cliente: " + t.clientHeight + "\nInner Height: " + t.innerWidth);
}

function resize_input() {
	var inputs = doc.getElementsByTagName("TEXTAREA");

	for (index = 0; index < inputs.length; index++) {
		if (inputs[index].scrollHeight == parseInt(inputs[index].style.height)) {
			if (typeof inputs[index].rows != "number" ) continue;
			inputs[index].rows = countLines(inputs[index].value,inputs[index].cols);
			var n = countLines(inputs[index].value,inputs[index].cols);
			inputs[index].style.height = (n*20) + "px"; 	
		} else {
			var difference = (parseInt(inputs[index].style.height) - inputs[index].scrollHeight);
/*			if (typeof inputs[index].rows != "number" ) continue;
//			inputs[index].rows = countLines(inputs[index].value, inputs[index].cols) + 1;
			var n = countLines(inputs[index].value,inputs[index].cols);
			if (n <= 2) {
				inputs[index].style.height = (n*20) + "px"; 						
			} else {
				inputs[index].style.height = ((n/2)*20) + "px"; 									
			}	*/
			if (inputs[index].scrollHeight > parseInt(inputs[index].style.height)) {
				var times = Math.round(inputs[index].scrollHeight/parseInt(inputs[index].style.height));
				inputs[index].style.height = (parseInt(inputs[index].style.height) + 20) + "px"; 			
			}		
		}	
		var number_id  = inputs[index].name.substring((inputs[index].name.indexOf("_") + 1), inputs[index].name.length);		
		if (rules[inverse[inputs[index].name]][1] != "0") {		
			if (inputs[index].value.length > rules[inverse[inputs[index].name]][1]) {
				if (inputs[index].className == "field_edit_over") {
					var objectDiv           = doc.getElementById("div_" + number_id);				
					objectDiv.className     = 'field_edit_holder_red';			
					inputs[index].className = 'field_edit_red';			
				} else if (inputs[index].className == "field_edit") {
					var objectDiv           = doc.getElementById("div_" + number_id);				
					objectDiv.className     = 'field_edit_holder_red';			
					inputs[index].className = 'field_edit_red';								
				}	
			} else {
				if (inputs[index].className == "field_edit_red") {			
					var objectDiv           = doc.getElementById("div_" + number_id);				
					objectDiv.className     = 'field_edit_holder';			
					inputs[index].className = 'field_edit';			
				}	
			}		
		}	
	}	
	setTimeout("resize_input()", 100);
}

function save_changes(field_id) {
  
	var input;
	if (document.all && !document.getElementById) {
		input = window.opener.document.all[parameters["subfields"]];
	} else {	
		input = window.opener.document.getElementById(parameters["subfields"]);		
	}	
	
	var index_field;									
	var subfields_str = "";
	var lines = new Array();
	var line = 0;
	for (index_field = 0; index_field < subfields.length; index_field++) {										
		var index;
		var subfields_data = subfields[index_field];		
		subfields_str      = "";
		for (var subfield in rules) {		
			var keep_searching = true;
			var index          = 0;			
			var id             = 0;						
			while ((index < subfields_data.length) && (keep_searching)) {		
				if (subfield == subfields_data[index][0]) {
					id             = index + 1;
					keep_searching = false;
				}
				index++;	
			}	
			if (doc.getElementsByName("input_" + index_field + id).length > 0) {
				var input_field = doc.getElementsByName("input_" + index_field + id)[0];	
				if (rules[subfield][1] != "0") {		
					if (input_field.value.length <= rules[subfield][1]) {
						if (doc.getElementsByName("input_" + index_field + id)[0].tagName == "INPUT") {
							var value = "";
							if (doc.getElementsByName("input_" + index_field + id)[0].checked) {
								value = doc.getElementsByName("input_" + index_field + id)[0].value;
							}						
						} else if (doc.getElementsByName("input_" + index_field + id)[0].tagName == "SELECT") {
							var value = doc.getElementsByName("input_" + index_field + id)[0].value;
							if (value == "-1") {
								value = "";
							}	
						} else {
							var value = doc.getElementsByName("input_" + index_field + id)[0].value;
							if (value == ""){
							   if (rules[subfield][5] == 1){
									if (doc.getElementsByName("inputTL_" + index_field + id)[0].value != -1){
										var value = doc.getElementsByName("inputTL_" + index_field + id)[0].value;
 							   		}
							   }
							}
						}						
						if (value != "") {
							value = value.replace(/\n/gi,"");
							value = value.replace(/\r/gi,"");
							value = value.replace(/\t/gi,"");
							if (subfield == "*") {
								subfields_str = subfields_str + value;
							} else {
								subfields_str = subfields_str + "^" + subfield + value;
							}	
						} else {
							if (rules[subfield][2] == 1) {
								alert(sprintf(messages[3], subfield));
								doc.getElementsByName("input_" + index_field + id)[0].focus();
								return false;
							}
						}	
					} else {
						if (rules[subfield][2] == 1) {
							alert(sprintf(messages[3], subfield));
							doc.getElementsByName("input_" + index_field + id)[0].focus();
							return false;
						}						
					}
				} else {
					if (doc.getElementsByName("input_" + index_field + id)[0].tagName == "INPUT") {
						var value = "";
						if (doc.getElementsByName("input_" + index_field + id)[0].checked) {
							value = doc.getElementsByName("input_" + index_field + id)[0].value;
						}	
					} else if (doc.getElementsByName("input_" + index_field + id)[0].tagName == "SELECT") {
						var value = doc.getElementsByName("input_" + index_field + id)[0].value;
						if (value == "-1") {
							value = "";
						}	
					} else {
						var value = doc.getElementsByName("input_" + index_field + id)[0].value;
					}	
					if (value != "") {
						value = value.replace(/\n/gi,"");
						value = value.replace(/\r/gi,"");
						value = value.replace(/\t/gi,"");
						if (subfield == "*") {
							subfields_str = subfields_str + value;
						} else {
							subfields_str = subfields_str + "^" + subfield + value;
						}	
					} else {
						if (rules[subfield][2] == 1) {
							alert(sprintf(messages[3], subfield));
							doc.getElementsByName("input_" + index_field + id)[0].focus();
							return false;
						}
					}					
				}				
			}			
		}
		if (subfields_str != "") {
			lines[line] = subfields_str;
			line++;
		}
	}
	if (lines.length != 0) {
		input.value = lines.join("\n");	
	} else {
		input.value = "";		
	}	
	window.close();
}


function show_hide(id) {
	if (doc.getElementById("table_" + id).style.display == 'none') {
		doc.getElementById("table_" + id).style.display = 'inline';
		doc.getElementById("show_" + id).src = parameters["hide_image_path"];		
	} else {
		doc.getElementById("table_" + id).style.display = 'none';
		doc.getElementById("show_" + id).src = parameters["show_image_path"];					
	}		
}

function get_variables() { 
	var url           = location.href; 
	var params_index  = url.indexOf("?");    
	var params_length = url.substring((params_index + 1), url.length); 
	var tuples        = new Array();
	
	tuples            = params_length.split("&");
	var index;
	for (index = 0; index < tuples.length; index++) {  
		var tuple = tuples[index].split("=");
		parameters[tuple[0]] = tuple[1];
	}
}

function build_subfields() {
	var subfields_data = window.opener.document.getElementById(parameters["subfields"]).value;
	var occurrences    = subfields_data.split("\n");
	var subfield_index = 0;	
	for (index = 0; index < occurrences.length; index++) {  
		/* IE adds a blanck space at the end of the string when a \n occurrs */
		if (IE) {
			var character      = occurrences[index].charAt(occurrences[index].length - 1);
			if (character.charCodeAt(0) == 13) {
				occurrences[index] = occurrences[index].substring(0, (occurrences[index].length - 1));
			}	
		}
		if ((occurrences[index].substring(0, 1) != "^") && ((occurrences[index].length > 0))) {
			occurrences[index] = "^*" + occurrences[index]; 
		}	
		var elements       = occurrences[index].split("^");
		var all_subfields  = new Array();
		for (subindex = 0; subindex < elements.length; subindex++) {  
			if (elements[subindex].length > 0) {
				all_subfields[elements[subindex].substring(0, 1)] = elements[subindex].substring(1, elements[subindex].length);
			}	
		}		
		var line           = new Array();
		var already_added  = new Array();		
		var line_index     = 0;				
		for (var subfield_name in rules) {
			if (all_subfields[subfield_name]) {
				var data = all_subfields[subfield_name]; 
				var is_data_correct;
				if (rules[subfield_name][0] == "numeric") {
					is_data_correct = is_numeric(data);
				} else if (rules[subfield_name][0] == "alphanumeric") {
					is_data_correct = is_alphanumeric(data);
				}	
				if (is_data_correct) {						
					line[line_index] = [subfield_name, data];
					line_index++;			
				} else {
					errors[errors.length] = [(index + 1), subfield_name];
					line[line_index] = [subfield_name, ""];
					line_index++;							
				}
				already_added[subfield_name] = true;				
			}
		}		
		for (var subfield in rules) {
			if (!already_added[subfield]) {
				if (subfield != "*") {
					line[line.length] = [subfield, ""];
				} else {
					for (move_index = line.length; move_index > 0; move_index--) {  
						line[move_index] = line[move_index - 1];
					}
					line[0]  = [subfield, ""];
				}	
			}
		}
		if (line.length > 0) {
			subfields[subfield_index] = line;
			subfield_index++;
		}	
	}
}

function is_numeric(string) {
	for (var index = 0; index < string.length; index++) {
		var character = string.charAt(index);
		var char_code = character.charCodeAt(0);
		if ((char_code < 48) || (char_code > 57)) {
			return false;
		}
	}	
	return true;	
}

function is_alphanumeric(string) {
/*	for (var index = 0; index < string.length; index++) {
		var character = string.charAt(index);
		var char_code = character.charCodeAt(0);
		if ((char_code < 48) || (char_code > 57 && char_code < 65) || ((char_code > 90) && (char_code < 97)) || (char_code > 122)) {
			return false;
		}
	}	*/
	return true;	
}

function report_errors() {
	for (index = 0; index < errors.length; index++) {  
		var occurrence_number = errors[index][0];
		var subfield_name	  = errors[index][1];
		alert(sprintf(messages[4], occurrence_number, subfield_name));		
	}
}

function delete_ocurrence(occurrence_id, holder_id) {
	var delete_occ = confirm(messages[5]);
	if (delete_occ) {
		var occurence_panel = doc.getElementById(occurrence_id);
		var holder_table    = doc.getElementById(holder_id);
		holder_table.tBodies[0].removeChild(occurence_panel);
	}		
}

function check_length(subfield_name, data) {
	return (data.length <= rules[subfield_name][1]);
}

function add_ocurrence(holder_id) {

	/* Check if this occurrence can be done */
	var can_be_done = check_last_occurrence(holder_id);
	/*if (can_be_done) { ocurrencia vazia*/
	
		/* Get the last index for ID´s */
		var index_field = get_last_ocurrences_id(holder_id);
		
		/* Get the last tabindex */
		var tabindex    = get_last_tabindex(holder_id);	
		
		/* Create the new occurrence */	
		var new_occurrence       = doc.createElement("TR");		
		new_occurrence.id        = "row_" + index_field;
		new_occurrence.className = "top_alignment";		
		
		/* Add the field tag */
		var new_column         = doc.createElement("TD");	
		new_column.className   = "top_alignment";		
		new_column.style.width = "10px";
		var new_div            = doc.createElement("DIV");	
		new_div.className      = "field";	
		var content            = doc.createTextNode(parameters['field_name']);
		new_div.appendChild(content);
		new_column.appendChild(new_div);	
		new_occurrence.appendChild(new_column);	
		
		/* Add the show and hide tag */
		new_column             = doc.createElement("TD");	
		new_column.className   = "top_alignment";				
		new_column.style.width = "25px";
		new_div                = doc.createElement("DIV");	
		new_div.className      = "show_hide";	
		var new_img            = doc.createElement("IMG");	
		new_img.src            = parameters["hide_image_path"];
		new_img.alt            = messages[9];
		new_img.style.border   = "0";
		new_img.style.valign   = "middle";
		new_img.style.width    = "16px";	
		new_img.style.height   = "16px";	
		new_img.id             = "show_" + index_field;		
		new_img.onclick        = function() { show_hide(index_field);};
		new_div.appendChild(new_img);
		new_column.appendChild(new_div);	
		new_occurrence.appendChild(new_column);			
	
		/* Add the delete occurrence tag */
		new_column             = doc.createElement("TD");	
		new_column.className   = "top_alignment";				
		new_column.style.width = "55px";
		new_div                = doc.createElement("DIV");	
		new_div.className      = "show_hide";
		new_div.onclick        = function() { var occurrence_id = "row_" + index_field; delete_ocurrence(occurrence_id, "occurrences_holder");};		
		var new_img2            = doc.createElement("IMG");	
		new_img2.src            = parameters["remove_image_path"];
		new_img2.style.border   = "0";
		new_img2.style.valign   = "right";
		new_img2.style.width    = "16px";	
		new_img2.style.height   = "16px";	
		new_img2.id             = "show_" + index_field;		
		new_div.title          = messages[10];
		new_div.appendChild(new_img2);
		new_column.appendChild(new_div);	
		new_occurrence.appendChild(new_column);			
		
		/* Add the subfield tag */
		var new_column          = doc.createElement("TD");	
		new_column.className   = "top_alignment";				
		new_column.style.align  = "left";
		var new_div             = doc.createElement("DIV");	
		new_div.className       = "subfields_table";	
		new_div.id              = "table_" + index_field;
		var index = 0;

		for (var subfield in rules) {
			var type     = rules[subfield][0];
			var length   = rules[subfield][1];
			var mandatory= rules[subfield][2];
			var legenda  = rules[subfield][6];
			var id = index + 1;
			var onkeypress = "";
			if (type == "alphanumeric") {
				onkeypress = "return accept_alphanum(event, this, '" + length + "')";
			} else if (type == "numeric") {
				onkeypress = "return accept_num(event, this, '" + length + "')";
			}
			var new_table           = doc.createElement("TABLE");	
			new_table.style.width   = "100%";
			new_table.style.margin  = "0px";
			new_table.style.padding = "0px";
			var new_tbody           = doc.createElement("TBODY");	
			var new_tr              = doc.createElement("TR");	
			new_tr.className        = "top_alignment";							
			var new_td              = doc.createElement("TD");
			var new_div_2;			
			if (IE) {
				new_div_2 = doc.createElement("<DIV name='" + "subfield_" + index_field + id + "'>");
				if (!new_div_2.name) {
					new_div_2      = doc.createElement("DIV");					
					new_div_2.name = "subfield_" + index_field + id;													
				}
			} else {
				new_div_2      = doc.createElement("DIV");				
				new_div_2.name = "subfield_" + index_field + id;							
;
			}	
//			var new_div_2           = doc.createElement("DIV");
			if (mandatory == "1") {
				new_div_2.className     = "subfield1";
			} else {
				new_div_2.className     = "subfield";
			}
			new_div_2.title = legenda;
			content                 = doc.createTextNode(subfield);
			new_div_2.appendChild(content);
			new_td.appendChild(new_div_2);	
			new_tr.appendChild(new_td);
			new_td                   = doc.createElement("TD");	
			new_td.style.align       = "left";
			var new_div_2            = doc.createElement("DIV");
			new_div_2.className      = "field_edit_holder";
			new_div_2.id             = "div_" + index_field + id;
			var new_input;
			if (rules[subfield][4] != "") {
				new_div_2.className = "checkbox_holder";
				if (IE) {
					new_input = doc.createElement("<input type='checkbox' name='" + "input_" + index_field + id + "' value='" + rules[subfield][4] + "'>");
					if (!new_input.name) {
						new_input       = doc.createElement("INPUT");					
						new_input.type  = "checkbox";
						new_input.value = rules[subfield][4];
						new_input.name  = "input_" + index_field + id;													
					}					
				} else {
					new_input       = doc.createElement("INPUT");				
					new_input.type  = "checkbox";
					new_input.value = rules[subfield][4];					
					new_input.name  = "input_" + index_field + id;							
				}							
			} else if (rules[subfield][3] != "") {
			
			if (rules[subfield][5] == 1) { /*começa aqui*/

			if (IE) {
					new_input = doc.createElement("<TEXTAREA name='" + "input_" + index_field + id + "'>");
					if (!new_input.name) {
						new_input      = doc.createElement("TEXTAREA");					
						new_input.name = "input_" + index_field + id;													
					}
				} else {
					new_input      = doc.createElement("TEXTAREA");				
					new_input.name = "input_" + index_field + id;							
				}	
				new_input.style.overflow = "hidden";
				new_input.value          = "";
				new_input.style.height   = "20px";
				new_input.className = "field_edit";		
				
				
			} else {/*meioaqui*/
			
				if (IE) {
					new_input = doc.createElement("<SELECT name='" + "input_" + index_field + id + "'>");
					if (!new_input.name) {
						new_input      = doc.createElement("SELECT");					
						new_input.name = "input_" + index_field + id;													
					}					
				} else {
					new_input      = doc.createElement("SELECT");				
					new_input.name = "input_" + index_field + id;							
				}			
				eval("var array_options = " + rules[subfield][3]);						
				var option_index = 0;
				new_input.innerHTML = "";
				if (rules[subfield][2] == 0) {
					if (IE) {
						var new_option   = doc.createElement("OPTION");
						new_option.text  = sprintf(messages[7]);						
						new_option.value = "-1";
						new_input.add(new_option);
					} else {
						new_input.options[option_index] = new Option(sprintf(messages[7]), "-1");				
					}				
					option_index++;										
				}else{
					if (IE) {
						var new_option   = doc.createElement("OPTION");
						new_option.text  = sprintf(messages[8]);						
						new_option.value = "-1";
						new_input.add(new_option);
					} else {
						new_input.options[option_index] = new Option(sprintf(messages[8]), "-1");				
					}				
					option_index++;										
				
				}
								
				for (var key in array_options) {
					if (IE) {
						var new_option   = doc.createElement("OPTION");
						new_option.text  = array_options[key];						
						new_option.value = key;
						new_input.add(new_option);
					} else {
						new_input.options[option_index] = new Option(array_options[key], key);				
					}	
					option_index++;					
				}
				new_input.className = "field_edit";		
				
				}/*terminaaqui*/																						
			} else {
				if (IE) {
					new_input = doc.createElement("<TEXTAREA name='" + "input_" + index_field + id + "'>");
					if (!new_input.name) {
						new_input      = doc.createElement("TEXTAREA");					
						new_input.name = "input_" + index_field + id;													
					}
				} else {
					new_input      = doc.createElement("TEXTAREA");				
					new_input.name = "input_" + index_field + id;							
				}	
				new_input.style.overflow = "hidden";
				new_input.value          = "";
				new_input.style.height   = "20px";
				new_input.className = "field_edit";																																								
			}												
			new_input.tabIndex       = tabindex;

			var change_class_id      = "" + index_field + id;
			if (rules[subfield][4] == "") {
				new_input.onclick        = function() { change_class_over(this);};
				new_input.onblur         = function() { change_class_out(this);};
				new_input.onfocus        = function() { change_class_over(this);};				
				new_input.onkeypress     = function() {};						
				
				if (type == "alphanumeric") {
					var str_function = 'return accept_alphanum(event, this, ' + length + ');';		
					new_input.onkeypress  = new Function('event', str_function);
				} else if (type == "numeric") {
					var str_function = 'return accept_num(event, this, ' + length + ');';		
					new_input.onkeypress    = new Function('event', str_function);
				}					
			}	

			new_div_2.appendChild(new_input);
			if (rules[subfield][4] != "") {
				var text = doc.createTextNode(rules[subfield][4]);
				new_div_2.appendChild(text);
			}
			new_td.appendChild(new_div_2);	
			new_tr.appendChild(new_td);							
			new_tbody.appendChild(new_tr);
			
			if (rules[subfield][5] == 1) { /*começa aqui*/
			
			var new_tr              = doc.createElement("TR");	
			new_tr.className        = "top_alignment";							
			var new_td              = doc.createElement("TD");

			new_tr.appendChild(new_td);

			new_td                   = doc.createElement("TD");	
			new_td.style.align       = "left";
			var new_div_2            = doc.createElement("DIV");
			new_div_2.className      = "field_edit_holder";
			new_div_2.id             = "div_" + index_field + id;			
			var new_input;
			
				if (IE) {
					new_input = doc.createElement("<SELECT name='" + "inputTL_" + index_field + id + "'>");
					if (!new_input.name) {
						new_input      = doc.createElement("SELECT");					
						new_input.name = "inputTL_" + index_field + id;													
					}					
				} else {
					new_input      = doc.createElement("SELECT");				
					new_input.name = "inputTL_" + index_field + id;							
				}			
				eval("var array_options = " + rules[subfield][3]);						
				var option_index = 0;
				new_input.innerHTML = "";
					if (IE) {
						var new_option   = doc.createElement("OPTION");
						new_option.text  = sprintf(messages[8]);						
						new_option.value = "-1";
						new_input.add(new_option);
					} else {
						new_input.options[option_index] = new Option(sprintf(messages[8]), "-1");				
					}				
					option_index++;										
					
				for (var key in array_options) {
					if (IE) {
						var new_option   = doc.createElement("OPTION");
						new_option.text  = array_options[key];						
						new_option.value = key;
						new_input.add(new_option);
					} else {
						new_input.options[option_index] = new Option(array_options[key], key);				
					}	
					option_index++;					
				}
				new_input.className = "field_edit";		
            new_div_2.appendChild(new_input);
			new_td.appendChild(new_div_2);	
			new_tr.appendChild(new_td);							
			new_tbody.appendChild(new_tr);

			}/*termina aqui*/
			
			
			
			new_table.appendChild(new_tbody);
			new_div.appendChild(new_table);		
			
			index++;
			tabindex++;
			inverse["input_" + index_field + id] = subfield;
		}	
		new_column.appendChild(new_div);	
		new_occurrence.appendChild(new_column);			
	
		var holder_table = doc.getElementById(holder_id);
		if (doc.getElementById(holder_id)) {
			holder_table = doc.getElementById(holder_id);	
			holder_table.tBodies[0].appendChild(new_occurrence);		
		} else {
			holder_table               = doc.createElement("TABLE");	
			holder_table.style.width   = "100%";
			holder_table.style.margin  = "0px";
			holder_table.style.padding = "0px";
			holder_table.id            = holder_id;
			var tbody                  = doc.createElement("TBODY");				
			var holder                 = doc.getElementById("lyr1");			
			tbody.appendChild(new_occurrence);				
			holder_table.appendChild(tbody);		
			holder.appendChild(holder_table);
		}		
	
		add_new_occurrence_to_subfields();							
	/*} else {
		alert(messages[6]);
	}	ocurrencia vazia*/
}

function get_last_ocurrences_id(holder_id) {
	if (doc.getElementById(holder_id)) {
		var holder_table = doc.getElementById(holder_id);
		return holder_table.tBodies[0].rows.length;
	} else {
		return 0;
	}	
}	

function get_last_tabindex(holder_id) {
	var last_tabindex = 0;
	for (var index = 0; index < subfields.length; index++) {
		var subindex;
		var subfields_data = subfields[index];
		for (subindex = 0; subindex < subfields_data.length; subindex++) {
			var id    = subindex + 1;		
			if (doc.getElementsByName("input_" + index + id)[0]) {	
				last_tabindex = doc.getElementsByName("input_" + index + id)[0].tabIndex;
			}			
		}	
	}		
	return (last_tabindex + 1);
}

function add_new_occurrence_to_subfields() {
	var lines = new Array();
	for (var subfield in rules) {
		lines[lines.length] = [subfield, ""];
	}
	subfields[subfields.length] = lines;
}

function delete_last_occurrence() {
	return 0;
}

function check_last_occurrence(holder_id) {
	if (doc.getElementById(holder_id)) {
		var holder_table = doc.getElementById(holder_id);
		if ((holder_table.tBodies[0].rows.length - 1) >= 0) {
			var can_be_done    = false;
			var index_field    = (holder_table.tBodies[0].rows.length - 1);
			var index          = 0;
			var subfields_data = subfields[index_field];		
			var keep_searching = true;
			while ((index < subfields_data.length) && (keep_searching)) {
					var id  = index + 1;
					if (doc.getElementsByName("input_" + index_field + id).length > 0) {
						var obj     = doc.getElementsByName("input_" + index_field + id)[0];			
						var value   = doc.getElementsByName("input_" + index_field + id)[0].value;	
						var tagName = doc.getElementsByName("input_" + index_field + id)[0].tagName;
						if (((tagName == "TEXTAREA") && (value.length > 0)) ||
						    ((tagName == "SELECT") && (value != -1)) ||
						    ((tagName == "INPUT") && (obj.checked))) {			
							keep_searching = false;
							can_be_done    = true;
						}	
					}
					index++;	
			}	
			return can_be_done;	
		} else {
			return 1;
		}		
	} else {
		return 1;
	}	
}