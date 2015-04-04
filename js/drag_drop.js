var tw_drag = function(object){
	this.drag_drop = document.getElementById(object.droppable);
	this.item = document.getElementsByClassName(object.draggable);
	if(this.item[0].getElementsByTagName('li') != null){
		this.item = this.item[0].getElementsByTagName('li');
	}
	
	this.total_drags = [];
    this.menu_item = [];
    
    this.draggable_objects = [];
    this.droppable = document.getElementById('drop');
    this.curr_object = null;
	
	this.draggable = [];
	
	this.tw_mouse_move = function(el){
    	if(this.curr_object != null){
    		this.curr_object.style.top = el.clientY-(this.curr_object.offsetHeight/2);
    		this.curr_object.style.left = el.clientX-(this.curr_object.offsetWidth/2);
    	}
    }
    
   	this.tw_removeListener = function(el){
    	if(this.curr_object != null){
	    	var	index = this.curr_object.getAttribute('class').match(/drag_\d+/).toString().replace('drag_','');
	    	this.checkDroppable();
	        this.curr_object.style.top = this.draggable_objects[index].topL;
	       	this.curr_object.style.left = this.draggable_objects[index].leftL;
	       	this.curr_object.style.zIndex = 0;
	       	
	       	var width = this.curr_object.offsetWidth;
	       	var height = this.curr_object.offsetHeight;
	       	
	       	this.curr_object = null;
	       	
	       	if(typeof(tw_mouse_move)){
	        	document.removeEventListener('mousemove',this.tw_mouse_move);
	        	document.removeEventListener('mousedown',this.tw_mousedown);
	       	}
    	}
    }
    
    this.checkDroppable = function(self){
    	if(this.droppable.offsetWidth+this.droppable.offsetLeft >= this.curr_object.offsetLeft && this.curr_object.offsetLeft+this.curr_object.offsetWidth > this.droppable.offsetLeft){
    		if(this.droppable.offsetHeight+this.droppable.offsetTop >= this.curr_object.offsetTop && this.curr_object.offsetTop+this.curr_object.offsetHeight > this.droppable.offsetTop){
    			this.droppable.innerHTML += '<div class="item">'+this.curr_object.innerHTML+'</div>';
    			holder = this.droppable.getElementsByClassName('item');
    			for(var i = 0; i < holder.length; ++i){
    				if(holder[i].getAttribute('class').toString().match('drag_') != false){
    					holder[i].setAttribute('class',holder[i].getAttribute('class')+' drag_'+i);
    					holder[i].addEventListener('mousedown',function(e){ parent.tw_mousedown(e,self); });
    				}
    			}
    		}
    	}
    }
    
    this.tw_mousedown = function(el,self){
    	this.curr_object = el.target;
    	this.curr_object.style.position = 'absolute';
    	this.curr_object.style.zIndex = 1000;
    	self = this;
        document.addEventListener('mousemove',function(e){ self.tw_mouse_move(e,self); });
        document.addEventListener('mouseup',function(e){ self.tw_removeListener(e,self); });
    }
	
	this.create_draggable = function(object){
		object.parent = this;
		object.draggable = this.item;
		var draggable = new drag_objects(object);
		this.draggable[draggable.length] = {'draggable_object':draggable};
	}
	
	if(object != null){
		this.create_draggable(object);
	}
}

drag_objects = function(object){
	item = object.draggable;
	parent = object.parent;
   	this.prevHeight = 0;
   	
   	this.animation = function(el){
    	this.object = el;
    	this.startPosition = {'left':el.offsetLeft,'top':el.offsetTop};
    	this.timeout = setTimeout(function(){  },0);
    	
    	var self = this;
    	
    	this.animate = function(){
	        this.object.style.left = this.startPosition.left;
	        this.object.style.top = this.startPosition.top;
    	}
    }
   	
    for(var i = 0; i < item.length; ++i){
        if(item[i].addEventListener != undefined){
        	item[i].style.position = 'absolute';
            parent.draggable_objects[i] = {'object':item[i],'topL':item[i].offsetTop+(this.prevHeight),'leftL':item[i].offsetLeft,'index':i};
           	
            this.prevHeight = this.prevHeight+item[i].offsetHeight;
            item[i].item = this;
            self = this;
            item[i].addEventListener('mousedown',function(e){ parent.tw_mousedown(e,self); });
            item[i].style.top = parent.draggable_objects[i].topL;
            item[i].style.left = parent.draggable_objects[i].leftL;
            item[i].setAttribute('class',item[i].getAttribute('class')+' drag_'+i);
            
            if(item[i].getAttribute('class') == null){
            	item[i].setAttribute('class',item[i].getAttribute('class')+' draggable');
            }
        }
    }
}