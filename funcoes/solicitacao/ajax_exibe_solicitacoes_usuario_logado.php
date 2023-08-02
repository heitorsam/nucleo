<?php

    include '../../conexao.php';

    session_start();

    $usuario_logado = $_SESSION['usuarioLogin'];

    $consulta_solicitado = "SELECT CASE
                                WHEN sol.CD_RESPONSAVEL IS NULL THEN 'Solicitado'
                                ELSE 'Recebido'
                                END AS TP_STATUS_SOLICITACAO,
                                sol.CD_SOLICITACAO,
                                sol.CD_OS_MV,
                                sol.CD_USUARIO_CADASTRO AS SOLICITANTE,
                                (SELECT usu.NM_USUARIO FROM dbasgu.USUARIOS usu WHERE usu.CD_USUARIO = sol.CD_USUARIO_CADASTRO) AS NM_USUARIO,
                                TO_CHAR(sol.HR_CADASTRO,'DD/MM/YYYY HH24:MI:SS') AS DATA_PEDIDO,
                                solmv.DS_SERVICO,
                                FNC_LONG_PARA_CHAR_OS(solmv.CD_OS) AS DS_OBSERVACAO,
                                sol.CD_RESPONSAVEL,
                                sol.ESTIMATIVA_ENTREGA
                            FROM nucleoinfo.SOLICITACAO sol
                            INNER JOIN dbamv.SOLICITACAO_OS solmv
                            ON solmv.CD_OS = sol.CD_OS_MV";
    $res_solicitados = oci_parse($conn_ora, $consulta_solicitado);
                       oci_execute($res_solicitados);


?>

<div class="div_br"> </div>

<div style="width: 100%; overflow: auto;">

    <table class='table table-striped' style='text-align: center'>

        <thead>

            <th style="text-align: center; border: solid 2px #3185c1;" >Status</th>   
            <th style="text-align: center; border: solid 2px #3185c1;" >OS</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Solicitante</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Pedido</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Responsavel</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Estimativa</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Ações</th>

        </thead>

        <tbody>
       
        <?php
        while ($row = oci_fetch_array($res_solicitados)) {

          echo '<tr>';

            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['TP_STATUS_SOLICITACAO'] . '</td>';
            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['CD_OS_MV'] . '</td>';
            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['NM_USUARIO'] . '</td>';
            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['DATA_PEDIDO'] . '</td>';
           
            if($row['CD_RESPONSAVEL'] != ''){

                echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['CD_RESPONSAVEL'] . '</td>';
            
            }else{

                echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">Pendente</td>';

            }

            if($row['ESTIMATIVA_ENTREGA'] != ''){

                echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['ESTIMATIVA_ENTREGA'] . '</td>';
            
            }else{

                echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">Pendente</td>';

            }
            
            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">

                <button class="btn btn-primary" onclick="ajax_modal_exibe_detalhes_adm('.$row['CD_SOLICITACAO'].','.$row['CD_OS_MV'].')"><i class="fa-solid fa-circle-info"></i></button>

            </td>';

        }
        ?>



        </tbody>

    </table>

<div>