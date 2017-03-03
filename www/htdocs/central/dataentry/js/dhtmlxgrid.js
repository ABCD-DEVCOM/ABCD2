//v.1.6 build 80603

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
You allowed to use this component or parts of it under GPL terms
To use it on other terms or get Professional edition of the component please contact us at sales@dhtmlx.com
*/
/*_TOPICS_
@0:initialization
@1:selection control
@2:rows control
@3:colums control
@4:cells controll
@5:data manipulation
@6:appearence control
@7:overal control
@8:tools
@9:treegrid
@10: event handlers
@11: paginal output
*/

var globalActiveDHTMLGridObject;
String.prototype._dhx_trim=function(){
	return this.replace(/&nbsp;/g, " ").replace(/(^[ \t]*)|([ \t]*$)/g, "");
}

function dhtmlxArray(ar){
	return dhtmlXHeir((ar||new Array()), dhtmlxArray._master);
};
dhtmlxArray._master={
	_dhx_find:function(pattern){
		for (var i = 0; i < this.length; i++){
			if (pattern == this[i])
				return i;
		}
		return -1;
	},
	_dhx_insertAt:function(ind, value){
		this[this.length]=null;
		for (var i = this.length-1; i >= ind; i--)
			this[i]=this[i-1]
		this[ind]=value
	},
	_dhx_removeAt:function(ind){
			this.splice(ind,1)
	},
	_dhx_swapItems:function(ind1, ind2){
		var tmp = this[ind1];
		this[ind1]=this[ind2]
		this[ind2]=tmp;
	}
}

/**
*   @desc: dhtmlxGrid constructor
*   @param: id - (optional) id of div element to base grid on
*   @returns: dhtmlxGrid object
*   @type: public
*/
function dhtmlXGridObject(id){
	if (_isIE)
		try{
			document.execCommand("BackgroundImageCache", false, true);
		}
		catch (e){}

	if (id){
		if (typeof (id) == 'object'){
			this.entBox=id
			this.entBox.id="cgrid2_"+this.uid();
		} else
			this.entBox=document.getElementById(id);
	} else {
		this.entBox=document.createElement("DIV");
		this.entBox.id="cgrid2_"+this.uid();
	}

	this.dhx_Event();

	var self = this;

	this._wcorr=0;
	this.cell=null;
	this.row=null;
	this.editor=null;
	this._f2kE=true;
	this._dclE=true;
	this.combos=new Array(0);
	this.defVal=new Array(0);
	this.rowsAr={
	};

	this.rowsBuffer=dhtmlxArray();
	this.rowsCol=dhtmlxArray(); //array of rows by index

	this._data_cache={
	};

	this._ecache={
	}

	this._ud_enabled=true;
	this.xmlLoader=new dtmlXMLLoaderObject(this.doLoadDetails, this, true, this.no_cashe);

	this._maskArr=[];
	this.selectedRows=dhtmlxArray(); //selected rows array

	this.UserData={};//hash of row related userdata (and for grid - "gridglobaluserdata")

	/*MAIN OBJECTS*/

	this.entBox.className+=" gridbox";

	this.entBox.style.width=this.entBox.getAttribute("width")
		||(window.getComputedStyle
			? (this.entBox.style.width||window.getComputedStyle(this.entBox, null)["width"])
			: (this.entBox.currentStyle
				? this.entBox.currentStyle["width"]
				: this.entBox.style.width||0))
		||"100%";

	this.entBox.style.height=this.entBox.getAttribute("height")
		||(window.getComputedStyle
			? (this.entBox.style.height||window.getComputedStyle(this.entBox, null)["height"])
			: (this.entBox.currentStyle
				? this.entBox.currentStyle["height"]
				: this.entBox.style.height||0))
		||"100%";
	//cursor and text selection
	this.entBox.style.cursor='default';

	this.entBox.onselectstart=function(){
		return false
	}; //avoid text select
	this.obj=document.createElement("TABLE");
	this.obj.cellSpacing=0;
	this.obj.cellPadding=0;
	this.obj.style.width="100%"; //nb:
	this.obj.style.tableLayout="fixed";
	this.obj.className="c_obj".substr(2);

	this.hdr=document.createElement("TABLE");
	this.hdr.style.border="1px solid gray"; //FF 1.0 fix
	this.hdr.cellSpacing=0;
	this.hdr.cellPadding=0;

	if ((!_isOpera)||(_OperaRv >= 8.5))
		this.hdr.style.tableLayout="fixed";
	this.hdr.className="c_hdr".substr(2);
	this.hdr.width="100%";

	this.xHdr=document.createElement("TABLE");
	this.xHdr.className="xhdr";
	this.xHdr.cellPadding=0;
	this.xHdr.cellSpacing=0;
	this.xHdr.style.width='100%'
	var r = this.xHdr.insertRow(0)
	var c = r.insertCell(0);
	r.insertCell(1).innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	r.childNodes[1].style.width='100%';
	c.appendChild(this.hdr)
	this.objBuf=document.createElement("DIV");
	this.objBuf.appendChild(this.obj);
	this.entCnt=document.createElement("TABLE");
	this.entCnt.insertRow(0).insertCell(0)
	this.entCnt.insertRow(1).insertCell(0);

	this.entCnt.cellPadding=0;
	this.entCnt.cellSpacing=0;
	this.entCnt.width="100%";
	this.entCnt.height="100%";

	this.entCnt.style.tableLayout="fixed";

	this.objBox=document.createElement("DIV");
	this.objBox.style.width="100%";
	this.objBox.style.height=this.entBox.style.height;
	this.objBox.style.overflow="auto";
	this.objBox.style.position="relative";
	this.objBox.appendChild(this.objBuf);
	this.objBox.className="objbox";

	this.hdrBox=document.createElement("DIV");
	this.hdrBox.style.width="100%"

	if (((_isOpera)&&(_OperaRv < 9)))
		this.hdrSizeA=25;
	else
		this.hdrSizeA=200;

	this.hdrBox.style.height=this.hdrSizeA+"px";

	if (_isIE)
		this.hdrBox.style.overflowX="hidden";
	else
		this.hdrBox.style.overflow="hidden";

	this.hdrBox.style.position="relative";
	this.hdrBox.appendChild(this.xHdr);

	this.preloadImagesAr=new Array(0)

	this.sortImg=document.createElement("IMG")
	this.sortImg.style.display="none";
	this.hdrBox.insertBefore(this.sortImg, this.xHdr)
	this.entCnt.rows[0].cells[0].vAlign="top";
	this.entCnt.rows[0].cells[0].appendChild(this.hdrBox);
	this.entCnt.rows[1].cells[0].appendChild(this.objBox);

	this.entBox.appendChild(this.entCnt);
	//add links to current object
	this.entBox.grid=this;
	this.objBox.grid=this;
	this.hdrBox.grid=this;
	this.obj.grid=this;
	this.hdr.grid=this;
	/*PROPERTIES*/
	this.cellWidthPX=new Array(0);                      //current width in pixels
	this.cellWidthPC=new Array(0);                      //width in % if cellWidthType set in pc
	this.cellWidthType=this.entBox.cellwidthtype||"px"; //px or %

	this.delim=this.entBox.delimiter||",";
	this._csvDelim=",";

	this.hdrLabels=[];
	this.columnIds=[];
	this.columnColor=[];
	this.cellType=dhtmlxArray();
	this.cellAlign=[];
	this.initCellWidth=[];
	this.fldSort=[];
	this.imgURL="./";
	this.isActive=false; //fl to indicate if grid is in work now
	this.isEditable=true;
	this.useImagesInHeader=false; //use images in header or not
	this.pagingOn=false;          //paging on/off
	this.rowsBufferOutSize=0;     //number of rows rendered at a moment
	/*EVENTS*/
	dhtmlxEvent(window, "unload", function(){
		try{
			self.destructor();
		}
		catch (e){}
	});

	/*XML LOADER(S)*/
	/**
	*   @desc: set one of predefined css styles (xp, mt, gray, light, clear, modern)
	*   @param: name - style name
	*   @type: public
	*   @topic: 0,6
	*/
	this.setSkin=function(name){
		this.entBox.className="gridbox gridbox_"+name;
		this.enableAlterCss("ev_"+name, "odd_"+name, this.isTreeGrid())
		this._fixAlterCss()
		this._sizeFix=this._borderFix=0;

		switch (name){
			case "clear":
				this._topMb=document.createElement("DIV");
				this._topMb.className="topMumba";
				this._topMb.innerHTML="<img style='left:0px'   src='"+this.imgURL
					+"skinC_top_left.gif'><img style='right:0px' src='"+this.imgURL+"skinC_top_right.gif'>";
				this.entBox.appendChild(this._topMb);
				this._botMb=document.createElement("DIV");
				this._botMb.className="bottomMumba";
				this._botMb.innerHTML="<img style='left:0px'   src='"+this.imgURL
					+"skinD_bottom_left.gif'><img style='right:0px' src='"+this.imgURL+"skinD_bottom_right.gif'>";
				this.entBox.appendChild(this._botMb);
				this.entBox.style.position="relative";
				this._gcCorr=20;
				break;

			case "modern":
			case "light":
				this.forceDivInHeader=true;
				this._sizeFix=1;
				break;

			case "xp":
				this.forceDivInHeader=true;
				this._srdh=22;
				this._sizeFix=1;
				break;

			case "mt":
				this._srdh=22;
				this._sizeFix=1;
				this._borderFix=(_isIE ? 1 : 0);
				break;

			case "gray":
				if ((_isIE)&&(document.compatMode != "BackCompat"))
					this._srdh=22;
				this._sizeFix=1;
				this._borderFix=(_isIE ? 1 : 0);
				break;
			case "sbdark":
				if (_isFF) this._gcCorr=1;
				break;
		}

		if (_isIE&&this.hdr){
			var d = this.hdr.parentNode;
			d.removeChild(this.hdr);
			d.appendChild(this.hdr);
		}
		this.setSizes();
	}

	if (_isIE)
		this.preventIECaching(true);
	this.dragger=new dhtmlDragAndDropObject();

	/*METHODS. SERVICE*/
	/**
	*   @desc: on scroll grid inner actions
	*   @type: private
	*   @topic: 7
	*/
	this._doOnScroll=function(e, mode){
		this.callEvent("onScroll", [
			this.objBox.scrollLeft,
			this.objBox.scrollTop
		]);

		this.doOnScroll(e, mode);
	}
	/**
	*   @desc: on scroll grid more inner action
	*   @type: private
	*   @topic: 7
	*/
	this.doOnScroll=function(e, mode){
		this.hdrBox.scrollLeft=this.objBox.scrollLeft;

		if (this.ftr)
			this.ftr.parentNode.scrollLeft=this.objBox.scrollLeft;

		if (mode)
			return;

		if (this._srnd){
			if (this._dLoadTimer)
				window.clearTimeout(this._dLoadTimer);
			this._dLoadTimer=window.setTimeout(function(){
				self._update_srnd_view();
			}, 100);
		}
	}
	/**
	*    @desc: attach grid to some object in DOM
	*    @param: obj - object to attach to
	*   @type: public
	*   @topic: 0,7
	*/
	this.attachToObject=function(obj){
		obj.appendChild(this.entBox)
		this.objBox.style.height=this.entBox.style.height;
	}
	/**
	*   @desc: initialize grid
	*   @param: fl - if to parse on page xml data island 
	*   @type: public
	*   @topic: 0,7
	*/
	this.init=function(fl){
		if ((this.isTreeGrid())&&(!this._h2)){
			this._h2=new dhtmlxHierarchy();

			if ((this._fake)&&(!this._realfake))
				this._fake._h2=this._h2;
			this._tgc={
				imgURL: null
				};
		}

		if (!this._hstyles)
			return;

		this.editStop()
		/*TEMPORARY STATES*/
		this.lastClicked=null;                //row clicked without shift key. used in multiselect only
		this.resized=null;                    //hdr cell that is resized now
		this.fldSorted=this.r_fldSorted=null; //hdr cell last sorted
		this.gridWidth=0;
		this.gridHeight=0;
		//empty grid if it already was initialized
		this.cellWidthPX=new Array(0);
		this.cellWidthPC=new Array(0);

		if (this.hdr.rows.length > 0){
			this.clearAll(true);
		}

		var hdrRow = this.hdr.insertRow(0);

		for (var i = 0; i < this.hdrLabels.length; i++){
			hdrRow.appendChild(document.createElement("TH"));
			hdrRow.childNodes[i]._cellIndex=i;
			hdrRow.childNodes[i].style.height="0px";
		}

		if (_isIE)
			hdrRow.style.position="absolute";
		else
			hdrRow.style.height='auto';

		var hdrRow = this.hdr.insertRow(_isKHTML ? 2 : 1);

		hdrRow._childIndexes=new Array();
		var col_ex = 0;

		for (var i = 0; i < this.hdrLabels.length; i++){
			hdrRow._childIndexes[i]=i-col_ex;

			if ((this.hdrLabels[i] == this.splitSign)&&(i != 0)){
				if (_isKHTML)
					hdrRow.insertCell(i-col_ex);
				hdrRow.cells[i-col_ex-1].colSpan=(hdrRow.cells[i-col_ex-1].colSpan||1)+1;
				hdrRow.childNodes[i-col_ex-1]._cellIndex++;
				col_ex++;
				hdrRow._childIndexes[i]=i-col_ex;
				continue;
			}

			hdrRow.insertCell(i-col_ex);

			hdrRow.childNodes[i-col_ex]._cellIndex=i;
			hdrRow.childNodes[i-col_ex]._cellIndexS=i;
			this.setColumnLabel(i, this.hdrLabels[i]);
		}

		if (col_ex == 0)
			hdrRow._childIndexes=null;
		this._cCount=this.hdrLabels.length;

		if (_isIE)
			window.setTimeout(function(){
				self.setSizes();
			}, 1);

		//create virtual top row
		if (!this.obj.firstChild)
			this.obj.appendChild(document.createElement("TBODY"));

		var tar = this.obj.firstChild;

		if (!tar.firstChild){
			tar.appendChild(document.createElement("TR"));
			tar=tar.firstChild;

			if (_isIE)
				tar.style.position="absolute";
			else
				tar.style.height='auto';

			for (var i = 0; i < this.hdrLabels.length; i++){
				tar.appendChild(document.createElement("TH"));
				tar.childNodes[i].style.height="0px";
			}
		}

		this._c_order=null;

		if (this.multiLine != true)
			this.obj.className+=" row20px";

		//
		//this.combos = new Array(this.hdrLabels.length);
		//set sort image to initial state
		this.sortImg.style.position="absolute";
		this.sortImg.style.display="none";
		this.sortImg.src=this.imgURL+"sort_desc.gif";
		this.sortImg.defLeft=0;
		//create and kill a row to set initial size
		//this.addRow("deletethisrtowafterresize",new Array("",""))
		this.entCnt.rows[0].style.display='' //display header

		if (this.noHeader){
			this.entCnt.rows[0].style.display='none';
		}
		else {
			this.noHeader=false
		}

		

		this.attachHeader();
		this.attachHeader(0, 0, "_aFoot");
		this.setSizes();

		if (fl)
			this.parseXML()
		this.obj.scrollTop=0

		if (this.dragAndDropOff)
			this.dragger.addDragLanding(this.entBox, this);

		if (this._initDrF)
			this._initD();

		if (this._init_point)
			this._init_point();
	};
	/**
	*    @desc: sets sizes of grid elements
	*   @type: private
	*   @topic: 0,7
	*/
	this.setSizes=function(fl){
		if ((!this.hdr.rows[0]))
			return;

		if (!this.entBox.offsetWidth){
			if (this._sizeTime)
				window.clearTimeout(this._sizeTime);
			this._sizeTime=window.setTimeout(function(){
				self.setSizes()
			}, 250);
			return;
		}
		
		if (((_isFF)&&(this.entBox.style.height == "100%"))||(this._fixLater)){
			this.entBox.style.height=this.entBox.parentNode.clientHeight;
			this._fixLater=true;
		}

		if (fl&&this.gridWidth == this.entBox.offsetWidth&&this.gridHeight == this.entBox.offsetHeight){
			return false
		} else if (fl){
			this.gridWidth=this.entBox.offsetWidth
			this.gridHeight=this.entBox.offsetHeight
		}

		if ((!this.hdrBox.offsetHeight)&&(this.hdrBox.offsetHeight > 0))
			this.entCnt.rows[0].cells[0].height=this.hdrBox.offsetHeight+"px";

		var gridWidth = parseInt(this.entBox.offsetWidth)-(this._gcCorr||0);
		var gridHeight = parseInt(this.entBox.offsetHeight)-(this._sizeFix||0);

		var _isVSroll = (this.objBox.scrollHeight > this.objBox.offsetHeight);

		if (((!this._ahgr)&&(_isVSroll))||((this._ahgrM)&&(this._ahgrM < this.objBox.scrollHeight)))
			gridWidth-=(this._scrFix||(_isFF ? 17 : 17));

		var len = this.hdr.rows[0].cells.length
		//                var pcx_widht=(this._fake?(gridWidth-this._fake.entBox.offsetWidth):gridWidth);

		for (var i = 0; i < this._cCount; i++){
			if (this.cellWidthType == 'px'&&this.cellWidthPX.length < len){
				this.cellWidthPX[i]=this.initCellWidth[i]-this._wcorr;
			}
			else if (this.cellWidthType == '%'&&this.cellWidthPC.length < len){
				this.cellWidthPC[i]=this.initCellWidth[i];
			}

			if (this.cellWidthType == '%'&&this.cellWidthPC.length != 0&&this.cellWidthPC[i]){
				this.cellWidthPX[i]=parseInt(gridWidth*this.cellWidthPC[i] / 100);
			}
		}

		var wcor = this.entBox.offsetWidth-this.entBox.clientWidth;

		var summ = 0;
		var fcols = new Array();

		for (var i = 0; i < this._cCount; i++)
			if ((this.initCellWidth[i] == "*")&&((!this._hrrar)||(!this._hrrar[i])))
				fcols[fcols.length]=i;
			else
				summ+=parseInt(this.cellWidthPX[i]);

		if (fcols.length){
			var ms = Math.floor((gridWidth-summ-wcor) / fcols.length);

			if (ms < 0)
				ms=1;

			for (var i = 0; i < fcols.length; i++){
				var min = (this._drsclmW ? this._drsclmW[fcols[i]] : 0);
				this.cellWidthPX[fcols[i]]=(min ? (min > ms ? min : ms) : ms)-this._wcorr;
				summ+=ms;
			}
		}

		var summ = 0;

		for (var i = 0; i < this._cCount; i++)summ+=parseInt(this.cellWidthPX[i])

		if (_isOpera)
			summ-=1;

		this.chngCellWidth();

		if ((this._awdth)&&(this._awdth[0])){
			//convert percents to PX
			if (this.cellWidthType == '%'){
				this.cellWidthType="px";
				this.cellWidthPC=[];
			}
			var gs = (summ > this._awdth[1]
				? this._awdth[1]
				: (summ < this._awdth[2]
					? this._awdth[2]
					: summ))
				+this._borderFix*2;
				
				
		if (this._fake) 
			for (var i = 0; i < this._fake._cCount; i++) gs+=parseInt(this._fake.cellWidthPX[i])
			this.entBox.style.width=gs+((_isVSroll&&!this._ahgr) ? (_isFF ? 20 : 18) : 0)+"px";
		if (this._fake && !this._realfake) 
			this._fake._correctSplit();
		}

		this.objBuf.style.width=summ+"px";

		if ((this.ftr)&&(!this._realfake))
			this.ftr.style.width=summ+"px";

		this.objBuf.childNodes[0].style.width=summ+"px";
		//if (_isOpera) this.hdr.style.width = summ + this.cellWidthPX.length*2 + "px";
		//set auto page size of dyn scroll
		this.doOnScroll(0, 1);

		//set header part of container visible height to header's height
		//this.entCnt.rows[0].cells[0].style.height = this.hdr.offsetHeight;

		this.hdr.style.border="0px solid gray"; //FF 1.0 fix
		/*                         if ((_isMacOS)&&(_isFF))
											var zheight=20;
										 else*/
		var zheight = this.hdr.offsetHeight+(this._borderFix ? this._borderFix : 0);

		if (this.ftr)
			zheight+=this.ftr.offsetHeight;

		if (this._ahgr)
			if (this.objBox.scrollHeight){
				if (_isIE)
					var z2 = this.objBox.scrollHeight;
				else
					var z2 = this.objBox.childNodes[0].scrollHeight;
				var scrfix =
					this.parentGrid
						? 1
						: ((this.objBox.offsetWidth < this.objBox.scrollWidth)
							? (_isFF
								? 20
								: 18)
							: 1);

				if (this._ahgrMA)
					z2=this.entBox.parentNode.offsetHeight-zheight-scrfix-(this._sizeFix ? this._sizeFix : 0)*2;

				if (((this._ahgrM)&&((this._ahgrF ? (z2+zheight+scrfix) : z2) > this._ahgrM)))
					gridHeight=this._ahgrM*1+(this._ahgrF ? 0 : (zheight+scrfix));
				else
					gridHeight=z2+zheight+scrfix;

				this.entBox.style.height=gridHeight+"px";
			}

		if (this.ftr)
			zheight-=this.ftr.offsetHeight;

		var aRow = this.entCnt.rows[1].cells[0].childNodes[0];

		if (!this.noHeader)
			aRow.style.top=(zheight-this.hdrBox.offsetHeight+((_isIE&&!window.XMLHttpRequest) ? (-wcor) : 0))+"px";

		if (this._topMb){
			this._topMb.style.top=(zheight||0)+"px";
			this._topMb.style.width=(gridWidth+20)+"px";
		}

		if (this._botMb){
			this._botMb.style.top=(gridHeight-3)+"px";
			this._botMb.style.width=(gridWidth+20)+"px";
		}

		//nb 072006:
		aRow.style.height=(((gridHeight-zheight-1) < 0&&_isIE)
			? 20
			: (gridHeight-zheight-1))
			-(this.ftr
				? this.ftr.offsetHeight
				: 0)
			+"px";

		if (this.ftr&&this.entBox.offsetHeight > this.ftr.offsetHeight)
			this.entCnt.style.height=this.entBox.offsetHeight-this.ftr.offsetHeight+"px";

		if (this._srdh)
			this.doOnScroll();
	};

	/**
	*   @desc: changes cell width
	*   @param: [ind] - index of row in grid
	*   @type: private
	*   @topic: 4,7
	*/
	this.chngCellWidth=function(){
		if ((_isOpera)&&(this.ftr))
			this.ftr.width=this.objBox.scrollWidth+"px";
		var l = this._cCount;

		for (var i = 0; i < l; i++){
			this.hdr.rows[0].cells[i].style.width=this.cellWidthPX[i]+"px";
			this.obj.rows[0].childNodes[i].style.width=this.cellWidthPX[i]+"px";

			if (this.ftr)
				this.ftr.rows[0].cells[i].style.width=this.cellWidthPX[i]+"px";
		}
	}
	/**
	*   @desc: set delimiter character used in list values (default is ",")
	*   @param: delim - delimiter as string
	*   @before_init: 1
	*   @type: public
	*   @topic: 0
	*/
	this.setDelimiter=function(delim){
		this.delim=delim;
	}
	/**
	*   @desc: set width of columns in percents
	*   @type: public
	*   @before_init: 1
	*   @param: wp - list of column width in percents
	*   @topic: 0,7
	*/
	this.setInitWidthsP=function(wp){
		this.cellWidthType="%";
		this.initCellWidth=wp.split(this.delim.replace(/px/gi, ""));
		this._setAutoResize();
	}
	/**
	*	@desc:
	*	@type: private
	*	@topic: 0
	*/
	this._setAutoResize=function(){
		var el = window;
		var self = this;

		if (el.addEventListener){
			if ((_isFF)&&(_FFrv < 1.8))
				el.addEventListener("resize", function(){
					if (!self.entBox)
						return;

					var z = self.entBox.style.width;
					self.entBox.style.width="1px";

					window.setTimeout(function(){
						self.entBox.style.width=z;
						self.setSizes();

						if (self._fake)
							self._fake._correctSplit();
					}, 10);
				}, false);
			else
				el.addEventListener("resize", function(){
					if (self.setSizes)
						self.setSizes();

					if (self._fake)
						self._fake._correctSplit();
				}, false);
		}

		else if (el.attachEvent)
			el.attachEvent("onresize", function(){
				if (self._resize_timer)
					window.clearTimeout(self._resize_timer);

				if (self.setSizes)
					self._resize_timer=window.setTimeout(function(){
						self.setSizes();

						if (self._fake)
							self._fake._correctSplit();
					}, 500);
			});
		this._setAutoResize=function(){
		};
	}
	/**
	*   @desc: set width of columns in pixels
	*   @type: public
	*   @before_init: 1
	*   @param: wp - list of column width in pixels
	*   @topic: 0,7
	*/
	this.setInitWidths=function(wp){
		this.cellWidthType="px";
		this.initCellWidth=wp.split(this.delim);

		if (_isFF){
			for (var i = 0; i < this.initCellWidth.length; i++)
				if (this.initCellWidth[i] != "*")
					this.initCellWidth[i]=parseInt(this.initCellWidth[i])-2;
		}
	}

	/**
	*   @desc: set multiline rows support to enabled or disabled state
	*   @type: public
	*   @before_init: 1
	*   @param: state - true or false
	*   @topic: 0,7
	*/
	this.enableMultiline=function(state){
		this.multiLine=convertStringToBoolean(state);
	}

	/**
	*   @desc: set multiselect mode to enabled or disabled state
	*   @type: public
	*   @param: state - true or false
	*   @topic: 0,7
	*/
	this.enableMultiselect=function(state){
		this.selMultiRows=convertStringToBoolean(state);
	}

	/**
	*   @desc: set path to grid internal images (sort direction, any images used in editors, checkbox, radiobutton)
	*   @type: public
	*   @param: path - url (or relative path) of images folder with closing "/"
	*   @topic: 0,7
	*/
	this.setImagePath=function(path){
		this.imgURL=path;
	}

	/**
	*   @desc: part of column resize routine
	*   @type: private
	*   @param: ev - event
	*   @topic: 3
	*/
	this.changeCursorState=function(ev){
		var el = ev.target||ev.srcElement;

		if (el.tagName != "TD")
			el=this.getFirstParentOfType(el, "TD")

		if ((el.tagName == "TD")&&(this._drsclmn)&&(!this._drsclmn[el._cellIndex]))
			return el.style.cursor="default";
		var check = ev.layerX+(((!_isIE)&&(ev.target.tagName == "DIV")) ? el.offsetLeft : 0);

		if ((el.offsetWidth-(ev.offsetX||(parseInt(this.getPosition(el, this.hdrBox))-check)*-1)) < 10){
			el.style.cursor="E-resize";
		}
		else
			el.style.cursor="default";

		if (_isOpera)
			this.hdrBox.scrollLeft=this.objBox.scrollLeft;
	}
	/**
	*   @desc: part of column resize routine
	*   @type: private
	*   @param: ev - event
	*   @topic: 3
	*/
	this.startColResize=function(ev){
		this.resized=null;
		var el = ev.target||ev.srcElement;

		if (el.tagName != "TD")
			el=this.getFirstParentOfType(el, "TD")
		var x = ev.clientX;
		var tabW = this.hdr.offsetWidth;
		var startW = parseInt(el.offsetWidth)

		if (el.tagName == "TD"&&el.style.cursor != "default"){
			if ((this._drsclmn)&&(!this._drsclmn[el._cellIndex]))
				return;
			this.entBox.onmousemove=function(e){
				this.grid.doColResize(e||window.event, el, startW, x, tabW)
			}
			document.body.onmouseup=new Function("",
				"document.getElementById('"+this.entBox.id+"').grid.stopColResize()");
		}
	}
	/**
	*   @desc: part of column resize routine
	*   @type: private
	*   @param: ev - event
	*   @topic: 3
	*/
	this.stopColResize=function(){
		this.entBox.onmousemove=""; //removeEventListener("mousemove")//
		document.body.onmouseup="";
		this.setSizes();
		this.doOnScroll(0, 1)
		this.callEvent("onResizeEnd", [this]);
	}
	/**
	*   @desc: part of column resize routine
	*   @param: el - element (column resizing)
	*   @param: startW - started width
	*   @param: x - x coordinate to resize from
	*   @param: tabW - started width of header table
	*   @type: private
	*   @topic: 3
	*/
	this.doColResize=function(ev, el, startW, x, tabW){
		el.style.cursor="E-resize";
		this.resized=el;
		var fcolW = startW+(ev.clientX-x);
		var wtabW = tabW+(ev.clientX-x)

		if (!(this.callEvent("onResize", [
			el._cellIndex,
			fcolW,
			this
		])))
			return;

		if (_isIE)
			this.objBox.scrollLeft=this.hdrBox.scrollLeft;

		if (el.colSpan > 1){
			var a_sizes = new Array();

			for (var i = 0;
				i < el.colSpan;
				i++)a_sizes[i]=Math.round(fcolW*this.hdr.rows[0].childNodes[el._cellIndexS+i].offsetWidth/el.offsetWidth);

			for (var i = 0; i < el.colSpan; i++)
				this._setColumnSizeR(el._cellIndexS+i*1, a_sizes[i]);
		} else
			this._setColumnSizeR(el._cellIndex, fcolW);
		this.doOnScroll(0, 1);

		if (_isOpera)
			this.setSizes();
		this.objBuf.childNodes[0].style.width="";
	}

	/**
	*   @desc: set width of grid columns ( zero row of header and body )
	*   @type: private
	*   @topic: 7
	*/
	this._setColumnSizeR=function(ind, fcolW){
		if (fcolW > ((this._drsclmW&&!this._notresize) ? (this._drsclmW[ind]||10) : 10)){
			this.obj.firstChild.firstChild.childNodes[ind].style.width=fcolW+"px";
			this.hdr.rows[0].childNodes[ind].style.width=fcolW+"px";

			if (this.ftr)
				this.ftr.rows[0].childNodes[ind].style.width=fcolW+"px";

			if (this.cellWidthType == 'px'){
				this.cellWidthPX[ind]=fcolW;
			}
			else {
				var gridWidth = parseInt(this.entBox.offsetWidth);

				if (this.objBox.scrollHeight > this.objBox.offsetHeight)
					gridWidth-=(this._scrFix||(_isFF ? 17 : 17));
				var pcWidth = Math.round(fcolW / gridWidth*100)
				this.cellWidthPC[ind]=pcWidth;
			}
		}
	}
	/**
	*    @desc: sets position and visibility of sort arrow
	*    @param: state - true/false - show/hide image
	*    @param: ind - index of field
	*    @param: order - asc/desc - type of image
	*    @param: row - one based index of header row ( used in multirow headers, top row by default )
	*   @type: public
	*   @topic: 7
	*/
	this.setSortImgState=function(state, ind, order, row){
		order=(order||"asc").toLowerCase();

		if (!convertStringToBoolean(state)){
			this.sortImg.style.display="none";
			this.fldSorted=null;
			return;
		}

		if (order == "asc")
			this.sortImg.src=this.imgURL+"sort_asc.gif";
		else
			this.sortImg.src=this.imgURL+"sort_desc.gif";
		this.sortImg.style.display="";
		this.fldSorted=this.hdr.rows[0].childNodes[ind];
		var r = this.hdr.rows[row||1];

		for (var i = 0; i < r.childNodes.length; i++)
			if (r.childNodes[i]._cellIndex == ind)
				this.r_fldSorted=r.childNodes[i];
		this.setSortImgPos();
	}

	/**
	*    @desc: sets position and visibility of sort arrow
	*    @param: ind - index of field
	*    @param: ind - index of field
	*    @param: hRowInd - index of row in case of complex header, one-based, optional

	*   @type: private
	*   @topic: 7
	*/
	this.setSortImgPos=function(ind, mode, hRowInd, el){
		if (!el){
			if (!ind)
				var el = this.r_fldSorted;
			else
				var el = this.hdr.rows[hRowInd||0].cells[ind];
		}

		if (el != null){
			var pos = this.getPosition(el, this.hdrBox)
			var wdth = el.offsetWidth;
			this.sortImg.style.left=Number(pos[0]+wdth-13)+"px"; //Number(pos[0]+5)+"px";
			this.sortImg.defLeft=parseInt(this.sortImg.style.left)
			this.sortImg.style.top=Number(pos[1]+5)+"px";

			if ((!this.useImagesInHeader)&&(!mode))
				this.sortImg.style.display="inline";
			this.sortImg.style.left=this.sortImg.defLeft+"px"; //-parseInt(this.hdrBox.scrollLeft)
		}
	}

	/**
	*   @desc: manage activity of the grid.
	*   @param: fl - true to activate,false to deactivate
	*   @type: private
	*   @topic: 1,7
	*/
	this.setActive=function(fl){
		if (arguments.length == 0)
			var fl = true;

		if (fl == true){
			//document.body.onkeydown = new Function("","document.getElementById('"+this.entBox.id+"').grid.doKey()")//
			if (globalActiveDHTMLGridObject&&(globalActiveDHTMLGridObject != this))
				globalActiveDHTMLGridObject.editStop();

			globalActiveDHTMLGridObject=this;
			this.isActive=true;
		} else {
			this.isActive=false;
		}
	};
	/**
	*     @desc: called on click occured
	*     @type: private
	*/
	this._doClick=function(ev){
		var selMethod = 0;
		var el = this.getFirstParentOfType(_isIE ? ev.srcElement : ev.target, "TD");
		var fl = true;

		//mm
		//markers start
		if (this.markedCells){
			var markMethod = 0;

			if (ev.shiftKey||ev.metaKey){
				markMethod=1;
			}

			if (ev.ctrlKey){
				markMethod=2;
			}
			this.doMark(el, markMethod);
			return true;
		}
		//markers end
		//mm

		if (this.selMultiRows != false){
			if (ev.shiftKey&&this.row != null){
				selMethod=1;
			}

			if (ev.ctrlKey||ev.metaKey){
				selMethod=2;
			}
		}
		this.doClick(el, fl, selMethod)
	};


	/**
	*   @desc: called onmousedown inside grid area
	*   @type: private
	*/
	this._doContClick=function(ev){
		var el = this.getFirstParentOfType(_isIE ? ev.srcElement : ev.target, "TD");

		if ((!el)||( typeof (el.parentNode.idd) == "undefined"))
			return true;

		if (ev.button == 2||(_isMacOS&&ev.ctrlKey)){
			if (!this.callEvent("onRightClick", [
				el.parentNode.idd,
				el._cellIndex,
				ev
			])){
				var z = function(e){
					document.body.oncontextmenu=Function("return true;");
					(e||event).cancelBubble=true;
					return false;
				}

				if (_isIE)
					ev.srcElement.oncontextmenu=z;

				else if (!_isMacOS)
					document.body.oncontextmenu=z;

				return false;
			}

			if (this._ctmndx){
				if (!(this.callEvent("onBeforeContextMenu", [
					el.parentNode.idd,
					el._cellIndex,
					this
				])))
					return true;
				el.contextMenuId=el.parentNode.idd+"_"+el._cellIndex;
				el.contextMenu=this._ctmndx;
				el.a=this._ctmndx._contextStart;

				if (_isIE)
					ev.srcElement.oncontextmenu=function(){
						event.cancelBubble=true;
						return false;
					};
				el.a(el, ev);
				el.a=null;
			}
		}

		else if (this._ctmndx)
			this._ctmndx._contextEnd();
		return true;
	}

	/**
	*    @desc: occures on cell click (supports treegrid)
	*   @param: [el] - cell to click on
	*   @param:   [fl] - true if to call onRowSelect function
	*   @param: [selMethod] - 0 - simple click, 1 - shift, 2 - ctrl
	*   @param: show - true/false - scroll row to view, true by defaul    
	*   @type: private
	*   @topic: 1,2,4,9
	*/
	this.doClick=function(el, fl, selMethod, show){

		var psid = this.row ? this.row.idd : 0;

		this.setActive(true);

		if (!selMethod)
			selMethod=0;

		if (this.cell != null)
			this.cell.className=this.cell.className.replace(/cellselected/g, "");

		if (el.tagName == "TD"){
			if (this.checkEvent("onSelectStateChanged"))
				var initial = this.getSelectedId();
			var prow = this.row;

		if (selMethod == 1){
				var elRowIndex = this.rowsCol._dhx_find(el.parentNode)
				var lcRowIndex = this.rowsCol._dhx_find(this.lastClicked)

				if (elRowIndex > lcRowIndex){
					var strt = lcRowIndex;
					var end = elRowIndex;
				} else {
					var strt = elRowIndex;
					var end = lcRowIndex;
				}

				for (var i = 0; i < this.rowsCol.length; i++)
					if ((i >= strt&&i <= end)){
						if (this.rowsCol[i]&&(!this.rowsCol[i]._sRow)){
							if (this.rowsCol[i].className.indexOf("rowselected")
								== -1&&this.callEvent("onBeforeSelect", [
								this.rowsCol[i].idd,
								psid
							])){
								this.rowsCol[i].className+=" rowselected";
								this.selectedRows[this.selectedRows.length]=this.rowsCol[i]
							}
						} else {
							this.clearSelection();
							return this.doClick(el, fl, 0, show);
						}
					}
			} else if (selMethod == 2){
				if (el.parentNode.className.indexOf("rowselected") != -1){
					el.parentNode.className=el.parentNode.className.replace(/rowselected/g, "");
					this.selectedRows._dhx_removeAt(this.selectedRows._dhx_find(el.parentNode))
					var skipRowSelection = true;
				}
			}
			this.editStop()
			if (typeof (el.parentNode.idd) == "undefined")
				return true;

			if ((!skipRowSelection)&&(!el.parentNode._sRow)){
				if (this.callEvent("onBeforeSelect", [
					el.parentNode.idd,
					psid
				])){
					if (selMethod == 0)
						this.clearSelection();
					this.cell=el;
					if ((prow == el.parentNode)&&(this._chRRS))
						fl=false;
					this.row=el.parentNode;
					this.row.className+=" rowselected"

					if (this.selectedRows._dhx_find(this.row) == -1)
						this.selectedRows[this.selectedRows.length]=this.row;
				} 
			}

			if (this.cell && this.cell.parentNode.className.indexOf("rowselected") != -1)
				this.cell.className=this.cell.className.replace(/cellselected/g, "")+" cellselected";
			
			if (selMethod != 1)
				if (!this.row)
					return;
			this.lastClicked=el.parentNode;

			var rid = this.row.idd;
			var cid = this.cell._cellIndex;

			if (fl&& typeof (rid) != "undefined")
				self.onRowSelectTime=setTimeout(function(){
					self.callEvent("onRowSelect", [
						rid,
						cid
					]);
				}, 100)

			if (this.checkEvent("onSelectStateChanged")){
				var afinal = this.getSelectedId();

				if (initial != afinal)
					this.callEvent("onSelectStateChanged", [afinal]);
			}
		}
		this.isActive=true;

		if (show !== false && this.cell && this.cell.parentNode.id)
			this.moveToVisible(this.cell)
	}

	/**
	*   @desc: select all rows in grid, it doesn't fire any events
	*   @param: edit - switch selected cell to edit mode
	*   @type: public
	*   @topic: 1,4
	*/
	this.selectAll=function(){
		this.clearSelection();
		this.selectedRows=dhtmlxArray([].concat(this.rowsCol));

		for (var i = this.rowsCol.length-1; i >= 0; i--){
			if (this.rowsCol[i]._cntr)
				this.selectedRows.splice(i, 1);
			else
				this.rowsCol[i].className+=" rowselected";
		}

		if (this.selectedRows.length){
			this.row=this.selectedRows[0];
			this.cell=this.row.cells[0];
		}

		if ((this._fake)&&(!this._realfake))
			this._fake.selectAll();
	}
	/**
	*   @desc: set selection to specified row-cell
	*   @param: r - row object or row index
	*   @param: cInd - cell index
	*   @param: [fl] - true if to call onRowSelect function
	  *   @param: preserve - preserve previously selected rows true/false (false by default)
	  *   @param: edit - switch selected cell to edit mode
	*   @param: show - true/false - scroll row to view, true by defaul         
	*   @type: public
	*   @topic: 1,4
	*/
	this.selectCell=function(r, cInd, fl, preserve, edit, show){
		if (!fl)
			fl=false;

		if (typeof (r) != "object")
			r=this.rowsCol[r]
		if (!r) return null;

		
			var c = r.childNodes[cInd];

		if (!c)
			c=r.childNodes[0];

		if (preserve)
			this.doClick(c, fl, 3, show)
		else
			this.doClick(c, fl, 0, show)

		if (edit)
			this.editCell();
	}
	/**
	*   @desc: moves specified cell to visible area (scrolls)
	*   @param: cell_obj - object of the cell to work with
	*   @param: onlyVScroll - allow only vertical positioning

	*   @type: private
	*   @topic: 2,4,7
	*/
	this.moveToVisible=function(cell_obj, onlyVScroll){
		if (!cell_obj.offsetHeight){
			//row is in not rendered part of the grid
			var h=this.rowsBuffer._dhx_find(cell_obj.parentNode)*this._srdh;
			return this.objBox.scrollTop=h;
		}
		try{
			var distance = cell_obj.offsetLeft+cell_obj.offsetWidth+20;

			var scrollLeft = 0;

			if (distance > (this.objBox.offsetWidth+this.objBox.scrollLeft)){
				if (cell_obj.offsetLeft > this.objBox.scrollLeft)
					scrollLeft=cell_obj.offsetLeft-5
			} else if (cell_obj.offsetLeft < this.objBox.scrollLeft){
				distance-=cell_obj.offsetWidth*2/3;
				if (distance < this.objBox.scrollLeft)
					scrollLeft=cell_obj.offsetLeft-5
			}

			if ((scrollLeft)&&(!onlyVScroll))
				this.objBox.scrollLeft=scrollLeft;

			var distance = cell_obj.offsetTop+cell_obj.offsetHeight+20;

			if (distance > (this.objBox.offsetHeight+this.objBox.scrollTop)){
				var scrollTop = distance-this.objBox.offsetHeight;
			} else if (cell_obj.offsetTop < this.objBox.scrollTop){
				var scrollTop = cell_obj.offsetTop-5
			}

			if (scrollTop)
				this.objBox.scrollTop=scrollTop;
		}
		catch (er){}
	}
	/**
	*   @desc: creates Editor object and switch cell to edit mode if allowed
	*   @type: public
	*   @topic: 4
	*/
	this.editCell=function(){
		if (this.editor&&this.cell == this.editor.cell)
			return; //prevent reinit for same cell

		this.editStop();

		if ((this.isEditable != true)||(!this.cell))
			return false;
		var c = this.cell;

		//#locked_row:11052006{
		if (c.parentNode._locked)
			return false;
		//#}

		this.editor=this.cells4(c);

		//initialize editor
		if (this.editor != null){
			if (this.editor.isDisabled()){
				this.editor=null;
				return false;
			}

			if (this.callEvent("onEditCell", [
				0,
				this.row.idd,
				this.cell._cellIndex
			]) != false&&this.editor.edit){
				this._Opera_stop=(new Date).valueOf();
				c.className+=" editable";
				this.editor.edit();
				this.callEvent("onEditCell", [
					1,
					this.row.idd,
					this.cell._cellIndex
				])
			} else { //preserve editing
				this.editor=null;
			}
		}
	}
	/**
	*   @desc: retuns value from editor(if presents) to cell and closes editor
	*   @mode: if true - current edit value will be reverted to previous one
	*   @type: public
	*   @topic: 4
	*/
	this.editStop=function(mode){
		if (_isOpera)
			if (this._Opera_stop){
				if ((this._Opera_stop*1+50) > (new Date).valueOf())
					return;

				this._Opera_stop=null;
			}

		if (this.editor&&this.editor != null){
			this.editor.cell.className=this.editor.cell.className.replace("editable", "");

			if (mode){
				var t = this.editor.val;
				this.editor.detach();
				this.editor.setValue(t);
				this.editor=null;
				return;
			}

			if (this.editor.detach())
				this.cell.wasChanged=true;

			var g = this.editor;
			this.editor=null;
			var z = this.callEvent("onEditCell", [
				2,
				this.row.idd,
				this.cell._cellIndex,
				g.getValue(),
				g.val
			]);

			if (( typeof (z) == "string")||( typeof (z) == "number"))
				g[g.setImage ? "setLabel" : "setValue"](z);

			else if (!z)
				g[g.setImage ? "setLabel" : "setValue"](g.val);
		}
	}
	/**
	*	@desc: 
	*	@type: private
	*/
	this._nextRowCell=function(row, dir, pos){
		row=this._nextRow(this.rowsCol._dhx_find(row), dir);

		if (!row)
			return null;

		return row.childNodes[row._childIndexes ? row._childIndexes[pos] : pos];
	}
	/**
	*	@desc: 
	*	@type: private
	*/
	this._getNextCell=function(acell, dir, i){

		acell=acell||this.cell;

		var arow = acell.parentNode;

		if (this._tabOrder){
			i=this._tabOrder[acell._cellIndex];

			if (typeof i != "undefined")
				if (i < 0)
					acell=this._nextRowCell(arow, dir, Math.abs(i)-1);
				else
					acell=arow.childNodes[i];
		} else {
			var i = acell._cellIndex+dir;

			if (i >= 0&&i < this._cCount){
				if (arow._childIndexes)
					i=arow._childIndexes[acell._cellIndex]+dir;
				acell=arow.childNodes[i];
			} else {

				acell=this._nextRowCell(arow, dir, (dir == 1 ? 0 : (this._cCount-1)));
			}
		}

		if (!acell){
			if ((dir == 1)&&this.tabEnd){
				this.tabEnd.focus();
				this.tabEnd.focus();
			}

			if ((dir == -1)&&this.tabStart){
				this.tabStart.focus();
				this.tabStart.focus();
			}
			return null;
		}

		//tab out

		// tab readonly
		if (acell.style.display != "none"
			&&(!this.smartTabOrder||!this.cells(acell.parentNode.idd, acell._cellIndex).isDisabled()))
			return acell;
		return this._getNextCell(acell, dir);
	// tab readonly

	}
	/**
	*	@desc: 
	*	@type: private
	*/
	this._nextRow=function(ind, dir){
		var r = this.rowsCol[ind+dir];

		if (r&&r.style.display == "none")
			return this._nextRow(ind+dir, dir);

		return r;
	}
	/**
	*	@desc: 
	*	@type: private
	*/
	this.scrollPage=function(dir){
		var new_ind = Math.floor((this.getRowIndex(this.row.idd)||0)+(dir)*this.objBox.offsetHeight / (this._srdh||20));

		if (new_ind < 0)
			new_ind=0;

		if (this._srnd && !this.rowsCol[new_ind])
			this.objBox.scrollTop+=this.objBox.offsetHeight*dir;
		else {
			if (new_ind >= this.rowsCol.length)
				new_ind=this.rowsCol.length-1;
			this.selectCell(new_ind, this.cell._cellIndex, true);
		}
	}

	/**
	*   @desc: manages keybord activity in grid
	*   @type: private
	*   @topic: 7
	*/
	this.doKey=function(ev){
		if (!ev)
			return true;

		if ((ev.target||ev.srcElement).value !== window.undefined){
			var zx = (ev.target||ev.srcElement);

			if ((!zx.parentNode)||(zx.parentNode.className.indexOf("editable") == -1))
				return true;
		}

		if ((globalActiveDHTMLGridObject)&&(this != globalActiveDHTMLGridObject))
			return globalActiveDHTMLGridObject.doKey(ev);

		if (this.isActive == false){
			//document.body.onkeydown = "";
			return true;
		}

		if (this._htkebl)
			return true;

		if (!this.callEvent("onKeyPress", [
			ev.keyCode,
			ev.ctrlKey,
			ev.shiftKey,
			ev
		]))
			return false;

		var code = "k"+ev.keyCode+"_"+(ev.ctrlKey ? 1 : 0)+"_"+(ev.shiftKey ? 1 : 0);

		if (this.cell){ //if selection exists in grid only
			if (this._key_events[code]){
				if (false === this._key_events[code].call(this))
					return true;

				if (ev.preventDefault)
					ev.preventDefault();
				ev.cancelBubble=true;
				return false;
			}

			if (this._key_events["k_other"])
				this._key_events.k_other.call(this, ev);
		}

		return true;
	}
	/**
	*   @desc: selects row (?)for comtatibility with previous version
	*   @param: cell - cell object(or cell's child)
	*   @invoke: click on cell(or cell content)
	*   @type: private
	*   @topic: 1,2
	*/
	this.getRow=function(cell){
		if (!cell)
			cell=window.event.srcElement;

		if (cell.tagName != 'TD')
			cell=cell.parentElement;
		r=cell.parentElement;

		if (this.cellType[cell._cellIndex] == 'lk')
			eval(this.onLink+"('"+this.getRowId(r.rowIndex)+"',"+cell._cellIndex+")");
		this.selectCell(r, cell._cellIndex, true)
	}
	/**
	*   @desc: selects row (and first cell of it)
	*   @param: r - row index or row object
	*   @param: fl - if true, then call function on select
	 *   @param: preserve - preserve previously selected rows true/false (false by default)
	 *   @param: show - true/false - scroll row to view, true by defaul    
	*   @type: public
	*   @topic: 1,2
	*/
	this.selectRow=function(r, fl, preserve, show){
		if (typeof (r) != 'object')
			r=this.rowsCol[r]
		this.selectCell(r, 0, fl, preserve, false, show)
	};

	/**
	*   @desc: called when row was double clicked
	*   @type: private
	*   @topic: 1,2
	*/
	this.wasDblClicked=function(ev){
		var el = this.getFirstParentOfType(_isIE ? ev.srcElement : ev.target, "TD");

		if (el){
			var rowId = el.parentNode.idd;
			return this.callEvent("onRowDblClicked", [
				rowId,
				el._cellIndex
			]);
		}
	}

	/**
	*   @desc: called when header was clicked
	*   @type: private
	*   @topic: 1,2
	*/
	this._onHeaderClick=function(e, el){
		var that = this.grid;
		el=el||that.getFirstParentOfType(_isIE ? event.srcElement : e.target, "TD");

		if (this.grid.resized == null){
			if (!(this.grid.callEvent("onHeaderClick", [
				el._cellIndexS,
				(e||window.event)
			])))
				return false;
			that.sortField(el._cellIndexS, false, el)
		}
	}

	/**
	*   @desc: deletes selected row(s)
	*   @type: public
	*   @topic: 2
	*/
	this.deleteSelectedRows=function(){
		var num = this.selectedRows.length //this.obj.rows.length

		if (num == 0)
			return;

		var tmpAr = this.selectedRows;
		this.selectedRows=dhtmlxArray()
		for (var i = num-1; i >= 0; i--){
			var node = tmpAr[i]

			if (!this.deleteRow(node.idd, node)){
				this.selectedRows[this.selectedRows.length]=node;
			}
			else {
				if (node == this.row){
					var ind = i;
				}
			}
/*
						   this.rowsAr[node.idd] = null;
						   var posInCol = this.rowsCol._dhx_find(node)
						   this.rowsCol[posInCol].parentNode.removeChild(this.rowsCol[posInCol]);//nb:this.rowsCol[posInCol].removeNode(true);
						   this.rowsCol._dhx_removeAt(posInCol)*/
		}

		if (ind){
			try{
				if (ind+1 > this.rowsCol.length) //this.obj.rows.length)
					ind--;
				this.selectCell(ind, 0, true)
			}
			catch (er){
				this.row=null
				this.cell=null
			}
		}
	}

	/**
	*   @desc: gets selected row id
	*   @returns: id of selected row (list of ids with default delimiter) or null if non row selected
	*   @type: public
	*   @topic: 1,2,9
	*/
	this.getSelectedRowId=function(){
		var selAr = new Array(0);
		var uni = {
		};

		for (var i = 0; i < this.selectedRows.length; i++){
			var id = this.selectedRows[i].idd;

			if (uni[id])
				continue;

			selAr[selAr.length]=id;
			uni[id]=true;
		}

		//..
		if (selAr.length == 0)
			return null;
		else
			return selAr.join(this.delim);
	}
	
	/**
	*   @desc: gets index of selected cell
	*   @returns: index of selected cell or -1 if there is no selected sell
	*   @type: public
	*   @topic: 1,4
	*/
	this.getSelectedCellIndex=function(){
		if (this.cell != null)
			return this.cell._cellIndex;
		else
			return -1;
	}
	/**
	*   @desc: gets width of specified column in pixels
	*   @param: ind - column index
	*   @returns: column width in pixels
	*   @type: public
	*   @topic: 3,7
	*/
	this.getColWidth=function(ind){
		return parseInt(this.cellWidthPX[ind])+((_isFF) ? 2 : 0);
	}

	/**
	*   @desc: sets width of specified column in pixels (soen't works with procent based grid)
	*   @param: ind - column index
	*   @param: value - new width value
	*   @type: public
	*   @topic: 3,7
	*/
	this.setColWidth=function(ind, value){
		if (this.cellWidthType == 'px')
			this.cellWidthPX[ind]=parseInt(value)-+((_isFF) ? 2 : 0);
		else
			this.cellWidthPC[ind]=parseInt(value);
		this.setSizes();
	}
	/**
	*   @desc: gets row index by id (grid only)
	*   @param: row_id - row id
	*   @returns: row index or -1 if there is no row with specified id
	*   @type: public
	*   @topic: 2
	*/
	this.getRowIndex=function(row_id){
		for (var i = 0; i < this.rowsBuffer.length; i++)
			if (this.rowsBuffer[i]&&this.rowsBuffer[i].idd == row_id)
				return i;
	}
	/**
	*   @desc: gets row id by index
	*   @param: ind - row index
	*   @returns: row id or null if there is no row with specified index
	*   @type: public
	*   @topic: 2
	*/
	this.getRowId=function(ind){
		return this.rowsBuffer[ind] ? this.rowsBuffer[ind].idd : this.undefined;
	}
	/**
	*   @desc: sets new id for row by its index
	*   @param: ind - row index
	*   @param: row_id - new row id
	*   @type: public
	*   @topic: 2
	*/
	this.setRowId=function(ind, row_id){
		var r = this.rowsCol[ind]
		this.changeRowId(r.idd, row_id)
	}
	/**
	*   @desc: changes id of the row to the new one
	*   @param: oldRowId - row id to change
	*   @param: newRowId - row id to set
	*   @type:public
	*   @topic: 2
	*/
	this.changeRowId=function(oldRowId, newRowId){
		if (oldRowId == newRowId)
			return;
		/*
						  for (var i=0; i<row.childNodes.length; i++)
							  if (row.childNodes[i]._code)
								  this._compileSCL("-",row.childNodes[i]);      */
		var row = this.rowsAr[oldRowId]
		row.idd=newRowId;

		if (this.UserData[oldRowId]){
			this.UserData[newRowId]=this.UserData[oldRowId]
			this.UserData[oldRowId]=null;
		}

		if (this._h2&&this._h2.get[oldRowId]){
			this._h2.get[newRowId]=this._h2.get[oldRowId];
			this._h2.get[newRowId].id=newRowId;
			delete this._h2.get[oldRowId];
		}

		this.rowsAr[oldRowId]=null;
		this.rowsAr[newRowId]=row;

		for (var i = 0; i < row.childNodes.length; i++)
			if (row.childNodes[i]._code)
				row.childNodes[i]._code=this._compileSCL(row.childNodes[i]._val, row.childNodes[i]);
	}
	/**
	*   @desc: sets ids to every column. Can be used then to retreive the index of the desired colum
	*   @param: [ids] - delimitered list of ids (default delimiter is ","), or empty if to use values set earlier
	*   @type: public
	*   @topic: 3
	*/
	this.setColumnIds=function(ids){
		this.columnIds=ids.split(this.delim)
	}
	/**
	*   @desc: sets ids to specified column.
	*   @param: ind- index of column
	*   @param: id- id of column
	*   @type: public
	*   @topic: 3
	*/
	this.setColumnId=function(ind, id){
		this.columnIds[ind]=id;
	}
	/**
	*   @desc: gets column index by column id
	*   @param: id - column id
	*   @returns: index of the column
	*   @type: public
	*   @topic: 3
	*/
	this.getColIndexById=function(id){
		for (var i = 0; i < this.columnIds.length; i++)
			if (this.columnIds[i] == id)
				return i;
	}
	/**
	*   @desc: gets column id of column specified by index
	*   @param: cin - column index
	*   @returns: column id
	*   @type: public
	*   @topic: 3
	*/
	this.getColumnId=function(cin){
		return this.columnIds[cin];
	}
	
	/**
	*   @desc: gets label of column specified by index
	*   @param: cin - column index
	*   @returns: column label
	*   @type: public
	*   @topic: 3
	*/
	this.getColumnLabel=function(cin, ind){
		var z = this.hdr.rows[(ind||0)+1];
		var n = z.cells[z._childIndexes ? z._childIndexes[parseInt(cin)] : cin];
		return(_isIE ? n.innerText : n.textContent);
	}
	

	/**
	*   @desc: sets row text BOLD
	*   @param: row_id - row id
	*   @type: public
	*   @topic: 2,6
	*/
	this.setRowTextBold=function(row_id){
		var r=this.getRowById(row_id)
		if (r) r.style.fontWeight="bold";
	}
	/**
	*   @desc: sets style to row
	*   @param: row_id - row id
	*   @param: styleString - style string in common format (exmpl: "color:red;border:1px solid gray;")
	*   @type: public
	*   @topic: 2,6
	*/
	this.setRowTextStyle=function(row_id, styleString){
		var r = this.getRowById(row_id)
		if (!r) return;
		for (var i = 0; i < r.childNodes.length; i++){
			var pfix = "";

			
			if (_isIE)
				r.childNodes[i].style.cssText=pfix+"width:"+r.childNodes[i].style.width+";"+styleString;
			else
				r.childNodes[i].style.cssText=pfix+"width:"+r.childNodes[i].style.width+";"+styleString;
		}
	}
	/**
	*   @desc: sets background color of row (via bgcolor attribute)
	*   @param: row_id - row id
	*   @param: color - color value
	*   @type: public
	*   @topic: 2,6
	*/
	this.setRowColor=function(row_id, color){
		var r = this.getRowById(row_id)

		for (var i = 0; i < r.childNodes.length; i++)r.childNodes[i].bgColor=color;
	}
	/**
	*   @desc: sets style to cell
	*   @param: row_id - row id
	*   @param: ind - cell index
	*   @param: styleString - style string in common format (exmpl: "color:red;border:1px solid gray;")
	*   @type: public
	*   @topic: 2,6
	*/
	this.setCellTextStyle=function(row_id, ind, styleString){
		var r = this.getRowById(row_id)

		if (!r)
			return;

		var cell = r.childNodes[r._childIndexes ? r._childIndexes[ind] : ind];

		if (!cell)
			return;
		var pfix = "";

		
		if (_isIE)
			cell.style.cssText=pfix+"width:"+cell.style.width+";"+styleString;
		else
			cell.style.cssText=pfix+"width:"+cell.style.width+";"+styleString;
	}

	/**
	*   @desc: sets row text weight to normal
	*   @param: row_id - row id
	*   @type: public
	*   @topic: 2,6
	*/
	this.setRowTextNormal=function(row_id){
		var r=this.getRowById(row_id);
		if (r) r.style.fontWeight="normal";
	}
	/**
	*   @desc: determines if row with specified id exists
	*   @param: row_id - row id
	*   @returns: true if exists, false otherwise
	*   @type: public
	*   @topic: 2,7
	*/
	this.doesRowExist=function(row_id){
		if (this.getRowById(row_id) != null)
			return true
		else
			return false
	}
	


	/**
	*   @desc: gets number of columns in grid
	*   @returns: number of columns in grid
	*   @type: public
	*   @topic: 3,7
	*/
	this.getColumnsNum=function(){
		return this._cCount;
	}
	
	

	/**
	*   @desc: moves row one position up if possible
	*   @param: row_id -  row id
	*   @type: public
	*   @topic: 2
	*/
	this.moveRowUp=function(row_id){
		var r = this.getRowById(row_id)

		if (this.isTreeGrid())
			return this.moveRowUDTG(row_id, -1);

		var rInd = this.rowsCol._dhx_find(r)
		if ((r.previousSibling)&&(rInd != 0)){
			r.parentNode.insertBefore(r, r.previousSibling)
			this.rowsCol._dhx_swapItems(rInd, rInd-1)
			this.setSizes();
			var bInd=this.rowsBuffer._dhx_find(r);
			this.rowsBuffer._dhx_swapItems(bInd,bInd-1);

			if (this._cssEven)
				this._fixAlterCss(rInd-1);
		}
	}
	/**
	*   @desc: moves row one position down if possible
	*   @param: row_id -  row id
	*   @type: public
	*   @topic: 2
	*/
	this.moveRowDown=function(row_id){
		var r = this.getRowById(row_id)

		if (this.isTreeGrid())
			return this.moveRowUDTG(row_id, 1);

		var rInd = this.rowsCol._dhx_find(r);
		if (r.nextSibling){ 
			this.rowsCol._dhx_swapItems(rInd, rInd+1)

			if (r.nextSibling.nextSibling)
				r.parentNode.insertBefore(r, r.nextSibling.nextSibling)
			else
				r.parentNode.appendChild(r)
			this.setSizes();
			
			var bInd=this.rowsBuffer._dhx_find(r);
			this.rowsBuffer._dhx_swapItems(bInd,bInd+1);

			if (this._cssEven)
				this._fixAlterCss(rInd);
		}
	}
	/**
	* @desc: gets Combo object of specified column. Use it to change select box value for cell before editor opened
	*   @type: public
	*   @topic: 3,4
	*   @param: col_ind - index of the column to get combo object for
	*/
	this.getCombo=function(col_ind){
		if (!this.combos[col_ind]){
			this.combos[col_ind]=new dhtmlXGridComboObject();
		}
		return this.combos[col_ind];
	}
	/**
	*   @desc: sets user data to row
	*   @param: row_id -  row id. if empty then user data is set for grid (not row)
	*   @param: name -  name of user data block
	*   @param: value -  value of user data block
	*   @type: public
	*   @topic: 2,5
	*/
	this.setUserData=function(row_id, name, value){
		try{
			if (row_id == "")
				row_id="gridglobaluserdata";

			if (!this.UserData[row_id])
				this.UserData[row_id]=new Hashtable()
			this.UserData[row_id].put(name, value)
		}
		catch (er){
			alert("UserData Error:"+er.description)
		}
	}
	/**
	*   @desc: gets user Data
	*   @param: row_id -  row id. if empty then user data is for grid (not row)
	*   @param: name -  name of user data
	*   @returns: value of user data
	*   @type: public
	*   @topic: 2,5
	*/
	this.getUserData=function(row_id, name){
		this.getRowById(row_id); //parse row if necessary

		if (row_id == "")
			row_id="gridglobaluserdata";
		var z = this.UserData[row_id];
		return(z ? z.get(name) : "");
	}

	/**
	*   @desc: manage editibility of the grid
	*   @param: [fl] - set not editable if FALSE, set editable otherwise
	*   @type: public
	*   @topic: 7
	*/
	this.setEditable=function(fl){
		this.isEditable=convertStringToBoolean(fl);
	}
	/**
	*   @desc: selects row by ID
	*   @param: row_id - row id
	*   @param: multiFL - VOID. select multiple rows
	*   @param: show - true/false - scroll row to view, true by defaul    
	*   @param: call - true to call function on select
	*   @type: public
	*   @topic: 1,2
	*/
	this.selectRowById=function(row_id, multiFL, show, call){
		if (!call)
			call=false;
		this.selectCell(this.getRowById(row_id), 0, call, multiFL, false, show);
	}
	
	/**
	*   @desc: removes selection from the grid
	*   @type: public
	*   @topic: 1,9
	*/
	this.clearSelection=function(){
		this.editStop()

		for (var i = 0; i < this.selectedRows.length; i++){
			var r = this.rowsAr[this.selectedRows[i].idd];

			if (r)
				r.className=r.className.replace(/rowselected/g, "");
		}

		//..
		this.selectedRows=dhtmlxArray()
		this.row=null;

		if (this.cell != null){
			this.cell.className=this.cell.className.replace(/cellselected/g, "");
			this.cell=null;
		}
	}
	/**
	*   @desc: copies row content to another existing row
	*   @param: from_row_id - id of the row to copy content from
	*   @param: to_row_id - id of the row to copy content to
	*   @type: public
	*   @topic: 2,5
	*/
	this.copyRowContent=function(from_row_id, to_row_id){
		var frRow = this.getRowById(from_row_id)

		if (!this.isTreeGrid())
			for (var i = 0; i < frRow.cells.length; i++){
				this.cells(to_row_id, i).setValue(this.cells(from_row_id, i).getValue())
			}
		else
			this._copyTreeGridRowContent(frRow, from_row_id, to_row_id);

		//for Mozilla (to avaoid visual glitches)
		if (!_isIE)
			this.getRowById(from_row_id).cells[0].height=frRow.cells[0].offsetHeight
	}
	/**
	*   @desc: sets new column header label
	*   @param: col - header column index
	*   @param: label - new label for the cpecified header's column. Can contai img:[imageUrl]Text Label
	*	@param: ind - header row index (default is 0)
	*   @type: public
	*   @topic: 3,6
	*/
	this.setColumnLabel=function(c, label, ind){
		var z = this.hdr.rows[ind||1];
		var col = (z._childIndexes ? z._childIndexes[c] : c);

		if (!this.useImagesInHeader){
			var hdrHTML = "<div class='hdrcell'>"

			if (label.indexOf('img:[') != -1){
				var imUrl = label.replace(/.*\[([^>]+)\].*/, "$1");
				label=label.substr(label.indexOf("]")+1, label.length)
				hdrHTML+="<img width='18px' height='18px' align='absmiddle' src='"+imUrl+"' hspace='2'>"
			}
			hdrHTML+=label;
			hdrHTML+="</div>";
			z.cells[col].innerHTML=hdrHTML;

			if (this._hstyles[col])
				z.cells[col].style.cssText=this._hstyles[col];
		} else { //if images in header header
			z.cells[col].style.textAlign="left";
			z.cells[col].innerHTML="<img src='"+this.imgURL+""+label+"' onerror='this.src = \""+this.imgURL
				+"imageloaderror.gif\"'>";
			//preload sorting headers (asc/desc)
			var a = new Image();
			a.src=this.imgURL+""+label.replace(/(\.[a-z]+)/, ".desc$1");
			this.preloadImagesAr[this.preloadImagesAr.length]=a;
			var b = new Image();
			b.src=this.imgURL+""+label.replace(/(\.[a-z]+)/, ".asc$1");
			this.preloadImagesAr[this.preloadImagesAr.length]=b;
		}

		if ((label||"").indexOf("#") != -1){
			var t = label.match(/(^|{)#([^}]+)(}|$)/);

			if (t){
				var tn = "_in_header_"+t[2];

				if (this[tn])
					this[tn]((this.forceDivInHeader ? z.cells[col].firstChild : z.cells[col]), col, label.split(t[0]));
			}
		}
	}
	/**
	*   @desc: deletes all rows in grid
	*   @param: header - (boolean) enable/disable cleaning header
	*   @type: public
	*   @topic: 5,7,9
	*/
	this.clearAll=function(header){
		if (this._h2){
			this._h2=new dhtmlxHierarchy();

			if (this._fake){
				if (this._realfake)
					this._h2=this._fake._h2;
				else
					this._fake._h2=this._h2;
			}
		}

		this.limit=this._limitC=0;
		this.editStop(true);

		if (this._dLoadTimer)
			window.clearTimeout(this._dLoadTimer);

		if (this._dload){
			this.objBox.scrollTop=0;
			this.limit=this._limitC||0;
			this._initDrF=true;
		}

		var len = this.rowsCol.length;

		//for some case
		len=this.obj.rows.length;

		for (var i = len-1; i > 0; i--){
			var t_r = this.obj.rows[i];
			t_r.parentNode.removeChild(t_r);
		}

		if (header&&this.obj.rows[0]){
			this._master_row=null;
			this.obj.rows[0].parentNode.removeChild(this.obj.rows[0]);

			for (var i = this.hdr.rows.length-1; i >= 0; i--){
				var t_r = this.hdr.rows[i];
				t_r.parentNode.removeChild(t_r);
			}

			if (this.ftr){
				this.ftr.parentNode.removeChild(this.ftr);
				this.ftr=null;
			}
			this._aHead=this.ftr=this._aFoot=null;
			this._hrrar=[];
			this.columnIds=[];
		}

		//..
		this.row=null;
		this.cell=null;

		this.rowsCol=dhtmlxArray()
		this.rowsAr=[]; //array of rows by idd
		this.rowsBuffer=dhtmlxArray()
		this.UserData=[]
		this.selectedRows=dhtmlxArray();

		if (this.pagingOn || this._srnd)
			this.xmlFileUrl="";
		if (this.pagingOn)
			this.changePage(1);
		
		//  if (!this._fake){
		/*
		   if ((this._hideShowColumn)&&(this.hdr.rows[0]))
			  for (var i=0; i<this.hdr.rows[0].cells.length; i++)
				  this._hideShowColumn(i,"");
	   this._hrrar=new Array();*/
		//}
		if (this._contextCallTimer)
			window.clearTimeout(this._contextCallTimer);

		if (this._sst)
			this.enableStableSorting(true);
		this._fillers=this.undefined;
		this.setSortImgState(false);
		this.setSizes();
		//this.obj.scrollTop = 0;

		this.callEvent("onClearAll", []);
	}


	/**
	*   @desc: sorts grid by specified field
	*    @invoke: header click
	*   @param: [ind] - index of the field
	*   @param: [repeatFl] - if to repeat last sorting
	*   @type: private
	*   @topic: 3
	*/
	this.sortField=function(ind, repeatFl, r_el){
		if (this.getRowsNum() == 0)
			return false;

		var el = this.hdr.rows[0].cells[ind];

		if (!el)
			return; //somehow
		// if (this._dload  && !this.callEvent("onBeforeSorting",[ind,this]) ) return true;

		if (el.tagName == "TH"&&(this.fldSort.length-1) >= el._cellIndex
			&&this.fldSort[el._cellIndex] != 'na'){ //this.entBox.fieldstosort!="" &&
			if ((((this.sortImg.src.indexOf("_desc.gif") == -1)&&(!repeatFl))
				||((this.sortImg.style.filter != "")&&(repeatFl)))
				&&(this.fldSorted == el))
				var sortType = "des";
			else
				var sortType = "asc";

			if (!this.callEvent("onBeforeSorting", [
				ind,
				this.fldSort[ind],
				sortType
			]))
				return;
			this.sortImg.src=this.imgURL+"sort_"+(sortType == "asc" ? "asc" : "desc")+".gif";

			//for header images
			if (this.useImagesInHeader){
				var cel = this.hdr.rows[1].cells[el._cellIndex].firstChild;

				if (this.fldSorted != null){
					var celT = this.hdr.rows[1].cells[this.fldSorted._cellIndex].firstChild;
					celT.src=celT.src.replace(/\.[ascde]+\./, ".");
				}
				cel.src=cel.src.replace(/(\.[a-z]+)/, "."+sortType+"$1")
			}
			//.
			this.sortRows(el._cellIndex, this.fldSort[el._cellIndex], sortType)
			this.fldSorted=el;
			this.r_fldSorted=r_el;
			var c = this.hdr.rows[1];
			var c = r_el.parentNode;
			var real_el = c._childIndexes ? c._childIndexes[el._cellIndex] : el._cellIndex;
			this.setSortImgPos(false, false, false, r_el);
			this.callEvent("onAfterSorting", [ind,this.fldSort[ind],sortType]);
		}
	}

	

	/**
	*   @desc: specify if values passed to Header are images file names
	*   @param: fl - true to treat column header values as image names
	*   @type: public
	*   @before_init: 1
	*   @topic: 0,3
	*/
	this.enableHeaderImages=function(fl){
		this.useImagesInHeader=fl;
	}

	/**
	*   @desc: set header label and default params for new headers
	*   @param: hdrStr - header string with delimiters
	*   @param: splitSign - string used as a split marker, optional. Default is "#cspan"
	*   @param: styles - array of header styles
	*   @type: public
	*   @before_init: 1
	*   @topic: 0,3
	*/
	this.setHeader=function(hdrStr, splitSign, styles){
		if (typeof (hdrStr) != "object")
			var arLab = this._eSplit(hdrStr);
		else
			arLab=[].concat(hdrStr);

		var arWdth = new Array(0);
		var arTyp = new dhtmlxArray(0);
		var arAlg = new Array(0);
		var arVAlg = new Array(0);
		var arSrt = new Array(0);

		for (var i = 0; i < arLab.length; i++){
			arWdth[arWdth.length]=Math.round(100 / arLab.length);
			arTyp[arTyp.length]="ed";
			arAlg[arAlg.length]="left";
			arVAlg[arVAlg.length]=""; //top
			arSrt[arSrt.length]="na";
		}

		this.splitSign=splitSign||"#cspan";
		this.hdrLabels=arLab;
		this.cellWidth=arWdth;
		this.cellType=arTyp;
		this.cellAlign=arAlg;
		this.cellVAlign=arVAlg;
		this.fldSort=arSrt;
		this._hstyles=styles||[];
	}
	/**
   *   @desc: 
   *   @param: str - ...
   *   @type: private
   */
	this._eSplit=function(str){
		if (![].push)
			return str.split(this.delim);

		var a = "r"+(new Date()).valueOf();
		var z = this.delim.replace(/([\|\+\*\^])/g, "\\$1")
		return(str||"").replace(RegExp(z, "g"), a).replace(RegExp("\\\\"+a, "g"), this.delim).split(a);
	}

	/**
	*   @desc: get column type by column index
	*   @param: cInd - column index
	*   @returns:  type code
	*   @type: public
	*   @topic: 0,3,4
	*/
	this.getColType=function(cInd){
		return this.cellType[cInd];
	}

	/**
	*   @desc: get column type by column ID
	*   @param: cID - column id
	*   @returns:  type code
	*   @type: public
	*   @topic: 0,3,4
	*/
	this.getColTypeById=function(cID){
		return this.cellType[this.getColIndexById(cID)];
	}

	/**
	*   @desc: set column types
	*   @param: typeStr - type codes list (default delimiter is ",")
	*   @before_init: 2
	*   @type: public
	*   @topic: 0,3,4
	*/
	this.setColTypes=function(typeStr){
		this.cellType=dhtmlxArray(typeStr.split(this.delim));
		this._strangeParams=new Array();

		for (var i = 0; i < this.cellType.length; i++)
			if ((this.cellType[i].indexOf("[") != -1)){
				var z = this.cellType[i].split(/[\[\]]+/g);
				this.cellType[i]=z[0];
				this.defVal[i]=z[1];

				if (z[1].indexOf("=") == 0){
					this.cellType[i]="math";
					this._strangeParams[i]=z[0];
				}
			}
	}
	/**
	*   @desc: set column sort types (avaialble: str, int, date, na or function object for custom sorting)
	*   @param: sortStr - sort codes list with default delimiter
	*   @before_init: 1
	*   @type: public
	*   @topic: 0,3,4
	*/
	this.setColSorting=function(sortStr){
		this.fldSort=sortStr.split(this.delim)

		
	}
	/**
	*   @desc: set align of values in columns
	*   @param: alStr - list of align values (possible values are: right,left,center,justify). Default delimiter is ","
	*   @before_init: 1
	*   @type: public
	*   @topic: 0,3
	*/
	this.setColAlign=function(alStr){
		this.cellAlign=alStr.split(this.delim)
	}
/**
*   @desc: set vertical align of columns
*   @param: valStr - vertical align values list for columns (possible values are: baseline,sub,super,top,text-top,middle,bottom,text-bottom)
*   @before_init: 1
*   @type: public
*   @topic: 0,3
*/
	this.setColVAlign=function(valStr){
		this.cellVAlign=valStr.split(this.delim)
	}

/**
* 	@desc: create grid with no header. Call before initialization, but after setHeader. setHeader have to be called in any way as it defines number of columns
*   @param: fl - true to use no header in the grid
*   @type: public
*   @before_init: 1
*   @topic: 0,7
*/
	this.setNoHeader=function(fl){
			this.noHeader=convertStringToBoolean(fl);
	}
	/**
	*   @desc: scrolls row to the visible area
	*   @param: rowID - row id
	*   @type: public
	*   @topic: 2,7
	*/
	this.showRow=function(rowID){
		this.getRowById(rowID)

		if (this.pagingOn)
			this.changePage(Math.floor(this.getRowIndex(rowID) / this.rowsBufferOutSize)+1);
		if (this._h2) this.openItem(this._h2.get[rowID].parent.id);
		var c = this.getRowById(rowID).cells[0];

		while (c&&c.style.display == "none")
			c=c.nextSibling;

		if (c)
			this.moveToVisible(c, true)
	}

	/**
	*   @desc: modify default style of grid and its elements. Call before or after Init
	*   @param: ss_header - style def. expression for header
	*   @param: ss_grid - style def. expression for grid cells
	*   @param: ss_selCell - style def. expression for selected cell
	*   @param: ss_selRow - style def. expression for selected Row
	*   @type: public
	*   @before_init: 2
	*   @topic: 0,6
	*/
	this.setStyle=function(ss_header, ss_grid, ss_selCell, ss_selRow){
		this.ssModifier=[
			ss_header,
			ss_grid,
			ss_selCell,
			ss_selCell,
			ss_selRow
		];

		var prefs = ["#"+this.entBox.id+" table.hdr td", "#"+this.entBox.id+" table.obj td",
			"#"+this.entBox.id+" table.obj tr.rowselected td.cellselected",
			"#"+this.entBox.id+" table.obj td.cellselected", "#"+this.entBox.id+" table.obj tr.rowselected td"];

		for (var i = 0; i < prefs.length; i++)
			if (this.ssModifier[i]){
				if (_isIE)
					document.styleSheets[0].addRule(prefs[i], this.ssModifier[i]);
				else
					document.styleSheets[0].insertRule(prefs[i]+" { "+this.ssModifier[i]+" } ", 0);
			}
	}
	/**
	*   @desc: colorize columns  background.
	*   @param: clr - colors list
	*   @type: public
	*   @before_init: 1
	*   @topic: 3,6
	*/
	this.setColumnColor=function(clr){
		this.columnColor=clr.split(this.delim)
	}

	/**
	*   @desc: set even/odd css styles
	*   @param: cssE - name of css class for even rows
	*   @param: cssU - name of css class for odd rows
	*   @param: perLevel - true/false - mark rows not by order, but by level in treegrid
	*   @param: levelUnique - true/false - creates additional unique css class based on row level
	*   @type: public
	*   @before_init: 1
	*   @topic: 3,6
	*/
	this.enableAlterCss=function(cssE, cssU, perLevel, levelUnique){
		if (cssE||cssU)
			this.attachEvent("onGridReconstructed",function(){
				if (!this._cssSP){
					this._fixAlterCss();
					if (this._fake)
						this._fake._fixAlterCss();
				}
			});

		this._cssSP=perLevel;
		this._cssSU=levelUnique;
		this._cssEven=cssE;
		this._cssUnEven=cssU;
	}

	/**
	*   @desc: recolor grid from defined point
	*   @type: private
	*   @before_init: 1
	*   @topic: 3,6
	*/
	this._fixAlterCss=function(ind){
		if (this._cssSP&&this._h2)
			return this._fixAlterCssTGR(ind);
		if (!this._cssEven && !this._cssUnEven) return;
		ind=ind||0;
		var j = ind;

		for (var i = ind; i < this.rowsCol.length; i++){
			if (!this.rowsCol[i])
				continue;

			if (this.rowsCol[i].style.display != "none"){
				if (this.rowsCol[i].className.indexOf("rowselected") != -1){
					if (j%2 == 1)
						this.rowsCol[i].className=this._cssUnEven+" rowselected"+(this.rowsCol[i]._css||"");
					else
						this.rowsCol[i].className=this._cssEven+" rowselected"+(this.rowsCol[i]._css||"");
				} else {
					if (j%2 == 1)
						this.rowsCol[i].className=this._cssUnEven+(this.rowsCol[i]._css||"");
					else
						this.rowsCol[i].className=this._cssEven+(this.rowsCol[i]._css||"");
				}
				j++;
			}
		}
	}

	


	/**
	*    @desc: returns absolute left and top position of specified element
	*    @returns: array of two values: absolute Left and absolute Top positions
	*    @param: oNode - element to get position of
	*   @type: private
	*   @topic: 8
	*/
	this.getPosition=function(oNode, pNode){
		if (!pNode)
			var pNode = document.body

		var oCurrentNode = oNode;
		var iLeft = 0;
		var iTop = 0;

		while ((oCurrentNode)&&(oCurrentNode != pNode)){ //.tagName!="BODY"){
			iLeft+=oCurrentNode.offsetLeft-oCurrentNode.scrollLeft;
			iTop+=oCurrentNode.offsetTop-oCurrentNode.scrollTop;
			oCurrentNode=oCurrentNode.offsetParent; //isIE()?:oCurrentNode.parentNode;
		}

		if (pNode == document.body){
			if (_isIE){
				if (document.documentElement.scrollTop)
					iTop+=document.documentElement.scrollTop;

				if (document.documentElement.scrollLeft)
					iLeft+=document.documentElement.scrollLeft;
			} else if (!_isFF){
				iLeft+=document.body.offsetLeft;
				iTop+=document.body.offsetTop;
			}
		}
		return new Array(iLeft, iTop);
	}
	/**
	*   @desc: gets nearest parent of specified type
	*   @param: obj - input object
	*   @param: tag - string. tag to find as parent
	*   @returns: object. nearest paraent object (including spec. obj) of specified type.
	*   @type: private
	*   @topic: 8
	*/
	this.getFirstParentOfType=function(obj, tag){
		while (obj&&obj.tagName != tag&&obj.tagName != "BODY"){
			obj=obj.parentNode;
		}
		return obj;
	}



	/*INTERNAL EVENT HANDLERS*/
	this.objBox.onscroll=function(){
		this.grid._doOnScroll();
	};

	if ((!_isOpera)||(_OperaRv > 8.5)){
		this.hdr.onmousemove=function(e){
			this.grid.changeCursorState(e||window.event);
		};
		this.hdr.onmousedown=function(e){
			return this.grid.startColResize(e||window.event);
		};		
	}
	this.obj.onmousemove=this._drawTooltip;
	this.obj.onclick=function(e){
		this.grid._doClick(e||window.event);
		if (this.grid._sclE) 
			this.grid.editCell(e||window.event); 
		(e||event).cancelBubble=true;
	};

	if (_isMacOS)
		this.entBox.oncontextmenu=function(e){
			return this.grid._doContClick(e||window.event);
		};
	
	this.entBox.onmousedown=function(e){
		return this.grid._doContClick(e||window.event);
	};
	this.obj.ondblclick=function(e){
		if (!this.grid.wasDblClicked(e||window.event)) 
			return false; 
		if (this.grid._dclE) 
			this.grid.editCell(e||window.event);  
		(e||event).cancelBubble=true;
	}
	this.hdr.onclick=this._onHeaderClick;
	this.sortImg.onclick=function(){
		self._onHeaderClick.apply({
			grid: self
			}, [
			null,
			self.r_fldSorted
		]);
	};

	this.hdr.ondblclick=this._onHeaderDblClick;


	if (!document.body._dhtmlxgrid_onkeydown){
		dhtmlxEvent(document, "keydown",function(e){
			if (globalActiveDHTMLGridObject) 
				return globalActiveDHTMLGridObject.doKey(e||window.event);
		});
		document.body._dhtmlxgrid_onkeydown=true;
	}

	dhtmlxEvent(document.body, "click", function(){
		if (self.editStop)
			self.editStop();
	});

	//activity management
	this.entBox.onbeforeactivate=function(){
		this._still_active=null;
		this.grid.setActive();
		event.cancelBubble=true;
	};
	
	this.entBox.onbeforedeactivate=function(){
		if (this.grid._still_active) 
			this.grid._still_active=null; 
		else 
			this.grid.isActive=false; 
		event.cancelBubble=true;
	};
	
	if (this.entBox.style.height.toString().indexOf("%") != -1)
		this._setAutoResize();
		
	/* deprecated names */
	this.setColHidden=this.setColumnsVisibility
	this.enableCollSpan = this.enableColSpan
	this.setMultiselect=this.enableMultiselect;
	this.setMultiLine=this.enableMultiline;
	this.deleteSelectedItem=this.deleteSelectedRows;
	this.getSelectedId=this.getSelectedRowId;
	this.getHeaderCol=this.getColumnLabel;
	this.isItemExists=this.doesRowExist;
	this.getColumnCount=this.getColumnsNum;
	this.setSelectedRow=this.selectRowById;
	this.setHeaderCol=this.setColumnLabel;
	this.preventIECashing=this.preventIECaching;
	this.enableAutoHeigth=this.enableAutoHeight;
	this.getUID=this.uid;
		
	return this;
}

dhtmlXGridObject.prototype={
	getRowAttribute: function(id, name){
		return this.getRowById(id)._attrs[name];
	},
	setRowAttribute: function(id, name, value){
		this.getRowById(id)._attrs[name]=value;
	},
	/**
	*   @desc: detect is current grid is a treeGrid
	*   @type: private
	*   @topic: 2
	*/
	isTreeGrid:function(){
		return(this.cellType._dhx_find("tree") != -1);
	},
	
	
	/**
	*   @desc: hide/show row (warning! - this command doesn't affect row indexes, only visual appearance)
	*   @param: ind - column index
	*   @param: state - true/false - hide/show row
	*   @type:  public
	*/
	setRowHidden:function(id, state){
		var f = convertStringToBoolean(state);
		//var ind=this.getRowIndex(id);
		//if (id<0)
		//   return;
		var row = this.getRowById(id) //this.rowsCol[ind];
	
		if (!row)
			return;
	
		if (row.expand === "")
			this.collapseKids(row);
	
		if ((state)&&(row.style.display != "none")){
			row.style.display="none";
			var z = this.selectedRows._dhx_find(row);
	
			if (z != -1){
				row.className=row.className.replace("rowselected", "");
	
				for (var i = 0;
					i < row.childNodes.length;
					i++)row.childNodes[i].className=row.childNodes[i].className.replace(/cellselected/g, "");
				this.selectedRows._dhx_removeAt(z);
			}
			this.callEvent("onGridReconstructed", []);
		}
	
		if ((!state)&&(row.style.display == "none")){
			row.style.display="";
			this.callEvent("onGridReconstructed", []);
		}
		this.setSizes();
	},
	
	
	/**
	*   @desc: enable/disable hovering row on mouse over
	*   @param: mode - true/false
	*   @param: cssClass - css class for hovering row
	*   @type:  public
	*/
	enableRowsHover:function(mode, cssClass){
		this._hvrCss=cssClass;
	
		if (convertStringToBoolean(mode)){
			if (!this._elmnh){
				this.obj._honmousemove=this.obj.onmousemove;
				this.obj.onmousemove=this._setRowHover;
	
				if (_isIE)
					this.obj.onmouseleave=this._unsetRowHover;
				else
					this.obj.onmouseout=this._unsetRowHover;
	
				this._elmnh=true;
			}
		} else {
			if (this._elmnh){
				this.obj.onmousemove=this.obj._honmousemove;
	
				if (_isIE)
					this.obj.onmouseleave=null;
				else
					this.obj.onmouseout=null;
	
				this._elmnh=false;
			}
		}
	},
	
	/**
	*   @desc: enable/disable events which fire excell editing, mutual exclusive with enableLightMouseNavigation
	*   @param: click - true/false - enable/disable editing by single click
	*   @param: dblclick - true/false - enable/disable editing by double click
	*   @param: f2Key - enable/disable editing by pressing F2 key
	*   @type:  public
	*/
	enableEditEvents:function(click, dblclick, f2Key){
		this._sclE=convertStringToBoolean(click);
		this._dclE=convertStringToBoolean(dblclick);
		this._f2kE=convertStringToBoolean(f2Key);
	},
	
	
	/**
	*   @desc: enable/disable light mouse navigation mode (row selection with mouse over, editing with single click), mutual exclusive with enableEditEvents
	*   @param: mode - true/false
	*   @type:  public
	*/
	enableLightMouseNavigation:function(mode){
		if (convertStringToBoolean(mode)){
			if (!this._elmn){
				this.entBox._onclick=this.entBox.onclick;
				this.entBox.onclick=function(){
					return true;
				};
	
				this.obj._onclick=this.obj.onclick;
				this.obj.onclick=function(e){
					var c = this.grid.getFirstParentOfType(e ? e.target : event.srcElement, 'TD');
					this.grid.editStop();
					this.grid.doClick(c);
					this.grid.editCell();
					(e||event).cancelBubble=true;
				}
	
				this.obj._onmousemove=this.obj.onmousemove;
				this.obj.onmousemove=this._autoMoveSelect;
				this._elmn=true;
			}
		} else {
			if (this._elmn){
				this.entBox.onclick=this.entBox._onclick;
				this.obj.onclick=this.obj._onclick;
				this.obj.onmousemove=this.obj._onmousemove;
				this._elmn=false;
			}
		}
	},
	
	
	/**
	*   @desc: remove hover state on row
	*   @type:  private
	*/
	_unsetRowHover:function(e, c){
		if (c)
			that=this;
		else
			that=this.grid;
	
		if ((that._lahRw)&&(that._lahRw != c)){
			for (var i = 0;
				i < that._lahRw.childNodes.length;
				i++)that._lahRw.childNodes[i].className=that._lahRw.childNodes[i].className.replace(that._hvrCss, "");
			that._lahRw=null;
		}
	},
	
	/**
	*   @desc: set hover state on row
	*   @type:  private
	*/
	_setRowHover:function(e){
		var c = this.grid.getFirstParentOfType(e ? e.target : event.srcElement, 'TD');
	
		if (c && c.parentNode!=this.grid._lahRw) {
			this.grid._unsetRowHover(0, c);
			c=c.parentNode;
	
			for (var i = 0; i < c.childNodes.length; i++)c.childNodes[i].className+=" "+this.grid._hvrCss;
			this.grid._lahRw=c;
		}
		this._honmousemove(e);
	},
	
	/**
	*   @desc: onmousemove, used in light mouse navigaion mode
	*   @type:  private
	*/
	_autoMoveSelect:function(e){
		//this - grid.obj
		if (!this.grid.editor){
			var c = this.grid.getFirstParentOfType(e ? e.target : event.srcElement, 'TD');
	
			if (c.parentNode.idd)
				this.grid.doClick(c, true, 0);
		}
		this._onmousemove(e);
	},
	
	
	/**
		*     @desc: destructor, removes grid and cleans used memory
		*     @type: public
	  *     @topic: 0
		*/
	destructor:function(){
		if (this._sizeTime)
			this._sizeTime=window.clearTimeout(this._sizeTime);
	
		if (this.formInputs)
			for (var i = 0; i < this.formInputs.length; i++)this.parentForm.removeChild(this.formInputs[i]);
	
		var a;
		this.xmlLoader=this.xmlLoader.destructor();
	
		for (var i = 0; i < this.rowsCol.length; i++)
			if (this.rowsCol[i])
				this.rowsCol[i].grid=null;
	
		for (i in this.rowsAr)
			if (this.rowsAr[i])
				this.rowsAr[i]=null;
	
		this.rowsCol=new dhtmlxArray();
		this.rowsAr=new Array();
		this.entBox.innerHTML="";
		this.entBox.onclick=function(){
		};
	
		this.entBox.onmousedown=function(){
		};
	
		this.entBox.onbeforeactivate=function(){
		};
	
		this.entBox.onbeforedeactivate=function(){
		};
	
		this.entBox.onbeforedeactivate=function(){
		};
	
		this.entBox.onselectstart=function(){
		};
	
		this.entBox.grid=null;
	
		for (a in this){
			if ((this[a])&&(this[a].m_obj))
				this[a].m_obj=null;
			this[a]=null;
		}
	
		if (this == globalActiveDHTMLGridObject)
			globalActiveDHTMLGridObject=null;
		//   self=null;
		return null;
	},
	
	
	/**
	*     @desc: get sorting state of grid
	*     @type: public
	*     @returns: array, first element is index of sortef column, second - direction of sorting ("asc" or "des").
	*     @topic: 0
	*/
	getSortingState:function(){
		var z = new Array();
	
		if (this.fldSorted){
			z[0]=this.fldSorted._cellIndex;
			z[1]=(this.sortImg.src.indexOf("sort_desc.gif") != -1) ? "des" : "asc";
		}
		return z;
	},
	
	/**
	*     @desc: enable autoheight of grid
	*     @param: mode - true/false
	*     @param: maxHeight - maximum height before scrolling appears (no limit by default)
	*     @param: countFullHeight - control the usage of maxHeight parameter - when set to true all grid height included in max height calculation, if false then only data part (no header) of grid included in calcualation (false by default)
	*     @type: public
	*     @topic: 0
	*/
	enableAutoHeight:function(mode, maxHeight, countFullHeight){
		this._ahgr=convertStringToBoolean(mode);
		this._ahgrF=convertStringToBoolean(countFullHeight);
		this._ahgrM=maxHeight||null;
	
		if (maxHeight == "auto"){
			this._ahgrM=null;
			this._ahgrMA=true;
			this._setAutoResize();
		//   this._activeResize();
		}
	},
	enableStableSorting:function(mode){
		this._sst=convertStringToBoolean(mode);
		this.rowsCol.stablesort=function(cmp){
			var size = this.length-1;
	
			for (var i = 0; i < this.length-1; i++){
				for (var j = 0; j < size; j++)
					if (cmp(this[j], this[j+1]) > 0){
						var temp = this[j];
						this[j]=this[j+1];
						this[j+1]=temp;
					}
				size--;
			}
		}
	},
	
	/**
	*     @desc: enable/disable hot keys in grid
	*     @param: mode - true/false
	*     @type: public
	*     @topic: 0
	*/
	enableKeyboardSupport:function(mode){
		this._htkebl=!convertStringToBoolean(mode);
	},
	
	
	/**
	*     @desc: enable/disable context menu
	*     @param: dhtmlxMenu object, if null - context menu will be disabled
	*     @type: public
	*     @topic: 0
	*/
	enableContextMenu:function(menu){
		this._ctmndx=menu;
	},
	
	
	/**
	*     @desc: set width of browser scrollbars, will be used to correct autoWidth calculations (by default grid uses 16 for IE and 19 pixels for FF)
	*     @param: width - scrollbar width
	*     @type: public
	*     @topic: 0
	*/
	setScrollbarWidthCorrection:function(width){
		this._scrFix=parseInt(width);
	},
	
	/**
	*     @desc: enable/disable tooltips for specified colums
	*     @param: list - list of true/false values, tooltips enabled for all columns by default
	*     @type: public
	*     @topic: 0
	*/
	enableTooltips:function(list){
		this._enbTts=list.split(",");
	
		for (var i = 0; i < this._enbTts.length; i++)this._enbTts[i]=convertStringToBoolean(this._enbTts[i]);
	},
	
	
	/**
	*     @desc: enable/disable resizing for specified colums
	*     @param: list - list of true/false values, resizing enabled for all columns by default
	*     @type: public
	*     @topic: 0
	*/
	enableResizing:function(list){
		this._drsclmn=list.split(",");
	
		for (var i = 0; i < this._drsclmn.length; i++)this._drsclmn[i]=convertStringToBoolean(this._drsclmn[i]);
	},
	
	/**
	*     @desc: set minimum column width ( works only for manual resizing )
	*     @param: width - minimum column width, can be set for specified column, or as comma separated list for all columns
	*     @param: ind - column index
	*     @type: public
	*     @topic: 0
	*/
	setColumnMinWidth:function(width, ind){
		if (arguments.length == 2){
			if (!this._drsclmW)
				this._drsclmW=new Array();
			this._drsclmW[ind]=width;
		} else
			this._drsclmW=width.split(",");
	},
	
	
	//#cell_id:11052006{
	/**
	*     @desc: enable/disable unique id for cells (id will be automaticaly created using the following template: "c_[RowId]_[colIndex]")
	*     @param: mode - true/false - enable/disable
	*     @type: public
	*     @topic: 0
	*/
	enableCellIds:function(mode){
		this._enbCid=convertStringToBoolean(mode);
	},
	//#}
	
	
	//#locked_row:11052006{
	/**
	*     @desc: lock/unlock row for editing
	*     @param: rowId - id of row
	*     @param: mode - true/false - lock/unlock
	*     @type: public
	*     @topic: 0
	*/
	lockRow:function(rowId, mode){
		var z = this.getRowById(rowId);
	
		if (z){
			z._locked=convertStringToBoolean(mode);
	
			if ((this.cell)&&(this.cell.parentNode.idd == rowId))
				this.editStop();
		}
	},
	//#}
	
	/**
	*   @desc:  get values of all cells in row
	*   @type:  private
	*/
	_getRowArray:function(row){
		var text = new Array();
	
		for (var ii = 0; ii < row.childNodes.length; ii++){
			var a = this.cells3(row, ii);
	
			if (a.cell._code)
				text[ii]=a.cell._val;
			else
				text[ii]=a.getValue();
		}
	
		return text;
	},
	
	
	
	//#config_from_xml:20092006{
	
	/**
	*   @desc:  configure grid structure from XML
	*   @type:  private
	*/
	_launchCommands:function(arr){
		for (var i = 0; i < arr.length; i++){
			var args = new Array();
	
			for (var j = 0; j < arr[i].childNodes.length; j++)
				if (arr[i].childNodes[j].nodeType == 1)
					args[args.length]=arr[i].childNodes[j].firstChild.data;
	
			this[arr[i].getAttribute("command")].apply(this, args);
		}
	},
	
	
	/**
	*   @desc:  configure grid structure from XML
	*   @type:  private
	*/
	_parseHead:function(xmlDoc){
		var hheadCol = this.xmlLoader.doXPath("//rows/head", xmlDoc);
	
		if (hheadCol.length){
			var headCol = this.xmlLoader.doXPath("//rows/head/column", hheadCol[0]);
			var asettings = this.xmlLoader.doXPath("//rows/head/settings", hheadCol[0]);
			var awidthmet = "setInitWidths";
			var split = false;
	
			if (asettings[0]){
				for (var s = 0; s < asettings[0].childNodes.length; s++)switch (asettings[0].childNodes[s].tagName){
					case "colwidth":
						if (asettings[0].childNodes[s].firstChild&&asettings[0].childNodes[s].firstChild.data == "%")
							awidthmet="setInitWidthsP";
						break;
	
					case "splitat":
						split=(asettings[0].childNodes[s].firstChild ? asettings[0].childNodes[s].firstChild.data : false);
						break;
				}
			}
			this._launchCommands(this.xmlLoader.doXPath("//rows/head/beforeInit/call", hheadCol[0]));
	
			if (headCol.length > 0){
				var sets = [
					[],
					[],
					[],
					[],
					[],
					[],
					[],
					[],
					[]
				];
	
				var attrs = ["", "width", "type", "align", "sort", "color", "format", "hidden", "id"];
				var calls = ["setHeader", awidthmet, "setColTypes", "setColAlign", "setColSorting", "setColumnColor", "",
					"", "setColumnIds"];
	
				for (var i = 0; i < headCol.length; i++){
					for (var j = 1; j < attrs.length; j++)sets[j].push(headCol[i].getAttribute(attrs[j]));
					sets[0].push((headCol[i].firstChild
						? headCol[i].firstChild.data
						: "").replace(/^\s*((.|\n)*.+)\s*$/gi, "$1"));
				};
	
				for (var i = 0; i < calls.length; i++)
					if (calls[i])
						this[calls[i]](sets[i].join(this.delim))
	
				for (var i = 0; i < headCol.length; i++){
					if ((this.cellType[i].indexOf('co') == 0)||(this.cellType[i] == "clist")){
						var optCol = this.xmlLoader.doXPath("./option", headCol[i]);
	
						if (optCol.length){
							var resAr = new Array();
	
							if (this.cellType[i] == "clist"){
								for (var j = 0;
									j < optCol.length;
									j++)resAr[resAr.length]=optCol[j].firstChild
									? optCol[j].firstChild.data
									: "";
	
								this.registerCList(i, resAr);
							} else {
								var combo = this.getCombo(i);
	
								for (var j = 0;
									j < optCol.length;
									j++)combo.put(optCol[j].getAttribute("value"),
									optCol[j].firstChild
										? optCol[j].firstChild.data
										: "");
							}
						}
					}
	
					else if (sets[6][i])
						if ((this.cellType[i] == "calendar")||(this.fldSort[i] == "date"))
							this.setDateFormat(sets[6][i], i);
						else
							this.setNumberFormat(sets[6][i], i);
				}
	
				this.init();
	
				if (this.setColHidden)
					this.setColHidden(sets[7].join(this.delim));
	
				if ((split)&&(this.splitAt))
					this.splitAt(split);
			}
			this._launchCommands(this.xmlLoader.doXPath("//rows/head/afterInit/call", hheadCol[0]));
		}
		//global(grid) user data
		var gudCol = this.xmlLoader.doXPath("//rows/userdata", xmlDoc);
	
		if (gudCol.length > 0){
			if (!this.UserData["gridglobaluserdata"])
				this.UserData["gridglobaluserdata"]=new Hashtable();
	
			for (var j = 0; j < gudCol.length; j++){
				this.UserData["gridglobaluserdata"].put(gudCol[j].getAttribute("name"),
					gudCol[j].firstChild
						? gudCol[j].firstChild.data
						: "");
			}
		}
	},
	
	
	//#}
	
	
	/**
	*   @desc: get list of Ids of all rows with checked exCell in specified column
	*   @type: public
	*   @param: col_ind - column index
	*   @topic: 5
	*/
	getCheckedRows:function(col_ind){
		var d = new Array();
		this.forEachRow(function(id){
			if (this.cells(id, col_ind).getValue() != 0)
				d.push(id);
		})
		return d.join(",");
	},
	/**
	*   @desc:  grid body onmouseover function
	*   @type:  private
	*/
	_drawTooltip:function(e){
		var c = this.grid.getFirstParentOfType(e ? e.target : event.srcElement, 'TD');
	
		if ((this.grid.editor)&&(this.grid.editor.cell == c))
			return true;
	
		var r = c.parentNode;
	
		if (!r.idd||r.idd == "__filler__")
			return;
		var el = (e ? e.target : event.srcElement);
	
		if (r.idd == window.unknown)
			return true;
	
		if (!this.grid.callEvent("onMouseOver", [
			r.idd,
			c._cellIndex
		]))
			return true;
	
		if ((this.grid._enbTts)&&(!this.grid._enbTts[c._cellIndex])){
			if (el.title)
				el.title='';
			return true;
		}
	
		if (c._cellIndex >= this.grid._cCount)
			return;
		var ced = this.grid.cells(r.idd, c._cellIndex);
		if (!ced) return; // fix for public release
	
		if (el._title)
			ced.cell.title="";
	
		if (!ced.cell._attrs['title'])
			el._title=true;
	
		if (ced)
			el.title=ced.cell._attrs['title']
				||(ced.getTitle
					? ced.getTitle()
					: (ced.getValue()||"").toString().replace(/<[^>]*>/gi, ""));
	
		return true;
	},
	
	/**
	*   @desc:  can be used for setting correction for cell padding, while calculation setSizes
	*   @type:  private
	*/
	enableCellWidthCorrection:function(size){
		if (_isFF)
			this._wcorr=parseInt(size);
	},
	
	
	/**
	*	@desc: gets a list of all row ids in grid
	*	@param: separator - delimiter to use in list
	*	@returns: list of all row ids in grid
	*	@type: public
	*	@topic: 2,7
	*/
	getAllRowIds:function(separator){
		var ar = [];
	
		for (var i = 0; i < this.rowsBuffer.length; i++)
			if (this.rowsBuffer[i])
				ar.push(this.rowsBuffer[i].idd);
	
		return ar.join(separator||this.delim)
	},
	getAllItemIds:function(){
		return this.getAllRowIds();
	},
	
	
	
	
	/**
	*   @desc: prevent caching in IE  by adding random values to URL string
	*   @param: mode - enable/disable random values in URLs ( disabled by default )
	*   @type: public
	*   @topic: 2,9
	*/
	preventIECaching:function(mode){
		this.no_cashe=convertStringToBoolean(mode);
		this.xmlLoader.rSeed=this.no_cashe;
	},
	enableColumnAutoSize:function(mode){
		this._eCAS=convertStringToBoolean(mode);
	},
	/**
	*   @desc: called when header was dbllicked
	*   @type: private
	*   @topic: 1,2
	*/
	_onHeaderDblClick:function(e){
		var that = this.grid;
		var el = that.getFirstParentOfType(_isIE ? event.srcElement : e.target, "TD");
	
		if (!that._eCAS)
			return false;
		that.adjustColumnSize(el._cellIndexS)
	},
	
	/**
	*   @desc: autosize column  to max content size
	*   @param: cInd - index of column
	*   @type:  public
	*/
	adjustColumnSize:function(cInd, complex){
		this._notresize=true;
		var m = 0;
		this._setColumnSizeR(cInd, 20);
	
		for (var j = 1; j < this.hdr.rows.length; j++){
			var a = this.hdr.rows[j];
			a=a.childNodes[(a._childIndexes) ? a._childIndexes[cInd] : cInd];
	
			if ((a)&&((!a.colSpan)||(a.colSpan < 2))){
				if ((a.childNodes[0])&&(a.childNodes[0].className == "hdrcell"))
					a=a.childNodes[0];
				m=Math.max(m, ((_isFF||_isOpera) ? (a.textContent.length*7) : a.scrollWidth));
			}
		}
	
		var l = this.obj.rows.length;
	
		for (var i = 1; i < l; i++){
			var z = this.obj.rows[i];
	
			if (z._childIndexes&&z._childIndexes[cInd] != cInd || !z.childNodes[cInd])
				continue;
	
			if (_isFF||_isOpera||complex)
				z=z.childNodes[cInd].textContent.length*7;
			else
				z=z.childNodes[cInd].scrollWidth;
	
			if (z > m)
				m=z;
		}
		m+=20+(complex||0);
	
		this._setColumnSizeR(cInd, m);
		this._notresize=false;
		this.setSizes();
	},
	
	
	/**
	*   @desc: remove header line from grid (opposite to attachHeader)
	*   @param: index - index of row to be removed ( zero based )
	*	@param: hdr - header object (optional)
	*   @type:  public
	*/
	detachHeader:function(index, hdr){
		hdr=hdr||this.hdr;
		var row = hdr.rows[index+1];
	
		if (row)
			row.parentNode.removeChild(row);
		this.setSizes();
	},
	
	/**
	*   @desc: remove footer line from grid (opposite to attachFooter)
	*   @param: values - array of header titles
	*   @type:  public
	*/
	detachFooter:function(index){
		this.detachHeader(index, this.ftr);
	},
	
	/**
	*   @desc: attach additional line to header
	*   @param: values - array of header titles
	*   @param: style - array of styles, optional
	*	@param: _type - reserved
	*   @type:  public
	*/
	attachHeader:function(values, style, _type){
		if (typeof (values) == "string")
			values=this._eSplit(values);
	
		if (typeof (style) == "string")
			style=style.split(this.delim);
		_type=_type||"_aHead";
	
		if (this.hdr.rows.length){
			if (values)
				this._createHRow([
					values,
					style
				], this[(_type == "_aHead") ? "hdr" : "ftr"]);
	
			else if (this[_type])
				for (var i = 0; i < this[_type].length; i++)this.attachHeader.apply(this, this[_type][i]);
		} else {
			if (!this[_type])
				this[_type]=new Array();
			this[_type][this[_type].length]=[
				values,
				style,
				_type
			];
		}
	},
	/**
	*	@desc:
	*	@type: private
	*/
	_createHRow:function(data, parent){
		if (!parent){
			//create footer zone
			this.entBox.style.position="relative";
			var z = document.createElement("DIV");
			z.className="c_ftr".substr(2);
			this.entBox.appendChild(z);
			var t = document.createElement("TABLE");
			t.cellPadding=t.cellSpacing=0;
	
			if (!_isIE){
				t.width="100%";
				t.style.paddingRight="20px";
			}
			t.style.tableLayout="fixed";
	
			z.appendChild(t);
			t.appendChild(document.createElement("TBODY"));
			this.ftr=parent=t;
	
			var hdrRow = t.insertRow(0);
			var thl = ((this.hdrLabels.length <= 1) ? data[0].length : this.hdrLabels.length);
	
			for (var i = 0; i < thl; i++){
				hdrRow.appendChild(document.createElement("TH"));
				hdrRow.childNodes[i]._cellIndex=i;
			}
	
			if (_isIE)
				hdrRow.style.position="absolute";
			else
				hdrRow.style.height='auto';
		}
		var st1 = data[1];
		var z = document.createElement("TR");
		parent.rows[0].parentNode.appendChild(z);
	
		for (var i = 0; i < data[0].length; i++){
			if (data[0][i] == "#cspan"){
				var pz = z.cells[z.cells.length-1];
				pz.colSpan=(pz.colSpan||1)+1;
				continue;
			}
	
			if ((data[0][i] == "#rspan")&&(parent.rows.length > 1)){
				var pind = parent.rows.length-2;
				var found = false;
				var pz = null;
	
				while (!found){
					var pz = parent.rows[pind];
	
					for (var j = 0; j < pz.cells.length; j++)
						if (pz.cells[j]._cellIndex == i){
							found=j+1;
							break;
						}
					pind--;
				}
	
				pz=pz.cells[found-1];
				pz.rowSpan=(pz.rowSpan||1)+1;
				continue;
			//            data[0][i]="";
			}
	
			var w = document.createElement("TD");
			w._cellIndex=w._cellIndexS=i;
			if (this._hrrar && this._hrrar[i] && !_isIE)
				w.style.display='none';

	
			if (this.forceDivInHeader)
				w.innerHTML="<div class='hdrcell'>"+data[0][i]+"</div>";
			else
				w.innerHTML=data[0][i];
	
			if ((data[0][i]||"").indexOf("#") != -1){
				var t = data[0][i].match(/(^|{)#([^}]+)(}|$)/);
	
				if (t){
					var tn = "_in_header_"+t[2];
	
					if (this[tn])
						this[tn]((this.forceDivInHeader ? w.firstChild : w), i, data[0][i].split(t[0]));
				}
			}
	
			if (st1)
				w.style.cssText=st1[i];
	
			z.appendChild(w);
		}
		var self = parent;
	
		if (_isKHTML){
			if (parent._kTimer)
				window.clearTimeout(parent._kTimer);
			parent._kTimer=window.setTimeout(function(){
				parent.rows[1].style.display='none';
				window.setTimeout(function(){
					parent.rows[1].style.display='';
				}, 1);
			}, 500);
		}
	},
	
	
	/**
		  *   @desc: 
		  *   @type: private
		  */
	dhx_Event:function(){
		this.dhx_SeverCatcherPath="";
	
		this.attachEvent=function(original, catcher, CallObj){
			CallObj=CallObj||this;
			original='ev_'+original;
	
			if ((!this[original])||(!this[original].addEvent)){
				var z = new this.eventCatcher(CallObj);
				z.addEvent(this[original]);
				this[original]=z;
			}
			return(original+':'+this[original].addEvent(catcher)); //return ID (event name & event ID)
		}
		this.callEvent=function(name, arg0){ 
			if (this["ev_"+name])
				return this["ev_"+name].apply(this, arg0);
	
			return true;
		}
		this.checkEvent=function(name){
			if (this["ev_"+name])
				return true;
	
			return false;
		}
	
		this.eventCatcher=function(obj){
			var dhx_catch = new Array();
			var m_obj = obj;
			var z = function(){
				if (dhx_catch)
					var res = true;
	
				for (var i = 0; i < dhx_catch.length; i++){
					if (dhx_catch[i] != null){
						var zr = dhx_catch[i].apply(m_obj, arguments);
						res=res&&zr;
					}
				}
				return res;
			}
			z.addEvent=function(ev){
				if (typeof (ev) != "function")
					ev=eval(ev);
	
				if (ev)
					return dhx_catch.push(ev)-1;
				return false;
			}
			z.removeEvent=function(id){
				dhx_catch[id]=null;
			}
			return z;
		}
	
		this.detachEvent=function(id){
			if (id != false){
				var list = id.split(':');           //get EventName and ID
				this[list[0]].removeEvent(list[1]); //remove event
			}
		}
	},
	/**
	*   @desc: execute code for each row in a grid
	*   @param: custom_code - function which get row id as incomming argument
	*   @type:  public
	*/
	forEachRow:function(custom_code){
		for (a in this.rowsAr)
			if (this.rowsAr[a]&&this.rowsAr[a].idd)
				custom_code.apply(this, [this.rowsAr[a].idd]);
	},
	/**
	*   @desc: execute code for each cell in a row
	*   @param: rowId - id of row where cell must be itterated
	*   @param: custom_code - function which get eXcell object as incomming argument
	*   @type:  public
	*/
	forEachCell:function(rowId, custom_code){
		var z = this.rowsAr[rowId];
	
		if (!z)
			return;
	
		for (var i = 0; i < this._cCount; i++) custom_code(this.cells3(z, i),i);
	},
	/**
	*   @desc: changes grid's container size on the fly to fit total width of grid columns
	*   @param: mode  - truse/false - enable / disable
	*   @param: max_limit  - max allowed width, not limited by default
	*   @param: min_limit  - min allowed width, not limited by default
	*   @type:  public
	*/
	enableAutoWidth:function(mode, max_limit, min_limit){
		this._awdth=[
			convertStringToBoolean(mode),
			(max_limit||99999),
			(min_limit||0)
		];
	},
	
	/**
	*   @desc: refresh grid from XML ( doesnt work for buffering, tree grid or rows in smart rendering mode )
	*   @param: insert_new - insert new items
	*   @param: del_missed - delete missed rows
	*   @param: afterCall - function, will be executed after refresh completted
	*   @type:  public
	*/
	
	updateFromXML:function(url, insert_new, del_missed, afterCall){
		if (typeof insert_new == "undefined")
			insert_new=true;
		this._refresh_mode=[
			true,
			insert_new,
			del_missed
		];
		this.load(url,afterCall)
	},
	_refreshFromXML:function(xml){
		if (window.eXcell_tree){
			eXcell_tree.prototype.setValueX=eXcell_tree.prototype.setValue;
			eXcell_tree.prototype.setValue=function(content){
				if (this.grid._h2.get[this.cell.parentNode.idd]){
					this.setLabel(content[1]);
	
					if (content[3])
						this.setImage(content[3]);
				} else
					this.setValueX(content);
			};
		}
	
		var tree = this.cellType._dhx_find("tree");
			xml.getXMLTopNode("rows");
		var pid = xml.doXPath("//rows")[0].getAttribute("parent")||0;
	
		var del = {
		};
	
		if (this._refresh_mode[2]){
			if (tree != -1)
				this._h2.forEachChild(pid, function(obj){
					del[obj.id]=true;
				}, this);
			else
				this.forEachRow(function(id){
					del[id]=true;
				});
		}
	
		var rows = xml.doXPath("//row");
	
		for (var i = 0; i < rows.length; i++){
			var row = rows[i];
			var id = row.getAttribute("id");
			del[id]=false;
			var pid = row.parentNode.getAttribute("id")||pid;
	
			if (this.rowsAr[id] && this.rowsAr[id].tagName!="TR")
				this.rowsAr[id].data=row;
			else if (this.rowsAr[id]){
					this._process_xml_row(this.rowsAr[id], row, -1);
					this._postRowProcessing(this.rowsAr[id])
				} else if (this._refresh_mode[1]){
					this.rowsBuffer.push({
						idd: id,
						data: row,
						_parser: this._process_xml_row,
						_locator: this._get_xml_data
					});
					this.rowsAr[id]=row;
					row=this.render_row(this.rowsBuffer.length-1);
					this._insertRowAt(row,-1)
				}
		}
				
		if (this._refresh_mode[2])
			for (id in del){
				if (del[id]&&this.rowsAr[id])
					this.deleteRow(id);
			}
	
		this._refresh_mode=null;
		if (window.eXcell_tree)
			eXcell_tree.prototype.setValue=eXcell_tree.prototype.setValueX;
		this.callEvent("onXLE", [
			this,
			rows.length
		]);
		
	},
	
	
	/**
	*   @desc: get combobox specific for cell in question
	*   @param: id - row id
	*   @param: ind  - row index
	*   @type:  public
	*/
	getCustomCombo:function(id, ind){
		var cell = this.cells(id, ind).cell;
	
		if (!cell._combo)
			cell._combo=new dhtmlXGridComboObject();
		return cell._combo;
	},
	/**
	*   @desc: set tab order of columns
	*   @param: order - list of tab indexes (default delimiter is ",")
	*   @type:  public
	*/
	setTabOrder:function(order){
		var t = order.split(this.delim);
		this._tabOrder=[];
	
		for (var i = 0; i < this._cCount; i++)t[i]={
			c: parseInt(t[i]),
			ind: i
			};
		t.sort(function(a, b){
			return(a.c > b.c ? 1 : -1);
		});
	
		for (var i = 0; i < this._cCount; i++)
			if (!t[i+1]||( typeof t[i].c == "undefined"))
				this._tabOrder[t[i].ind]=(t[0].ind+1)*-1;
			else
				this._tabOrder[t[i].ind]=t[i+1].ind;
	},
	
	i18n:{
		loading: "Loading",
		decimal_separator:".",
		group_separator:","
	},
	
	//key_ctrl_shift
	_key_events:{
		k13_1_0: function(){
			var rowInd = this.rowsCol._dhx_find(this.row)
			this.selectCell(this.rowsCol[rowInd+1], this.cell._cellIndex, true);
		},
		k13_0_1: function(){
			var rowInd = this.rowsCol._dhx_find(this.row)
			this.selectCell(this.rowsCol[rowInd-1], this.cell._cellIndex, true);
		},
		k13_0_0: function(){
			this.editStop();
			this.callEvent("onEnter", [
				(this.row ? this.row.idd : null),
				(this.cell ? this.cell._cellIndex : null)
			]);
			this._still_active=true;
		},
		k9_0_0: function(){
			this.editStop();
			var z = this._getNextCell(null, 1);
	
			if (z){
				this.selectCell(z.parentNode, z._cellIndex, (this.row != z.parentNode), false, true);
				this._still_active=true;
			}
		},
		k9_0_1: function(){
			this.editStop();
			var z = this._getNextCell(null, -1);
	
			if (z){
				this.selectCell(z.parentNode, z._cellIndex, (this.row != z.parentNode), false, true);
				this._still_active=true;
			}
		},
		k113_0_0: function(){
			if (this._f2kE)
				this.editCell();
		},
		k32_0_0: function(){
			var c = this.cells4(this.cell);
	
			if (!c.changeState||(c.changeState() === false))
				return false;
		},
		k27_0_0: function(){
			this.editStop(true);
		},
		k33_0_0: function(){
			if (this.pagingOn)
				this.changePage(this.currentPage-1);
			else
				this.scrollPage(-1);
		},
		k34_0_0: function(){
			if (this.pagingOn)
				this.changePage(this.currentPage+1);
			else
				this.scrollPage(1);
		},
		k37_0_0: function(){
			if (!this.editor&&this.isTreeGrid())
				this.collapseKids(this.row)
			else
				return false;
		},
		k39_0_0: function(){
			if (!this.editor&&this.isTreeGrid())
				this.expandKids(this.row)
			else
				return false;
		},
		k40_0_0: function(){
			if (this.editor&&this.editor.combo)
				this.editor.shiftNext();
			else {
				var rowInd = this.rowsCol._dhx_find(this.row)+1;
	
				if (rowInd != this.rowsCol.length&&rowInd != this.obj.rows.length-1){
					var nrow = this._nextRow(rowInd-1, 1);
					this.selectCell(nrow, this.cell._cellIndex, true);
				} else {
					this._key_events.k34_0_0.apply(this, []);
					if (this.pagingOn && this.rowsCol[0])
						this.selectCell(0, 0, true);
				}
			}
			this._still_active=true;
		},
		k38_0_0: function(){
			if (this.editor&&this.editor.combo)
				this.editor.shiftPrev();
			else {
				var rowInd = this.rowsCol._dhx_find(this.row)+1;
				if (rowInd != -1 && (!this.pagingOn || (rowInd!=1))){
					var nrow = this._nextRow(rowInd-1, -1);
					this.selectCell(nrow, this.cell._cellIndex, true);
				} else {
					this._key_events.k33_0_0.apply(this, []);
	
					if (this.pagingOn && this.rowsCol[this.rowsBufferOutSize-1])
						this.selectCell(this.rowsBufferOutSize-1, 0, true);
				}
			}
			this._still_active=true;
		}
	},
	
	//(c)dhtmlx ltd. www.dhtmlx.com
	
	_build_master_row:function(){
		var t = document.createElement("DIV");
		var html = ["<table><tr>"];
	
		for (var i = 0; i < this._cCount; i++)html.push("<td></td>");
		html.push("</tr></table>");
		t.innerHTML=html.join("");
		this._master_row=t.firstChild.rows[0];
	},
	
	_prepareRow:function(new_id){ /*TODO: hidden columns, cell ids , d-n-d, cell indexes */
		if (!this._master_row)
			this._build_master_row();
	
		var r = this._master_row.cloneNode(true);
	
		for (var i = 0; i < r.childNodes.length; i++){
			r.childNodes[i]._cellIndex=i;
	
			if (this.dragAndDropOff)
				this.dragger.addDraggableItem(r.childNodes[i], this);
		}
		r.idd=new_id;
		r.grid=this;
	
		return r;
	},
	
	_process_jsarray_row:function(r, data){
		r._attrs={
		};
	
		for (var j = 0; j < r.childNodes.length; j++)r.childNodes[j]._attrs={
		};
	
		this._fillRow(r, (this._c_order ? this._swapColumns(data) : data));
		return r;
	},
	_get_jsarray_data:function(data, ind){
		return data[ind];
	},
	_process_json_row:function(r, data){
		r._attrs={
		};
	
		for (var j = 0; j < r.childNodes.length; j++)r.childNodes[j]._attrs={
		};
	
		this._fillRow(r, (this._c_order ? this._swapColumns(data.data) : data.data));
		return r;
	},
	_get_json_data:function(data, ind){
		return data.data[ind];
	},
	
	_process_csv_row:function(r, data){
		r._attrs={
		};
	
		for (var j = 0; j < r.childNodes.length; j++)r.childNodes[j]._attrs={
		};
	
		this._fillRow(r, (this._c_order ? this._swapColumns(data.split(this.csv.cell)) : data.split(this.csv.cell)));
		return r;
	},
	_get_csv_data:function(data, ind){
		return data.split(this.csv.cell)[ind];
	},
	
	_process_xml_row:function(r, xml){		
		var cellsCol = this.xmlLoader.doXPath("./cell", xml);
		var strAr = [];
	
		r._attrs=this._xml_attrs(xml);
	
		//load userdata
		if (this._ud_enabled){
			var udCol = this.xmlLoader.doXPath("./userdata", xml);
	
			for (var i = udCol.length-1;
				i >= 0;
				i--)this.setUserData(r.idd,udCol[i].getAttribute("name"), udCol[i].firstChild
				? udCol[i].firstChild.data
				: "");
		}
	
		//load cell data
		for (var j = 0; j < cellsCol.length; j++){
			var cellVal = cellsCol[j];
			var exc = cellVal.getAttribute("type");
	
			if (r.childNodes[j]){
				if (exc)
					r.childNodes[j]._cellType=exc;
				r.childNodes[j]._attrs=this._xml_attrs(cellsCol[j]);
			}
	
			if (cellVal.getAttribute("xmlcontent"))
				cellVal=cellsCol[j];
	
			else if (cellVal.firstChild)
				cellVal=cellVal.firstChild.data;
	
			else
				cellVal="";
	
			strAr.push(cellVal);
		}
	
		for (j < cellsCol.length; j < r.childNodes.length; j++)r.childNodes[j]._attrs={
		};
	
		//treegrid
		if (r.parentNode&&r.parentNode.tagName == "row")
			r._attrs["parent"]=r.parentNode.getAttribute("idd");
	
		//back to common code
		this._fillRow(r, (this._c_order ? this._swapColumns(strAr) : strAr));
		return r;
	},
	_get_xml_data:function(data, ind){ 
		data=data.firstChild;
	
		while (true){
			if (!data)
				return "";
	
			if (data.tagName == "cell")
				ind--;
	
			if (ind < 0)
				break;
			data=data.nextSibling;
		}
		return(data.firstChild ? data.firstChild.data : "");
	},
	
	_fillRow:function(r, text){
		if (this.editor)
			this.editStop();
	
		for (var i = 0; i < r.childNodes.length; i++){
			if ((i < text.length)||(this.defVal[i])){
				var val = text[i]
				var aeditor = this.cells5(r.childNodes[i], (r.childNodes[i]._cellType||this.cellType[i]));
	
				if ((this.defVal[i])&&((val == "")||( typeof (val) == "undefined")))
					val=this.defVal[i];
	
				aeditor.setValue(val)
			} else {
				var val = "&nbsp;";
				r.childNodes[i].innerHTML=val;
				r.childNodes[i]._clearCell=true;
			}
		}
	
		return r;
	},
	
	_postRowProcessing:function(r){ /*TODO selected*/
		if (r._attrs["class"])
			r.className=r._attrs["class"];
	
		if (r._attrs.locked)
			r._locked=true;
	
		if (r._attrs.bgColor)
			r.bgColor=r._attrs.bgColor;
		var cor = 0;
	
		for (var i = 0; i < r.childNodes.length; i++){
			c=r.childNodes[i+cor];
			//style attribute
			var s = c._attrs.style||r._attrs.style;
	
			if (s)
				c.style.cssText+=";"+s;
	
			if (c._attrs["class"])
				c.className=c._attrs["class"];
			s=c._attrs.align||this.cellAlign[i];
	
			if (s)
				c.align=s;
			c.style.verticalAlign=c._attrs.valign||this.cellVAlign[i];
			var color = c._attrs.bgColor||this.columnColor[i];
	
			if (color)
				c.bgColor=color;
	
			if (c._attrs["colspan"]){
				this.setColspan(r.idd, i, c._attrs["colspan"]);
				cor+=(1-c._attrs["colspan"]);
				i-=(1-c._attrs["colspan"]);
			}
	
			if (this._hrrar&&this._hrrar[i])
				c.style.display="none";
		};
		this.callEvent("onRowCreated", [
			r.idd,
			r,
			null
		]);
	},
	/**
	*   @desc: load data from external file ( xml, json, jsarray, csv )
	*   @param: url - url to external file
	*   @param: call - after loading callback function, optional, can be ommited
	*   @param: type - type of data (xml,csv,json,jsarray) , optional, xml by default
	*   @type:  public
	*/			
	load:function(url, call, type){
		this.callEvent("onXLS", [this]);
		if (arguments.length == 2 && typeof call != "function"){
			type=call;
			call=null;
		}
		type=type||"xml";
	
		if (!this.xmlFileUrl)
			this.xmlFileUrl=url;
		this._data_type=type;
		this.xmlLoader.onloadAction=function(that, b, c, d, xml){
			xml=that["_process_"+type](xml);
			if (!that._contextCallTimer)
			that.callEvent("onXLE", [that,0,0,xml]);
	
			if (call){
				call();
				call=null;
			}
		}
		this.xmlLoader.loadXML(url);
	},
	loadXMLString:function(str, afterCall){
		var t = new dtmlXMLLoaderObject(function(){
		});

		t.loadXMLString(str);
		this.parse(t, afterCall, "xml")
	},
	loadXML:function(url, afterCall){
		this.load(url, afterCall, "xml")
	},
	/**
	*   @desc: load data from local datasource ( xml string, csv string, xml island, xml object, json objecs , javascript array )
	*   @param: data - string or object
	*   @param: type - data type (xml,json,jsarray,csv), optional, data threated as xml by default
	*   @type:  public
	*/			
	parse:function(data, call, type){
		if (arguments.length == 2 && typeof call != "function"){
			type=call;
			call=null;
		}
		type=type||"xml";
		this._data_type=type;
		data=this["_process_"+type](data);
		if (!this._contextCallTimer)
		this.callEvent("onXLE", [this,0,0,data]);
		if (call)
			call();
	},
	
	xml:{
		top: "rows",
		row: "./row",
		cell: "./cell",
		s_row: "row",
		s_cell: "cell",
		row_attrs: [],
		cell_attrs: []
	},
	
	csv:{
		row: "\n",
		cell: ","
	},
	
	_xml_attrs:function(node){
		var data = {
		};
	
		if (node.attributes.length){
			for (var i = 0; i < node.attributes.length; i++)data[node.attributes[i].name]=node.attributes[i].value;
		}
	
		return data;
	},
	
	_process_xml:function(xml){ 
		if (this._refresh_mode) return this._refreshFromXML(xml);
		if (!xml.doXPath){
			var t = new dtmlXMLLoaderObject(function(){});
			if (typeof xml == "string") 
				t.loadXMLString(xml);
			else {
				if (xml.responseXML)
					t.xmlDoc=xml;
				else
					t.xmlDoc={};
				t.xmlDoc.responseXML=xml;
			}
			xml=t;
		}
		
		this._parsing=true;
		var top = xml.getXMLTopNode(this.xml.top)
		if (top.tagName.toLowerCase()!=this.xml.top) return;
		this._parseHead(top);
		var rows = xml.doXPath(this.xml.row, top)
		var cr = parseInt(xml.doXPath("//"+this.xml.top)[0].getAttribute("pos")||0);
		var total = parseInt(xml.doXPath("//"+this.xml.top)[0].getAttribute("total_count")||0);
	
		if (total&&!this.rowsBuffer[total-1])
			this.rowsBuffer[total-1]=null;
			
		if (this.isTreeGrid())
			return this._process_tree_xml(xml);
			 
	
		for (var i = 0; i < rows.length; i++){
			if (this.rowsBuffer[i+cr])
				continue;
			var id = rows[i].getAttribute("id");
			this.rowsBuffer[i+cr]={
				idd: id,
				data: rows[i],
				_parser: this._process_xml_row,
				_locator: this._get_xml_data
				};
	
			this.rowsAr[id]=rows[i];
		//this.callEvent("onRowCreated",[r.idd]);
		}
		this.render_dataset();
		this._parsing=false;
		return xml.xmlDoc.responseXML?xml.xmlDoc.responseXML:xml.xmlDoc;
	},
	
	_process_jsarray:function(data){
		this._parsing=true;
	
		if (data&&data.xmlDoc)
			eval("data="+data.xmlDoc.responseText+";");
	
		for (var i = 0; i < data.length; i++){
			var id = i+1;
			this.rowsBuffer.push({
				idd: id,
				data: data[i],
				_parser: this._process_jsarray_row,
				_locator: this._get_jsarray_data
				});
	
			this.rowsAr[id]=data[i];
		//this.callEvent("onRowCreated",[r.idd]);
		}
		this.render_dataset();
		this._parsing=false;
	},
	
	_process_csv:function(data){
		this._parsing=true;
		if (data.xmlDoc)
			data=data.xmlDoc.responseText;
		data=data.replace(/\r/g,"");
		data=data.split(this.csv.row);
	    if (this._csvHdr){
   			this.clearAll();
	   		this.setHeader(data.splice(0,1).split(this.csv.cell).join(this.delim));
	   		this.init();
   		}
	
		for (var i = 0; i < data.length; i++){
			if (this._csvAID){
				var id = i+1;
				this.rowsBuffer.push({
					idd: id,
					data: data[i],
					_parser: this._process_csv_row,
					_locator: this._get_csv_data
					});
			} else {
				var temp = data[i].split(this.csv.cell);
				var id = temp.splice(0,1)[0];
				this.rowsBuffer.push({
					idd: id,
					data: temp,
					_parser: this._process_jsarray_row,
					_locator: this._get_jsarray_data
					});
			}
			
	
			this.rowsAr[id]=data[i];
		//this.callEvent("onRowCreated",[r.idd]);
		}
		this.render_dataset();
		this._parsing=false;
	},
	
	_process_json:function(data){
		this._parsing=true;
	
		if (data&&data.xmlDoc)
			eval("data="+data.xmlDoc.responseText+";");
	
		for (var i = 0; i < data.rows.length; i++){
			var id = data.rows[i].id;
			this.rowsBuffer.push({
				idd: id,
				data: data.rows[i],
				_parser: this._process_json_row,
				_locator: this._get_json_data
				});
	
			this.rowsAr[id]=data[i];
		//this.callEvent("onRowCreated",[r.idd]);
		}
		this.render_dataset();
		this._parsing=false;
	},
	
	render_dataset:function(min, max){ 
		//normal mode - render all
		//var p=this.obj.parentNode;
		//p.removeChild(this.obj,true)
		if (this._srnd){
			if (this._fillers)
				return this._update_srnd_view();
	
			max=Math.min(this._get_view_size(), this.rowsBuffer.length);
		}
	
		if (this.pagingOn){
			min=(this.currentPage-1)*this.rowsBufferOutSize;
			max=Math.min(min+this.rowsBufferOutSize, this.rowsBuffer.length)
		} else {
			min=min||0;
			max=max||this.rowsBuffer.length;
		}
	
		for (var i = min; i < max; i++){
			var r = this.render_row(i)
	
			if (r == -1){
				if (this.xmlFileUrl)
					this.load(this.xmlFileUrl+getUrlSymbol(this.xmlFileUrl)+"posStart="+i+"&count="+(this._dpref?this._dpref:(max-i)), this._data_type);
				max=i;
				break;
			}
	
			if (!r.parentNode||!r.parentNode.tagName){ 
				this._insertRowAt(r, i);
				if (r._attrs["selected"]){
					this.selectRow(r,false,true);
					delete r._attrs["selected"];
				}
			}
			
							
			if (this._ads_count && i-min==this._ads_count){
				var that=this;
				return this._contextCallTimer=window.setTimeout(function(){
					that._contextCallTimer=null;
					that.render_dataset(i,max);
					if (!that._contextCallTimer)
						that.callEvent("onXLE",[])
				},this._ads_time)
			}
		}
	
		if (this._srnd&&!this._fillers)
			this._fillers=[this._add_filler(max, this.rowsBuffer.length-max)];
	
		//p.appendChild(this.obj)
		this.setSizes();
	},
	
	render_row:function(ind){
		if (!this.rowsBuffer[ind])
			return -1;
	
		if (this.rowsBuffer[ind]._parser){
			var r = this.rowsBuffer[ind];
			var row = this._prepareRow(r.idd);
			this.rowsBuffer[ind]=row;
			this.rowsAr[r.idd]=row;
	
			r._parser.call(this, row, r.data);
			this._postRowProcessing(row);
			return row;
		}
		return this.rowsBuffer[ind];
	},
	
	
	_get_cell_value:function(row, ind, method){
		if (row._locator){
			/*if (!this._data_cache[row.idd])
				this._data_cache[row.idd]=[];
			if (this._data_cache[row.idd][ind]) 
				return this._data_cache[row.idd][ind];
			else
				 return this._data_cache[row.idd][ind]=row._locator.call(this,row.data,ind);
				 */
			if (this._c_order)
				ind=this._c_order[ind];
			return row._locator.call(this, row.data, ind);
		}
		return this.cells3(row, ind)[method ? method : "getValue"]();
	},
	/**
	*   @desc: sort grid
	*   @param: col - index of column, by which grid need to be sorted
	*   @param: type - sorting type (str,int,date), optional, by default sorting type taken from column setting
	*   @param: order - sorting order (asc,des), optional, by default sorting order based on previous sorting operation
	*   @type:  public
	*/		
	sortRows:function(col, type, order){
		//default values
		order=(order||"asc").toLowerCase();
		type=(type||this.fldSort[col]);
		col=col||0;
		
		if (this.isTreeGrid())
			return this.sortTreeRows(col, type, order)
	
		var arrTS = {
		};
	
		var atype = this.cellType[col];
		var amet = "getValue";
	
		if (atype == "link")
			amet="getContent";
	
		if (atype == "dhxCalendar"||atype == "dhxCalendarA")
			amet="getDate";
	
		for (var i = 0;
			i < this.rowsBuffer.length;
			i++)arrTS[this.rowsBuffer[i].idd]=this._get_cell_value(this.rowsBuffer[i], col, amet);
	
		this._sortRows(col, type, order, arrTS);
	},
	/**
	*	@desc: 
	*	@type: private
	*/
	_sortCore:function(col, type, order, arrTS, s){
		var sort = "sort";
	
		if (this._sst){
			s["stablesort"]=this.rowsCol.stablesort;
			sort="stablesort";
		}
	
		
		if (type == 'str'){
			s[sort](function(a, b){
				if (order == "asc")
					return arrTS[a.idd] > arrTS[b.idd] ? 1 : -1
				else
					return arrTS[a.idd] < arrTS[b.idd] ? 1 : -1
			});
		}
		else if (type == 'int'){
			s[sort](function(a, b){
				var aVal = parseFloat(arrTS[a.idd]);
				aVal=isNaN(aVal) ? -99999999999999 : aVal;
				var bVal = parseFloat(arrTS[b.idd]);
				bVal=isNaN(bVal) ? -99999999999999 : bVal;
	
				if (order == "asc")
					return aVal-bVal;
				else
					return bVal-aVal;
			});
		}
		else if (type == 'date'){
			s[sort](function(a, b){
				var aVal = Date.parse(arrTS[a.idd])||(Date.parse("01/01/1900"));
				var bVal = Date.parse(arrTS[b.idd])||(Date.parse("01/01/1900"));
	
				if (order == "asc")
					return aVal-bVal
				else
					return bVal-aVal
			});
		}
	},
	/**
	*   @desc: inner sorting routine
	*   @type: private
	*   @topic: 7
	*/
	_sortRows:function(col, type, order, arrTS){
		this._sortCore(col, type, order, arrTS, this.rowsBuffer);
		this._reset_view();
		this.callEvent("onGridReconstructed", []);
	},
	_reset_view:function(skip){
		var tb = this.obj.rows[0].parentNode;
		var tr = tb.removeChild(tb.childNodes[0], true)
	    if (_isKHTML) //Safari 2x
	    	for (var i = tb.parentNode.childNodes.length-1; i >= 0; i--) { if (tb.parentNode.childNodes[i].tagName=="TR") tb.parentNode.removeChild(tb.parentNode.childNodes[i],true); }
	    else if (_isIE)
			for (var i = tb.childNodes.length-1; i >= 0; i--) tb.childNodes[i].removeNode(true);
		else
			tb.innerHTML="";
		tb.appendChild(tr)
		this.rowsCol=dhtmlxArray();
		this._fillers=this.undefined;
		if (!skip)
			this.render_dataset();
	},
	
	
	/**
	*   @desc: delete row from the grid
	*   @param: row_id - row ID
	*   @type:  public
	*/		
	deleteRow:function(row_id, node){
		if (!node)
			node=this.getRowById(row_id)
	
		if (!node)
			return;
	
		this.editStop();
	
		if (this.callEvent("onBeforeRowDeleted", [row_id]) == false)
			return false;
	
		if (this.cellType._dhx_find("tree") != -1)
			this._removeTrGrRow(node);
		else {
			if (node.parentNode)
				node.parentNode.removeChild(node);
	
			var ind = this.rowsCol._dhx_find(node);
	
			if (ind != -1)
				this.rowsCol._dhx_removeAt(ind);
	
			for (var i = 0; i < this.rowsBuffer.length; i++)
				if (this.rowsBuffer[i]&&this.rowsBuffer[i].idd == row_id){
					this.rowsBuffer._dhx_removeAt(i);
					ind=i;
					break;
				}
		}
		this.rowsAr[row_id]=null;
	
		for (var i = 0; i < this.selectedRows.length; i++)
			if (this.selectedRows[i].idd == row_id)
				this.selectedRows._dhx_removeAt(i);
	
		if (this._srnd){
			for (var i = 0; i < this._fillers.length; i++){
				var f = this._fillers[i]
	
				if (f[0] >= ind)
					f[0]=f[0]-1;
				else if (f[1] >= ind)
					f[1]=f[1]-1;
			};
	
			this._update_srnd_view();
		}
	
		if (this.pagingOn)
			this.changePage();
		this.callEvent("onGridReconstructed", []);
		return true;
	},
	
	_addRow:function(new_id, text, ind){
		if (ind == -1|| typeof ind == "undefined")
			ind=this.rowsBuffer.length;
		if (typeof text == "string") text=text.split(this.delim);
		var row = this._prepareRow(new_id);
		row._attrs={
		};
	
		for (var j = 0; j < row.childNodes.length; j++)row.childNodes[j]._attrs={
		};
	
	
		this.rowsAr[row.idd]=row;
		this._fillRow(row, text)
		this._postRowProcessing(row)
		if (this._skipInsert){
			this._skipInsert=false;
			return this.rowsAr[row.idd]=row;
		}
	
		if (this.pagingOn){
			this.rowsBuffer._dhx_insertAt(ind,row);
			this.rowsAr[row.idd]=row;
			return row;
		}
	
		if (this._fillers){ 
			this.rowsCol._dhx_insertAt(ind, null);
			this.rowsBuffer._dhx_insertAt(ind,row);
			this.rowsAr[row.idd]=row;
			var found = false;
	
			for (var i = 0; i < this._fillers.length; i++){
				var f = this._fillers[i];
	
				if (f&&f[0] <= ind&&(f[0]+f[1]) >= ind){
					f[1]=f[1]+1;
					found=true;
				}
	
				if (f&&f[0] >= ind)
					f[0]=f[0]+1
			}
	
			if (!found)
				this._fillers.push(this._add_filler(ind, 1, (ind == 0 ? {
					parentNode: this.obj.rows[0].parentNode,
					nextSibling: (this.rowsCol[1])
					} : this.rowsCol[ind-1])));
	
			return row;
		}
		this.rowsBuffer._dhx_insertAt(ind,row);
		return this._insertRowAt(row, ind);
	},
	
	/**
	*   @desc: add row to the grid
	*   @param: new_id - row ID, must be unique
	*   @param: text - row values, may be a comma separated list or an array
	*   @param: ind - index of new row, optional, row added to the last position by default
	*   @type:  public
	*/	
	addRow:function(new_id, text, ind){
		var r = this._addRow(new_id, text, ind);
	
		if (!this.dragContext)
			this.callEvent("onRowAdded", [new_id]);
		
	
		if (this.pagingOn)
			this.changePage(this.currentPage)
	
		if (this._srnd)
			this._update_srnd_view();
	
		r._added=true;
	
		if (this._ahgr)
			this.setSizes();
		this.callEvent("onGridReconstructed", []);
		return r;
	},
	
	_insertRowAt:function(r, ind, skip){
		this.rowsAr[r.idd]=r;
	
		if (this._skipInsert){
			this._skipInsert=false;
			return r;
		}
	
		if ((ind < 0)||((!ind)&&(parseInt(ind) !== 0)))
			ind=this.rowsCol.length;
		else {
			if (ind > this.rowsCol.length)
				ind=this.rowsCol.length;
		}
	
		if (this._cssEven){
			if ((this._cssSP ? this.getLevel(r.idd) : ind)%2 == 1)
				r.className+=" "+this._cssUnEven+(this._cssSU ? (this._cssUnEven+"_"+this.getLevel(r.idd)) : "");
			else
				r.className+=" "+this._cssEven+(this._cssSU ? (" "+this._cssEven+"_"+this.getLevel(r.idd)) : "");
		}
		/*
		if (r._skipInsert) {                
			this.rowsAr[r.idd] = r;
			return r;
		}*/
		if (!skip)
			if ((ind == (this.obj.rows.length-1))||(!this.rowsCol[ind]))
				if (_isKHTML)
					this.obj.appendChild(r);
				else {
					this.obj.firstChild.appendChild(r);
				}
			else {
				this.rowsCol[ind].parentNode.insertBefore(r, this.rowsCol[ind]);
			}
	
		this.rowsCol._dhx_insertAt(ind, r);
	
		return r;
	},
	
	getRowById:function(id){
		var row = this.rowsAr[id];
	
		if (row){
			if (row.tagName != "TR"){
				for (var i = 0; i < this.rowsBuffer.length; i++)
					if (this.rowsBuffer[i] && this.rowsBuffer[i].idd == id)
						return this.render_row(i);
				if (this._h2) return this.render_row(null,row.idd);
			}
			return row;
		}
		return null;
	},
	
/**
*   @desc: gets dhtmlXGridCellObject object (if no arguments then gets dhtmlXGridCellObject object of currently selected cell)
*   @param: row_id -  row id
*   @param: col -  column index
*   @returns: dhtmlXGridCellObject object (see its methods below)
*   @type: public
*   @topic: 4
*/
	cellById:function(row_id, col){
		return this.cells(row_id, col);
	},
/**
*   @desc: gets dhtmlXGridCellObject object (if no arguments then gets dhtmlXGridCellObject object of currently selected cell)
*   @param: row_id -  row id
*   @param: col -  column index
*   @returns: dhtmlXGridCellObject object (use it to get/set value to cell etc.)
*   @type: public
*   @topic: 4
*/
	cells:function(row_id, col){
		if (arguments.length == 0)
			return this.cells4(this.cell);
		else
			var c = this.getRowById(row_id);
		var cell = (c._childIndexes ? c.childNodes[c._childIndexes[col]] : c.childNodes[col]);
		return this.cells4(cell);
	},
	/**
	*   @desc: gets dhtmlXGridCellObject object
	*   @param: row_index -  row index
	*   @param: col -  column index
	*   @returns: dhtmlXGridCellObject object (see its methods below)
	*   @type: public
	*   @topic: 4
	*/
	cellByIndex:function(row_index, col){
		return this.cells2(row_index, col);
	},
	/**
	*   @desc: gets dhtmlXGridCellObject object
	*   @param: row_index -  row index
	*   @param: col -  column index
	*   @returns: dhtmlXGridCellObject object (see its methods below)
	*   @type: public
	*   @topic: 4
	*/
	cells2:function(row_index, col){
		var c = this.render_row(row_index);
		var cell = (c._childIndexes ? c.childNodes[c._childIndexes[col]] : c.childNodes[col]);
		return this.cells4(cell);
	},
	/**
	*   @desc: gets exCell editor for row  object and column id
	*   @type: private
	*   @topic: 4
	*/
	cells3:function(row, col){
		var cell = (row._childIndexes ? row.childNodes[row._childIndexes[col]] : row.childNodes[col]);
		return this.cells4(cell);
	},
	/**
	*   @desc: gets exCell editor for cell  object
	*   @type: private
	*   @topic: 4
	*/
	cells4:function(cell){
		var type = window["eXcell_"+(cell._cellType||this.cellType[cell._cellIndex])];

		if (type)
			return new type(cell);
	},	
	cells5:function(cell, type){
		var type = type||(cell._cellType||this.cellType[cell._cellIndex]);
	
		if (!this._ecache[type]){
			if (!window["eXcell_"+type])
				var tex = eXcell_ro;
			else
				var tex = window["eXcell_"+type];
	
			this._ecache[type]=new tex(cell);
		}
		this._ecache[type].cell=cell;
		return this._ecache[type];
	},
	dma:function(mode){
		if (!this._ecache)
			this._ecache={
			};
	
		if (mode&&!this._dma){
			this._dma=this.cells4;
			this.cells4=this.cells5;
		} else if (!mode&&this._dma){
			this.cells4=this._dma;
			this._dma=null;
		}
	},
	
	/**
	*   @desc: returns count of row in grid ( in case of dynamic mode it will return expected count of rows )
	*   @type:  public
	*	@returns: count of rows in grid
	*/	
	getRowsNum:function(){
		return this.rowsBuffer.length;
	},
	
	
	/**
	*   @desc: enables/disables mode when readonly cell is not available with tab 
	*   @param: mode - (boolean) true/false
	*   @type:  public
	*/
	enableEditTabOnly:function(mode){
		if (arguments.length > 0)
			this.smartTabOrder=convertStringToBoolean(mode);
		else
			this.smartTabOrder=true;
	},
	/**
	*   @desc: sets elements which get focus when tab is pressed in the last or first (tab+shift) cell 
	*   @param: start - html object or its id - gets focus when tab+shift are pressed in the first cell  
	*   @param: end - html object or its id - gets focus when tab is pressed in the last cell  
	*   @type:  public
	*/
	setExternalTabOrder:function(start, end){
		var grid = this;
		this.tabStart=( typeof (start) == "object") ? start : document.getElementById(start);
		this.tabStart.onkeydown=function(e){
			var ev = (e||window.event);
			ev.cancelBubble=true;
	
			if (ev.keyCode == 9){
				grid.selectCell(0, 0, 0, 0, 1);
	
				if (grid.cells2(0, 0).isDisabled()){
					grid._key_events["k9_0_0"].call(grid);
				}
				return false;
			}
		}
	
		this.tabEnd=( typeof (end) == "object") ? end : document.getElementById(end);
		this.tabEnd.onkeydown=function(e){
			var ev = (e||window.event);
			ev.cancelBubble=true;
	
			if ((ev.keyCode == 9)&&ev.shiftKey){
				grid.selectCell((grid.getRowsNum()-1), (grid.getColumnCount()-1), 0, 0, 1);
	
				if (grid.cells2((grid.getRowsNum()-1), (grid.getColumnCount()-1)).isDisabled()){
					grid._key_events["k9_0_1"].call(grid);
				}
				return false;
			}
		}
	},
	/**
	*   @desc: returns unique ID
	*   @type:  public
	*/	
	uid:function(){
		if (!this._ui_seed) this._ui_seed=(new Date()).valueOf();
		return this._ui_seed++;
	},
	/**
	*   @desc: clears existing grid state and load new XML
	*   @type:  public
	*/
	clearAndLoad:function(){
		var t=this._pgn_skin; this._pgn_skin=null;
		this.clearAll();
		this._pgn_skin=t;
		this.load.apply(this,arguments);
	},
	/**
	*   @desc: returns details about current grid state
	*   @type:  public
	*/
	getStateOfView:function(){
		if (this.pagingOn) 		
			return [this.currentPage, (this.currentPage-1)*this.rowsBufferOutSize, (this.currentPage-1)*this.rowsBufferOutSize+this.rowsCol.length, this.rowsBuffer.length ];
 		return [
            Math.floor(this.objBox.scrollTop/this._srdh),
			Math.ceil(parseInt(this.objBox.offsetHeight)/this._srdh),
			this.limit
			];
	}
}


/* just a merge test :: 80512 */		
//(c)dhtmlx ltd. www.dhtmlx.com