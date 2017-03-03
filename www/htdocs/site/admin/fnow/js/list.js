function directoryList ( relative )
{
    var formList = document.formDirectoryList;
    formList.task.value = "list";
    formList.relative.value = relative;
    formList.submit();

    return false;
}

function columnList ( setColumn, column, order )
{
    var formList = document.formDirectoryList;
    formList.task.value = "list";
    formList.column.value = setColumn;
    if ( setColumn == column )
    {
        if ( order == "ascending" )
        {
            order = "descending";
        }
        else
        {
            order = "ascending";
        }
    }
    formList.order.value = order;
    formList.submit();

    return false;
}

var wShow = null;

function showLink ( fileName )
{
    wShow = window.open(fileName,"show","top=30,left=100,height=550,width=800,toolbar=yes,menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes");

    setTimeout("wShow.focus();",100);

    return false;
}

function createNewFolder ( )
{
    var formList = document.formDirectoryList;
    formList.task.value = "createFolder";
    var folderName = prompt("\nPlease, inform the new folder name:","");

    if ( folderName )
    {
        formList.newFolder.value = folderName;
        formList.submit();
    }

    return false;
}

function removeFile ( what, fileName )
{
    var formList = document.formDirectoryList;
    formList.task.value = "removeFile";
    var whatMessage = what == "directory" ? "folder" : "file";

    if ( confirm("Delete " + whatMessage + " " + fileName + "?") )
    {
        formList.deleteFile.value = fileName;
        formList.submit();
    }

    return false;
}

function renameFile ( fromName )
{
    var formList = document.formDirectoryList;
    formList.task.value = "renameFile";
    var toName = prompt("\nRename file " + fromName + " to:",fromName);

    if ( toName )
    {
        formList.renameFrom.value = fromName;
        formList.renameTo.value = toName;
        formList.submit();
    }

    return false;
}

