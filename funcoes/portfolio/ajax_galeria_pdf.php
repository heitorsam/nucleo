<?php 

    include '../../conexao.php';

    $cd_portfolio = $_GET['cd_portfolio'];

    $cons_qtd = "SELECT COUNT(*) AS QTD 
                        FROM portal_projetos.galeria gl
                    WHERE gl.cd_portfolio = $cd_portfolio";
    $result_qtd = oci_parse($conn_ora, $cons_qtd);

    oci_execute($result_qtd);

    $row_qtd = oci_fetch_array($result_qtd);

    $qtd = $row_qtd['QTD'];

    $cons_anexo = "SELECT gl.documento, gl.cd_galeria, gl.extensao
                    FROM portal_projetos.galeria gl
                    WHERE gl.cd_portfolio = $cd_portfolio
                    AND gl.TP_GALERIA = 'DC'
                    AND gl.SN_PRINCIPAL = 'N'";

    $result_anexo = oci_parse($conn_ora, $cons_anexo);

    oci_execute($result_anexo);

        $p = 0;
    if($qtd > 0){
        while($row_anexo = oci_fetch_array($result_anexo)){
            $img = $row_anexo['DOCUMENTO']->load();
            
            $array_img[$p] = base64_encode($img); 

            $array_cd_anexo[$p] = $row_anexo['CD_GALERIA'];
            
            $array_ext[$p] = $row_anexo['EXTENSAO'];
            
            $p++;
        }
        $ext = '.jpeg';
        
        include 'galeria.php';
    }

    
?>