<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solicitacoes extends CI_Controller {

	public function __construct(){
		
		parent::__construct();
		$this->load->library('grocery_CRUD');
	}

}

/* End of file solicitacoes.php */
/* Location: ./application/controllers/solicitacoes.php */


 ?>