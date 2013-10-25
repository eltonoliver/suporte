$(function(){

	$(".finalizar").live('click',function(){

		var finalizar = confirm("Deseja finalizar este atendimento?")
        if(finalizar){         
                            
          return true;
        }else{ 
             
            return false;
         
          }
	});

});