<?php
	session_start();	
		
	//Incluindo a conexão com banco de dados
	include 'conexao.php';
	
	$pag_apos = 'home.php';	
	$pag_login = 'index.php';

	//header('Location: home.php');

	//O campo usuário e senha preenchido entra no if para validar
	if((isset($_POST['login'])) && (isset($_POST['senha']))){

		//Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário		
		//$result_usuario = "SELECT * FROM usuarios WHERE login = '$usuario' && senha = '$senha' LIMIT 1";
		
		$usuario = strtoupper($_POST['login']);
		$senha = $_POST['senha'];	
		
		echo $usuario;	echo '</br>'; echo $senha; echo '</br>';
		
		$result_usuario = oci_parse($conn_ora, "SELECT portal_projetos.VALIDA_SENHA_FUNC_LOGIN(:usuario,:senha) AS RESP_LOGIN,
												(SELECT INITCAP(usu.NM_USUARIO)
												FROM dbasgu.USUARIOS usu
												WHERE usu.CD_USUARIO = :usuario) AS NM_USUARIO,		
												CASE
													WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																		FROM dbasgu.PAPEL_USUARIOS puia
																		WHERE puia.CD_PAPEL = 424) THEN 'S' --USUARIO COMUM
													ELSE 'N'
												END SN_USU,											
												CASE
													WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																		FROM dbasgu.PAPEL_USUARIOS puia
																		WHERE puia.CD_PAPEL = 425) THEN 'S' --ANALISTA
													ELSE 'N'
												END SN_ADM,
												CASE
													WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																		FROM dbasgu.PAPEL_USUARIOS puia
																		WHERE puia.CD_PAPEL = 426) THEN 'S' --AUXILIAR
													ELSE 'N'
												END SN_AUX,
												CASE
													WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																		FROM dbasgu.PAPEL_USUARIOS puia
																		WHERE puia.CD_PAPEL = 427) THEN 'S' --SUPORTE
													ELSE 'N'
												END SN_SUP

												FROM DUAL");																															
												
		oci_bind_by_name($result_usuario, ':usuario', $usuario);
		oci_bind_by_name($result_usuario, ':senha', $senha);

		echo '</br> RESULT USUARIO:' . $result_usuario . '</br>';
		
		oci_execute($result_usuario);
        $resultado = oci_fetch_row($result_usuario);

		echo '</br> COLUNA 0:' . $resultado['0']  . ' - ' . $resultado['1'] . '</br>';
		
		//Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		if(isset($resultado)){
			
			if($resultado[0] == 'Login efetuado com sucesso') {

				$cons_acesso_login="INSERT INTO portal_projetos.ACESSO
				SELECT portal_projetos.SEQ_CD_ACESSO.NEXTVAL AS CD_ACESSO,
				32 AS CD_PORTFOLIO,
				'PORTAL PROJETOS' AS DS_PROJETO,
				'$usuario' AS CD_USUARIO_ACESSO,
				SYSDATE AS HR_ACESSO
				FROM DUAL";

				$result_acesso = oci_parse($conn_ora,$cons_acesso_login);

				$valida_acesso = oci_execute($result_acesso);

				$_SESSION['usuarioLogin'] = $usuario;
				$_SESSION['usuarioNome'] = $resultado[1];
				$_SESSION['SN_USU'] = $resultado[2];
				$_SESSION['SN_ADM'] = $resultado[3];
				$_SESSION['SN_AUX'] = $resultado[4];
				$_SESSION['SN_SUP'] = $resultado[5];

				header("Location: $pag_apos");	
					
			} else { 
				echo 'teste';
				$_SESSION['msgerro'] = 'Prestador não tem acesso a esse portal!';
				header("Location: $pag_login");	

			}
		//Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		//redireciona o usuario para a página de login
		}else{	

			//Váriavel global recebendo a mensagem de erro
			$_SESSION['msgerro'] = "Ocorreu um erro!";
			header("Location: $pag_login");
			
		}
		
	}
?>