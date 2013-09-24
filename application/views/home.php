<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">

   <title>Solicitação de Serviços</title>

   <!--link rel="stylesheet/less" href="<?php echo base_url(); ?>assets/less/bootstrap.less" type="text/css" /-->
   <!--link rel="stylesheet/less" href="<?php echo base_url(); ?>assets/less/responsive.less" type="text/css" /-->
   <!--script src="<?php echo base_url(); ?>assets/js/less-1.3.3.min.js"></script-->
   <!--append ‘#!watch’ to the browser URL, then refresh the page. -->
   
   <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">

   <?php foreach($css_files as $file): ?>
   <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
   <?php endforeach; ?>    
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/img/apple-touch-icon-57-precomposed.png">
  
  
  <style type='text/css'>
    body{
      font-family: Arial;
      font-size: 14px;
      }
      a {
          color: blue;
          text-decoration: none;
          font-size: 14px;
      }
      a:hover
      {
        text-decoration: underline;
      }

  </style>


 
</head>
<body>
<div class="container">
  <div class="row">
    <div class="span12">
      <img src="<?php echo base_url(); ?>assets/images/topo.png" />
    </div>
  </div>  
    <div class="row">   
      <div class="span12">
        <div class="navbar">
          <div class="navbar-inner new-color-nav">
            <div class="container-fluid">
              
              <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav">
                  <li class="active">
                    <a href="<?php echo base_url(); ?>home/"><i class="icon-home icon-white"></i> &nbsp; Home</a>
                  </li>
                  <!--Drop Nova Solicitação -->
               

                   <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-file icon-white"></i> &nbsp;Nova Solicitação<strong class="caret"></strong></a>
                         
                        <ul class="dropdown-menu">
                          <li>
                            <a href="<?php echo base_url(); ?>home/solicitacao-equipamento/add">Problema Em Equipamento de Informática</a>
                          </li>
                          <li>
                            <a href="<?php echo base_url(); ?>home/solicitacao-sistema/add">Problema Em Sistema da Instituição</a>
                          </li>                     
                        </ul>
                    </li>
                  <!--End Drop Nova Solicitação -->

                  <li>
                    <a href="<?php echo base_url(); ?>home/minhas-solicitacoes"><i class="icon-search icon-white"></i> &nbsp;Minhas Solicitações</a>
                  </li>
                  <li>
                    <a href="#modal-container-95857" data-toggle="modal"><i class="icon-thumbs-up icon-white"></i> &nbsp;Dúvidas Frequentes</a>
                  </li>

                  <!--Drop Administração -->
               

                   <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-wrench icon-white"></i> &nbsp;Administração<strong class="caret"></strong></a>
                         
                        <ul class="dropdown-menu">
                          <li>
                            <a href="<?php echo base_url(); ?>home/atendimentos/add">Atendimentos</a>
                          </li>
                          <li>
                            <a href="<?php echo base_url(); ?>home/solicitacao-sistema/add">Relatórios</a>
                          </li> 
                            <li>
                            <a href="<?php echo base_url(); ?>home/solicitacao-sistema/add">Cadastro de Usuários</a>
                          </li>  
                            <li>
                            <a href="<?php echo base_url(); ?>home/solicitacao-sistema/add">Cadastro de Dúvidas</a>
                          </li>                     
                        </ul>
                    </li>
                    
                  <!--End Drop Administração -->
                </ul>



                
                  </li>
                </ul>
              </div>
              
            </div>
          </div>
          
        </div>
      </div>
    </div>  


  <?php  echo $contents; ?>

  <!-- Window Modal -->
 
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
                  
          <div id="modal-container-95857" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel">
                Título
              </h3>
            </div>
            <div class="modal-body">
              <p>
                Texto com descrição da dúvidas
              </p>
            </div>
            <div class="modal-footer">
               <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Fechar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- End Window Modal -->

<div class="row">
    <div class="span12">
      <p style="color-footer">
          <strong><center>Senac Amazonas - Todos os direitos reservados</center></strong>
      </p>
    </div>
  </div>
</div>
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
   
  <?php foreach($js_files as $file): ?>
  <script type="text/javascript" src="<?php echo $file; ?>"></script>
  <?php endforeach; ?>

 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/scripts.js"></script>

</html>