<?php

    session_start();

    //INICIANDO CONEXÃO
    include '../../conexao.php';

    //RECEBENDO VARIAVEIS PARA REALIZAR A CONSULTA
    $var_solicitacao = $_GET['solicitacao'];
    $var_os = $_GET['os'];
    $var_adm = $_SESSION['SN_USU_ADM'];

    //INICIANDO A CONSULTA 
    $consulta_solicitado = "SELECT sol.CD_SOLICITACAO,
                                   sol.CD_OS_MV,
                                   sol.CD_USUARIO_CADASTRO AS SOLICITANTE,
                                   (SELECT usu.NM_USUARIO FROM dbasgu.USUARIOS usu WHERE usu.CD_USUARIO = sol.CD_USUARIO_CADASTRO) AS NM_USUARIO,
                                   TO_CHAR(sol.HR_CADASTRO,'DD/MM/YYYY HH24:MI:SS') AS DATA_PEDIDO,
                                   solmv.DS_SERVICO,
                                   FNC_LONG_PARA_CHAR_OS(solmv.CD_OS) AS DS_OBSERVACAO,
                                   sol.CD_RESPONSAVEL,
                                   (SELECT usu.NM_USUARIO FROM dbasgu.USUARIOS usu WHERE usu.CD_USUARIO = sol.CD_RESPONSAVEL) AS NM_RESPONSAVEL,
                                   sol.ESTIMATIVA_ENTREGA,
                                   (SELECT st.NM_SETOR FROM dbamv.SETOR st WHERE st.CD_SETOR = solmv.CD_SETOR) AS DS_SETOR,
                                   (SELECT loc.DS_LOCALIDADE FROM dbamv.LOCALIDADE loc WHERE loc.CD_LOCALIDADE = solmv.CD_LOCALIDADE) AS DS_LOCALIDADE_OS,
                                   solmv.DS_RAMAL,
                                   solmv.DS_EMAIL_ALTERNATIVO,
                                   itsol.CKB_QUERY,
                                   itsol.CKB_PAINEL,
                                   itsol.CKB_RELATORIO,
                                   itsol.CKB_DESENVOLVIMENTO,
                                   itsol.CD_USUARIO_VALIDADOR,
                                   (SELECT usu.NM_USUARIO FROM dbasgu.USUARIOS usu WHERE usu.CD_USUARIO = itsol.CD_USUARIO_VALIDADOR) AS NM_USUARIO_VALIDADOR,
                                   TO_CHAR(itsol.DT_ENTREGA_OS,'DD/MM/YYYY') AS DT_ENTREGA_OS,
                                   FNC_LONG_PARA_CHAR_NUCLEOINFO(sol.CD_SOLICITACAO) AS DS_CONSIDERACOES,
                                   TRIM(TO_CHAR(solmv.DT_USUARIO_RECEBE_SOL_SERV,'DD/MM/YYYY HH24:MI:SS')) AS  DT_USUARIO_RECEBE_SOL_SERV
                            FROM nucleoinfo.SOLICITACAO sol
                            INNER JOIN dbamv.SOLICITACAO_OS solmv
                            ON solmv.CD_OS = sol.CD_OS_MV
                            INNER JOIN nucleoinfo.IT_SOLICITACAO itsol
                            ON itsol.CD_SOLICITACAO = sol.CD_SOLICITACAO
                            WHERE sol.CD_OS_MV = $var_os
                            AND sol.CD_SOLICITACAO = $var_solicitacao"; 

                            $res_solicitados = oci_parse($conn_ora, $consulta_solicitado);
                            oci_execute($res_solicitados); 
                            $row = oci_fetch_array($res_solicitados);

?>

<div class="row">

    <div class="col-md-4">

        Setor Solicitante:
        <input type="text" id="setor_solicitante" readonly value="<?php echo  $row['DS_SETOR'] ?>" class="form form-control">

    </div>

    <div class="col-md-3">

        Localidade:
        <input type="text" id="setor_localidade" readonly value="<?php echo  $row['DS_LOCALIDADE_OS'] ?>" class="form form-control">

    </div>

    <div class="col-md-3">

        Email:
        <input type="text" id="email_os" readonly value="<?php echo  $row['DS_EMAIL_ALTERNATIVO'] ?>" class="form form-control">

    </div>

    <div class="col-md-2">

        Ramal:
        <input type="text" id="email_os" readonly value="<?php echo  $row['DS_RAMAL'] ?>" class="form form-control">

    </div>


</div>

<div class="div_br"> </div>


<div class="row">

    <div class="col-md-12">
            
        <h11><i class="fa-solid fa-circle-info"></i> Descrição do Serviço:</h11>
        <div class="div_br"> </div>
        <textarea class="textarea" readonly style="text-align: left !important;"><?php echo $row['DS_SERVICO']; ?></textarea>

    </div>

</div>

<div class="div_br"> </div>

<input type="text" hidden id="data_recebimento_serv" value="<?php echo $row['DT_USUARIO_RECEBE_SOL_SERV']; ?>">

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

        <button class="btn btn-primary" onclick="ajax_chama_modal_galeria_chamado_finalizado(<?php echo $row['CD_OS_MV']; ?>)"><i class="fa-regular fa-folder-open"></i> Anexos</button>

    </div>

</div>

<div class="div_br"> </div>

    <div class="fnd_azul"><i class="fa-solid fa-globe efeito-zoom"></i> <b>Nucleo de Informações</b></div>

    <div class="div_br"> </div>

    <div class="row">

        <div class="col-md-3 d-flex align-items-center justify-content-center">

            Query:
            <span class="espaco_pequeno"></span>
            <span class="espaco_pequeno"></span>
            <input type="checkbox" class="check_box" id="ckb_query" <?php if($row['CKB_QUERY'] == 'true'){ echo 'checked'; } ?> disabled>

        </div>

        <div class="col-md-3 d-flex align-items-center justify-content-center">
            Painel:
            <span class="espaco_pequeno"></span>
            <span class="espaco_pequeno"></span>
            <input type="checkbox" class="check_box" id="ckb_painel" <?php if($row['CKB_PAINEL'] == 'true'){ echo 'checked'; } ?> disabled>
        </div>

        <div class="col-md-3 d-flex align-items-center justify-content-center">
            Relatorio:
            <span class="espaco_pequeno"></span>
            <span class="espaco_pequeno"></span>
            <input type="checkbox" class="check_box" id="ckb_relatorio" <?php if($row['CKB_RELATORIO'] == 'true'){ echo 'checked'; } ?> disabled>
        </div>

        <div class="col-md-3 d-flex align-items-center justify-content-center">
            Desenvolvimento:
            <span class="espaco_pequeno"></span>
            <span class="espaco_pequeno"></span>
            <input type="checkbox" class="check_box" id="ckb_desenvolvimento" <?php if($row['CKB_DESENVOLVIMENTO'] == 'true'){ echo 'checked'; } ?> disabled>
        </div>

    </div>

    <div class="div_br"> </div>
    
    <div class="row">

        <div class="col-md-3">

            Previsão de Entrega:
            <input disabled type="date" class="form form-control" id="data_entrega" value="<?php echo date_format(date_create($row['ESTIMATIVA_ENTREGA']), 'Y-m-d'); ?>">
        
        </div>

        <div class="col-md-3">

            Responsavel:
            <select class="form form-control" id="prestador_responsavel_receb" style="background-color: #e9ecef">

                <option readonly><?php echo $row['NM_RESPONSAVEL']; ?></option>
                
            <select>

        </div>

        <div class="col-md-3">

            Validado Por:
            <select class="form form-control" id="prestador_validador_receb" style="background-color: #e9ecef">

                <option readonly><?php echo $row['NM_USUARIO_VALIDADOR']; ?></option>
                

            <select>

        </div>

        
        <div class="col-md-3">

            Data Entrega:
            <input type="text" class="form form-control" id="data_ent_recebida" readonly value="<?php echo $row['DT_ENTREGA_OS']; ?>">

        </div>

    </div>

    <div class="div_br"> </div>

    <div class="row">

        <div class="col-md-12">

            Considerações
            <textarea readonly style="background-color: #e9ecef" class="textarea" id="consideracoes" rows="4"><?php echo $row['DS_CONSIDERACOES']; ?></textarea>
            
        </div>


    </div>