<?php
	session_start();
	
	unset(
		$_SESSION['usuarioLogin'],
		$_SESSION['usuarioNome'],
		$_SESSION['CRM'],
		$_SESSION['PRESTADOR'],
		$_SESSION['SN_GERENCIA']
	);
	
	$_SESSION['msgneutra'] = "Logout realizado com sucesso!";
	
	//redirecionar o usuario para a página de login
	header("Location: index.php");

?>