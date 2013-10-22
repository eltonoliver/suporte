
		
	<div class="row">
		<div class="span12">
			
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
	
	