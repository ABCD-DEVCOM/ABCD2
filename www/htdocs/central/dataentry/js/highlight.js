function doHighlight(bodyText, searchTerm, highlightStartTag, highlightEndTag)
{
  // the highlightStartTag and highlightEndTag parameters are optional
  if ((!highlightStartTag) || (!highlightEndTag)) {
    highlightStartTag = "<font style='color:blue; background-color:yellow;'>";
    highlightEndTag = "</font>";
  }

  // find all occurences of the search term in the given text,
  // and add some "highlight" tags to them (we're not using a
  // regular expression search, because we want to filter out
  // matches that occur within HTML tags and script blocks, so
  // we have to do a little extra validation)
  var newText = "";
  var i = -1;
  var lcSearchTerm = searchTerm.toLowerCase();
  lcSearchTerm  = lcSearchTerm.replace(/[èéêë]/ig, 'e');
  lcSearchTerm  = lcSearchTerm.replace(/[àâäá]/ig, "a");
  lcSearchTerm  = lcSearchTerm.replace(/[îïíì]/ig, "i");
  lcSearchTerm  = lcSearchTerm.replace(/[ôöóò]/ig, "o");
  lcSearchTerm  = lcSearchTerm.replace(/[ùûüú]/ig, "u");
  lcSearchTerm  = lcSearchTerm.replace(/[,]/ig, " ");

  var lcBodyText = bodyText.toLowerCase();
  lcBodyText = lcBodyText.replace(/[èéêë]/ig, 'e');
  lcBodyText = lcBodyText.replace(/[àâäá]/ig, "a");
  lcBodyText = lcBodyText.replace(/[îïíì]/ig, "i");
  lcBodyText = lcBodyText.replace(/[ôöóò]/ig, "o");
  lcBodyText = lcBodyText.replace(/[ùûüú]/ig, "u");
  while (bodyText.length > 0) {
    i = lcBodyText.indexOf(lcSearchTerm, i+1);
    if (i < 0) {
      newText += bodyText;
      bodyText = "";
    } else {
      // skip anything inside an HTML tag
      if (bodyText.lastIndexOf(">", i) >= bodyText.lastIndexOf("<", i)) {
        // skip anything inside a <script> block
        if (lcBodyText.lastIndexOf("/script>", i) >= lcBodyText.lastIndexOf("<script", i)) {
          newText += bodyText.substring(0, i) + highlightStartTag + bodyText.substr(i, searchTerm.length) + highlightEndTag;
          bodyText = bodyText.substr(i + searchTerm.length);
          lcBodyText = bodyText.toLowerCase();
          lcBodyText = lcBodyText.replace(/[èéêë]/ig, 'e');
  		  lcBodyText = lcBodyText.replace(/[àâäá]/ig, "a");
  		  lcBodyText = lcBodyText.replace(/[îïíì]/ig, "i");
  		  lcBodyText = lcBodyText.replace(/[ôöóò]/ig, "o");
  		  lcBodyText = lcBodyText.replace(/[ùûüú]/ig, "u");
          i = -1;
        }
      }
    }
  }

  return newText;
}


/*
 * This is sort of a wrapper function to the doHighlight function.
 * It takes the searchText that you pass, optionally splits it into
 * separate words, and transforms the text on the current web page.
 * Only the "searchText" parameter is required; all other parameters
 * are optional and can be omitted.
 */
function highlightSearchTerms(searchText, treatAsPhrase, warnOnFailure, highlightStartTag, highlightEndTag)
{
  // if the treatAsPhrase parameter is true, then we should search for
  // the entire phrase that was entered; otherwise, we will split the
  // search string so that each word is searched for and highlighted
  // individually
  searchText = searchText.replace(/ and not /ig, '|');
  searchText = searchText.replace(/ and /ig, '|');
  searchText = searchText.replace(/ or /ig, '|');
  searchText=searchText.replace(",","")
  if (!document.body || typeof(document.body.innerHTML) == "undefined") {
    if (warnOnFailure) {
      alert("Sorry, for some reason the text of this page is unavailable. Searching will not work.");
    }
    return false;
  }
  searchArray=searchText.split('|')
  texto=document.getElementById('results');
  var bodyText = texto.innerHTML;
  for (var ixt = 0; ixt < searchArray.length; ixt++) {
    term=searchArray[ixt];
	ix=term.lastIndexOf('_')
	if (ix>0){
		term=term.substring(ix+1)
    }
    ix=term.lastIndexOf('$')
    if (ix>0){
        term=term.substring(0,ix)
	}
	st=term.split(" ")
	for (ixst=0;ixst<st.length;ixst++){
		termino=Trim(st[ixst])
		if (termino!="" && termino.length>3){
			bodyText = doHighlight(bodyText,termino , highlightStartTag, highlightEndTag);
		}
    }
  }

  texto.innerHTML = bodyText;
  return true;
}

