//alert('yes');

function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

function tothebasket(act, id) {
    var req = getXmlHttp();
    // в нем будем отображать ход выполнения
    //var statusElem = document.getElementById('vote_status');
	
    req.onreadystatechange = function() { 
        // onreadystatechange активируется при получении ответа сервера 
        if (req.readyState == 4) {
            // если запрос закончил выполняться
            //statusElem.innerHTML = req.statusText // показать статус (Not Found, ОК..) 
            if(req.status == 200) {
				//alert(req.responseText);
				if (act==0){
				//alert("Ответ сервера: "+req.responseText);
				//if (document.getElementById('basketbutton').value=="В корзину"){
					num=req.responseText;
					//alert(num);
					document.getElementById('basketbutton').value="("+num+" шт.) Еще";
					document.getElementById('basketbutton').style.backgroundColor="#00FF00";
				//}
				/*
				else{
					document.getElementById('basketbutton').value="В корзину";
					document.getElementById('basketbutton').style.backgroundColor="#FFFF00";
				}
				*/
				}
				else if(act==1){
					if (req.responseText==0){
						document.getElementById("content").innerHTML="<div>В вашей корзине нет товаров.</div>";
					}
					else{
						var node = document.getElementById("tr"+id);
						node.parentNode.removeChild(node);
					}
				}
            }
            // тут можно добавить else с обработкой ошибок запроса
        }
    }
    req.open('GET', '/modules/components/<?php echo $this->component_name;?>/front_end/tothebasket.php?act='+act+'&id='+id, true); 
    req.send(null);  // отослать запрос	
	//statusElem.innerHTML = 'Ожидаю ответа сервера...';
}
