<?php 
    $mes = $_GET['mes'];

    include '../../conexao.php';

    $consulta_responsavel = "SELECT fnc.nm_func FROM portal_projetos.responsavel rp
                            INNER JOIN dbamv.funcionario fnc
                            ON fnc.cd_func = rp.cd_usuario_mv
                            ORDER BY rp.cd_responsavel";

    $consulta_grafico = "SELECT rsp.cd_responsavel, res.QTD
                        FROM portal_projetos.responsavel rsp
                        LEFT JOIN (SELECT COUNT(*) AS QTD, sol.cd_responsavel
                                    FROM portal_projetos.solicitacao sol
                                    INNER JOIN dbamv.solicitacao_os os
                                    ON os.cd_os = sol.cd_os_mv
                                    WHERE TO_CHAR(sol.hr_cadastro,'YYYY-MM') = '$mes'";
                            

    $consulta_grafico_concluido = $consulta_grafico;
    $consulta_grafico_aceito = $consulta_grafico;
    $consulta_grafico_total = $consulta_grafico;

    $consulta_grafico_aceito .= "AND os.tp_situacao = 'A'
                                GROUP BY sol.cd_responsavel) res
                                ON res.cd_responsavel = rsp.cd_responsavel
                                ORDER BY rsp.cd_responsavel";

    $consulta_grafico_concluido .= "AND os.tp_situacao = 'C'
                                        GROUP BY sol.cd_responsavel) res
                                        ON res.cd_responsavel = rsp.cd_responsavel
                                        ORDER BY rsp.cd_responsavel";

    $consulta_grafico_total .= "GROUP BY sol.cd_responsavel) res
                                ON res.cd_responsavel = rsp.cd_responsavel
                                ORDER BY rsp.cd_responsavel";

    $resultado_grafico_aceito = oci_parse($conn_ora, $consulta_grafico_aceito);
    $resultado_grafico_concluido = oci_parse($conn_ora, $consulta_grafico_concluido);
    $resultado_grafico_total = oci_parse($conn_ora, $consulta_grafico_total);
    $resultado_responsavel = oci_parse($conn_ora, $consulta_responsavel);

    oci_execute($resultado_grafico_aceito);
    oci_execute($resultado_grafico_concluido);
    oci_execute($resultado_grafico_total);
    oci_execute($resultado_responsavel);

    $responsaveis = '';

    while($row_responsavel = oci_fetch_array($resultado_responsavel)){
        $responsaveis .= '"'.$row_responsavel['NM_FUNC'].'",';
    }

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
        labels: [<?php echo $responsaveis ?>],
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