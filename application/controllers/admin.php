<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller{	

	public function __construct(){

		parent::__construct();		
		$this->load->library('grocery_CRUD');
		$this->load->model('solicitacao_model');
		if(!$this->session->userdata('login')){

			redirect('http://portalsenac.am.senac.br/');

		}

	}


	public function atendimentos($id = null){

	  try{	
			
			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('admin/atendimentos'));
			$crud->set_theme('datatables');
			$crud->set_table('solicitacao');
			$crud->where('situacao_id', 1);
			$crud->set_relation('id_suporte','usuarios','nome');
			$crud->set_relation('situacao_id','situacao','nome');	
			$crud->set_relation('prioridade_id','prioridade','nome');	
		
			$crud->set_relation('sistemas_id','sistemas','nome');
			$crud->set_relation('usuario_id','db_base.usuario_usu','usu_nomeusuario');
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			$crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_sis');
			$crud->columns('id','usuario_id','data_solicitacao','situacao_id','id_suporte','tipo');

			$crud->callback_column('tipo',array($this,'tipo_callback'));
			
			$crud->display_as('id','Código')
				 ->display_as('id_suporte','Nome do Suporte')
				 ->display_as('situacao_id','Situação')
				 ->display_as('data_solicitacao','Data de Solicitação')
				 ->display_as('usuario_id','Nome do usuário')
				 ->display_as('descricao_equi','Descrição do Equipamento')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço')
				 ->display_as('prioridade_id','Prioridade')
				 ->display_as('sistemas_id','Nome do Sistema')
				 ->display_as('patrimonio','Patrimônio');
			
			
			$crud->callback_field('data_solicitacao',array($this,'formatData'));
			$crud->field_type('id','readonly');
			//$crud->unset_back_to_list();	 
			$crud->unset_print();
			$crud->unset_add();
			$crud->unset_delete();
			
			/*STATE*/
			
			$state = $crud->getState();
    		$state_info = $crud->getStateInfo();
    		if($state == 'read'){

    			$idSolicitacao = $state_info->primary_key;
    			$tipo = $this->solicitacao_model->getTipoSolicitacao($idSolicitacao);

    			foreach ($tipo as $value) {
        			if($value->tipo == 2){
        				
        				$crud->fields('id','descricao_servico','anexo','data_solicitacao','situacao_id','id_suporte','sistemas_id','usuario_id');        				

        			}else{
        				$crud->fields('id','local_servico','descricao_equi','descricao_servico','patrimonio','data_solicitacao','situacao_id','id_suporte','usuario_id');
        			}
        		}

    		}elseif($state == 'edit'){
    				$idSolicitacao = $state_info->primary_key;
    			$tipo = $this->solicitacao_model->getTipoSolicitacao($idSolicitacao);

    			foreach ($tipo as $value) {
        			if($value->tipo == 2 || $value->tipo == 1 ){
        				
        				$crud->edit_fields('id','id_suporte');   				

        			}
        		}
    		}
    		/*END STATE*/

    		/*ACTIONS*/
    		
    		$crud->callback_after_update(array($this, 'msgUpdate'));
    		//$crud->callback_column('Mensagem',array($this,'callback_forum'));
    		$crud->add_action('Assumir Atendimento', '', 'admin/assumirAtendimento','ui-icon ui-icon-circle-check');
    		
    		/*END ACTIONS*/	
			$crud->order_by('id','desc');
			
			$output = $crud->render();

			$this->template->load('home','templates/view_atendimento',$output);

		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());

		}
	}

	public function historicoAtendimento(){


		try{	
			
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('solicitacao');
			$crud->where('situacao_id', 3);
			$crud->set_relation('id_suporte','usuarios','nome');
			$crud->set_relation('situacao_id','situacao','nome');	
			$crud->set_relation('prioridade_id','prioridade','nome');	
		
			$crud->set_relation('sistemas_id','sistemas','nome');
			$crud->set_relation('usuario_id','db_base.usuario_usu','usu_nomeusuario');
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			$crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_sis');
			$crud->columns('id','usuario_id','data_solicitacao','situacao_id','id_suporte','tipo');

			$crud->callback_column('tipo',array($this,'tipo_callback'));
			
			$crud->display_as('id','Código')
				 ->display_as('id_suporte','Nome do Suporte')
				 ->display_as('situacao_id','Situação')
				 ->display_as('data_solicitacao','Data de Solicitação')
				 ->display_as('usuario_id','Nome do usuário')
				 ->display_as('descricao_equi','Descrição do Equipamento')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço')
				 ->display_as('prioridade_id','Prioridade')
				 ->display_as('sistemas_id','Nome do Sistema')
				 ->display_as('patrimonio','Patrimônio');
			
			
			$crud->callback_field('data_solicitacao',array($this,'formatData'));
			$crud->field_type('id','readonly');
			//$crud->unset_back_to_list();	 
			$crud->unset_print();
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			
			/*STATE*/
			
			$state = $crud->getState();
    		$state_info = $crud->getStateInfo();
    		if($state == 'read'){

    			$idSolicitacao = $state_info->primary_key;
    			$tipo = $this->solicitacao_model->getTipoSolicitacao($idSolicitacao);

    			foreach ($tipo as $value) {
        			if($value->tipo == 2){
        				
        				$crud->fields('id','descricao_servico','anexo','data_solicitacao','situacao_id','id_suporte','sistemas_id','usuario_id');        				

        			}else{
        				$crud->fields('id','local_servico','descricao_equi','descricao_servico','patrimonio','data_solicitacao','situacao_id','id_suporte','usuario_id');
        			}
        		}

    		}
    		/*END STATE*/    	
    		
    		/*END ACTIONS*/	
			$crud->order_by('id','desc');
			
			$output = $crud->render();

			$this->template->load('home','templates/view_historico',$output);

		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());

		}
	}	


	

	/*CADASTRAR USUÁRIOS*/

	public function cadastrarUsuarios(){
		try{

			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('admin/cadastrarUsuarios'));
			$crud->set_theme('datatables');
			$crud->set_table('usuarios');
			$crud->columns('id','nome','login','email','status_id');
			
			$crud->field_type('status_id', 'hidden', 1);

			$crud->display_as('nome','Nome')
				 ->display_as('login','Login')
				 ->display_as('email','E-mail');
			$crud->unset_print();	 
		    $crud->callback_column('status_id',array($this,'status_callback'));	
			$output = $crud->render();

			$this->template->load('home','templates/view_frm_usuarios',$output);
		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());	

		}
		

	}
	/*CADASTRO DE DÚVIDAS*/

	public function cadastrarDuvidas(){
		try{

			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('admin/cadastrarDuvidas'));
			$crud->set_theme('datatables');
			$crud->set_table('duvidas');
			$crud->columns('id','titulo','conteudo');
			

			$crud->display_as('titulo','Título')
				 ->display_as('conteudo','Conteúdo');
				 
			$crud->unset_print();	 
		    $crud->callback_column('status_id',array($this,'status_callback'));	
			$output = $crud->render();

			$this->template->load('home','templates/view_frm_usuarios',$output);
		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());	

		}
		

	}

	public function cadastrarSistemas(){
		try{

			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('admin/cadastrarSistemas'));
			$crud->set_theme('datatables');
			$crud->set_table('sistemas');
			$crud->columns('id','nome','descricao');
			

			$crud->display_as('id','Código')
				 ->display_as('nome','Nome do Sistema')
				 ->display_as('descricao','Descrição do Sistema');
				 
			$crud->unset_print();		
			$output = $crud->render();

			$this->template->load('home','templates/view_sistemas',$output);
		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());	

		}
		

	}

	public function cadastrarNoticia(){

		try{

			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('admin/cadastrarNoticia'));
			$crud->set_theme('datatables');
			$crud->set_table('noticia');			
			$crud->columns('id','titulo','descricao');
			$crud->fields('titulo','descricao');
			$crud->required_fields('titulo','descricao');
			$crud->callback_after_update(array($this, 'data_noticia'));
			$output = $crud->render();

			$this->template->load('home','templates/view_noticia',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());

		}
	}


	public function cadastrarMensagem(){
		try{
			$idSolicitacao =  $this->input->post('solicitacao_id');
			$dados = array(

				'mensagem' 		 => $this->input->post('mensagem'),
				'data'	  		 => $this->input->post('data'),
				'usuario_id'	 => $this->input->post('suporte_id'),
				'solicitacao_id' => $idSolicitacao


				);

			if(!$this->solicitacao_model->addForum($dados)){

				throw new Exception("Erro ao inserir mensagem");				

			}

			$msg = '<div class="alert alert-success">Mensagem enviada! <button type="button" class="close" data-dismiss="alert">×</button></div>';

			$this->session->set_flashdata('mensagem',$msg);
			redirect("admin/atendimentos/read/".$idSolicitacao);

		
		}catch(Exception $e){

			$msg = '<div class="alert alert-error">'.$e->getMessage().'<button type="button" class="close" data-dismiss="alert">×</button></div>';
			$this->session->set_flashdata('mensagem',$msg);
			redirect("admin/atendimentos/read/".$idSolicitacao);

		}	

	}


	public function relatorio(){
			$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
			$this->template->load('home','templates/view_relatorio',$output);		
	}

	public function gerarRelatorio(){
		
		$nomeReport = "relatorio";

		$tecnico  	= $this->input->post('tecnico');
		$tipo     	= $this->input->post('tipo');
		$situacao 	= $this->input->post('situacao');
		$dataInicio = formatDataMysql($this->input->post('dataInicio'));
		$dataFim 	= formatDataMysql($this->input->post('dataFim'));

	

		if($tecnico !="Todos"){

			$andtecnico = " AND suporte.solicitacao.id_suporte = ".$tecnico;
		}else{
			$andtecnico ="";
		}

		if($tipo != "Todos"){
			$andtipo = " AND suporte.solicitacao.tipo = ".$tipo;

		}else{
			$andtipo = "";
		}

		if($situacao != "Todas"){

			$andsituacao = " AND suporte.solicitacao.situacao_id = ".$situacao;
		}else{
			$andsituacao = "";
		}

		if($dataInicio != "" && $dataFim != ""){

			$andData = " AND suporte.solicitacao.data_solicitacao >= '".$dataInicio."' AND  suporte.solicitacao.data_finalizacao <= '".$dataFim."'";
		}elseif($dataInicio != "" && $dataFim == ""){
			$andData = " AND suporte.solicitacao.data_solicitacao >= '".$dataInicio."'";
		}elseif($dataInicio == "" && $dataFim == ""){
			$andData = "";
		}

		$report = $this->db->query(
			'SELECT
				suporte.solicitacao.id,
				suporte.usuarios.nome as suporteNome,
				db_base.unidade_uni.uni_nomecompleto as localServico,
				suporte.situacao.nome as situacao,
				suporte.situacao.id as idSituacao,
				db_base.usuario_usu.usu_loginusuario as nomeUsuario,
				suporte.solicitacao.tipo,
				suporte.solicitacao.data_solicitacao,
				suporte.solicitacao.data_finalizacao
			FROM
				suporte.solicitacao
				Left Join db_base.unidade_uni ON suporte.solicitacao.local_servico = db_base.unidade_uni.uni_codunidade
				Left Join suporte.usuarios ON suporte.solicitacao.id_suporte = suporte.usuarios.id
				Left Join suporte.situacao ON suporte.solicitacao.situacao_id = suporte.situacao.id
				Inner Join db_base.usuario_usu ON suporte.solicitacao.usuario_id = db_base.usuario_usu.usu_codusuario'.$andtecnico.$andtipo.$andsituacao.$andData

		)->result();

		$conteudo = "";
		$chamado = 0;
		$chamadoAberto = 0;
		$chamadoFechado = 0;
		$reg = 0;
		foreach ($report as $value) {
			$reg++;
			$chamado++;
			if($value->idSituacao == 1){
				$chamadoAberto++;
			}

			if($value->idSituacao == 3){
				$chamadoFechado++;
			}

			($value->suporteNome == "") ? $value->suporteNome = "Em aberto" : $value->suporteNome;
			($value->data_finalizacao == "") ? $value->data_finalizacao = "Em aberto" : formatDataBrasil($value->data_finalizacao);

			$conteudo .= '
							<tr>
									<td><center>'.$value->id.'</center></td>
									<td><center>'.$value->nomeUsuario.'</center></td>
									<td><center>'.$value->localServico.'</center></td>
									<td><center>'.formatDataBrasil($value->data_solicitacao).'</center></td>
									<td><center>'.$value->data_finalizacao.'</center></td>
									<td><center>'.$value->suporteNome.'</center></td>
									<td><center>'.$value->situacao.'</center></td>
									
								</tr>';
		}
		

				$html =  '
					<script type="text/javascript" src="'.base_url().'assets/js/jquery.min.js"></script>
					<script type="text/javascript" src="'.base_url().'assets/js/custom.js"></script>
					<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
					<style> 
						h4{
							font-family: Arial;
						}
						table th{

							border: 1px solid black;
							border-collapse: collapse;

						}table td{
							border: 1px solid black;
							border-collapse: collapse;
						}
					 </style>	
				

						<center><h4> Relatório - Sistema de Suporte </h4></center>


						<center><table style="height: 96px;font-family: Arial;border: 1px solid black;" width="1000">
								<tbody>
								<tr>
									<td><strong><center>Código</center></strong></td>
									<td><strong><center>Nome do usuário</center></strong></td>
									<td><strong><center>Local do Serviço</center></strong></td>
									<td><strong><center>Data Solicitação</center></strong></td>
									<td><strong><center>Data Finalização</center></strong></td>
									<td><strong><center>Nome do Suporte</center></strong></td>
									<td><strong><center>Situação</center></strong></td>
									
								</tr>
								'.$conteudo.'	
								
								
								</tbody>
						</table>
						</center>
						<br>

						<div style="margin: 0 auto; width: 1000px;font-family: Arial">
						<strong>Quantidade de Registros : </strong>'.$reg.'<br>
						<strong>Quantidade de Chamados : </strong> '.$chamado.' <br>
						<strong>Quantidade de Chamados Abertos: </strong> '.$chamadoAberto.' <br>
						<strong>Quantidade de Chamados Finalizados:</strong>  '.$chamadoFechado.' <br>
						</div>

						<br>
						<center> <img src="'.base_url().'assets/images/print.png" style="cursor:pointer" class="imprimir"/> </center>

					 ';

		
			echo $html;		 

		
	}

	public function tipo_callback($value,$row){
		if($row->tipo == 1){

			$value = "Equipamentos";

		}else{

			$value = "Sistemas";
		}

		return $value;

	}

	/*VERIFICA AO LISTAR OS DADOS*/
	public function status_callback($value,$row){
		if($row->status_id == 1){

			$value = "Ativo";

		}else{

			$value = "Inativo";
		}

		return $value;

	}

	/*CALLBACK ASSUMIR ATENDIMENTO*/

	public function assumirAtendimento($id = null){
		try{
			$dados = array('id_suporte' => $this->session->userdata('suporte_id'));
			if(!$this->solicitacao_model->update($id,$dados)){

				throw new Exception("Você já é responsável por este atendimento!");
				
			}


			$this->db->where('id',$id);
			$this->db->select('usuario_id');
			$idUser = $this->db->get('solicitacao')->result();



			$this->db->where('emus_codusuario',$idUser[0]->usuario_id);
		    $user = $this->db->get('db_base.emailusuario_emus')->result();
		    $emailUser = $user[0]->emus_email;


		    		        $this->db->where('id', $this->session->userdata('suporte_id'));
		    			    $this->db->select('nome');
		    $suporte     =  $this->db->get('usuarios')->result();
		    $nomeSuporte =  $suporte[0]->nome;



					$mensagem = '
							
							<html>
							
							<body>
								<div style="text-align: center;">
									<p style="text-align: left;">
										<span class="header" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);"><strong>MENSAGEM AUTOM&Aacute;TICA. POR FAVOR, N&Atilde;O RESPONDA ESSE E-MAIL.</strong><br />
										Para isso utilize a ferramenta de suporte <span class="Object" id="OBJ_PREFIX_DWT153_com_zimbra_url" style="color: rgb(51, 102, 153); cursor: pointer;"><a class="external" href="http://portalsenac.am.senac.br" style="color: rgb(51, 102, 153); text-decoration: none; cursor: pointer;" target="_blank">http://</a>portalsenac.am.senac.br</span><br />
										___<em>_</em>_____________________________________________________________________________________________</span></p>
									<p style="text-align: left;">
										<span style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);">O Técnico - ('.$nomeSuporte.') Assumiu seu chamado.</span></p>
									<ul style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);">
										<li style="text-align: left;">
											Data : &nbsp;'.date('d/m/Y').'</li>
											<li style="text-align: left;">
											Nº : &nbsp;'.$id.'</li>
									</ul>
								
										<span class="footer" style="font-size: 0.8em; font-style: italic; font-family: Helvetica, Arial, sans-serif; background-color: rgb(253, 253, 253);"><strong>ESTA &Eacute; UMA MENSAGEM AUTOM&Aacute;TICA. POR FAVOR, N&Atilde;O RESPONDA ESSE E-MAIL.</strong><br />
										Voc&ecirc; recebeu este e-mail porque voc&ecirc; est&aacute; inscrito na lista de suporte da Equipe GIC.<br />
										Para alterar suas configura&ccedil;&otilde;es por favor acess:&nbsp;<span class="Object" id="OBJ_PREFIX_DWT157_com_zimbra_url" style="color: rgb(51, 102, 153); cursor: pointer;"><a class="external" href="http://portal.am.senac.br" style="color: rgb(51, 102, 153); text-decoration: none; cursor: pointer;" target="_blank">http://portal.am.senac.br</a></span>.</span></p>
								</div>
								<p>
									&nbsp;</p>
							</body>
						</html>			
					
					
					
					
					';				
					
					
					$email = $emailUser;
					$assunto ="Chamado Nº ".$id;
					$config['charset'] = 'utf-8';

					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
					$this->email->initialize($config);

					$this->email->from($email, 'Sistema de Solicitação de Serviços');
					$this->email->to($email);				 
								
					$this->email->subject($assunto);
					$this->email->message($mensagem);	
					
					$this->email->send();









			$msg = '
				<script>
					alert("Você assumiu este atendimento!");
				</script>';
 				$this->session->set_flashdata('msg', $msg);
			
				redirect('admin/atendimentos/');
		}catch(Exception $e){

			$msg = '
				<script>
  					alert("'.$e->getMessage().'");
				</script>
			';
			$this->session->set_flashdata('msg', $msg); 
			redirect('admin/atendimentos/');
		}

	}


	/*CALLBACK MSG DE UPDATE*/
	public function msgUpdate($post_array,$primary_key){
    	
    	$dados = array('data_atualizacao' => date('Y-m-d h:i:s'));
    	$this->solicitacao_model->update($primary_key,$dados);	

 		$msg = '
				<script>
 						alert("Dados Atualizados!");
						
				</script>';
		
		$this->session->set_flashdata('msg', $msg); 
		
    	
	}

	/*CALLBACK EDIT SITUAÇÃO*/
	public function callback_forum($value,$row){
		$id = $row->id;
		$query = $this->solicitacao_model->getMensagemForum($id);
		if($query){

			return '<a href="'.base_url().'home/mensagem/'.$id.'">Ativo</a>';
		}else{

			return '';
		}

	}	

	
	/*FORMATAÇÃO DAS DATAS*/
	public function formatData($value, $primary_key = null){
		return formatDataBrasil($value);
	}


	public function data_noticia($postArray) {
		  	
		  $postArray['data'] = date('Y-m-d h:i:s');
		  return $postArray;
	}



 


}


?>
