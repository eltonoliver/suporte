<?php

	$idSolicitacao = $this->uri->segment(3);

	$dados = $this->solicitacao_model->getSolicitacao($idSolicitacao);	

 ?>
<script type="text/javascript">
	var ajax_relation_url = 'http://localhost/suportehome/mensagem/ajax_relation';

</script>
<?php if($dados[0]->tipo == 1){ ?>
<div class="container">

<div> <h3> Solicitação N. <?php echo $dados[0]->id; ?>  </h3> </div>
	<p><strong> Patrimônio: </strong>	<?php echo $dados[0]->patrimonio; ?>  </p>
	<p><strong> Descrição do Equipamento: </strong>	<?php echo $dados[0]->descricao_equi; ?>  </p>
	<p><strong> Local do Serviço: </strong>	<?php echo $dados[0]->uni_nomecompleto; ?>  </p>
	<p><strong> Data da Solicitação: </strong>	<?php echo $dados[0]->data_solicitacao; ?>  </p>
	<p><strong> Situação: </strong>	<?php echo $dados[0]->nomeSituacao; ?>  </p>
</div>

  <?php echo $this->session->flashdata('msg'); ?> 

<form action="admin/mensagem/insert" method="post">

	<textarea id="field-mensagem" name="mensagem" class="texteditor" style="margin: 0px 0px 10px; width: 1184px; height: 53px;"></textarea><br>
	<input id="field-data" type="hidden" name="data" value="<?php echo date('d/m/Y'); ?>" />
	<input id="field-data" type="hidden" name="hora" value="<?php echo date('h:i:s'); ?>" /> 
	<input id="field-suporte_id" type="hidden" name="suporte_id" value="" />
	<input id="field-usuario_id" type="hidden" name="usuario_id" value="<?php echo $dados[0]->usuario_id ?>" />
	<input id="field-solicitacao_id" type="hidden" name="solicitacao_id" value="<?php echo $dados[0]->id; ?>" />

	<center><button id="button-save"  class="btn btn-warning" style="width:1000px;font-size:16px;"> Enviar  </button></center>
	
</form>	

<?php
		/*LISTA MENSAGEM*/
		$mensagens = $this->solicitacao_model->getForum($idSolicitacao);

?>
 <?php foreach ($mensagens as $value){  ?>
	<div class="alert alert-info">

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
	 <strong>Atualizado Por </strong> : <?php echo $value->usuario_id; ?> há 2 Dias.
		<br>
		<strong>Mensagem :</strong><p> <?php echo $value->mensagem;  ?></p> 
	</div>

<?php } ?>


 </div>



<?php }else{ ?>


<?php } ?>