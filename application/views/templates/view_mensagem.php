<?php 


	$idSolicitacao = $this->uri->segment(3);

	$dados = $this->solicitacao_model->getSolicitacao($idSolicitacao);
	echo '<pre>';
	foreach ($dados as $value) {

		print_r($value);
	}


 ?>

 <div> <h3> Solicitação N. <?php echo $dados[0]->id; ?>  </h3> </div>
