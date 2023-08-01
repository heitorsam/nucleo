<?php 
    $ano = $_GET['ano'];

    include '../../conexao.php';

    $consulta_grafico = "SELECT periodos.mes, res.QTD
                            FROM (SELECT '01' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '02' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '03' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '04' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '05' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '06' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '07' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '08' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '09' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '10' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '11' AS MES
                                    FROM DUAL
                                UNION ALL
                                SELECT '12' AS MES
                                    FROM DUAL) PERIODOS
                            LEFT JOIN (SELECT COUNT(*) AS qtd, TO_CHAR(sol.Hr_Cadastro, 'MM') AS MES
                                        FROM portal_projetos.solicitacao sol
                                        INNER JOIN dbamv.solicitacao_os os
                                        ON os.cd_os = sol.cd_os_mv
                                        ";
                            

    $consulta_grafico_concluido = $consulta_grafico;
    $consulta_grafico_aceito = $consulta_grafico;
    $consulta_grafico_total = $consulta_grafico;
    $consulta_grafico_recusado = $consulta_grafico;

    $consulta_grafico_aceito .= "WHERE os.tp_situacao = 'A'
                                AND EXTRACT(YEAR FROM sol.hr_cadastro) = '$ano'
                                    GROUP BY TO_CHAR(sol.Hr_Cadastro, 'MM')) res
                                ON res.MES = periodos.mes
                                ORDER BY 1";

    $consulta_grafico_concluido .= "WHERE os.tp_situacao = 'C'
                                    AND EXTRACT(YEAR FROM sol.hr_cadastro) = '$ano'
                                        GROUP BY TO_CHAR(sol.Hr_Cadastro, 'MM')) res
                                    ON res.MES = periodos.mes
                                    ORDER BY 1";

    $consulta_grafico_total .= "WHERE EXTRACT(YEAR FROM sol.hr_cadastro) = '$ano'
                                    GROUP BY TO_CHAR(sol.Hr_Cadastro, 'MM')) res
                                    ON res.MES = periodos.mes
                                    ORDER BY 1";

    $consulta_grafico_recusado .= "WHERE os.tp_situacao = 'D'
                                        AND EXTRACT(YEAR FROM sol.hr_cadastro) = '$ano'
                                        GROUP BY TO_CHAR(sol.Hr_Cadastro, 'MM')) res
                                    ON res.MES = periodos.mes
                                    ORDER BY 1";

    $resultado_grafico_aceito = oci_parse($conn_ora, $consulta_grafico_aceito);
    $resultado_grafico_concluido = oci_parse($conn_ora, $consulta_grafico_concluido);
    $resultado_grafico_total = oci_parse($conn_ora, $consulta_grafico_total);
    $resultado_grafico_recusado = oci_parse($conn_ora, $consulta_grafico_recusado);

    oci_execute($resultado_grafico_aceito);
    oci_execute($resultado_grafico_concluido);
    oci_execute($resultado_grafico_total);
    oci_execute($resultado_grafico_recusado);

?>

</br>

<div class="row" >
    <div class="col-md-12">
        <canvas id="myChart" style="width: 800px;max-width:800px; margin: 0 auto;"></canvas>
    </div>
</div>
</br>

<script>
    var ctx = document.getElementById("myChart").getContext("2d")

    var data = {
        labels: ["Jan", "Fev", "Mar","Abr", "Mai","Jun","Jul","Aug","Set","Out","Nov","Dez"],
        datasets: [
            {
                label: "Total",
                backgroundColor: "#206db9",
                data: [<?php 
                            while($row_total =  oci_fetch_array($resultado_grafico_total)){
                                echo $row_total['QTD'].',';
                            }?>]
            },
            {
                label: "Andamento",
                backgroundColor: "#A2B3FC",
                data: [<?php 
                            while($row_aceito =  oci_fetch_array($resultado_grafico_aceito)){
                                echo $row_aceito['QTD'].',';
                            }?>]
            },
            {
                label: "Concluído",
                backgroundColor: "#46b683",
                data: [<?php 
                            while($row_concluido =  oci_fetch_array($resultado_grafico_concluido)){
                                echo $row_concluido['QTD'].',';
                            }?>]
            },
            {
                label: "Recusados",
                backgroundColor: "#a11616",
                data: [<?php 
                            while($row_recusado =  oci_fetch_array($resultado_grafico_recusado)){
                                echo $row_recusado['QTD'].',';
                            }?>]
            }

        ]
    }

    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            barValueSpacing: 20,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                    }
                }]
            }
        }
    })

</script>