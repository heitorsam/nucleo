<?php 

    include '../../conexao.php';

    $cd_solicitacao = $_GET['cd_solicitacao'];

    $cons_qtd = "SELECT COUNT(*) AS QTD from anexos anx WHERE anx.cd_solicitacao = $cd_solicitacao";
    $result_qtd = oci_parse($conn_ora, $cons_qtd);

    oci_execute($result_qtd);

    $row_qtd = oci_fetch_array($result_qtd);

    $qtd = $row_qtd['QTD'];

    $cons_anexo = "SELECT anx.documento, anx.cd_anexos, anx.extensao
                        FROM portal_projetos.anexos anx
                    WHERE anx.cd_solicitacao = $cd_solicitacao";

    $result_anexo = oci_parse($conn_ora, $cons_anexo);

    oci_execute($result_anexo);

        $p = 0;
    if($qtd > 0){
        while($row_anexo = oci_fetch_array($result_anexo)){
            $img = $row_anexo['DOCUMENTO']->load();
            
            $array_img[$p] = base64_encode($img); 

            $array_cd_anexo[$p] = $row_anexo['CD_ANEXOS'];
            
            $array_ext[$p] = $row_anexo['EXTENSAO'];
            
            $p++;
        }
        $ext = '.jpeg';
        include 'galeria.php';
    }
?>