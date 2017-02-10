// fixEnterKey and handleEnter disable the enter key to post a form 
// tested with Firefox 1.5 and IE6 Windows XP
//
// Ciro Mondueri
// Kalio.Net 2006

function ieHandleEnter(e) {
  // e is traditionally the event
  if (!e) e = window.event;  // ... but, just in case
  return handleEnter(this,e);
}

function handleEnter (field,event) {
  var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
  if (keyCode == 13) {
      var i;
      for (i = 0; i < field.form.elements.length; i++)
        if (field == field.form.elements[i])
          break;
      i = (i + 1) % field.form.elements.length;
      // TODO disable this when the autocomplete box is showing
      field.form.elements[i].focus();        
      return false;
  } 
  else
    return true;
}    

function fixEnterKey() {
   var inputs = document.getElementsByTagName('input');
   var selects = document.getElementsByTagName('select');

   for (var i=0; i < inputs.length; i++) {
     if (inputs[i].type == 'text') { 
      inputs[i].onkeypress = ieHandleEnter;
      //inputs[i].setAttribute('onkeypress','return handleEnter(this, event)');
     }
   }
   for (var i=0; i < selects.length; i++) {
      selects[i].onkeypress = ieHandleEnter;
      //selects[i].setAttribute('onkeypress','return handleEnter(this, event)');
   }
}

