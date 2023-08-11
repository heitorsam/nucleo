<?php

    session_start();

    //CHAMANDO CONEXÃO
    include '../../conexao.php';

    //RECEBENDO VARIAVEIS
    $var_data = $_GET['data_filtro'];
    $usuario_logado = $_SESSION['usuarioLogin'];
    $usu_global = $_SESSION['SN_USU_GLOBAL'];
    $usu_adm = $_SESSION['SN_USU_ADM'];

    //INICIANDO A CONSULTA
    $consulta_solicitado = "SELECT
                                sol.CD_SOLICITACAO,
                                sol.CD_OS_MV,
                                sol.CD_USUARIO_CADASTRO AS SOLICITANTE,
                                (SELECT usu.NM_USUARIO FROM dbasgu.USUARIOS usu WHERE usu.CD_USUARIO = sol.CD_USUARIO_CADASTRO) AS NM_USUARIO,
                                TO_CHAR(sol.HR_CADASTRO,'DD/MM/YYYY HH24:MI:SS') AS DATA_PEDIDO,
                                solmv.DS_SERVICO,
                                FNC_LONG_PARA_CHAR_OS(solmv.CD_OS) AS DS_OBSERVACAO,
                                sol.CD_RESPONSAVEL,
                                TO_CHAR(sol.ESTIMATIVA_ENTREGA,'DD/MM/YYYY') AS ESTIMATIVA_ENTREGA,
                                TO_CHAR(solmv.DT_EXECUCAO,'DD/MM/YYYY HH24:MI:SS') AS DT_EXECUCAO
                            FROM nucleoinfo.SOLICITACAO sol
                            INNER JOIN dbamv.SOLICITACAO_OS solmv
                            ON solmv.CD_OS = sol.CD_OS_MV
                            WHERE TO_CHAR(solmv.DT_EXECUCAO,'DD/MM/YYYY') = '$var_data'";

                            if($usu_global == 'S' &&  $usu_adm == 'N'){

                                $consulta_solicitado .= " AND sol.CD_USUARIO_CADASTRO = '$usuario_logado'
                                                         AND solmv.TP_SITUACAO = 'C' 
                                                         ORDER BY sol.CD_SOLICITACAO DESC ";



                            }

                            if($usu_adm == 'S'){

                               $consulta_solicitado .= " AND sol.CD_RESPONSAVEL = '$usuario_logado'
                                                         AND solmv.TP_SITUACAO = 'C' 
                                                         ORDER BY sol.CD_SOLICITACAO DESC ";

                            }

    $res_solicitados = oci_parse($conn_ora, $consulta_solicitado);
                       oci_execute($res_solicitados);
    


?>

<div class="div_br"> </div> 


<div style="width: 100%; overflow: auto;">

    <table class='table table-striped' style='text-align: center'>

        <thead>

            <th style="text-align: center; border: solid 2px #3185c1;" >OS</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Solicitante</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Pedido</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Finalização</th>
            <th style="text-align: center; border: solid 2px #3185c1;" >Ações</th>

        </thead>

        <tbody>


        <?php
        while ($row = oci_fetch_array($res_solicitados)) {

          echo '<tr>';

            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['CD_OS_MV'] . '</td>';
            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['NM_USUARIO'] . '</td>';
            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['DATA_PEDIDO'] . '</td>';   
            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">' . $row['DT_EXECUCAO'] . '</td>';   
            echo '<td class="align-middle" style=" cursor: pointer; text-align: center; border: solid 2px #3185c1; padding: 10px !important; !important; color: black !important;">

                    <button class="btn btn-primary" onclick="ajax_modal_exibe_detalhes_adm_finalizada('.$row['CD_SOLICITACAO'].','.$row['CD_OS_MV'].')"><i class="fa-solid fa-eye"></i></button>

                </td>'; 
     

        }
        ?>



        </tbody>

    </table>

<div>