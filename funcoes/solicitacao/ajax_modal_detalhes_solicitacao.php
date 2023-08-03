<?php

    session_start();

    //INICIANDO CONEXÃO
    include '../../conexao.php';

    //RECEBENDO VARIAVEIS PARA REALIZAR A CONSULTA
    $var_solicitacao = $_GET['solicitacao'];
    $var_os = $_GET['os'];
    $var_adm = $_SESSION['SN_USU_ADM'];

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

<div class="div_br"> </div>

<div class="row">

    <div class="col-md-12" style="text-align: center;">

        <button class="btn btn-primary" onclick="ajax_chama_modal_galeria(<?php echo $row['CD_OS_MV']; ?>)"><i class="fa-regular fa-folder-open"></i> Anexos</button>

    </div>

</div>

<div class="div_br"> </div>

<?php

if($var_adm == 'S'){

?>

    <div class="fnd_azul"><i class="fa-solid fa-globe efeito-zoom"></i> <b>Nucleo de Informações</b></div>

    <div class="div_br"> </div>

    <div class="row">

        <div class="col-md-3 d-flex align-items-center justify-content-center">

            Query:
            <span class="espaco_pequeno"></span>
            <span class="espaco_pequeno"></span>
            <input onclick="controla_check_box_('1')" type="checkbox" class="check_box" id="ckb_query">

        </div>

        <div class="col-md-3 d-flex align-items-center justify-content-center">
            Painel:
            <span class="espaco_pequeno"></span>
            <span class="espaco_pequeno"></span>
            <input onclick="controla_check_box('2')" type="checkbox" class="check_box" id="ckb_painel">
        </div>

        <div class="col-md-3 d-flex align-items-center justify-content-center">
            Relatorio:
            <span class="espaco_pequeno"></span>
            <span class="espaco_pequeno"></span>
            <input onclick="controla_check_box('3')" type="checkbox" class="check_box" id="ckb_relatorio">
        </div>

        <div class="col-md-3 d-flex align-items-center justify-content-center">
            Desenvolvimento:
            <span class="espaco_pequeno"></span>
            <span class="espaco_pequeno"></span>
            <input onclick="controla_check_box('4')" type="checkbox" class="check_box" id="ckb_desenvolvimento">
        </div>

    </div>

    <div class="div_br"> </div>
    
    <div class="row">

        <div class="col-md-3">

            Previsão de Entrega:
            <input type="date" class="form form-control" id="data_prevista">

        </div>

        <div class="col-md-3">

            Responsavel:
            <select class="form form-control" id="prestador_responsavel">

                <option value="All">Selecione</option>
                
            
            <select>

        </div>

        <div class="col-md-3">

            Validado Por:
            <select class="form form-control" id="prestador_responsavel" disabled>

                <option value="All">Selecione</option>
                

            <select>

        </div>

        
        <div class="col-md-3">

            Data Entrega:
            <input type="date" class="form form-control" id="data_entrega" disabled>

        </div>

    </div>

    <div class="div_br"> </div>

    <div class="row">

        <div class="col-md-12">
            Considerações
            <textarea style="background-color: white" class="textarea"  id="considerações" rows="4"></textarea>
        </div>

    </div>

    

<?php

}

?>