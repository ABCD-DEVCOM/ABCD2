var msgArray = new Array( "[first]" );
var wOpen = null;
var tabLevel = "....";
var tabLength = tabLevel.length;

function close_and_focus ( )
{
    wOpen.close();
    document.formPage.tree.focus();
}

function windowOpen ( href, target )
{
    wOpen = window.open( href, target, "top=70,left=150,height=600,width=700,menubar=no,location=no,resizable=yes,scrollbars=yes,status=yes" );
    wOpen.focus();
}

function changeItemBuffer ( value, page )
{
    var formGo = document.formHidden;

    windowOpen("","item");

    formGo.target = "item";
    formGo.page.value = page;
    formGo.buffer.value = value;

    setTimeout("document.formHidden.submit(); wOpen.focus();",200);
}

function newItem ( page )
{
    changeItemBuffer("",page);
}

function changeItem ( currList, page )
{
    var curr = currList.selectedIndex;

    if ( curr == -1 )
    {
        alert(msgArray[1]);
        return;
    }
    changeItemBuffer(listValues[curr],page);
}

function left ( currList )
{
    var curr = currList.selectedIndex;
    var qtt = currList.options.length;
    var level;
    var nextLevel;

    if ( curr < 0 )
    {
        alert(msgArray[1]);
        return;
    }
    if ( currList.options[curr].value < 1 )
    {
        alert(msgArray[2]);
        return;
    }
    level = parseInt(currList.options[curr].value);
    nextLevel = 0;
    if ( curr < qtt - 1 )
    {
        nextLevel = parseInt(currList.options[curr + 1].value);
    }
    if ( nextLevel - level > 0 )
    {
        alert(msgArray[3]);
        return;
    }

    if ( curr <  qtt - 1 )
    {
        nextLevel = parseInt(currList.options[curr + 1].value);
    }

    level--;
    currList.options[curr].value = level.toString();
    currList.options[curr].text = currList.options[curr].text.substring(tabLength);
}

function right ( currList )
{
    var curr = currList.selectedIndex;
    var level;
    var prevLevel;

    if ( curr < 0 )
    {
        alert(msgArray[1]);
        return;
    }
    if ( curr < 1 )
    {
        alert(msgArray[3]);
        return;
    }
    level = parseInt(currList.options[curr].value);
    prevLevel = parseInt(currList.options[curr - 1].value);
    if ( level - prevLevel > 0 )
    {
        alert(msgArray[3]);
        return;
    }

    level++;
    currList.options[curr].value = level.toString();
    currList.options[curr].text = tabLevel + currList.options[curr].text;
}

function up ( currList )
{
    var curr = currList.selectedIndex;
    var auxText = "";
    var auxList;

    if ( curr < 0 )
    {
        alert(msgArray[1]);
        return;
    }
    if ( curr < 1 )
    {
        alert(msgArray[4]);
        return;
    }

    auxList = listValues[curr - 1];
    listValues[curr - 1] = listValues[curr];
    listValues[curr] = auxList;

    auxText = currList.options[curr - 1].text;
    currList.options[curr - 1].text = currList.options[curr].text;
    currList.options[curr].text = auxText;

    auxText = currList.options[curr - 1].value;
    currList.options[curr - 1].value = currList.options[curr].value;
    currList.options[curr].value = auxText;

    currList.selectedIndex--;
}

function down ( currList )
{
    var curr = currList.selectedIndex;
    var qtt = currList.options.length;
    var auxText = "";
    var auxList;

    if ( curr < 0 )
    {
        alert(msgArray[1]);
        return;
    }
    if ( curr >= qtt - 1 )
    {
        alert(msgArray[5]);
        return;
    }

    auxList = listValues[curr + 1];
    listValues[curr + 1] = listValues[curr];
    listValues[curr] = auxList;

    auxText = currList.options[curr + 1].text;
    currList.options[curr + 1].text = currList.options[curr].text;
    currList.options[curr].text = auxText;

    auxText = currList.options[curr + 1].value;
    currList.options[curr + 1].value = currList.options[curr].value;
    currList.options[curr].value = auxText;

    currList.selectedIndex++;
}

function del ( selectList )
{
    var curr = selectList.selectedIndex;
    var qtt = selectList.options.length;

    if ( curr < 0 )
    {
        alert(msgArray[1]);
        return;
    }
    for ( var i = curr; i < qtt - 1; i++ )
    {
        listValues[i] = listValues[i + 1];
        selectList.options[i].text = selectList.options[i + 1].text;
        selectList.options[i].value = selectList.options[i + 1].value;
    }
    listValues[qtt - 1] = null;
    listValues.length--;
    selectList.options.length--;
}

function delComponent ( selectList )
{
    var curr = selectList.selectedIndex;
    var qtt = selectList.options.length;
    var lang = document.formPage.lang.value;
    
    var portal = '';
    if( document.formPage.portal )
        portal = document.formPage.portal.value
 
    var component = listValues[curr];
    //var id = curr;
    var id   = tagValue(component, "id");
    var name = tagValue(component, "name");
    var type = tagValue(component, "type");
    var file = tagValue(component, "file");

    var href = "../admin/del_component.php?id="
        + id + "&name=" + name + "&type=" + type + "&file=" + file
        + "&lang=" + lang;

    if ( portal != '' ){
        href += '&portal=' + portal;
    }
//alert(href);
    dOpen = window.open( href, "delete", "top=10000,left=10000,height=1,width=1,menubar=no,location=no,resizable=yes,scrollbars=yes,status=yes" );
    dOpen.focus();

    return;
}

function structXML ( fromForm )
{
    var qtt = fromForm.elements.length;
    var currElement;
    var value = "";
    var splited = null;

    for ( var i = 0; i < qtt; i++ )
    {
        currElement = fromForm.elements[i];
        value += "<" + currElement.name + ">";

        if ( currElement.name ==  "id" && currElement.value == "New" )
        {
            value += nextId.toString();
            nextId++;
        }
        else if ( currElement.name ==  "password" && currElement.value.length < 16 )
        {
           value += hex_md5(currElement.value);
        }
        else
        {
           value += currElement.value;
            // evitar o erro na transformação do XML
            splited = value.split("\"");
            value = splited.join("\'");
        }
        value += "</" + currElement.name + ">";
    }

    return value;
}

function tabString ( )
{
    var currList = document.formPage.tree;
    var curr = currList.selectedIndex;
    var level = parseInt(currList.options[curr].value);
    var tab = "";

    while ( level-- )
    {
        tab += tabLevel;
    }

    return tab;
}

function getValue ( fromForm, findName )
{
    var qtt = fromForm.elements.length;
    var currElement;
    var findNameList = findName.split(",");
    var findNameListLenght = findNameList.length;
    var i,j;

    for ( j = 0; j < findNameListLenght; j++ )
    {
        for ( i = 0; i < qtt; i++ )
        {
            currElement = fromForm.elements[i];
            if ( currElement.name == findNameList[j] )
            {
                if ( currElement.value != '' )
                {
                    return tabString() + currElement.value;
                }
            }
        }
    }

    return "[not found]";
}

function replaceItem ( curr, toOptionText )
{
    var fromForm = wOpen.document.formPage;
    var currList = document.formPage.tree;

    listValues[curr] = structXML(fromForm);
    currList.options[curr].text = getValue(fromForm,toOptionText);
    wOpen.close();
    currList.focus();
}

function addItem ( toOptionText )
{
    var currList = document.formPage.tree;
    var qtt = currList.options.length;

    listValues[qtt + 1] = null;
    currList.options[qtt] = new Option("","0");
    currList.selectedIndex = qtt;
    replaceItem(qtt,toOptionText);
}

function addComponent ( toOptionText )
{
    var currList = document.formPage.tree;
    var qtt = currList.options.length;
    var lang = document.formPage.lang.value;

    var portal = '';
    if( document.formPage.portal )
        portal = document.formPage.portal.value

    listValues[qtt + 1] = null;
    currList.options[qtt] = new Option("","0");
    currList.selectedIndex = qtt;
    replaceItem(qtt,toOptionText);

    var component = listValues[qtt];
    var id = tagValue(component, "id");
    var type = tagValue(component, "type");

    var href = "../admin/add_component.php?id=" + id + "&type=" + type
        + "&lang=" + lang;

    if ( portal != '' ){
        href += '&portal=' + portal;
    }

    aOpen = window.open( href, "add", "top=10,left=10,height=100,width=100,menubar=no,location=no,resizable=no,scrollbars=no,status=no" );

}


function modifyItem ( toOptionText )
{
    var currList = document.formPage.tree;
    var curr = currList.selectedIndex;

    replaceItem(curr,toOptionText);
}

function checkLevel ( )
{
    var currList = document.formPage.tree;
    var qtt = currList.options.length;
    var prevLevel = -1;
    var currLevel;

    for ( var i = 0; i < qtt; i++ )
    {
        currLevel = parseInt(currList.options[i].value);
        if ( currLevel - prevLevel > 1 )
        {
            return i;
        }
        prevLevel = currLevel;
    }

    return -1;
}

function listValuesJoin ( itemName )
{
    var currList = document.formPage.tree;
    var qtt = currList.options.length;
    var value = "";
    var currLevel;
    var nextLevel;
    var closeLevel;

    for ( var i = 0; listValues[i]; i++ )
    {
        currLevel = parseInt(currList.options[i].value);

        splited = listValues[i].split("\"");
        value += "<" + itemName + ">" + splited.join("\\\"");
//        value += "<" + itemName + ">" + listValues[i];

        nextLevel = 0;
        if ( i < qtt - 1 )
        {
            nextLevel = parseInt(currList.options[i + 1].value);
        }
        for ( closeLevel = currLevel; closeLevel >= nextLevel; closeLevel-- )
        {
            value += "</" + itemName + ">\n";
        }
    }

    return value;
}

function save ( itemName )
{
    var breakLevel;
    var formGo = document.formPage;

    breakLevel = checkLevel();
    if ( breakLevel != -1 )
    {
        alert(msgArray[3]);
        document.formPage.tree.selectedIndex = breakLevel;
        return;
    }
//    formGo.xsl.value = parent.frameHidden.menuXSL;
    formGo.buffer.value = listValuesJoin(itemName);
    formGo.submit();
}

function showListValues()
{
    msg = "";
    for (var i = 0; listValues[i]; i++)
    {
        msg += listValues[i] + "\n";
    }
    alert(msg);
}


function tagElement(XMLString) {

    var input = XMLString;
    var reTagCatcher = /(<.[^(><.)]+>)/g;
    var output = XMLString.match(reTagCatcher);

    return output;

}

function tagValue (xml, tag) {
    var start_string = "<" + tag + ">";
    var end_string = "</" + tag + ">";

    var pos1 = xml.indexOf(start_string) + start_string.length;
    var pos2 = xml.indexOf(end_string) - pos1;

    var tag_value  = xml.substr(pos1,pos2 );

    return tag_value;
}