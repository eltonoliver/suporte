<?php 
$verifica = $this->solicitacao_model->verificaSolicitacoes($this->sessionUsuario, 2 , 1);
 if($verifica < 4){
	echo $output;
 
}else{

	echo '<div class="alert alert-block">
			  <button type="button" class="close" data-dismiss="alert">×</button>
			  <h4>Advertência!</h4>
			<center> Você já efetuou um chamado relacionado a sistemas! </center>
		</div>'.br(15);
}
 ?>