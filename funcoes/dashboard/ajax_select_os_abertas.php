<?php 

    include '../../conexao.php';

    $querry =   "SELECT atd_mes.MES,
                    qtd_sol.QTD
                FROM (
                SELECT DISTINCT EXTRACT(MONTH FROM atd.DT_ATENDIMENTO) AS MES
                FROM dbamv.ATENDIME atd
                WHERE EXTRACT(YEAR FROM atd.DT_ATENDIMENTO) = EXTRACT(YEAR FROM SYSDATE) 
                ORDER BY EXTRACT(MONTH FROM atd.DT_ATENDIMENTO) ASC) atd_mes

                LEFT JOIN(SELECT EXTRACT(MONTH FROM solmv.DT_PEDIDO) AS MES,
                        COUNT(sol.CD_SOLICITACAO) AS QTD
                FROM nucleoinfo.SOLICITACAO sol
                INNER JOIN dbamv.SOLICITACAO_OS solmv
                    ON solmv.CD_OS = sol.CD_OS_MV 
                GROUP BY EXTRACT(MONTH FROM solmv.DT_PEDIDO)
                
                )qtd_sol
                ON atd_mes.MES = qtd_sol.MES
                ORDER BY atd_mes.MES ASC";

    $result = oci_parse($conn_ora, $querry);
    $valida = oci_execute($result);

    $array = [];

    while($row = oci_fetch_array($result))
    {
        array_push($array, $row['QTD']);
    }

    echo json_encode($array);

?>