<?php echo $this->session->flashdata('msg'); ?> 

<?php

echo $output;


?>

<?php 
/*****************************************
*TELA DO CHAT DE RETORNO
/*****************************************/		
	$controller =  $this->uri->rsegment(2);
	$action     =  $this->uri->rsegment(3);

	if($controller == 'atendimentos' && $action == 'read'){
?>

	<center><h4> Chat Suporte </h4></center>






<?php } ?>