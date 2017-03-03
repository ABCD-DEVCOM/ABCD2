/************************************************************************************************************
(C) www.dhtmlgoodies.com, March 2006

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Version:
    1.0    Released    March. 3rd 2006

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/

var flyingSpeed = 25;
var url_addProductToBasket = '../php/decsBasketAdd.php';
var url_removeProductFromBasket = '../php/decsBasketDel.php';
var url_updateQuery = '../php/decsBasketSearch.php';
var txt_totalPrice = 'Total: ';


var shopping_cart_div = false;
var flyingDiv = false;
var currentProductDiv = false;

var shopping_cart_x = false;
var shopping_cart_y = false;

var slide_xFactor = false;
var slide_yFactor = false;

var diffX = false;
var diffY = false;
var _index = 0;
var currentXPos = false;
var currentYPos = false;

var ajaxObjects = new Array();


function shoppingCart_getTopPos(inputObj)
{
  var returnValue = inputObj.offsetTop;
  while((inputObj = inputObj.offsetParent) != null){
      if(inputObj.tagName!='HTML')returnValue += inputObj.offsetTop;
  }
  return returnValue;
}

function shoppingCart_getLeftPos(inputObj)
{
  var returnValue = inputObj.offsetLeft;
  while((inputObj = inputObj.offsetParent) != null){
      if(inputObj.tagName!='HTML')returnValue += inputObj.offsetLeft;
  }
  return returnValue;
}


function addToBasket(productId,productName,productOptions)
{
    if(!shopping_cart_div)shopping_cart_div = document.getElementById('shopping_cart');
    if(!flyingDiv){
        flyingDiv = document.createElement('DIV');
        flyingDiv.style.position = 'absolute';
        document.body.appendChild(flyingDiv);
    }

    shopping_cart_x = shoppingCart_getLeftPos(shopping_cart_div);
    shopping_cart_y = shoppingCart_getTopPos(shopping_cart_div);

    currentProductDiv = document.getElementById('slidingProduct' + productId);

    currentXPos = shoppingCart_getLeftPos(currentProductDiv);
    currentYPos = shoppingCart_getTopPos(currentProductDiv);

    diffX = shopping_cart_x - currentXPos;
    diffY = shopping_cart_y - currentYPos;

    var shoppingContentCopy = currentProductDiv.cloneNode(true);
    shoppingContentCopy.id='';
    flyingDiv.innerHTML = '';
    flyingDiv.style.left = currentXPos + 'px';
    flyingDiv.style.top = currentYPos + 'px';
    flyingDiv.appendChild(shoppingContentCopy);
    flyingDiv.style.display='block';
    flyingDiv.style.width = currentProductDiv.offsetWidth + 'px';
    flyToBasket(productId,productName,productOptions);

}


function flyToBasket(productId,productName,productOptions)
{
    var maxDiff = Math.max(Math.abs(diffX),Math.abs(diffY));
    var moveX = (diffX / maxDiff) * flyingSpeed;;
    var moveY = (diffY / maxDiff) * flyingSpeed;

    currentXPos = currentXPos + moveX;
    currentYPos = currentYPos + moveY;

    flyingDiv.style.left = Math.round(currentXPos) + 'px';
    flyingDiv.style.top = Math.round(currentYPos) + 'px';


    if(moveX>0 && currentXPos > shopping_cart_x){
        flyingDiv.style.display='none';
    }
    if(moveX<0 && currentXPos < shopping_cart_x){
        flyingDiv.style.display='none';
    }

    if(flyingDiv.style.display=='block')setTimeout('flyToBasket("' + productId + '","' + productName + '","' + productOptions + '")',10); else ajaxAddProduct(productId,productName, productOptions);
}

function showAjaxBasketContent(ajaxIndex)
{
    // Getting a reference to the shopping cart items table
    var itemBox = document.getElementById('shopping_cart_items');
    var productItems = ajaxObjects[ajaxIndex].response.split('|||');    // Breaking response from Ajax into tokens


    if(document.getElementById('shoping_cart_items_product' + productItems[0])){    // A product with this id is allready in the basket - just add number items
        var row = document.getElementById('shoping_cart_items_product' + productItems[0]);
        var items = row.cells[0].innerHTML /1;
        items = items + 1;
        //row.cells[0].innerHTML = items;
    }else{    // Product isn't allready in the basket - add a new row

        var totalRows = itemBox.rows.length;
        var evenOdd = (totalRows % 2 == 0 ? 'oddLine' : 'evenLine');

        var tr = itemBox.insertRow(-1);
        tr.id = 'shoping_cart_items_product' + productItems[0];
        tr.className = evenOdd;

        var td = tr.insertCell(-1);
        td.width = 20;
        td.innerHTML = '<a href="#" onclick="removeProductFromBasket(\'' + productItems[0] + '\');return false;"><span>X</span></a>';

        var td = tr.insertCell(-1);
        td.width = 20;
        if (productItems[2].indexOf('Q') !=-1){
            td.innerHTML = '<a href="#" onclick="selectTermQualifier(\'' + productItems[0] + '\');return false;"><span>Q</span></a>';
        }

        var td = tr.insertCell(-1);
        td.width = 20;
        if (productItems[2].indexOf('Ex') !=-1){
            td.innerHTML = '<a href="#" onclick="selectTermExplode(\'' + productItems[0] + '\');return false;"><span>Ex</span></a>';
        }

        var td = tr.insertCell(-1);
        td.innerHTML = productItems[1];     // Description
        /*
        var td = tr.insertCell(-1);
        td.style.textAlign = 'right';
        td.innerHTML = productItems[2];     // Price
        */
    }

    showHideSearchOptions();

    ajaxObjects[ajaxIndex] = false;

}


function removeProductFromBasket(productId)
{
    var productRow = document.getElementById('shoping_cart_items_product' + productId);
    productRow.parentNode.removeChild(productRow);

    showHideSearchOptions();
    ajaxRemoveProduct(productId);

}

function updateQuery(ajaxIndex)
{
    var expression = document.getElementById('expression');
    var basketQuery = ajaxObjects[ajaxIndex].response;

    expression.value = basketQuery;
    document.send2search.submit();
}

function ajaxUpdateQuery()
{
    var connector = document.send2search.connector.value;
    var ajaxIndex = ajaxObjects.length;
    ajaxObjects[ajaxIndex] = new sack();
    ajaxObjects[ajaxIndex].requestFile = url_updateQuery + '?connector=' + connector;
    ajaxObjects[ajaxIndex].onCompletion = function(){ updateQuery(ajaxIndex); };    // Specify function that will be executed after file has been found
    ajaxObjects[ajaxIndex].runAJAX();        // Execute AJAX function

}

function ajaxValidateRemovedProduct(ajaxIndex)
{
    if(ajaxObjects[ajaxIndex].response!='OK')alert('Error while removing product from the database');

}

function ajaxRemoveProduct(productId)
{
    var ajaxIndex = ajaxObjects.length;
    ajaxObjects[ajaxIndex] = new sack();
    ajaxObjects[ajaxIndex].requestFile = url_removeProductFromBasket + '?productIdToRemove=' + productId;    // Saving product in this file
    ajaxObjects[ajaxIndex].onCompletion = function(){ ajaxValidateRemovedProduct(ajaxIndex); };    // Specify function that will be executed after file has been found
    ajaxObjects[ajaxIndex].runAJAX();        // Execute AJAX function
}

function ajaxAddProduct(productId,productName,productOptions)
{
    var ajaxIndex = ajaxObjects.length;
    ajaxObjects[ajaxIndex] = new sack();
    ajaxObjects[ajaxIndex].requestFile = url_addProductToBasket + '?productId=' + productId + '&productName=' + productName + '&productOptions=' + productOptions;    // Saving product in this file
    ajaxObjects[ajaxIndex].onCompletion = function(){ showAjaxBasketContent(ajaxIndex); };    // Specify function that will be executed after file has been found
    ajaxObjects[ajaxIndex].runAJAX();        // Execute AJAX function
}

function showHideSearchOptions()
{
    var searchButtonEnabled = document.getElementById('searchButtonEnabled');
    var searchButtonDisabled = document.getElementById('searchButtonDisabled');
    var emptyListRow = document.getElementById('shoping_cart_items_product0');

    var itemBox = document.getElementById('shopping_cart_items');

    if (itemBox.rows.length == 1){
        searchButtonEnabled.style.display = "none";
        searchButtonDisabled.style.display = "block";
        emptyListRow.style.display = "block";
    }

    if (itemBox.rows.length >= 2){
        searchButtonEnabled.style.display = "block";
        searchButtonDisabled.style.display = "none";
        emptyListRow.style.display = "none";
    }
}
