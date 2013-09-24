<?php 


	$idSolicitacao = $this->uri->segment(3);

	$dados = $this->solicitacao_model->getSolicitacao($idSolicitacao);
	echo "<pre>";
	print_r($dados);



 ?>

 <div> <h3> Solicitação N. <?php echo $dados[0]->id; ?>  </h3> </div>
