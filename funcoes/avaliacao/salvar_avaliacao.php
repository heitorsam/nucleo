<?php

    include '../../conexao.php';

    session_start();

    $usu =  $_SESSION['usuarioLogin'];

    $consulta_inputs = "SELECT CD_PERGUNTA FROM portal_projetos.pergunta";

    $resultado_inputs = oci_parse($conn_ora,$consulta_inputs);

    oci_execute($resultado_inputs);

    $os = $_POST['os'];

    while($row_inputs = oci_fetch_array($resultado_inputs)){
        $cd_pergunta = $row_inputs['CD_PERGUNTA'];
        
        $input = $_POST[$cd_pergunta];

        $consulta_insert = "INSERT INTO portal_projetos.resposta 
                                    (CD_RESPOSTA, 
                                     CD_PERGUNTA, 
                                     CD_SOLICITACAO, 
                                     DS_RESPOSTA, 
                                     CD_USUARIO_CADASTRO, 
                                     HR_CADASTRO)  
                                VALUES(portal_projetos.seq_cd_resposta.nextval,
                                       $cd_pergunta,
                                       $os,
                                       '$input',
                                       '$usu',
                                       SYSDATE)";
        $resultado_insert = oci_parse($conn_ora,$consulta_insert);

        oci_execute($resultado_insert);

    }

    header('Location: ../../home.php');
?>