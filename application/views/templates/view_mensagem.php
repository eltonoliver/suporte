<?php 


	$idSolicitacao = $this->uri->segment(3);

	$dados = $this->solicitacao_model->getSolicitacao($idSolicitacao);
	//echo '<pre>';
	/*foreach ($dados as $value) {

		print_r($value);
	}*/


 ?>

<?php if($dados[0]->tipo == 1){ ?>
<div class="flexigrid crud-form" style="width: 100%;" data-unique-hash="7c5cbd9895a5b928f7309dfabff909a0">

<div> <h3> Solicitação N. <?php echo $dados[0]->id; ?>  </h3> </div>
<p><strong> Patrimônio: </strong>	<?php echo $dados[0]->patrimonio; ?>  </p>
<p><strong> Descrição do Equipamento: </strong>	<?php echo $dados[0]->descricao_equi; ?>  </p>
<p><strong> Local do Serviço: </strong>	<?php echo $dados[0]->uni_nomecompleto; ?>  </p>
<p><strong> Data da Solicitação: </strong>	<?php echo $dados[0]->data_solicitacao; ?>  </p>
<p><strong> Situação: </strong>	<?php echo $dados[0]->nomeSituacao; ?>  </p>
</div>




<?php }else{ ?>

	

	sistemas



<?php } ?>