<?php 

    include '../../conexao.php';

    echo $cd_port = $_POST['cd_port'];

    $consulta_port = "DELETE portal_projetos.PORTFOLIO port WHERE port.CD_PORTFOLIO = $cd_port";

    $resultado_port = oci_parse($conn_ora, $consulta_port);

    oci_execute($resultado_port);

    $consulta_galeria = "DELETE portal_projetos.GALERIA glr WHERE glr.CD_PORTFOLIO = $cd_port";

    $resultado_galeria = oci_parse($conn_ora, $consulta_galeria);

    oci_execute($resultado_galeria);

    @unlink('../../upload_videos/'.$cd_port.'.mp4');

?>