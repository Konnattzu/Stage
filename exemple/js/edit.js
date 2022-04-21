
        //
        $(document).ready(function(){
            $('.editline').css("display", "none");
            $('.editbtn').css("display", "none");
            $('.savebtn').css("display", "none");
			var hoverelements = "";
			var clickelements = "";
			var editing = false;
			for(i=0;i<4;i++){
				hoverelements += '#line'+i+', ';
				clickelements += '#line'+i+' .editbtn, ';
			}
			hoverelements = hoverelements.substring(0,hoverelements.length - 2);
			clickelements = clickelements.substring(0,clickelements.length - 2);
			$(hoverelements).hover(function(){
				if(editing == false){
					$(this).children('.editbtn').css("display", "");
				}
			},function(){
				if(editing == false){
					$(this).children('.editbtn').css("display", "none");
				}
			});
			$(clickelements).click(function(){
				if(editing == false){
					$(this).css("display", "none");
					$(this).parent().children('.savebtn').css("display", "");
					$(this).parent().children('.dataline').css("display", "none");
					$(this).parent().children('.editline').css("display", "");
					editing = true;
				}
			});
			
        });