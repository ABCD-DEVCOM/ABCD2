



 function dhtmlXToolbarObject(htmlObject,width,height,name,vMode){
 this.width=width;this.height=height;
 if(typeof(htmlObject)!="object")
 this.parentObject=document.getElementById(htmlObject);
 else
 this.parentObject=htmlObject;

 this.xmlDoc=0;
 this.topNod=0;this.dividerCell=0;this.firstCell=0;this.nameCell=0;this.crossCell=0;
 this.items=new Array();this.itemsCount=0;
 this.defaultAction=0;
 this.extraMode=convertStringToBoolean(vMode);
 this.onShow=0;this.onHide=0;
 this.oldMouseMove=0;
 this.tname=name;

 this.gecko=(document.all?0:1);

 this.tableCSS="toolbarTable";
 this.titleCSS="toolbarName";

 if(!this.extraMode)
 this.a9_self();
 else
{
 this.a9_self_vertical();
 this.addItem=this.a10_vertical;
};

 if(this.a11)this.a11();
 this.xmlUnit=new dtmlXMLLoaderObject(this.a12,this);
 return this;

};

 dhtmlXToolbarObject.prototype = new dhtmlXProtobarObject;





 dhtmlXToolbarObject.prototype.addItem=function(item,position){
 this.items[this.itemsCount]=item;
 this.firstCell.parentNode.insertBefore(item.getTopNode(),this.firstCell);
 item.parentNod=this;
 if(this.defaultAction)item.setAction(this.defaultAction);
 this.itemsCount++;
}


 dhtmlXToolbarObject.prototype.a10_vertical=function(item,position){
 this.items[this.itemsCount]=item;
 var tr=document.createElement("tr");
 tr.style.verticalAlign="top";
 tr.appendChild(item.getTopNode());
 this.firstCell.parentNode.parentNode.insertBefore(tr,this.firstCell.parentNode);
 item.parentNod=this;
 if(this.defaultAction)item.setAction(this.defaultAction);
 this.itemsCount++;
}




 dhtmlXToolbarObject.prototype.a0ByPosition=function(position){
 var j=0;
 for(var i=0;i<this.itemsCount;i++)
{
 if(this.items[i].hide!=1)j++;
 if(j==position)return i;
};
 return -1;
};




 dhtmlXToolbarObject.prototype.getItemByPosition=function(position){
 var z=this.a0ByPosition(position);
 if(z>=0)return this.items[z];
};

 dhtmlXToolbarObject.prototype.removeItemById=function(itemId){
 var z=this.a0(itemId);
 if(z>=0){
 if(this.items[z].removeItem)this.items[z].removeItem();
 this.firstCell.parentNode.removeChild(this.items[z].getTopNode());
 this.items[z]=0;
 this.itemsCount--;
 for(var i=z;i<this.itemsCount;i++){
 this.items[i]=this.items[i+1];
}
}
}

 dhtmlXToolbarObject.prototype.removeItemByPosition=function(position){
 var z=this.a0ByPosition(position);
 if(z){
 if(this.items[z].removeItem)this.items[z].removeItem();
 this.firstCell.parentNode.removeChild(this.items[z].getTopNode());
 this.items[z]=0;
 this.itemsCount--;
 for(var i=z;i<this.itemsCount;i++){
 this.items[i]=this.items[i+1];
}
}

}


 dhtmlXToolbarObject.prototype.hideItemByPosition=function(position){
 var z=this.getItemByPosition(position);
 if(z){z.getTopNode().style.display="none";z.hide=1;}
}






 dhtmlXToolbarObject.prototype.a12=function(that,node){
 if(!node)node=that.xmlUnit.getXMLTopNode("toolbar");

 var toolbarAlign=node.getAttribute("toolbarAlign");
 if(toolbarAlign)that.setBarAlign(toolbarAlign);

 var absolutePosition=node.getAttribute("absolutePosition");
 if(absolutePosition=="yes"){
 that.topNod.style.position="absolute";
 that.topNod.style.top=node.getAttribute("left")||0;
 that.topNod.style.left=node.getAttribute("top")||0;
};
 if((absolutePosition!="auto")&&(absolutePosition!="yes"))that.dividerCell.style.display="none";
 var name=node.getAttribute("name");if(name)that.setTitleText(name);
 var width=node.getAttribute("width");var height=node.getAttribute("height");

 that.setBarSize(width,height);

 var globalTextCss=node.getAttribute("globalTextCss");
 var globalCss=node.getAttribute("globalCss");

 for(var i=0;i<node.childNodes.length;i++)
{
 var localItem=node.childNodes[i];
 if(localItem.nodeType==1)
{
 if((!localItem.getAttribute("className"))&&(globalCss))
 localItem.setAttribute("className",globalCss);

 if((!localItem.getAttribute("textClassName"))&&(globalTextCss))
 localItem.setAttribute("textClassName",globalTextCss);


 var z=eval("window.dhtmlX"+localItem.tagName+"Object");
 if(z)
 var TempNode= new z(localItem);
 else
 var TempNode=null;

 if(localItem.tagName=="divider")
{
 var imid=localItem.getAttribute("id");
 if(that.extraMode)
 that.addItem(new dhtmlXToolbarDividerYObject(imid));
 else
 that.addItem(new dhtmlXToolbarDividerXObject(imid));
}
 else
 if(TempNode)
{
 that.addItem(TempNode);
 if(that.a14)that.a14(that,TempNode,localItem);
}
}
}
};


 dhtmlXToolbarObject.prototype.setToolbarCSS=function(table,title){
 this.tableCSS=table;
 this.titleCSS=title;
 this.topNod.className=this.tableCSS;
 this.preNameCell.className=this.titleCSS;
 this.nameCell.className=this.titleCSS;

}


 dhtmlXToolbarObject.prototype.a9_self=function()
{
 if(!this.width)this.width=1;
 if(!this.height)this.height=1;

 var div=document.createElement("div");
 div.innerHTML='<table cellpadding="0" cellspacing="1" class="'+this.tableCSS+'" style="display:none" width="'+this.width+'" height="'+this.height+'"><tbody>'+
 '<tr>'+
 '<td width="'+(this.gecko?5:3)+'px"><div class="toolbarHandle">&nbsp;</div></td>'+
 '<td class="'+this.titleCSS+'" style="display:none">'+this.name+'</td>'+
 '<td></td>'+
 '<td align="right" width="100%" class="'+this.titleCSS+'" style="display:none">'+this.name+'</td>'+
 '<td></td>'+
 '</tr></tbody></table>';
 var table=div.childNodes[0];
 table.setAttribute("UNSELECTABLE","on");
 table.onselectstart=this.badDummy;
 this.topNod=table;
 this.dividerCell=table.childNodes[0].childNodes[0].childNodes[0];
 this.dividerCell.toolbar=this;
 this.preNameCell=this.dividerCell.nextSibling;
 this.firstCell=this.preNameCell.nextSibling;
 this.nameCell=this.firstCell.nextSibling;
 this.crossCell=this.nameCell.nextSibling;

 this.parentObject.appendChild(table);
};


 dhtmlXToolbarObject.prototype.a9_self_vertical=function()
{
 if(!this.width)this.width=1;
 if(!this.height)this.height=1;

 var div=document.createElement("div");
 div.innerHTML='<table cellpadding="0" cellspacing="1" class="'+this.tableCSS+'" style="display:none" width="'+this.width+'" height="'+this.height+'"><tbody>'+
 '<tr><td heigth="'+(this.gecko?5:3)+'px"><div class="vtoolbarHandle" style="height: 3px;width:100%;overflow:hidden"></div></td></tr>'+
 '<tr><td height="100%" class="'+this.titleCSS+'" style="display:none">'+this.name+'</td></tr>'+
 '<tr><td></td></tr>'+
 '<tr><td align="right" height="100%" class="'+this.titleCSS+'" style="display:none">'+this.name+'</td></tr>'+
 '<tr><td></td></tr>'+
 '</tbody></table>';

 var table=div.childNodes[0];
 table.onselectstart=this.badDummy;
 table.setAttribute("UNSELECTABLE","on");

 this.topNod=table;
 this.dividerCell=table.childNodes[0].childNodes[0].childNodes[0];
 this.dividerCell.toolbar=this;
 this.preNameCell=table.childNodes[0].childNodes[1].childNodes[0];
 this.firstCell=table.childNodes[0].childNodes[2].childNodes[0];
 this.nameCell=table.childNodes[0].childNodes[3].childNodes[0];
 this.crossCell=table.childNodes[0].childNodes[4].childNodes[0];

 this.parentObject.appendChild(table);
};






 function dhtmlXImageButtonObject(src,width,height,action,id,tooltip,className,disableImage){
 if(src.tagName=="ImageButton")
{
 width=src.getAttribute("width");
 height=src.getAttribute("height");
 id=src.getAttribute("id");
 action=src.getAttribute("imaction");
 tooltip=src.getAttribute("tooltip");
 className=src.getAttribute("className");
 disableImage=src.getAttribute("disableImage");
 src=src.getAttribute("src");
}

 this.topNod=0;this.action=0;this.persAction=0;this.id=id||0;
 this.className=className||"defaultButton";
 this.src=src;this.disableImage=disableImage;
 this.tooltip=tooltip||"";

 td=document.createElement("td");
 this.topNod=td;
 td.height=height;td.width=width;td.align="center";

 td.innerHTML="<img src='"+src+"' border='0' alt='"+this.tooltip+"' title='"+this.tooltip+"' style='padding-left:2px;padding-right:2px;'>";
 td.className=this.className;
 td.objectNode=this;
 this.imageTag=td.childNodes[0];
 this.enable();
};


 dhtmlXImageButtonObject.prototype = new dhtmlXButtonPrototypeObject;





 function dhtmlXToolbarDividerYObject(id){
 this.topNod=0;
 if(id)this.id=id;else this.id=0;
 td=document.createElement("td");
 this.topNod=td;td.align="center";td.style.paddingRight="2";td.style.paddingLeft="2";
 td.innerHTML="<div class='toolbarDividerY'>&nbsp;</div>";
 if(!document.all)td.childNodes[0].style.height="0px";
 return this;
};
 dhtmlXToolbarDividerYObject.prototype = new dhtmlXButtonPrototypeObject;





 function dhtmlXToolbarDividerXObject(id){
 this.topNod=0;
 if(id)this.id=id;else this.id=0;
 td=document.createElement("td");
 this.topNod=td;td.align="center";td.style.paddingRight="2";td.style.paddingLeft="2";td.width="4px";
 td.innerHTML="<div class='toolbarDivider'></div >";
 if(!document.all){td.childNodes[0].style.width="0px";td.style.padding="0 0 0 0";td.style.margin="0 0 0 0";}
 return this;
};
 dhtmlXToolbarDividerXObject.prototype = new dhtmlXButtonPrototypeObject;





 function dhtmlXImageTextButtonObject(src,text,width,height,action,id,tooltip,className,textClassName,disableImage){
 if(src.tagName=="ImageTextButton")
{
 width=src.getAttribute("width");
 height=src.getAttribute("height");
 id=src.getAttribute("id");
 action=src.getAttribute("imaction");
 tooltip=src.getAttribute("tooltip");
 className=src.getAttribute("className");
 disableImage=src.getAttribute("disableImage");
 textClassName=src.getAttribute("textClassName");
 if(src.childNodes[0])
 text=src.childNodes[0].data;
 else
 text="";
 src=src.getAttribute("src");
}
 this.topNod=0;
 this.action=0;this.persAction=0;
 this.className=className||"defaultButton";
 this.textClassName=textClassName||"defaultButtonText";
 this.src=src;this.disableImage=disableImage;
 this.tooltip=tooltip||"";this.id=id||0;


 td=document.createElement("td");
 this.topNod=td;
 td.height=height;
 td.width=width;td.align="center";
 td.noWrap=true;
 td.innerHTML="<table width='100%' height='100%' cellpadding='0' cellspacing='0'><tr><td valign='middle'><img src='"+src+"' border='0' alt='"+this.tooltip+"' style='padding-left:2px;padding-right:2px;'></td><td width='100%' style='padding-left:5px' align='left' class='"+this.textClassName+"'>"+text+"</td></tr></table>";
 td.className=this.className;
 td.objectNode=this;
 this.imageTag=td.childNodes[0].childNodes[0].childNodes[0].childNodes[0].childNodes[0];
 this.textTag=td.childNodes[0].childNodes[0].childNodes[0].childNodes[1];
 this.enable();

 return this;
};

 dhtmlXImageTextButtonObject.prototype = new dhtmlXButtonPrototypeObject;

 dhtmlXImageTextButtonObject.prototype.setText = function(newText){
 this.textTag.innerHTML=newText;
};







 function dhtmlXSelectButtonObject(id,valueList,displayList,action,width,height,className)
{
 if(id.tagName=="SelectButton")
{
 width=id.getAttribute("width");
 height=id.getAttribute("height");
 className=id.getAttribute("className");
 action=id.getAttribute("imaction");
 valueList="";
 displayList="";
 for(var j=0;j<id.childNodes.length;j++)
{
 var z=id.childNodes[j];
 if((z.nodeType==1)&&(z.tagName == "option"))
{
 if(valueList)valueList+=","+z.getAttribute("value");
 else valueList=z.getAttribute("value");
 if(z.childNodes[0])
{
 if(displayList)displayList+=","+z.childNodes[0].data;
 else displayList=z.childNodes[0].data;
}
 else displayList+=",";
};
};
 id=id.getAttribute("id");
}
 this.topNod=0;
 this.action=0;
 this.persAction=0;
 this.selElement=0;
 if(id)this.id=id;else this.id=0;




 td=document.createElement("td");
 this.topNod=td;td.align="center";
 td.width=width;
 var sel=document.createElement("select");
 this.selElement=sel;
 sel.onchange=this.a1;
 sel.objectNode=this;
 if(className)sel.className=className;
 if(width)sel.style.width="100%";
 var temp1=valueList.split(",");

 if(displayList)var temp2=displayList.split(",");
 else var temp2=valueList.split(",");
 for(var i=0;i<temp1.length;i++)
{
 sel.options[sel.options.length]=new Option(temp2[i],temp1[i]);
};
 td.appendChild(sel);

 td.className="toolbarNormalButton";
 td.objectNode=this;

 return this;
};


 dhtmlXSelectButtonObject.prototype = new dhtmlXButtonPrototypeObject;

 dhtmlXSelectButtonObject.prototype.disable=function(){
 this.selElement.disabled=true;
};


 dhtmlXSelectButtonObject.prototype.enable=function(){
 this.selElement.disabled=false;
};



 dhtmlXSelectButtonObject.prototype.a1=function(){
 if((!this.objectNode.persAction)||(this.objectNode.persAction(this.objectNode.selElement.value)))
 if(this.objectNode.action){this.objectNode.action(this.objectNode.id,this.objectNode.selElement.value);}
};


 dhtmlXSelectButtonObject.prototype.addOption=function(value,display){
 this.selElement.options[this.selElement.options.length]=new Option(display,value);
};

 dhtmlXSelectButtonObject.prototype.removeOption=function(value){
 var z=getIndexByValue(value);
 if(z>=0)this.selElement.removeChild(this.selElement.options[i]);
};

 dhtmlXSelectButtonObject.prototype.setOptionValue=function(oldValue,newValue){
 var z=getIndexByValue(oldValue);
 if(z>=0)this.selElement.options[i].value=newValue;
};

 dhtmlXSelectButtonObject.prototype.setOptionText=function(value,newText){
 var z=getIndexByValue(value);
 if(z>=0)this.selElement.options[i].text=newText;
};

 dhtmlXSelectButtonObject.prototype.setSelected=function(value){
 var z=getIndexByValue(value);
 if(z>=0)this.selElement.options[i].selected=true;
};

 dhtmlXSelectButtonObject.prototype.getIndexByValue=function(value){
 for(var i=0;i<this.selElement.options.lenght;i++)
{
 if(this.selElement.options[i].value==value)
 return i;
};
 return -1;
};





function dhtmlXTwoStateButtonObject(id,src,text,width,height,action,tooltip,className,textClassName,disableImage,pressedState){
 if(id.tagName=="TwoStateButton")
{
 width=id.getAttribute("width")||1;
 height=id.getAttribute("height")||1;
 action=id.getAttribute("imaction");
 tooltip=id.getAttribute("tooltip");
 className=id.getAttribute("className");
 disableImage=id.getAttribute("disableImage");
 textClassName=id.getAttribute("textClassName");
 pressedState=id.getAttribute("pressedState");

 if(id.childNodes[0])
 text=id.childNodes[0].data;
 else
 text="";
 src=id.getAttribute("src");
 id=id.getAttribute("id");
}
 this.state=0;
 this.topNod=0;
 this.action=0;this.persAction=0;
 this.className=className||"defaultButton";
 this.textClassName=textClassName||"defaultButtonText";

 this.disableImage=disableImage;
 this.tooltip=tooltip||"";this.id=id||0;
 if(text)this.textP=text.split(',');else this.textP=",".split(',');
 if(src)this.srcA=src.split(',');else this.srcA=",".split(',');
 this.src=this.srcA[0];
 td=document.createElement("td");
 this.topNod=td;
 td.height=height;
 td.width=width;
 td.align="center";
 td.noWrap=true;

 td.innerHTML="<table width='100%' height='100%' cellpadding='0' cellspacing='0'><tr><td valign='middle'><img src='"+this.srcA[0]+"' border='0' alt='"+this.tooltip+"' style='padding-left:2px;padding-right:2px;'></td><td width='100%' style='padding-left:5px' align='left' class='"+this.textClassName+"'>"+this.textP[0]+"</td></tr></table>";
 td.className=this.className;
 td.objectNode=this;
 this.imageTag=td.childNodes[0].childNodes[0].childNodes[0].childNodes[0].childNodes[0];
 this.textTag=td.childNodes[0].childNodes[0].childNodes[0].childNodes[1];

 if(!text)this.textTag.style.display="none";
 if(!src)this.imageTag.style.display="none";

 this.enable();
 if(convertStringToBoolean(pressedState))
{
 this.state=1;this.topNod.className=this.className+"down";
 if(this.textP[1])this.textTag.innerHTML=this.textP[1];
 if(this.srcA[1])this.imageTag.src=this.srcA[1];
}
 return this;
};

dhtmlXTwoStateButtonObject.prototype = new dhtmlXButtonPrototypeObject;


dhtmlXTwoStateButtonObject.prototype.a1 = function(e,that){
 if(!that)that=this.objectNode;
 if(that.topNod.dstatus)return;
 if(that.state==0){that.state=1;this.className=that.className+"down";}
 else{that.state=0;this.className=that.className;}

 if(that.textP[that.state])that.textTag.innerHTML=that.textP[that.state];
 if(that.srcA[that.state])that.imageTag.src=that.srcA[that.state];


 if((!that.persAction)||(that.persAction()))
 if(that.action){that.action(that.id,that.state);}

};

 dhtmlXTwoStateButtonObject.prototype.a3=function(e){
};

 dhtmlXTwoStateButtonObject.prototype.a2=function(e){
};

 dhtmlXTwoStateButtonObject.prototype.getState=function(){
 return this.state;
};

 dhtmlXTwoStateButtonObject.prototype.setState=function(state){
 this.state=state;
 if(state==0)this.topNod.className=this.className;
 else this.topNod.className=this.className+"down";

 if(this.textP[this.state])this.textTag.innerHTML=this.textP[this.state];
 if(this.srcA[this.state])this.imageTag.src=this.srcA[this.state];
};


