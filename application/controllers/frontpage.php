<?php if (!defined('BASEPATH')) die();
class Frontpage extends Main_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('grocery_CRUD'); 
		/* Standard Libraries */
        $this->load->database();
        $this->load->helper('url');
	}

   public function index($output)
	{
      $this->load->view('include/header');
      $this->load->view('frontpage',$output);
      $this->load->view('include/footer');
	}

	function offices()

    {
        $output = $this->grocery_crud->render();
 
        $this->index($output);

    }
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
