<?php 

    include '../../conexao.php';

    $querry =   "SELECT atd_mes.MES,
                    qtd_finalizada.NM_USUARIO,
                    qtd_finalizada.QTD
                FROM (
                SELECT DISTINCT EXTRACT(MONTH FROM atd.DT_ATENDIMENTO) AS MES
                FROM dbamv.ATENDIME atd
                WHERE EXTRACT(YEAR FROM atd.DT_ATENDIMENTO) = EXTRACT(YEAR FROM SYSDATE) 
                ORDER BY EXTRACT(MONTH FROM atd.DT_ATENDIMENTO) ASC) atd_mes

                LEFT JOIN(
                SELECT EXTRACT(MONTH FROM solmv.DT_EXECUCAO) AS MES,
                    COUNT(sol.CD_SOLICITACAO) AS QTD,
                    usu.NM_USUARIO
                FROM nucleoinfo.SOLICITACAO sol
                INNER JOIN dbamv.SOLICITACAO_OS solmv
                ON solmv.CD_OS = sol.CD_OS_MV
                INNER JOIN dbasgu.USUARIOS usu
                ON usu.CD_USUARIO = sol.CD_RESPONSAVEL 
                WHERE solmv.TP_SITUACAO = 'C'
                AND EXTRACT(YEAR FROM solmv.DT_EXECUCAO) = EXTRACT(YEAR FROM SYSDATE) 
                GROUP BY EXTRACT(MONTH FROM solmv.DT_EXECUCAO), usu.NM_USUARIO) qtd_finalizada

                ON atd_mes.MES = qtd_finalizada.MES
                ORDER BY atd_mes.MES ASC";

    $result = oci_parse($conn_ora, $querry);
    $valida = oci_execute($result);

    while ($row = oci_fetch_array($result)) {
        $array[] = array(
            'MES' => $row['MES'],
            'NM_USUARIO' => $row['NM_USUARIO'],
            'QTD' => $row['QTD']
        );
    }
    
    echo json_encode($array);

?>