function MM_findObj(n, d) 
{
			 var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
			  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);
			 }
			 if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
			 for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
			 if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_showhideLayers() 
{
			 var i,p,v,obj,args=MM_showhideLayers.arguments; 
			 for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) {
			  v=args[i+2]; z=args[i+3]; 
			  if (!z) {
			   if (obj.style) { obj=obj.style; v=(v=='show')?'block':(v=='hide')?'none':v; } 
			   obj.display=v; 
			  } else {
			   if (obj.style) { obj=obj.style; v=(v=='show')?z:(v=='hide')?'none':v; } 
			   obj.display=v; 
			  }
			 }
} 

function showVerb(verb)
{
	MM_showhideLayers('Identify','','hide');
	MM_showhideLayers('ListMetadataFormats','','hide');
	MM_showhideLayers('ListIdentifiers','','hide');
	MM_showhideLayers('ListSets','','hide');
	MM_showhideLayers('ListRecords','','hide');
	MM_showhideLayers('GetRecord','','hide');

	MM_showhideLayers(verb,'','show');		
}

function submitForm()
{
	URL = document.sendQuery.oaiURL.value;
	verb = document.sendQuery.verb.value;
	MetadataPrefix = document.sendQuery.MetadataPrefix.value;
	from = document.sendQuery.from.value;
	until = document.sendQuery.until.value;
	set = document.sendQuery.set.value;
	identifier = document.sendQuery.identifier.value;
	resumptionToken = document.sendQuery.resumptionToken.value;
	formStatus = true;
	if (!URL)
	{
		alert("Is necessary to fill the URL field");
		formStatus = false;
	}

	if (verb == "Identify")
	{
		URL = URL+"?verb="+verb;
	}
	else if (verb == "ListMetadataFormats")
	{
		URL = URL+"?verb="+verb;
	}
	else if (verb == "ListIdentifiers")
	{
		URL = URL+"?verb="+verb;

		if (resumptionToken){ 
			URL = URL+"&resumptionToken="+resumptionToken;
		}else{
			if (MetadataPrefix) 
			{URL = URL+"&metadataPrefix="+MetadataPrefix;}
			else 
			{ 
				alert("parameter matadataPrefix is necessary");
				formStatus = false;
			}
			if (from) URL = URL+"&from="+from;
			if (until) URL = URL+"&until="+until;
			if (set) URL = URL+"&set="+set;			
		}
	}
	else if (verb == "ListSets")
	{
		URL = URL+"?verb="+verb;
		if (resumptionToken) URL = URL+"&resumptionToken="+resumptionToken;			
	}
	else if (verb == "ListRecords")
	{
		URL = URL+"?verb="+verb;
		
		if (resumptionToken) {
			URL = URL+"&resumptionToken="+resumptionToken;
		}else{
			if (MetadataPrefix) 
			{
				URL = URL+"&metadataPrefix="+MetadataPrefix;}
			else 
			{ 
			alert("parameter matadataPrefix is necessary");
			formStatus = false;
			}			
			if (from) URL = URL+"&from="+from;
			if (until) URL = URL+"&until="+until;
			if (set) URL = URL+"&set="+set;	
		}	
	}
	else if (verb == "GetRecord")
	{
		URL = URL+"?verb="+verb;
		if (MetadataPrefix) 
		{URL = URL+"&metadataPrefix="+MetadataPrefix;}
		else 
		{ 
		alert("parameter matadataPrefix is necessary");
		formStatus = false;
		}
		if (identifier) 
		{URL = URL+"&identifier="+identifier;}
		else 
		{ 
		alert("parameter identifier is necessary");
		formStatus = false;
		}						
	}
	else
	{
		alert("parameter verb is necessary");
		formStatus = false;
	}
	if (formStatus)
	{
		document.sendQuery.outputURL.value = URL;
		window.open(URL,'oai_output');
	}
}
function setForm(verb)
{
	for (i=0 ; i<document.sendQuery.elements.length ; i++)
	{	
		if (document.sendQuery.elements[i].name != "oaiURL")
			document.sendQuery.elements[i].disabled = true;
	}
	
	if (verb == "Identify")
	{
		document.sendQuery.verb.value = "Identify";
	}
	else if (verb == "ListMetadataFormats")
	{
		document.sendQuery.verb.value = "ListMetadataFormats";
	}
	else if (verb == "ListIdentifiers")
	{
		document.sendQuery.verb.value = "ListIdentifiers";
		document.sendQuery.MetadataPrefix.disabled = false;
		document.sendQuery.from.disabled = false;
		document.sendQuery.until.disabled = false;
		document.sendQuery.set.disabled = false;
		document.sendQuery.resumptionToken.disabled = false;										
	}
	else if (verb == "ListSets")
	{
		document.sendQuery.verb.value = "ListSets";
		document.sendQuery.resumptionToken.disabled = false;		
	}
	else if (verb == "ListRecords")
	{
		document.sendQuery.verb.value = "ListRecords";
		document.sendQuery.MetadataPrefix.disabled = false;
		document.sendQuery.from.disabled = false;
		document.sendQuery.until.disabled = false;
		document.sendQuery.set.disabled = false;
		document.sendQuery.resumptionToken.disabled = false;
	}
	else if (verb == "GetRecord")
	{
		document.sendQuery.verb.value = "GetRecord";
		document.sendQuery.MetadataPrefix.disabled = false;			
		document.sendQuery.identifier.disabled = false;			
	}		
}
