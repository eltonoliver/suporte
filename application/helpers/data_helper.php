<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  formatDataMysql - tulizado para transformar data no formato Ano/mes/dia
	*  @param $data - recebe a data 
	***/
	function formatDataMysql($data){

		if($data != ""){

			$array = explode("-",$data);

			$dataMysql = $array[2]."/";
			$dataMysql .= $array[1]."/";
			$dataMysql .= $array[0];
			return $dataMysql;
		}else{
			return null;
		}
	}


	/**
	*  formatDataBrasil - tulizado para transformar data no formato dia/mes/ano
	*  @param $data - recebe a data 
	***/
	function formatDataBrasil($data){

		if($data != ""){

			$array = explode("-",$data);

			$dataMysql  = $array[2]."-";
			$dataMysql .= $array[1]."-";
			$dataMysql .= $array[0];
			return $dataMysql;
		}else{
			return null;
		}
	}

	/**
	*  formatFeriado - tulizado para transformar data no formato dia/mes
	*  @param $data - recebe a data 
	***/
	function formatFeriado($data){

		if($data != ""){

			$array = explode("-",$data);

			$dataMysql  = $array[2]."-";
			$dataMysql .= $array[1];
			return $dataMysql;
		}else{
			return null;
		}
	}

	
	function defineMes($numeroMes){
		$retornaNome = "";
		switch ($numeroMes) {
			case 1:$retornaNome = 'Janeiro'; break;
			case 2:$retornaNome = 'Fevereiro'; break;
			case 3:$retornaNome = 'Março'; break;
			case 4:$retornaNome = 'Abril'; break;
			case 5:$retornaNome = 'Maio'; break;
			case 6:$retornaNome = 'Junho'; break;
			case 7:$retornaNome = 'Julho'; break;
			case 8:$retornaNome = 'Agosto'; break;
			case 9:$retornaNome = 'Setembro'; break;
			case 10:$retornaNome = 'Outubro'; break;
			case 11:$retornaNome = 'Novembro'; break;
			case 12:$retornaNome = 'Dezembro'; break;
			default:$retornaNome =
				'Mês não existe!';
				break;
		}

		return $retornaNome;
	}


	 function diasemana($data)
		{ // Traz o dia da semana para qualquer data informada
		$dia = substr($data,0,2);
		$mes = substr($data,3,2);
		$ano = substr($data,6,9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana){ 
		 case"0": $diasemana = "Domingo"; break; 
		 case"1": $diasemana = "Segunda-Feira"; break; 
		 case"2": $diasemana = "Terça-Feira"; break; 
		 case"3": $diasemana = "Quarta-Feira"; break; 
		 case"4": $diasemana = "Quinta-Feira"; break; 
		 case"5": $diasemana = "Sexta-Feira"; break; 
		 case"6": $diasemana = "Sábado"; break; 
		 }
		return $diasemana;
		}

	
	/*soma datas*/	
	function somar_data($data, $dias, $meses, $ano){
	  $data = explode("/", $data);
	  $resData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
	  return $resData;

	  /*exemplo*/
	  /* Somar 45 dias ao dia 07/05/2012 */
		//echo somar_data('07/05/2012', 45, 0, 0); /* Imprime 21/06/2012 */
		 
		/* Somar 6 meses ao dia 28/02/2012  */
		//echo somar_data('28/02/2012', 0, 6, 0); /* Imprime 28/08/2012 */
		 
		/* Somar 2 anos, 3 meses e 10 dias ao dia 01/01/2012 */
		//echo somar_data('01/01/2012', 10, 3, 2); /* Imprime 11/04/2014 */
	}


	function dataRelativa($data){
		$today = strtotime(date('M j, Y'));
		$reldays = (strtotime($data) - $today)/86400;
		$hora = substr($data,11,5);
		if ($reldays >= 0 && $reldays < 1) 
			return (strlen($hora)?$hora:'Hoje');
		else if ($reldays >= 1 && $reldays < 2)
			return 'Amanhã ';
		else if ($reldays >= -1 && $reldays < 0)
			return 'Ontem '.(substr($data,11,5) != '00:00'?" às ".substr($data,11,5):'');

			if (abs($reldays) < 7){
			  if ($reldays > 0) {
			    $reldays = floor($reldays);
			   return 'Há ' . $reldays . ' dia' . ($reldays != 1 ? 's' : '');
			} 
			  else {
			   $reldays = abs(floor($reldays));
			   return $reldays . ' dia' . ($reldays != 1 ? 's' : '') . ' atrás '.(substr($data,11,5) != '00:00'?" às ".substr($data,11,5):'');
			 }
			}

			if (abs($reldays) < 182) 
			   return toSystemDate($data);
			else
			  return toSystemDate($data);
	}



?>