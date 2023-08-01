<?php 

    include '../../conexao.php';

    $usuario = $_POST['usuario'];

    $consulta_delete = "DELETE portal_projetos.solicitacao WHERE CD_SOLICITACAO = '$usuario'";

    $resultado_delete = oci_parse($conn_ora,$consulta_delete);

    oci_execute($resultado_delete);

?>