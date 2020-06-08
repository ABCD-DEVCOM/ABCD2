var wPreview = null;

function preview ( prevAction )
{
    var href = '../php/index.php';

    try {
        href += '?portal=' + document.forms.formPage.portal.value
    } catch(e) {}

    wPreview = window.open( href, "preview", "top=0,left=0,height=530,width=785,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no" );
    wPreview.focus();
}

function attachW ( href )
{
    window.open( href, "attach", "top=20,left=20,height=540,width=785,menubar=no,location=no,resizable=yes,scrollbars=yes,status=yes" );
}


function fnow( href )
{
    window.open( href, "attach", "top=150,left=250,height=500,width=600,menubar=no,location=no,resizable=yes,scrollbars=yes,status=yes" );
}