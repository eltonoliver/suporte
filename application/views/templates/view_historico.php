<?php

echo $output;


?>



<?php 

		
		$controller 	=  $this->uri->rsegment(2);
		$action     	=  $this->uri->rsegment(3);
		$idSolicitacao  =  $this->uri->rsegment(4);

		if($controller == 'historicoAtendimento' && $action == 'read'){

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




<?php } ?>

