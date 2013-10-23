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

<?php 

		/*LISTA MENSAGEM*/
		$mensagens = $this->solicitacao_model->getForum($idSolicitacao);		


?>
 <?php foreach ($mensagens as $value){  ?>

  	<?php 
		$nomeUser = "";
		$this->db->where('id',$value->usuario_id);
		$user = $this->db->get('usuarios')->result();

		
		if(!isset($user[0]->nome)){

			$this->db->where('usu_codusuario',$value->usuario_id);
		    $user = $this->db->get('db_base.usuario_usu')->result();
		    $nomeUser = $user[0]->usu_nomeusuario;
		}else{

			 $nomeUser = $user[0]->nome;
		}

	?>	
	<br><div class="alert alert-info">

	 <strong>Atualizado Por </strong> : <?php echo $nomeUser; ?> - <strong> <?php echo diasPostagem( $value->data ); ?></strong>
		<br>
		<strong>Mensagem :</strong><p> <?php echo $value->mensagem;  ?></p> 
	</div>

<?php } ?>



	<br>
	<?php echo $this->session->flashdata('mensagem'); ?>
	<center><h4> Chat Suporte </h4></center>

	<form action="<?php echo base_url(); ?>admin/cadastrarMensagem/" method="post">

		<textarea id="field-mensagem" name="mensagem" class="texteditor" style="margin: 0px 0px 10px; width: 1184px; height: 53px;"></textarea><br>
		<input id="field-data" type="hidden" name="data" value="<?php echo date('Y-m-d'); ?>" />
		<input id="field-suporte_id" type="hidden" name="suporte_id" value="<?php echo $this->session->userdata('usuario_id'); ?>" />		
		<input id="field-solicitacao_id" type="hidden" name="solicitacao_id" value="<?php echo $idSolicitacao; ?>" />
		<center><button id="button-save"  class="btn btn-warning" style="width:300px;font-size:16px;"> Enviar  </button></center>

	</form>

<?php } ?>

