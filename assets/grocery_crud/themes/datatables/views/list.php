<?php 
	/*UTILIZANDO O CORE DO CODEIGNITER*/
	$system_path = 'system';
	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}

	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}


	require_once BASEPATH.'core/CodeIgniter.php';


$CI =& get_instance();

$CI->load->database();

/*$query = $CI->db->get('usuarios')->result();

foreach ($query as  $value) {
	print_r($value);
}*/


?>


<table cellpadding="0" cellspacing="0" border="0" class="display groceryCrudTable" id="<?php echo uniqid(); ?>">
	<thead>
		<tr>
			<?php foreach($columns as $column){?>
				<th><?php echo $column->display_as; ?></th>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<th class='actions'><?php echo $this->l('list_actions'); ?></th>
			<?php }?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($list as $num_row => $row){ ?>
		<tr id='row-<?php echo $num_row?>'>
			<?php foreach($columns as $column){?>
				<td><?php echo $row->{$column->field_name}?></td>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<td class='actions'>
				<?php
				if(!empty($row->action_urls)){
					foreach($row->action_urls as $action_unique_id => $action_url){
						$action = $actions[$action_unique_id];

				?>		<!--ACTIONS -->
					<?php 
					       /**
					       *VERIFICA SE ESTÁ NO CONTROLLER MINHAS-SOLICITACOES PARA INSERIR AS REGRAS ABAIXO
					       *SE ÑENHUM TÉCNICO ESTIVER ASSUMINDO O ATENDIMENTO , O USUÁRIUO NÃO VAI PODER FINALIZAR
					       *O CHAMADO.
					       */
			        	   $controller  =  $CI->uri->segment(2);

	   						if($controller == "minhas-solicitacoes"){
				     			    $newUrl = explode('/', $action_url);
									
									$idChamado = $newUrl[6];

									$CI->db->where('id', $idChamado);
									$query = $CI->db->get('solicitacao')->result();

									$idSuporte = $query[0]->id_suporte;
									$situacao_id = $query[0]->situacao_id;
						
			         ?>
					 <?php if(isset($idSuporte) && $situacao_id != 3){ ?>
							<a href="<?php echo $action_url; ?>" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
								<span class="ui-button-icon-primary ui-icon <?php echo $action->css_class; ?> <?php echo $action_unique_id;?>"></span><span class="ui-button-text">&nbsp;<?php echo $action->label?></span>
							</a>
					 <?php } ?>	

					<?php }else{ /*LISTA NORMALMENTE*/ ?>			

							<a href="<?php echo $action_url; ?>" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
								<span class="ui-button-icon-primary ui-icon <?php echo $action->css_class; ?> <?php echo $action_unique_id;?>"></span><span class="ui-button-text">&nbsp;<?php echo $action->label?></span>
							</a>
							<!--END ACTIONS -->
				<?php }}/*FECHA CHAVE DO ACTION*/
				}
				?>
				<?php if(!$unset_read){?>
					<a href="<?php echo $row->read_url?>" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-document"></span>
						<span class="ui-button-text">&nbsp;<?php echo $this->l('list_view'); ?></span>
					</a>
				<?php }?>

				<?php if(!$unset_edit){?>
					<a href="<?php echo $row->edit_url?>" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span>
						<span class="ui-button-text">&nbsp;<?php echo $this->l('list_edit'); ?></span>
					</a>
				<?php }?>
				<?php if(!$unset_delete){?>
					<a onclick = "javascript: return delete_row('<?php echo $row->delete_url?>', '<?php echo $num_row?>')"
						href="javascript:void(0)" class="delete_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-circle-minus"></span>
						<span class="ui-button-text">&nbsp;<?php echo $this->l('list_delete'); ?></span>
					</a>
				<?php }?>
			</td>
			<?php }?>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<?php foreach($columns as $column){?>
				<th><input type="text" name="<?php echo $column->field_name; ?>" placeholder="<?php echo $this->l('list_search').' '.$column->display_as; ?>" class="search_<?php echo $column->field_name; ?>" /></th>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
				<th>
					<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only floatR refresh-data" role="button" data-url="<?php echo $ajax_list_url; ?>">
						<span class="ui-button-icon-primary ui-icon ui-icon-refresh"></span><span class="ui-button-text">&nbsp;</span>
					</button>
					<a href="javascript:void(0)" role="button" class="clear-filtering ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary floatR">
						<span class="ui-button-icon-primary ui-icon ui-icon-arrowrefresh-1-e"></span>
						<span class="ui-button-text"><?php echo $this->l('list_clear_filtering');?></span>
					</a>
				</th>
			<?php }?>
		</tr>
	</tfoot>
</table>
