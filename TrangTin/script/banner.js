
		window.onload=function(){
			setTimeout("switchImage()",3000);
		}
		var current=0;
		var numIMG=2;
		function switchImage(){
			current++;
			document.images['myimage'].src='image/banner' +current+'.png';
			if(current==numIMG){
				current=0;
			}
			setTimeout("switchImage()",3000);
		}
