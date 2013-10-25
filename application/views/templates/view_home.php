
		
	<div class="row">
		<div class="span12">
		 <!-- CHAMADOS ABERTOS E MENSGENS -->	
		  <?php 
				  	
				  		$this->db->where('usuario_id',$this->session->userdata('usuario_id'));
				  		$this->db->where('situacao_id',1);				  		
				  		$this->db->get('solicitacao')->result();
						$contaReg = $this->db->affected_rows();

						if($contaReg > 1){

							$msg = "Você tem ".$contaReg." chamados em aberto,";
						}else{

							$msg = "Você tem ".$contaReg." chamado em aberto,";
						}

						

		   ?>
		   <?php if($contaReg > 0){ ?>
			<div class="alert alert-error">
  				<button type="button" class="close" data-dismiss="alert">×</button>
				  <center><h4> Aviso! </h4></center>
				 
				  	<p><a href="<?php echo base_url(); ?>home/minhas-solicitacoes/" style="color:#b94a6c"><?php echo $msg; ?> caso já tenha sido atendido favor clicar em finalizar.</a> </p>


				 
			</div>
			<?php } ?>
		 <!-- FIM CHAMADOS  -->	
				<center>

					<img src="<?php echo base_url(); ?>assets/images/logo-suporte.png" width="200"><br />
					<span class="logo-suporte"> Módulo de Serviços Gic </span>	
					<marquee direction="right" onmouseover="this.stop()" onmouseout="this.start()">
					<div id="div-noticia" >
							
						<ul>
							<?php 

								$dados = $this->db->get('noticia')->result();
								foreach ($dados as $value) {
									echo '

										<li class="alert alert-info">
											<h4>'.$value->titulo.'</h4>
											<p>'.$value->descricao.'</p>

										</li >
									';
								}

							 ?>
						</ul>
						

					</div>
					 </marquee>
				</center>
				
			<?php echo br(15); ?>
		</div>
	</div>
	
	