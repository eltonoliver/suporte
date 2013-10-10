
		
	<div class="row">
		<div class="span12">
			
				<center>

					<img src="<?php echo base_url(); ?>assets/images/logo-suporte.png" width="400"><br />
					<span class="logo-suporte"> Módulo de Solicitação de Serviços </span>	
					<marquee>
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
	
	