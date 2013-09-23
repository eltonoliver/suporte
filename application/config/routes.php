<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] 										= "home";
$route['home'] 														= "/home/home_sisten/";
/*ROTA SOLICITACAO EQUIPAMENTO*/
$route['home/solicitacao-equipamento/add'] 							= "/home/solicitacaoEquipamento/";
$route['home/solicitacao-equipamento/insert'] 						= "/home/solicitacaoEquipamento/";
$route['home/solicitacao-equipamento/edit'] 						= "/home/solicitacaoEquipamento/";
$route['home/solicitacao-equipamento/upload_file/anexo'] 			= "/home/solicitacaoEquipamento/";
$route['home/solicitacao-equipamento/delete_file/anexo/(:any)'] 	= "/home/solicitacaoEquipamento/";
$route['home/solicitacao-equipamento/delete/:num']					= "/home/solicitacaoEquipamento/";
$route['home/solicitacao-equipamento/insert_validation']			= "/home/solicitacaoEquipamento/";

/*ROTAS SOLICITACAO SISTEMAS*/
$route['home/solicitacao-sistema/add'] 							= "/home/solcicitacaoSistema/";
$route['home/solicitacao-sistema/insert'] 						= "/home/solcicitacaoSistema/";
$route['home/solicitacao-sistema/edit'] 						= "/home/solcicitacaoSistema/";
$route['home/solicitacao-sistema/upload_file/anexo'] 			= "/home/solcicitacaoSistema/";
$route['home/solicitacao-sistema/delete_file/anexo/(:any)'] 	= "/home/solcicitacaoSistema/";
$route['home/solicitacao-sistema/delete/:num']					= "/home/solcicitacaoSistema/";
$route['home/solicitacao-sistema/insert_validation']			= "/home/solcicitacaoSistema/";

/*ROTAS MINHAS SOLICITACOES*/
$route['home/minhas-solicitacoes']								= "/home/minhasSolicitacoes/";


$route['404_override'] = 'home/home_sisten';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
