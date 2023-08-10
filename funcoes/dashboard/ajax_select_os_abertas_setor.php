<?php 

    include '../../conexao.php';

    $querry =   "SELECT atd_mes.MES,
                    qtd_finalizada.NM_SETOR,
                    qtd_finalizada.QTD
                FROM (
                SELECT DISTINCT EXTRACT(MONTH FROM atd.DT_ATENDIMENTO) AS MES
                FROM dbamv.ATENDIME atd
                WHERE EXTRACT(YEAR FROM atd.DT_ATENDIMENTO) = EXTRACT(YEAR FROM SYSDATE) 
                ORDER BY EXTRACT(MONTH FROM atd.DT_ATENDIMENTO) ASC) atd_mes
                LEFT JOIN(
                SELECT st.NM_SETOR,
                    EXTRACT(MONTH FROM solmv.DT_PEDIDO) AS MES,
                    COUNT(sol.CD_SOLICITACAO) AS QTD 
                FROM nucleoinfo.SOLICITACAO sol
                INNER JOIN dbamv.SOLICITACAO_OS solmv
                ON solmv.CD_OS = sol.CD_OS_MV
                INNER JOIN dbamv.SETOR st
                ON st.CD_SETOR = solmv.CD_SETOR
                AND EXTRACT(YEAR FROM solmv.DT_PEDIDO) = EXTRACT(YEAR FROM SYSDATE)
                GROUP BY st.NM_SETOR,EXTRACT(MONTH FROM solmv.DT_PEDIDO)) qtd_finalizada
                ON qtd_finalizada.MES = atd_mes.MES
                ORDER BY atd_mes.MES ASC";

    $result = oci_parse($conn_ora, $querry);
    $valida = oci_execute($result);

    while ($row = oci_fetch_array($result)) {
        $array[] = array(

            'MES' => $row['MES'],
            'NM_SETOR' => $row['NM_SETOR'],
            'QTD' => $row['QTD']

        );
    }
    
    echo json_encode($array);

?>