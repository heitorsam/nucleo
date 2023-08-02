<?php

    //INICIANDO CONEXÃO
    include '../../conexao.php';

    //RECEBENDO VARIAVEIS PARA REALIZAR A CONSULTA
    $var_solicitacao = $_GET['solicitacao'];
    $var_os = $_GET['os'];

    //INICIANDO A CONSULTA 
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
                            ON solmv.CD_OS = sol.CD_OS_MV
                            WHERE sol.CD_OS_MV = $var_os
                            AND sol.CD_SOLICITACAO = $var_solicitacao"; 
                            $res_solicitados = oci_parse($conn_ora, $consulta_solicitado);
                            oci_execute($res_solicitados); 
                            $row = oci_fetch_array($res_solicitados);

?>

<div class="row">

    <div class="col-md-12">
            
        <h11><i class="fa-solid fa-circle-info"></i> Descrição do Serviço:</h11>
        <div class="div_br"> </div>
        <textarea class="textarea" readonly style="text-align: left !important;"><?php echo $row['DS_SERVICO']; ?></textarea>

    </div>

</div>

<div class="div_br"> </div>

<div class="row">
    <div class="col-md-12">
        <h11><i class="fa-solid fa-message"></i> Observações:</h11>
        <div class="div_br"> </div>
        <textarea class="textarea" readonly style="text-align: left !important;"><?php echo $row['DS_OBSERVACAO']; ?></textarea>
    </div>
</div>
