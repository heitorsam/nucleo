<?php

    //CHAMANDO CONEXÃO  
    include '../../conexao.php';

    //CHAMANDO VARIAVEIS
    $var_ckb_query = $_POST['ckb_query'];
    $var_ckb_painel = $_POST['ckb_painel'];
    $var_ckb_relatorio = $_POST['ckb_relatorio'];
    $var_ckb_desenvolvimento = $_POST['ckb_desenvolvimento'];
    $consideracoes = $_POST['consideracoes'];
    $prev_entrega = $_POST['data_prevista'];
    $responsavel_os = $_POST['prestador_responsavel'];
    $solicitacao = $_POST['global_solic'];
    $os_mv = $_POST['global_os_mv'];

    //INICIANDO UPDATE TABELA MV
    $update_etapa2_mv = "UPDATE dbamv.SOLICITACAO_OS sol
                        SET sol.SN_RECEBIDA = 'S',
                            sol.CD_RESPONSAVEL = TRIM('$responsavel_os'),
                            sol.SN_EMAIL_ENVIADO = 'S',
                            sol.CD_USUARIO_RECEBE_SOL_SERV = TRIM('$responsavel_os'),
                            sol.DT_USUARIO_RECEBE_SOL_SERV = SYSDATE
                        WHERE sol.CD_OS = '$os_mv'";
    $res_update_etapa2_mv = oci_parse($conn_ora, $update_etapa2_mv);
                            oci_execute($res_update_etapa2_mv);

    //INICIANDO UPDATE NA TABELA DO BANCO DE DADOS NUCLEO
    $update_solicitacao = "UPDATE nucleoinfo.SOLICITACAO solic
                           SET solic.CD_RESPONSAVEL = '$responsavel_os',
                               solic.ESTIMATIVA_ENTREGA = TO_DATE('$prev_entrega','DD/MM/YYYY')
                           WHERE solic.CD_SOLICITACAO = '$solicitacao'
                           AND solic.CD_OS_MV = '$os_mv'";

    $res_update = oci_parse($conn_ora, $update_solicitacao);
                  oci_execute($res_update);

    //INSERINDO INFORMAÇÕES EM IT_SOLICITACAO TABELA DE RECEBIMENTO OWNER NUCLEOINFO.

    $insert_itsolicitacao = "INSERT INTO nucleoinfo.IT_SOLICITACAO
                             SELECT
                             nucleoinfo.SEQ_CD_IT_SOLICITACAO.NEXTVAL AS CD_IT_SOLICITACAO,    
                             TRIM($solicitacao)         AS CD_SOLICITACAO,      
                             TRIM($os_mv)               AS CD_OS_MV,             
                             '$var_ckb_query'           AS CKB_QUERY,           
                             '$var_ckb_painel'          AS CKB_PAINEL,           
                             '$var_ckb_relatorio'       AS CKB_RELATORIO,        
                             '$var_ckb_desenvolvimento' AS CKB_DESENVOLVIMENTO,  
                             NULL                       AS CD_USUARIO_VALIDADOR, 
                             NULL                       AS DT_ENTREGA_OS,        
                             TO_CLOB('$consideracoes')  AS DS_CONSIDERACOES,     
                             '$responsavel_os'          AS CD_USUARIO_CADASTRO,   
                             SYSDATE                    AS HR_CADASTRO,         
                             NULL                       AS CD_USUARIO_ULT_ALT,   
                             NULL                       AS HR_ULT_ALT
                             
                             FROM DUAL";
    $res_insert_itsolicitacao = oci_parse($conn_ora, $insert_itsolicitacao);
                                oci_execute($res_insert_itsolicitacao);

?>