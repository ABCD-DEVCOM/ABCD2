function UPDATE_X_stringReplace ( strFrom, strFind, strReplace )
{
	var arrayFrom = strFrom.split(strFind);
	return arrayFrom.join(strReplace);
}

function UPDATE_X_xhtml ( value )
{
	value = UPDATE_X_stringReplace(value,"<br>","<br/>");
	value = UPDATE_X_stringReplace(value,"<hr>","<hr/>");

	return value;
}

function UPDATE_X_repeatType ( listItem )
{
	var repeatType = "";

	if ( listItem != null )
	{
		if ( listItem.repeat != null )
		{
			repeatType = listItem.repeat.type;
		}
	}
	
	return repeatType;
}

function UPDATE_X_findListItem ( list, find )
{
	var listItem = null;
	var found = null;

	for ( var j = 0; list[j] && found == null; j++ )
	{
		listItem = list[j];
		if ( listItem.path == find )
		{
			return listItem;
		}
		if ( UPDATE_X_repeatType(listItem) == "list" )
		{
			if ( listItem.repeat.current >= 0 )
			{
				found = UPDATE_X_findListItem(listItem.child.item[listItem.repeat.current].list,find);
			}
		}
		else
		{
			found  = UPDATE_X_findListArray(listItem.child,find);
		}
	}
	
	return found;
}

function UPDATE_X_findListArray ( listArray, find )
{
	var found = null;

	if ( listArray != null )
	{
		for ( var i = 0; listArray.item[i] && found == null; i++ )
		{
			found = UPDATE_X_findListItem(listArray.item[i].list,find);
		}
	}
	
	return found;
}

function UPDATE_X_findListSelect ( path )
{
	var lastSep = 0;
	var findPath = path;
	var listItem;

	while ( lastSep > -1 )
	{
		lastSep = findPath.lastIndexOf("/");
		findPath = findPath.substring(0,lastSep);
		listItem = UPDATE_X_findListArray(UPDATE_X_tree,findPath);
		if ( UPDATE_X_repeatType(listItem) == "list" )
		{
			return listItem;
		}
	} // while

	return null;
}

function UPDATE_X_findFormElement ( find )
{
	var formEdit = document.formEdit;
	var qtt = formEdit.elements.length;
	
	for ( var i = 0; i < qtt; i++ )
	{
		if ( formEdit.elements[i].name == find )
		{
			return formEdit.elements[i];
		}
	}
	
	alert("UPDATE_X_findFormElement: \"" + find + "\" not found!");
	return null;
}

function UPDATE_X_formElementChecked ( find, checked )
{
	var formEdit = document.formEdit;
	var qtt = formEdit.elements.length;
	var formElement = null;
	
	for ( var i = 0; i < qtt; i++ )
	{
		formElement = formEdit.elements[i];
		if ( formElement.name == find )
		{
			if ( formElement.type == "radio" || formElement.type == "checkbox" )
			{		
				formElement.checked = checked;
			}
		}
	}
	
	return;
}

function UPDATE_X_formElementSelect ( formElement, item )
{
	var qttElements = formElement.options.length;
	var startSplit = "<" + item.name + ">";
	var startSplitLength = startSplit.length;
	var endSplit = "</" + item.name + ">";
	var valueList = item.value.split(endSplit);
	var qttList = valueList.length - 1;
	var value = "";

	for ( var i = 0; i < qttElements; i++ )
	{
		formElement.options[i].selected = false;
		for ( var j = 0; j < qttList; j++ )
		{
			value = valueList[j].substring(startSplitLength);
			if ( formElement.options[i].value == value )
			{
				formElement.options[i].selected = true;
			}
		}
	}

	return;
}

function UPDATE_X_formElementCheckbox ( listItem )
{
	var formEdit = document.formEdit;
	var qttElements = formEdit.elements.length;
	var formElement = null;
	var startSplit = "<" + listItem.name + ">";
	var startSplitLength = startSplit.length;
	var endSplit = "</" + listItem.name + ">";
	var valueList = listItem.value.split(endSplit);
	var qttList = valueList.length - 1;
	var value = "";
	
	for ( var i = 0; i < qttElements; i++ )
	{
		formElement = formEdit.elements[i];
		if ( formElement.name == listItem.path )
		{
			formElement.checked = false;
			for ( var j = 0; j < qttList; j++ )
			{
				value = valueList[j].substring(startSplitLength);
				if ( formElement.value == value )
				{
					formElement.checked = true;
				}
			}
		}
	}

	return;
}

function UPDATE_X_formElementRadio ( listItem )
{
	var formEdit = document.formEdit;
	var qtt = formEdit.elements.length;
	var formElement = null;
	var checkedOnce = false;
	
	for ( var i = 0; i < qtt; i++ )
	{
		formElement = formEdit.elements[i];
		if ( formElement.name == listItem.path )
		{
			if ( formElement.value == listItem.value )
			{
				formElement.checked = true;
				checkedOnce = true;
			}
		}
	}

	if ( !checkedOnce )
	{
		for ( var i = 0; i < qtt; i++ )
		{
			formElement = formEdit.elements[i];
			if ( formElement.name == listItem.path )
			{
				if ( formElement.defaultChecked )
				{
					listItem.value = formElement.value;
					break;
				}
			}
		}
	}
	
	return;
}

function UPDATE_X_optionTextSelect ( listValue )
{
	var splitedValue = listValue.split("<");
	var qtt = splitedValue.length;
	var optionText = "";
	var addText = "";
	
	for ( var i = 0; i < qtt; i++ )
	{
		pos = splitedValue[i].indexOf(">");
		if ( pos >= 0 )
		{
			pos++;
			addText = splitedValue[i].substring(pos);
			if ( addText != "" )
			{
				if ( optionText != "" )
				{
					optionText += ", ";
				}
				optionText += addText;
			}
		}
	}

	return optionText;
}

function UPDATE_X_optionText ( pos, listItem )
{
	var posString = "";
	var optionText = "";
	var list = null;
	var optionTextLength = 0;
	var spaces = "                                                            ";
	//			  123456789 123456789 123456789 123456789 123456789 123456789 
	var maxShow = spaces.length;
var externalText = null;	

	if ( listItem != null )
	{
		if ( listItem.child != null )
		{
			if ( pos < listItem.child.item.length )
			{
				if ( listItem.child.item[pos].list.length > 0 )
				{
					list = listItem.child.item[pos].list;
					for ( var i = 0; list[i]; i++ )
					{
						if ( list[i].value == null )
						{
							UPDATE_X_spreadTextarea(UPDATE_X_tree,0); // 01.julho.2003
						}
						if ( optionText != "" )
						{
							optionText += ", ";
						}
						if ( UPDATE_X_repeatType(list[i]) == "select" )
						{
							optionText += UPDATE_X_optionTextSelect(list[i].value);
						}
						else
						{
							if ( list[i].value != null )
                                                	{

								optionText += list[i].value;
							}
						}
					}
				}
			}
		}
	}

	pos++;
	posString = pos.toString();

	optionTextLength = optionText.length;
	if ( optionTextLength > maxShow ) 
	{
		optionText = optionText.substring(0,maxShow - 4) + "...";
	}
	else
	{
		optionText = optionText + spaces.substring(0,maxShow - optionTextLength - 1);
	}

	return posString + ". " + optionText;
}

function UPDATE_X_newOption ( pos, listItem )
{
	var posString = "";

	optionText = UPDATE_X_optionText(pos,listItem);
	pos++;
	posString = pos.toString();

	return new Option(optionText,posString,false,false);
}

function UPDATE_X_spreadEmpty ( addList )
{
	var addItem = null;
	var formElement = null;
	var qtt = 0;

	if ( addList != null )
	{
		for ( var i = 0; addList[i]; i++ )
		{
			addItem = addList[i];
			formElement = null;
			if ( addItem.type == "edit" || ( addItem.type == "element" && addItem.repeat != null ) )
			{
				formElement = UPDATE_X_findFormElement(addItem.path);
				switch ( formElement.type )
				{
					case "radio":
					case "checkbox":
						UPDATE_X_formElementChecked(addItem.path,false);
						break;

					case "select-one":
						formElement.indexSelected = -1;
						formElement.value = "";
						break;
	
					case "select-multiple":
						qtt = formElement.options.length;
						for ( var j = 0; j < qtt; j++ )
						{
							formElement.options[j].selected = false;
						}
						break;
						
					default: 
						formElement.value = "";
						break;
				}
				if ( addItem.type == "element" )
				{
					if ( UPDATE_X_repeatType(addItem) == "list" )
					{
						formElement.options.length = 0;						
					}
				}
			}
			UPDATE_X_spreadEmpty(addItem.child);
		}
	}
}

function UPDATE_X_spreadSelect ( formElement, listItem )
{
	var pos = 0;

	formElement.options.length = 0;
	for ( var i = 0; listItem.child.item[i]; i++ )
	{
		formElement.options[i] = UPDATE_X_newOption(i,listItem);
	}
	formElement.selectedIndex = listItem.repeat.current;
	
	return;
}

function UPDATE_X_spreadTextarea ( tree, iElement )
{
	var listItem = null;
	var item = null;
	var formTextarea = document.formTextarea;

	for ( var i = 0; tree.item[i]; i++ )
	{
		item = tree.item[i];
		for ( var j = 0; item.list[j]; j++ )
		{
			listItem = item.list[j];
			if ( listItem.child != null )
			{
				iElement = UPDATE_X_spreadTextarea(listItem.child,iElement);
			}
			if ( listItem.type == "edit" )
			{
				if ( listItem.value == null )
				{
					listItem.value = UPDATE_X_xhtml(formTextarea.elements[iElement].value);
					iElement++;
				}
			}
		}
	}

	return iElement;
}

function UPDATE_X_spreadListItem ( formElement, listItem )
{
	UPDATE_X_spreadSelect(formElement,listItem);
	if ( listItem.repeat.current < 0 )
	{
		UPDATE_X_spreadEmpty(listItem.repeat.add);
	}
	else
	{
		UPDATE_X_spreadList(listItem.child.item[listItem.repeat.current].list);
	}
	
	return;
}

function UPDATE_X_spreadList ( list )
{
	var listItem = null;
	var formElement = null;

	for ( var i = 0; list[i]; i++ )
	{
		listItem = list[i];
		switch ( listItem.type )
		{
			case "element":
				if ( listItem.repeat != null )
				{
					formElement = UPDATE_X_findFormElement(listItem.path);
					if ( listItem.repeat.type == "list" )
					{
						UPDATE_X_spreadListItem(formElement,listItem);
					}
					if ( listItem.repeat.type == "select" )
					{
						if ( formElement.type == "checkbox" )
						{
							UPDATE_X_formElementCheckbox(listItem);
						}
						else
						{
							UPDATE_X_formElementSelect(formElement,listItem);
						}
					}
				}
				else
				{
					UPDATE_X_spreadTree(listItem.child);
				}
				break;

			case "edit":
				formElement = UPDATE_X_findFormElement(listItem.path);
				if ( formElement.type == "radio" )
				{
					UPDATE_X_formElementRadio(listItem);
					continue;
				}
				if ( listItem.value == null )
				{
					UPDATE_X_spreadTextarea(UPDATE_X_tree,0);
				}
				formElement.value = listItem.value;
				break;

		} // switch
	}
	
	return;
}

function UPDATE_X_spreadTree ( tree )
{
	for ( var i = 0; tree.item[i]; i++ )
	{
		UPDATE_X_spreadList(tree.item[i].list);
	}

	return;
}

function UPDATE_X_goto ( formElement )
{
	var listItem = UPDATE_X_findListArray(UPDATE_X_tree,formElement.name);

	if ( listItem == null )
	{
		alert("UPDATE_X_goto: \"" + formElement.name + "\" not found!");
		return;
	}
	if ( formElement.selectedIndex >= 0 )
	{
		listItem.repeat.current = formElement.selectedIndex;
		UPDATE_X_spreadList(listItem.child.item[listItem.repeat.current].list);
	}
	
	return;
}

function UPDATE_X_first ( elementName )
{
	formElement = UPDATE_X_findFormElement(elementName);

	if ( formElement.selectedIndex > 0 )
	{
		formElement.selectedIndex = 0;
		UPDATE_X_goto(formElement);
	}
	
	return;
}

function UPDATE_X_previous ( elementName )
{
	formElement = UPDATE_X_findFormElement(elementName);

	if ( formElement.selectedIndex > 0 )
	{
		formElement.selectedIndex--;
		UPDATE_X_goto(formElement);
	}
	
	return;
}

function UPDATE_X_next ( elementName )
{
	formElement = UPDATE_X_findFormElement(elementName);

	if ( formElement.selectedIndex < formElement.options.length - 1 )
	{
		formElement.selectedIndex++;
		UPDATE_X_goto(formElement);
	}
	
	return;
}

function UPDATE_X_last ( elementName )
{
	formElement = UPDATE_X_findFormElement(elementName);

	if ( formElement.selectedIndex < formElement.options.length - 1 )
	{
		formElement.selectedIndex = formElement.options.length - 1;
		UPDATE_X_goto(formElement);
	}
	
	return;
}

function UPDATE_X_move ( formElement, pos1, pos2 )
{
	var listItem = UPDATE_X_findListArray(UPDATE_X_tree,formElement.name);
	var auxItem = null;
	
	auxItem = listItem.child.item[pos1];
	listItem.child.item[pos1] = listItem.child.item[pos2];
	listItem.child.item[pos2] = auxItem;

	formElement.options[pos1].text = UPDATE_X_optionText(pos1,listItem);
	formElement.options[pos2].text = UPDATE_X_optionText(pos2,listItem);
	
	return;
}

function UPDATE_X_top ( elementName )
{
	formElement = UPDATE_X_findFormElement(elementName);

	if ( formElement.selectedIndex > 0 )
	{
		for ( var i = formElement.selectedIndex; i > 0; i-- )
		{
			UPDATE_X_move(formElement,i,i - 1);
		}
		formElement.selectedIndex = 0;
	}
	
	return;
}

function UPDATE_X_up ( elementName )
{
	formElement = UPDATE_X_findFormElement(elementName);

	if ( formElement.selectedIndex > 0 )
	{
		UPDATE_X_move(formElement,formElement.selectedIndex,formElement.selectedIndex - 1);
		formElement.selectedIndex--;
	}
	
	return;
}

function UPDATE_X_down ( elementName )
{
	formElement = UPDATE_X_findFormElement(elementName);

	if ( formElement.selectedIndex < formElement.options.length - 1 )
	{
		UPDATE_X_move(formElement,formElement.selectedIndex,formElement.selectedIndex + 1);
		formElement.selectedIndex++;
	}
	
	return;
}

function UPDATE_X_botton ( elementName )
{
	var last;

	formElement = UPDATE_X_findFormElement(elementName);

	last = formElement.options.length - 1;
	if ( formElement.selectedIndex < last )
	{
		for ( var i = formElement.selectedIndex; i < last; i++ )
		{
			UPDATE_X_move(formElement,i,i + 1);
		}
		formElement.selectedIndex = 0;
	}
	
	return;
}

function UPDATE_X_newTree ( addList )
{
	var newTree = null;
	var i = 0;

	if ( addList != null )
	{
		newTree = new Object();
		newTree.item = new Array();
		newTree.item[i] = UPDATE_X_newItem(addList);
		newTree.item[i + 1] = null;
	}
	
	return newTree;
}

function UPDATE_X_newListItemRepeat ( repeat )
{
	var newRepeat = new Object();

	if ( repeat == null )
	{
		return null;
	}
	newRepeat.type = repeat.type;
	newRepeat.current = 0;
	newRepeat.add = repeat.add;

	return newRepeat;
}

function UPDATE_X_newListItem ( addItem )
{
	var newListItem = new Object();
	var formElement = null;
	
	newListItem.name = addItem.name;
	newListItem.path = addItem.path;
	newListItem.type = addItem.type;
	newListItem.repeat = UPDATE_X_newListItemRepeat(addItem.repeat);
	newListItem.value = "";
	if ( addItem.type == "edit" )
	{
		formElement = UPDATE_X_findFormElement(addItem.path);
		if ( formElement.defaultValue != null )
		{
			newListItem.value = formElement.defaultValue;
		}
	}
	newListItem.child = UPDATE_X_newTree(addItem.child);
	
	return newListItem;
}

function UPDATE_X_newItem ( addList )
{
	var newItem = new Object();
	var i = 0;
	
	newItem.list = new Array();
	for ( i = 0; addList[i]; i++ )
	{
		newItem.list[i] = UPDATE_X_newListItem(addList[i]);
	}
	newItem.list[i] = null;

	return newItem;
}

function UPDATE_X_add ( elementName )
{
	var listItem = UPDATE_X_findListArray(UPDATE_X_tree,elementName);
	var formElement = null;
	var next = 0;

	if ( listItem == null )
	{
		alert("UPDATE_X_add: \"" + elementName + "\" not found!");
		return;
	}

	next = listItem.child.item.length - 1; // last is null
	listItem.child.item[next] = UPDATE_X_newItem(listItem.repeat.add);
	listItem.child.item[next + 1] = null;
	listItem.repeat.current = next;

	formElement = UPDATE_X_findFormElement(listItem.path);
	UPDATE_X_spreadListItem(formElement,listItem);

	return;
}

function UPDATE_X_delete ( elementName )
{
	var listItem = UPDATE_X_findListArray(UPDATE_X_tree,elementName);
	var formElement = null;
	var current = 0;
	var last = 0;
	var item = null;

	if ( listItem == null )
	{
		alert("UPDATE_X_delete: \"" + elementName + "\" not found!");
		return;
	}

	if ( listItem.repeat.current < 0 )
	{
		return;
	}
	current = listItem.repeat.current;
	last = listItem.child.item.length - 1;
	item = listItem.child.item;
	for ( var i = current; i < last - 1; i++ )
	{
		item[i] = item[i + 1];
	}
	item[last - 1] = null;
	last--;
	item.length--;

	if ( current > last - 1 )
	{
		current--;
	}
	listItem.repeat.current = current;

	formElement = UPDATE_X_findFormElement(listItem.path);
	UPDATE_X_spreadListItem(formElement,listItem);

	return;
}

function UPDATE_X_addFirst ( path )
{
	var pathSplited = path.split("/");
	var qtt = pathSplited.length;
	var findPath = "";
	var listItem = null;

	for ( var i = 1; i < qtt; i++ )
	{
		findPath += "/" + pathSplited[i];
		listItem = UPDATE_X_findListArray(UPDATE_X_tree,findPath);
		if ( listItem == null )
		{
			alert("UPDATE_X_addFirst: \"" + findPath + "\" not found!");		
			return;
		}
		if ( UPDATE_X_repeatType(listItem) != "list" )
		{
			continue;
		}
		if ( listItem.repeat.current >= 0 )
		{
			continue;
		}			
		UPDATE_X_add(findPath);
	}
	
	return;
}

function UPDATE_X_setList ( formElement )
{
	var listSelect = null;
	var listElement = null;

	listSelect = UPDATE_X_findListSelect(formElement.name);
	if ( listSelect != null )
	{
		listElement = UPDATE_X_findFormElement(listSelect.path);
		listElement.options[listSelect.repeat.current].text = UPDATE_X_optionText(listSelect.repeat.current,listSelect);
	}
}

function UPDATE_X_setValue ( formElement )
{
	var setValue = formElement.value;
	var listItem = UPDATE_X_findListArray(UPDATE_X_tree,formElement.name);

	if ( listItem == null )
	{
		UPDATE_X_addFirst(formElement.name);
		listItem = UPDATE_X_findListArray(UPDATE_X_tree,formElement.name);
		if ( listItem == null )
		{
			alert("UPDATE_X_setValue: \"" + formElement.name + "\" not found!");
			return;
		}
		formElement.value = setValue;
	}
	listItem.value = setValue;

	UPDATE_X_setList(formElement);
	
	return;
}

function UPDATE_X_setMultipleValue ( formElement )
{
	var qtt = formElement.options.length;
	var listItem = UPDATE_X_findListArray(UPDATE_X_tree,formElement.name);

	if ( listItem == null )
	{
		alert("UPDATE_X_setMultipleValue: \"" + formElement.name + "\" not found!");
		return;
	}
	listItem.value = "";
	for ( var i = 0; i < qtt; i++ )
	{
		if ( formElement.options[i].selected )
		{
			listItem.value += "<" + listItem.name + ">" + formElement.options[i].value + "</" + listItem.name + ">";
		}
	}
	
	UPDATE_X_setList(formElement);

	return;
}

function UPDATE_X_setCheckboxValue ( elementCheckbox )
{
	var formEdit = elementCheckbox.form;
	var qtt = formEdit.elements.length;
	var formElement = null;
	var listItem = UPDATE_X_findListArray(UPDATE_X_tree,elementCheckbox.name);

	if ( listItem == null )
	{
		alert("UPDATE_X_setCheckboxValue: \"" + elementCheckbox.name + "\" not found!");
		return;
	}
	listItem.value = "";
	for ( var i = 0; i < qtt; i++ )
	{
		formElement = formEdit.elements[i];
		if ( formElement.name == elementCheckbox.name )
		{
			if ( formElement.checked )
			{
				listItem.value += "<" + listItem.name + ">" + formElement.value + "</" + listItem.name + ">";
			}
		}
	}

	UPDATE_X_setList(elementCheckbox);

	return;
}

function UPDATE_X_entities ( value )
{
	if ( value != "" )
	{
		value = UPDATE_X_stringReplace(value,"\"","&quot;");
		value = UPDATE_X_stringReplace(value,"<","&lt;");
		value = UPDATE_X_stringReplace(value,">","&gt;");
	}

	return value;
}

function UPDATE_X_xml ( parentName, tree )
{
	var msg = "";
	var msgAttribute = "";
	var msgChild = "";
	var list = null;
	var listItem = null;
	var formElement = null;
	
	for ( var i = 0; tree.item[i]; i++ )
	{
		list = tree.item[i].list;
		msgAttribute = "";
		msgChild = "";
		for ( var j = 0; list[j]; j++ )
		{
			listItem = list[j];
			if ( listItem.name.substring(0,1) == "@" )
			{
				if ( listItem.value != "" )
				{
					msgAttribute += " " + listItem.name.substring(1) + "=\"" + UPDATE_X_entities(listItem.value) + "\"";
				}
				continue;
			}
			if ( UPDATE_X_repeatType(listItem) == "select" )
			{
				msgChild += listItem.value;
				continue;
			}
			if ( listItem.value != null )
			{
				if ( listItem.type == "edit" || ( listItem.type == "element" && listItem.repeat != null ) )
				{
					formElement = UPDATE_X_findFormElement(listItem.path);
					if ( formElement.type == "text" || formElement.type == "password" )
					{
						listItem.value = UPDATE_X_entities(listItem.value);
					}
				}
				if ( listItem.name == "text()" )
				{
					msgChild += listItem.value;
				}
				else
				{
					if ( listItem.value != "" )
					{
						msgChild += "<" + listItem.name + ">" + listItem.value + "</" + listItem.name + ">";
					}
				}
			}
			if ( listItem.child != null )
			{
				msgChild += UPDATE_X_xml(listItem.name,listItem.child);
			}
		}
		if ( parentName != "" )
		{
			msg += "<" + parentName + msgAttribute + ">";
		}
		msg += msgChild;
		if ( parentName != "" )
		{
			msg += "</" + parentName + ">";
		}
	}
	
	return msg;
}

var UPDATE_X_validateFocus = null;

function UPDATE_X_validate ( parentItem, tree )
{
	var list = null;
	var listItem = null;
	var iMessage = 0;

	for ( var i = 0; iMessage == 0 && tree.item[i]; i++ )
	{
		list = tree.item[i].list;
		if ( UPDATE_X_repeatType(parentItem) == "list" )
		{
			parentItem.repeat.current = i;
		}
		for ( var j = 0; iMessage == 0 && list[j]; j++ )
		{
			listItem = list[j];
			iMessage = UPDATE_X_validateItem(listItem);
			if ( iMessage != 0 )
			{
				UPDATE_X_validateFocus = UPDATE_X_findFormElement(listItem.path);
				break;
			}
			if ( listItem.child != null )
			{
				iMessage = UPDATE_X_validate(listItem,listItem.child);
			}
		}
	}
	
	return iMessage;
}

function UPDATE_X_validXML ( tree )
{
	var iMessage = 0;

	iMessage = UPDATE_X_validate(null,UPDATE_X_tree);
	if ( iMessage != 0 )
	{
		UPDATE_X_spreadTree(UPDATE_X_tree);
		if ( iMessage >= UPDATE_X_validateMessageList.length - 1)
		{
			alert("[VALIDATE: " + iMessage + "]");
		}
		else
		{
			alert(UPDATE_X_validateMessageList[iMessage]);
		}
		UPDATE_X_validateFocus.focus();

		return false;
	}
	
	return true;
}

function UPDATE_X_sendXML ( formSend )
{
	if ( UPDATE_X_validXML() == true )
	{
		formSend.xml.value = UPDATE_X_xml("",UPDATE_X_tree);
		formSend.submit();
	}

	return false;
}

function UPDATE_X_editUnload ( formSend )
{
	if ( formSend.selectedId.value != "New" )
	{
		if ( formSend.xml.value == "" )
		{
			window.open("unlock.php?ini=" + formSend.ini.value + "&user=" + formSend.user.value + "&selectedId=" + formSend.selectedId.value,"UPDATE_X_unlock","top=0,left=0,height=0,width=0,menubar=no,location=no,resizable=no,scrollbars=no,status=no");
		}
	}

	return true;
}
