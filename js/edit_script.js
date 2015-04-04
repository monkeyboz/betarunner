var g = document.getElementById('overlay');
var l = document.getElementsByClassName('action');
for(var i = 0; i < l.length; ++i){
    var h = l[i].getElementsByTagName('a')[0];
    h.onclick = function(){
        loadXMLDoc(link,g);
        return false;
    }
}

function loadXMLDoc(url,element){
    var xmlhttp;
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            element.style.display = 'block';
            document.getElementsByClassName('form_holder')[0].style.display = 'block';
            
            element.getElementsByClassName('form_holder')[0].innerHTML = xmlhttp.responseText;
            
            document.getElementsByClassName('form_holder')[0].onclick = function(el){
                el.stopPropagation();
            }
            
            document.getElementById('overlay').onclick = function(el){
                el.target.style.display = 'none';
            }
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}