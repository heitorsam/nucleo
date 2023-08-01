<?php 

    include '../../conexao.php';

    $cd_galeria = $_POST['cd_anexo'];

    $consulta = "DELETE portal_projetos.galeria gl WHERE gl.cd_galeria = $cd_galeria";

    $resultado = oci_parse($conn_ora, $consulta);

    oci_execute($resultado);

?>