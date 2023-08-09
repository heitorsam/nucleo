<?php

    //CHAMANDO CONEXÃO
    include '../../conexao.php';

    //RECEBENDO VARIAVEIS
    $Prestadorresp = $_POST['Prestadorresp'];

    $datar_entrega = $_POST['datar_entrega'];
    $global_solic = $_POST['global_solic'];
    $Prestadovalidador = $_POST['Prestadovalidador'];

    $roundedMinutes = $_POST['roundedMinutes'];
    $global_os_mv = $_POST['global_os_mv'];
    $data_recebimento_servico = $_POST['data_recebimento_servico'];
    $data_final_servico = $_POST['data_final_servico'];
    
    if($roundedMinutes >= 60){

        $roundedMinutes = 60;

    }else{

        $roundedMinutes;

    }
    
    //INIANDO UPDATES E INSERTS E CONSULTAS
    
    //CONSULTA PARA PEGAR O FUNCIONARIO DO USUARIO 
    $cons_func = "SELECT func.CD_FUNC
                  FROM dbamv.FUNCIONARIO func
                  WHERE func.Cd_USUARIO = '$Prestadorresp'
                  AND func.SN_ATIVO = 'S'";
    $res_func = oci_parse($conn_ora, $cons_func);
                oci_execute($res_func);
    $row_funcionario = oci_fetch_array($res_func);

    //ATRIBUINDO VALOR A VARIAVEL
    $funcionario = $row_funcionario['CD_FUNC'];

    //UPDATE TABELA NUCLEO
    $update_it_sol_nuc = "UPDATE 
                          nucleoinfo.IT_SOLICITACAO isol
                          SET
                          isol.CD_USUARIO_VALIDADOR = '$Prestadovalidador',
                          isol.DT_ENTREGA_OS = TO_DATE('$datar_entrega','DD/MM/YYYY')
                          WHERE isol.CD_SOLICITACAO = $global_solic";

    $res_up_sol_nuc = oci_parse($conn_ora, $update_it_sol_nuc);
                      oci_execute($res_up_sol_nuc);

    //UPDATE TABELA SOLICITACAO_OS MV
    $update_solicitacao_os_mv = "    UPDATE dbamv.SOLICITACAO_OS sol
                                     SET sol.DT_EXECUCAO = TO_DATE('$data_final_servico', 'DD/MM/YYYY HH24:MI:SS'),
                                         sol.TP_SITUACAO = 'C',
                                         sol.CD_ESPEC = 58,
                                         sol.CD_LOCALIDADE = 142, --VERIFICAR POIS DEVE SER INSERIDO AO ABRIR A OS.
                                         sol.TP_LOCAL = 'I',
                                         sol.CD_MOT_SERV = 247,
                                         sol.CD_USUARIO_FECHA_OS = '$Prestadorresp',
                                         sol.DT_USUARIO_FECHA_OS = TO_DATE('$data_final_servico', 'DD/MM/YYYY HH24:MI:SS')
                                     WHERE sol.CD_OS = $global_os_mv";

    
    $res_update_solicitacao_os_mv = oci_parse($conn_ora, $update_solicitacao_os_mv);
                                    oci_execute($res_update_solicitacao_os_mv);
    
   

    //EXECUTANDO SEQUENCE SEPARADAMENTE 
    $consulta_nextval_serv = "SELECT 
                              dbamv.SEQ_ITOS.NEXTVAL AS CD_ITSOLICITACAO_OS 
                              FROM DUAL";

    $result_nextval_serv = oci_parse($conn_ora, $consulta_nextval_serv);
                           oci_execute($result_nextval_serv);

    $row_nextval_serv = oci_fetch_array($result_nextval_serv);

    //ATRIBUINDO SEQUENCE A UMA VARIAVEL
    $var_nextval_serv = $row_nextval_serv['CD_ITSOLICITACAO_OS'];

    //INICIANDO UM INSERT NA TABELA IT_SOLICITACAO_OS MV 
    $insert_it_sol_mv = "INSERT INTO dbamv.ITSOLICITACAO_OS
                         SELECT 
                         $var_nextval_serv                                            AS CD_ITSOLICITACAO_OS,
                         TO_DATE('$data_final_servico','DD/MM/YYYY HH24:MI:SS')       AS HR_FINAL,
                         TO_DATE('$data_recebimento_servico','DD/MM/YYYY HH24:MI:SS') AS HR_INICIO,
                         0                                                            AS VL_TEMPO_GASTO,
                         $global_os_mv                                                AS CD_OS,
                         $funcionario                                                 AS CD_FUNC,
                         11101                                                        AS CD_SERVICO,
                         NULL                                                         AS DS_SERVICO,
                         $roundedMinutes                                              AS VL_TEMPO_GASTO_MIN,
                         'S'                                                          AS SN_CHECK_LIST,
                         NULL                                                         AS VL_REAL,
                         NULL                                                         AS CD_BEM,
                         NULL                                                         AS VL_REFERENCIA,
                         NULL                                                         AS CD_LEITURA,
                         1                                                            AS VL_HORA,
                         1                                                            AS VL_HORA_EXTRA,
                         0                                                            AS VL_EXTRA,
                         0                                                            AS VL_EXTRA_MIN,
                         NULL                                                         AS DS_FUNCIONARIO,
                         NULL                                                         AS CD_ITSOLICITACAO_OS_INTEGRA,
                         NULL                                                         AS CD_SEQ_INTEGRA,
                         NULL                                                         AS DT_INTEGRA,
                         NULL                                                         AS CD_ITSOLICITACAO_OS_FILHA,
                         NULL                                                         AS CD_TIPO_PROCEDIMENTO_PLANO

                         FROM DUAL";

    $result_insert_it_sol_mv = oci_parse($conn_ora, $insert_it_sol_mv);
                               oci_execute($result_insert_it_sol_mv);

?>