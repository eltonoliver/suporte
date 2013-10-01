
<?php 
$verifica = $this->solicitacao_model->verificaSolicitacoes($this->sessionUsuario, 1 , 1);
if($verifica < 1){
	echo $output;

}else{

	echo '<div class="alert alert-block">
			  <button type="button" class="close" data-dismiss="alert">×</button>
			  <h4>Advertência!</h4>
			<center> Você já efetuou um chamado relacionado a equipamentos! </center>
		</div>'.br(15);
}
 ?>