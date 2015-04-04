function clickSetup(){
    var layout = document.getElementById('layout');
    var table = document.getElementById('content-query');
    table = table.getElementsByTagName('div');
    
    for(var i = 0; i < table.length; ++i){
        table[i].onclick = function(el){
            layout.innerHTML += '<div>'+el.target.innerHTML+'<span>delete</span></div>';
            el.target.remove();
            for(info in layout.getElementsByTagName('span')){
                if(layout.getElementsByTagName('span')[info].addEventListener != null){
                    layout.getElementsByTagName('span')[info].addEventListener('click',removeInfo);
                }
            }
        }
    }
}

function removeInfo(el){
    document.getElementById('content-query').innerHTML = '<div>'+el.target.parentNode.innerHTML.replace('<span>delete</span>','')+'</div>'+document.getElementById('content-query').innerHTML;
    el.target.parentNode.remove();
    clickSetup();
}