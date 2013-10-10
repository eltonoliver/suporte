<?php 
$verifica = $this->solicitacao_model->verificaSolicitacoes($this->sessionUsuario, 1 , 1);
 if($verifica < 4){
	echo $output;
 
}else{


	echo '<div class="alert alert-block">
			  <button type="button" class="close" data-dismiss="alert">×</button>
			  <center><h4>Advertência!</h4></center>
			<center> Excedeu o limite de chamados relacionado a equipamentos! </center>
		</div>'.br(15);
}
 ?>