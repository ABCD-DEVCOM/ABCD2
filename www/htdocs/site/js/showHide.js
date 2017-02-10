function MM_findObj(n, d) { //v4.01
var p,i,x; if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showhideLayers() { //v6.0
var i,p,v,obj,args=MM_showhideLayers.arguments;
for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
if (obj.style) { obj=obj.style; }
//alert(v);
obj.display=v;
//alert(obj.display);
}
}

function showhideLayers(obj,imageId, retractImage, expandImage) { //v1.0
var v,obj;

defaultImagePath = "../image/common/";

if (retractImage == null)
    retractImage = defaultImagePath + "retract.gif";

if (expandImage == null)
    expandImage = defaultImagePath + "expand.gif";

image=MM_findObj(imageId);

if ((obj=MM_findObj(obj))!=null) {
    v=obj.style.display;
    if (v == 'none' ) {
        disp = 'block';
        img = retractImage;
    }
    else {
        disp = 'none';
        img = expandImage;

    }
    obj.style.display = disp;
    image.src = img;
 }

}

function MyshowHideLayers(obj,mode) { //v1.0
    var obj;

    if ((obj=MM_findObj(obj))!=null) {
        alert(obj);
//        obj.style.display = mode;
    }
}

function expandRetract(icon,obj) { //v1.0
var v,icon,obj;
if ((obj=MM_findObj(obj))!=null) {
    v=obj.style.display;
    if (v == 'none' ) {
        obj.style.display = 'block';
        icon.className = 'opened';
    }
    else {
        obj.style.display = 'none';
        icon.className = 'closed';
    }
 }
}

