<?php echo $this->session->flashdata('msg'); ?> 

<?php

echo $output;


?>

<?php 

/*****************************************
*TELA DO CHAT DE RETORNO
/*****************************************/		
	$controller 	=  $this->uri->rsegment(2);
	$action     	=  $this->uri->rsegment(3);
	$idSolicitacao  =  $this->uri->rsegment(4);

	if($controller == 'atendimentos' && $action == 'read'){
?>
	<br>
	<?php echo $this->session->flashdata('msg'); ?>
	<center><h4> Chat Suporte </h4></center>

	<form action="<?php echo base_url(); ?>admin/cadastrarMensagem/" method="post">

		<textarea id="field-mensagem" name="mensagem" class="texteditor" style="margin: 0px 0px 10px; width: 1184px; height: 53px;"></textarea><br>
		<input id="field-data" type="hidden" name="data" value="<?php echo date('Y-m-d'); ?>" />
		<input id="field-suporte_id" type="hidden" name="suporte_id" value="<?php echo $this->session->userdata('usuario_id'); ?>" />		
		<input id="field-solicitacao_id" type="hidden" name="solicitacao_id" value="<?php echo $idSolicitacao; ?>" />
		<center><button id="button-save"  class="btn btn-warning" style="width:300px;font-size:16px;"> Enviar  </button></center>

	</form>

<?php } ?>