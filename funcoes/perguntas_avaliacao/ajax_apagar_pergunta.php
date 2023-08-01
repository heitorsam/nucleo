<?php 
    include '../../conexao.php';

    session_start();

    $cd_pergunta = $_POST['cd_pergunta'];

    $consulta = "DELETE portal_projetos.pergunta perg
    WHERE perg.cd_pergunta = $cd_pergunta
      AND perg.cd_pergunta NOT IN (SELECT res.cd_pergunta FROM portal_projetos.resposta res)
   ";

    $resultado = oci_parse($conn_ora,$consulta);

    oci_execute($resultado);




?>