<?php 
    include '../../conexao.php';

    session_start();

    //print_r($_FILES);
    $count = count($_FILES['image']['name']);
    $var_usuario = $_SESSION['usuarioLogin'];
    $prioridade = $_POST['prioridade'];
    $tipo = $_POST['tipo']; 
    //$prazo = $_POST['prazo']; 
   print_r($_FILES);
    $descricao =  $_POST['descricao'];
    $email = $_POST['inpt_email'];
    $ramal = $_POST['inpt_ramal'];
    
    
    
    //echo $prioridade . ' ' . $responsavel . ' ' . $descricao . ' ' . $anexos . ' ' . $var_usuario ;

    ////////////////////
  ///CONSULTA BANCO/// 
 ////////////////////


//nextval os
  $consulta_nextval="SELECT SEQ_OS.NEXTVAL AS CD_OS FROM DUAL";

  $result_nextval = oci_parse($conn_ora, $consulta_nextval);							

//EXECUTANDO A CONSULTA SQL (ORACLE) [VALIDANDO AO MESMO TEMPO]
  $nextval = oci_execute($result_nextval);
  $row_nextval = oci_fetch_array($result_nextval);

  $var_nextval = $row_nextval['CD_OS']; 

  

// INSERT NA TABELA DE OS
   $consulta_tb_os = "INSERT INTO dbamv.SOLICITACAO_OS 
                          SELECT $var_nextval AS CD_OS,
                          TO_DATE(SYSDATE, 'dd/mm/yy hh24:mi:ss') AS DT_PEDIDO,
                          '$descricao' as DS_SERVICO, 
                          '$descricao' as DS_OBSERVACAO,
                          NULL AS DT_EXECUCAO,
                          NULL as DT_PREV_EXEC,
                          '$var_usuario' as NM_SOLICITANTE,
                          'A' as TP_SITUACAO,
                          186 as CD_SETOR, 
                          1 as CD_MULTI_EMPRESA,
                          NULL as CD_ESPEC,
                          87 as CD_TIPO_OS, 
                          '$var_usuario' as NM_USUARIO,
                          SYSDATE as DT_ULTIMA_ATUALIZACAO, 
                          NULL as CD_LOCALIDADE, 
                          NULL as TP_LOCAL,
                          NULL as CD_BEM,
                          NULL as TP_MOT_CORRET,
                          NULL as SN_SOL_EXTERNA,
                          NULL as CD_FORNECEDOR,
                          28 as CD_OFICINA,
                          'S' as SN_ORDEM_SERVICO_PRINCIPAL,
                          NULL as CD_ORDEM_SERVICO_PRINCIPAL,
                          NULL as CD_MOT_SERV,
                          NULL as SN_OS_IMPRESSA,
                          NULL DT_HORA_IMPRESSAO,
                          NULL as CD_OS_INTEGRA,
                          NULL as CD_ORDEM_SERVICO_PRINC_INTEGRA,
                          NULL as CD_SEQ_INTEGRA,
                          NULL as DT_INTEGRA,
                          'N' as N_PACIENTE,
                          NULL as CD_LEITO,
                          NULL as CD_MOV_INT,
                          NULL as DS_EMAIL_ALTERNATIVO,
                          NULL as DS_RAMAL,
                          NULL as CD_USUARIO_REPROVA_OS,
                          NULL DT_USUARIO_REPROVA_OS,
                          NULL DT_ENTREGA, 
                          '$prioridade' as TP_PRIORIDADE,
                          NULL as QT_PRONTUARIOS,
                          'N' as SN_RECEBIDA,
                          NULL as CD_RESPONSAVEL,
                          'N' as SN_ETIQUETA_IMPRESSA,
                          'N' as SN_EMAIL_ENVIADO,
                          NULL as CD_PROGRAMACAO_PLANO,
                          'P' as TP_CLASSIFICACAO,
                          NULL as DS_SERVICO_GERAL,
                          NULL as CD_USUARIO_CADASTRO_SOL_SERV,
                          NULL DT_USUARIO_CADASTRO_SOL_SERV,
                          NULL as CD_USUARIO_CADASTRO_OS,
                          NULL DT_USUARIO_CADASTRO_OS,
                          NULL as CD_USUARIO_ULTIMA_MODIFICACAO,
                          NULL DT_USUARIO_ULTIMA_MODIFICACAO,
                          NULL as CD_USUARIO_RECEBE_SOL_SERV,
                          NULL DT_USUARIO_RECEBE_SOL_SERV,
                          NULL as CD_USUARIO_FECHA_OS,
                          NULL DT_USUARIO_FECHA_OS,
                          NULL as CD_USUARIO_GERA_OS,
                          NULL DT_USUARIO_GERA_OS,
                          NULL as DS_CONCLUIDO,
                          NULL as CD_PLANO,
                          NULL as DS_JUSTIFICA_CANCELAMENTO,
                          NULL DT_CANCELAMENTO,
                          NULL as CD_USUARIO_CANCELAMENTO,
                          NULL as TP_PRIORIDADE_MODIFIC_NO_RECEB
                          FROM DUAL";

      //$teste = '</br></br>' . $consulta_tb_os . '</br>';
      //echo '</br>'. $teste . '</br>';
      $result_tb_os = oci_parse($conn_ora, $consulta_tb_os);							

      //EXECUTANDO A CONSULTA SQL (ORACLE) [VALIDANDO AO MESMO TEMPO]
      
      $valida_chamado = oci_execute($result_tb_os);



    //INSERT TABELA PROJETOS SOLICITACÃO

    $insert_tabela_proj = "INSERT INTO portal_projetos.solicitacao
                            (CD_SOLICITACAO, 
                            CD_OS_MV, 
                            CD_RESPONSAVEL,
                            TP_PRIORIDADE,
                            TP_TIPO, 
                            ESTIMATIVA_ENTREGA, 
                            RAMAL_SOLICITANTE,
                            EMAIL_SOLICITANTE,
                            CD_USUARIO_CADASTRO,
                            HR_CADASTRO, 
                            CD_USUARIO_ULT_ALT,
                             HR_ULT_ALT)
                            VALUES
                            (portal_projetos.SEQ_CD_SOLICITACAO.nextval,
                            '$var_nextval',
                            NULL,
                            '$prioridade',
                            '$tipo', 
                            NULL, 
                            '$ramal',
                            '$email',
                            '$var_usuario', 
                            SYSDATE, 
                            '$var_usuario',
                            SYSDATE)";

    $result_insert = oci_parse($conn_ora, $insert_tabela_proj);							

    //EXECUTANDO A CONSULTA SQL (ORACLE) [VALIDANDO AO MESMO TEMPO]
      
    oci_execute($result_insert);

    for ($i= 0; $i < $count; $i++){
      
      $file = $_FILES['image']['name'][$i];
      
      $image = $_FILES['image']['tmp_name'][$i];
      $extensao = strtolower(pathinfo($file,PATHINFO_EXTENSION));
      $image = file_get_contents($image);

      $insert_gal = "INSERT INTO PORTAL_PROJETOS.ANEXOS
                                  (CD_ANEXOS, 
                                    CD_SOLICITACAO,
                                    DOCUMENTO, 
                                    EXTENSAO,
                                    CD_USUARIO_CADASTRO, 
                                    HR_CADASTRO, 
                                    CD_USUARIO_ULT_ALT, 
                                    HR_ULT_ALT)
                                  VALUES (portal_projetos.SEQ_CD_ANEXOS.nextval, 
                                          $var_nextval,
                                          empty_blob(),
                                          '$extensao',
                                          '$var_usuario',
                                          SYSDATE,
                                          NULL,
                                          NULL) RETURNING DOCUMENTO INTO :image";

                          //echo $consulta_insert;
                              $insere_dados = oci_parse($conn_ora, $insert_gal);
                              $blob = oci_new_descriptor($conn_ora, OCI_D_LOB);
                              oci_bind_by_name($insere_dados, ":image", $blob, -1, OCI_B_BLOB);

                              oci_execute($insere_dados, OCI_DEFAULT);

                              if(!$blob->save($image)) {
                                  oci_rollback($conn_ora);
                              }
                              else {
                                  oci_commit($conn_ora);
                              }

                              oci_free_statement($insere_dados);
                              $blob->free();
    }
    $_SESSION['msg'] = 'Solicitação '. $var_nextval .' com sucesso!';
    header('Location: ../../home.php');

?>