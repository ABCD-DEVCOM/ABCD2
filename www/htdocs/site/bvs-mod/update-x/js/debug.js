function UPDATE_X_debug ( message )
{
	var debugWindow = window.open("","debug");
	var doc = debugWindow.document;
	
	doc.open();
	doc.write("<html><body>");
	doc.write(message);
	doc.write("</body></html>");
	doc.close();
	debugWindow.focus();
}

function UPDATE_X_debugListItemRepeatAdd ( addList )
{
	var msg = "";
	var addItem = null;

	if ( addList == null )
	{
		return "=null";
	}
	msg += '<ul type="square">';
	for ( var i = 0; addList[i]; i++ )
	{
		addItem = addList[i];
		msg += "<li>";
		msg += "<pre>";
		msg += '.name=<font color="Red"><b>' + addItem.name + '</b></font>\n';
		msg += '.path=' + addItem.path + '\n';
		msg += ".type=" + addItem.type + "\n";
		msg += ".repeat" + UPDATE_X_debugListItemRepeat(addItem.repeat);
		if ( addItem.child != null )
		{
			msg += UPDATE_X_debugListItemRepeatAdd(addItem.child);
		}
		msg += "</pre>";
		msg += "</li>";
	}
	msg += "</ul>";
	
	return msg;
}

function UPDATE_X_debugListItemRepeat ( repeat )
{
	var msg = "";

	if ( repeat == null )
	{
		return "=null";
	}

	msg += "\n";
	msg += "      .type=" + repeat.type + "\n";
	msg += "      .current=" + repeat.current + "\n";
	msg += "      .add" + UPDATE_X_debugListItemRepeatAdd(repeat.add);

	return msg;
}

function UPDATE_X_debugListItem ( listItem )
{
	var msg = "";
	
	msg += '    .name=<font color="Red"><b>' + listItem.name + '</b></font>\n';
	msg += '    .path=' + listItem.path + '\n';
	msg += "    .type=" + listItem.type + "\n";
	msg += "    .repeat" + UPDATE_X_debugListItemRepeat(listItem.repeat) + "\n";
	msg += '    .value=<font color="Blue">' + listItem.value + '</font>\n';
	if ( listItem.child != null )
	{
		msg += UPDATE_X_debugTree(listItem.child);
	}

	return msg;
}

function UPDATE_X_debugTree ( tree )
{
	var msg = "";
	var item = null;
	
	msg += '<ul type="disc">';
	for ( var i = 0; tree.item[i]; i++ )
	{
		msg += "<li>";
		msg += "<pre>";
		item = tree.item[i];
		msg += ".item[" + i + "]\n";
		for ( var j = 0; item.list[j]; j++ )
		{
			msg += "  .list[" + j + "]\n";
			msg += UPDATE_X_debugListItem(item.list[j]);
		}
		msg += "</pre>";
		msg += "</li>";
	}
	msg += "</ul>";
	

	return msg;
}

function UPDATE_X_debugStruct ( )
{
	UPDATE_X_debug(UPDATE_X_debugTree(UPDATE_X_tree));

	return;
}
