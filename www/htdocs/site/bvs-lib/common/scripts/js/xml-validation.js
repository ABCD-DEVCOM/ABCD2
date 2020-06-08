/*
	Códigos de erro
	---------------
	1.	falta < ou tem > em excesso
	2. falta > ou tem < em excesso
	3. caracter inválido após <, em: message[0]
	4. </message[0]> encontrado, falta <message[0]>
	5. </message[0]> encontrado, fora de ordem
	6. <message[0]> encontrado, falta </message[0]>
	7. atributo mal formado em: message[0]
	8. atributo message[0] mal formado, caracter message[1] esperado
	9. atributo duplicado em: message[0]
	10. falta o fecha comentário de: message[0]
*/

var xmlValidationErrorCode = 0;
var xmlValidationMessage = new Array();

function xmlMessageSet ( erroCode, message )
{
	xmlValidationErrorCode = erroCode;
	xmlValidationMessage = message.split("|");
	return false;
}

function xmlSkipSpace ( text, i, qtt )
{
	for ( ; i < qtt; i++ )
	{
		var currChar = text.charAt(i);
		if ( currChar != ' ' && currChar != '\n' && currChar != '\r' && currChar != '\t' )
		{
			return i;
		}
	}
	return i;
}

function xmlSkipUntil ( text, i, qtt, untilChar )
{
	for ( ; i < qtt; i++ )
	{
		if ( text.charAt(i) == untilChar )
		{
			return i;
		}
	}
	return i;
}

function xmlAttrName ( text, from, qtt )
{
	checkFirst = true;
	for (i = from; i < qtt; i++ )
	{
		compChar = text.charAt(i);
		if ( checkFirst )
		{
			if ( !(	(compChar >= 'A' && compChar <= 'Z') ||
						(compChar >= 'a' && compChar <= 'z') ) )
			{
				return i;
			}
			checkFirst = false;
		}
		else
		{
			if ( !(	(compChar >= '0' && compChar <= '9') ||
						(compChar >= 'A' && compChar <= 'Z') ||
						(compChar >= 'a' && compChar <= 'z') ||
						(compChar == ':') ||
						(compChar == '-') ||
						(compChar == '_') ) )
			{
				return i;
			}
			if ( compChar == ':' )
			{
				if ( i+1 == qtt )
				{
					return from;
				}
				checkFirst = true;
			}
		}	
	}
	return i;
}

function xmlCheckAttrChar ( element, i, qtt, checkChar, attrName )
{
	if ( i < qtt )
	{
		if ( element.charAt(i) == checkChar )
		{
			return true;
		}
	}
	return xmlMessageSet(8,attrName + "|" + checkChar);
}

function xmlCheckAttributes ( element )
{
	var qtt = element.length;
	var i = 0;
	var j = 0;
	var stack = new Array();
	var stackQtt = 0;

	do {
		i = xmlSkipSpace(element,i,qtt);
		if ( i >= qtt )
		{
			break;
		}

		j = xmlAttrName(element,i,qtt);
		var attrName = element.substring(i,j);
		if ( attrName.length == 0 )
		{
			return xmlMessageSet(7,element.substring(i));
		}

		for ( k = 0; k < stackQtt; k++ )
		{
			if ( attrName == stack[k] )
			{
				return xmlMessageSet(9,element);
			}
		}
		stack[stackQtt++] = attrName;

		i = xmlSkipSpace(element,j,qtt);
		if ( !xmlCheckAttrChar(element,i,qtt,'=',attrName ) )
		{
			return false;
		}

		i = xmlSkipSpace(element,i+1,qtt);
		if ( !xmlCheckAttrChar(element,i,qtt,'"',attrName ) )
		{
			return false;
		}

		i = xmlSkipUntil(element,i+1,qtt,'"');
		if ( !xmlCheckAttrChar(element,i,qtt,'"',attrName ) )
		{
			return false;
		}
	} while ( ++i < qtt );

	return true;
}

function xmlCheckElements ( elementList )
{
	var qtt = elementList.length;
	var stack = new Array();
	var j = 0;

	for ( var i = 0; i < qtt; i++ )
	{
		var elementSplited = elementList[i].split("/");

		if ( elementSplited[0] != "" )
		{
			var whiteSep = elementList[i].split(" ");

			if ( whiteSep[0] == "" )
			{
				return xmlMessageSet(3,elementList[i]);
			}
	
			if ( !xmlCheckAttributes(elementList[i].substring(whiteSep[0].length)) )
			{
				return false;
			}

			stack[j++] = whiteSep[0];
		}
		else
		{
			if ( j == 0 )
			{
				return xmlMessageSet(4,elementSplited[1]);
			}
			else
			{
				if ( elementSplited[1] == stack[j-1] )
				{
					j--;
				}
				else
				{
					return xmlMessageSet(5,elementSplited[1]);
				}
			}
		}
	}

	if ( j > 0 )
	{
		return xmlMessageSet(6,stack[j-1]);
	}

	return true;
}

function xmlSkipComment ( xmlSplited, i, qtt )
{
	for ( ; i < qtt; i++ )
	{
		if ( xmlSplited[i].lastIndexOf("-->") != -1 )
		{
			break;
		}
	}
	return i;
}

function xmlIsValid ( xml )
{
	xmlValidationErrorCode = 0;
	xmlValidationMessage = "";

	var elementList = new Array();

	var xmlSplited = xml.split("<");
	var len = xmlSplited.length;
	var countSplited = xml.split(">");

	if ( len < countSplited.length )
	{
		return xmlMessageSet(1,"<|>");
	}

	if ( len > countSplited.length )
	{
		return xmlMessageSet(2,">|<");
	}

	var j = 0;
	for ( var i = 0; i < len; i++ )
	{
		if ( xmlSplited[i].substring(0,3) == "!--" )
		{
			var startComment = i;

			i = xmlSkipComment(xmlSplited,i,len);
			if ( i == len )
			{
				return xmlMessageSet(10,xmlSplited[startComment]);
			}
			continue;
		}

		var itemSplited = xmlSplited[i].split(">");
		if ( itemSplited.length > 1 )
		{
			elementList[j++] = itemSplited[0];
		}
	}
	return xmlCheckElements(elementList);
}


