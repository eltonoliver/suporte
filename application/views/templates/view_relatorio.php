<?php 

$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );



 ?>
<h4><center>Relatórios</center></h4>
<br>
<?php echo form_open('admin/gerarRelatorio','target="_blank"'); ?>
<strong>Técnico : </strong> 

<select name="tecnico" > 
	<option>Todos</option>
	<?php 

		$this->db->select('id,nome');
		$suporte = $this->db->get('usuarios')->result();
		foreach ($suporte as $value) {
			echo '<option value="'.$value->id.'">'.$value->nome.'</option>';
		}
	?>


</select>
<br />

<strong>Tipo : </strong>

<select name="tipo" > 
	<option>Todos</option>
	<option value="1"> Equipamentos </option>
	<option value="2"> Sistemas </option>

</select>
<br />
<strong>Situação : </strong>

<select name="situacao" > 
	<option>Todas</option>
<?php 

		$this->db->select('id,nome');
		$situacao = $this->db->get('situacao')->result();
		foreach ($situacao as $value) {
			echo '<option value="'.$value->id.'">'.$value->nome.'</option>';
		}
	?>

</select>

<br />

<strong> Data Início : </strong> <input type="text" name="dataInicio"> <br />

<strong> Data Fim : </strong> <?php echo nbs(2); ?> <input type="text" name="dataFim"> <br />


<input type="submit" class="btn btn-primary" value="Gerar Relatório" >

</form>
