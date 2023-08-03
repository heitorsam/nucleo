<?php 

    include '../../conexao.php';

    $usuario = $_POST['usuario'];

    $consulta_delete = "DELETE nucleoinfo.responsavel WHERE CD_USUARIO_CADASTRO = '$usuario'";

    $resultado_delete = oci_parse($conn_ora,$consulta_delete);

    oci_execute($resultado_delete);

?>