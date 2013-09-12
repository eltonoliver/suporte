<?php

class uploadInit {
	/**
	 *
	 *
	 * @method _doUpload  - executa o upload
	 * @param unknown $path    - caminho onde ficara a imagem
	 * @param unknown $type    - tipo dos arquivos suportados
	 * @param unknown $largura - largura da imagem
	 * @param unknown $altura  - altura da imagem
	 * */
	public function uploadInit( $path = null, $type = null, $largura = null, $altura = null ) {
		$CI =& get_instance();
		$config['upload_path'] = $path;
		$config['allowed_types'] = $type;
		$config['max_size'] = '1000';
		$config['max_width']  = $largura;
		$config['max_height']  = $altura;
		$config['encrypt_name'] = TRUE;
		$CI->load->library( 'upload', $config );
		$CI->upload->initialize( $config );

	}

	/**
	 *
	 *
	 * @method cropInit  - corta a imagem
	 * @param unknown $path    - caminho onde esta a imagem
	 * @param unknown $nomeImg - nome da imagem
	 * @param unknown $largura - largura da imagem
	 * @param unknown $altura  - altura da imagem
	 * */
	public function cropInit( $path = null, $nomeImg = null, $largura = null, $altura = null, $thumb = FALSE ) {
		$CI =& get_instance();
		$config['image_library'] = 'gd2';
		$config['source_image'] = $path.$nomeImg;
		$config['create_thumb'] = $thumb;
		$config['maintain_ratio'] = TRUE;
		$config['width']  = $largura ;
		$config['height'] = $altura;
		$CI->load->library( 'image_lib', $config );
		$CI->image_lib->resize();

	}
}

?>
