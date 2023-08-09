<?php 

  //INICIANDO CONEXÃO
  include '../../conexao.php';

  //USUARIO LOGADO/DADOS PACIENTE 
  $var_inpt_ramal = $_POST['inpt_ramal'];
  $var_inpt_email = $_POST['inpt_email'];
  $var_inpt_descricao = $_POST['descricao'];
  $var_inpt_motivo = $_POST['motivo'];
  $var_inpt_localidade = $_POST['localidade'];
  $var_usuario_logado = $_POST['usuariologado'];
  $var_nome_usuario_logado = $_POST['nm_usuario_logado'];
  $st_usuario_logado = $_POST['st_usuario_logado'];
  $ckb_unica_vez = $_POST['ckb_unica_vez'];
  $ckb_mensalmente = $_POST['ckb_mensalmente'];
  $ckb_temporeal = $_POST['ckb_temporeal'];
  

  
  // Exibindo informações do usuário (remova essas linhas se não forem necessárias)
  //echo "Ramal: " . $var_inpt_ramal . "<br>";
  //echo "Email: " . $var_inpt_email . "<br>";
  //echo "Descrição: " . $var_inpt_descricao . "<br>";
  //echo "Motivo: " . $var_inpt_motivo . "<br>";
  //echo "Usuário Logado: " . $var_usuario_logado . "<br>";

  // Recupere o array de informações sobre o(s) arquivo(s) enviado(s)
  $file = $_FILES['arquivos'];

  // Verifique se foram enviados múltiplos arquivos
  $num_files = count($file['name']);

  // Faça um loop para percorrer todas as informações dos arquivos
  for ($i = 0; $i < $num_files; $i++) {
      // Informações do arquivo atual
      $nome_do_arquivo = $file['name'][$i];
      $tipo_do_arquivo = $file['type'][$i];
      $tamanho_do_arquivo = $file['size'][$i];
      $caminho_temporario = $file['tmp_name'][$i];
      $erro_do_arquivo = $file['error'][$i];
      
      // Exibindo informações do arquivo (remova essas linhas se não forem necessárias)
      //echo "Nome do Arquivo: " . $nome_do_arquivo . "<br>";
      //echo "Tipo do Arquivo: " . $tipo_do_arquivo . "<br>";
      //echo "Tamanho do Arquivo: " . $tamanho_do_arquivo . "<br>";
      // Não exiba o caminho temporário nem o código de erro, pois não são relevantes para o usuário final.
  }


  //CRIANDO SEQUENCE DA TEBELA DE OS MV
  $nextval_os = "SELECT SEQ_OS.NEXTVAL AS CD_OS 
                 FROM DUAL";
  $res_next_os = oci_parse($conn_ora, $nextval_os);
      $nextval = oci_execute($res_next_os);

  //COLETANDO O VALOR DA SEQUENCE 
  $row_nextval = oci_fetch_array($res_next_os);
  $var_nextval = $row_nextval['CD_OS']; 

  //echo "Sequence: " . $var_nextval . "<br>";

  //INICIANDO O INSERT NA TABELA DE OS

  //INSERT NA TABELA DE OS
  $consulta_tb_os = "INSERT INTO dbamv.SOLICITACAO_OS 
                          SELECT $var_nextval AS CD_OS,
                          TO_DATE(TO_CHAR(SYSDATE, 'DD/MM/YYYY HH24:MI:SS'), 'DD/MM/YYYY HH24:MI:SS') AS DT_PEDIDO,
                          '$var_inpt_descricao' as DS_SERVICO, 
                          '$var_inpt_motivo' as DS_OBSERVACAO,
                          NULL AS DT_EXECUCAO,
                          NULL as DT_PREV_EXEC,
                          trim('$var_usuario_logado') as NM_SOLICITANTE,
                          'S' as TP_SITUACAO,
                          $st_usuario_logado as CD_SETOR, 
                          1 as CD_MULTI_EMPRESA,
                          NULL as CD_ESPEC,
                          87 as CD_TIPO_OS, 
                          trim('$var_usuario_logado') as NM_USUARIO,
                          SYSDATE as DT_ULTIMA_ATUALIZACAO, 
                          $var_inpt_localidade as CD_LOCALIDADE, 
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
                          '$var_inpt_email' as DS_EMAIL_ALTERNATIVO,
                          '$var_inpt_ramal' as DS_RAMAL,
                          NULL as CD_USUARIO_REPROVA_OS,
                          NULL DT_USUARIO_REPROVA_OS,
                          NULL DT_ENTREGA, 
                          'E' as TP_PRIORIDADE,
                          NULL as QT_PRONTUARIOS,
                          'N' as SN_RECEBIDA,
                          NULL as CD_RESPONSAVEL,
                          'N' as SN_ETIQUETA_IMPRESSA,
                          'N' as SN_EMAIL_ENVIADO,
                          NULL as CD_PROGRAMACAO_PLANO,
                          'C' as TP_CLASSIFICACAO,
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
      $result_tb_os = oci_parse($conn_ora, $consulta_tb_os);							
      $valida_chamado = oci_execute($result_tb_os);

      if(!$valida_chamado){

        $erro = oci_error($result_tb_os);
        $msg_erro = htmlentities($erro['message']);
        echo $msg_erro;

      }else{

        $count = 1;

      }

    

    //EXECUTANDO INSERT OWNER PROJETO SOLICITACÃO
    $insert_tabela_proj = "INSERT INTO nucleoinfo.solicitacao
                                      (CD_SOLICITACAO, 
                                      CD_OS_MV, 
                                      CD_RESPONSAVEL,
                                      TP_PRIORIDADE,
                                      TP_TIPO, 
                                      ESTIMATIVA_ENTREGA, 
                                      RAMAL_SOLICITANTE,
                                      EMAIL_SOLICITANTE,
                                      SN_CKB_UNICA_VEZ,
                                      SN_CKB_MENSALMENTE,
                                      SN_CKB_TEMPOREAL,
                                      CD_USUARIO_CADASTRO,
                                      HR_CADASTRO, 
                                      CD_USUARIO_ULT_ALT,
                                      HR_ULT_ALT)
                                      VALUES
                                      (nucleoinfo.SEQ_CD_SOLICITACAO.nextval,
                                      '$var_nextval',
                                      NULL,
                                      'M',
                                      'S', 
                                      NULL, 
                                      '$var_inpt_ramal',
                                      '$var_inpt_email',
                                      '$ckb_unica_vez',
                                      '$ckb_mensalmente',
                                      '$ckb_temporeal',
                                      '$var_usuario_logado', 
                                      SYSDATE, 
                                      NULL,
                                      NULL)";

                                  $result_insert = oci_parse($conn_ora, $insert_tabela_proj);							
                                  $valida_insert = oci_execute($result_insert);
    

    if(!$valida_insert){

    $erro = oci_error($result_insert);
    $msg_erro = htmlentities($erro['message']);
    echo $msg_erro;

    }else{

    $count2 = 1;

    }
                                            




// Faça um loop para percorrer todas as informações dos arquivos
for ($i = 0; $i < $num_files; $i++) {

    // Informações do arquivo atual
    $caminho_temporario = $file['tmp_name'][$i];
    $tipo_do_arquivo = $file['type'][$i];

    // Abra o arquivo em modo binário para leitura
    $conteudo_arquivo = file_get_contents($caminho_temporario);

    // Se o arquivo foi lido com sucesso, insira o conteúdo no banco de dados
    if ($conteudo_arquivo !== false) {

        // Prepare os dados para inserção na tabela
        $nome_do_arquivo = $file['name'][$i];
        $extensao_do_arquivo = pathinfo($nome_do_arquivo, PATHINFO_EXTENSION);
        $conteudo_binario = $conteudo_arquivo;
        $cd_usuario_cadastro = $var_usuario_logado;
        $hr_cadastro = date('Y-m-d H:i:s');
        $cd_usuario_ult_alt = NULL;
        $hr_ult_alt =  NULL;

        // Prepare a consulta SQL para inserção do arquivo
        // Substitua "nucleoinfo.ANEXOS" pelos nomes corretos da sua tabela e colunas
        $sql = "INSERT INTO nucleoinfo.ANEXOS (CD_ANEXOS, CD_OS_MV, DOCUMENTO, EXTENSAO, CD_USUARIO_CADASTRO, HR_CADASTRO, CD_USUARIO_ULT_ALT, HR_ULT_ALT) 
                VALUES (nucleoinfo.SEQ_CD_ANEXOS.NEXTVAL, :cd_os_mv, EMPTY_BLOB(), :extensao, :cd_usuario_cadastro, TO_TIMESTAMP(:hr_cadastro, 'YYYY-MM-DD HH24:MI:SS'), :cd_usuario_ult_alt, TO_TIMESTAMP(:hr_ult_alt, 'YYYY-MM-DD HH24:MI:SS'))
                RETURNING DOCUMENTO INTO :blob";

        // Prepare a consulta SQL
        $stmt = oci_parse($conn_ora, $sql);

        // Associe os parâmetros BLOB e outros usando bind by name
        $blob = oci_new_descriptor($conn_ora, OCI_D_LOB);
        oci_bind_by_name($stmt, ':cd_os_mv', $var_nextval);
        oci_bind_by_name($stmt, ':extensao', $extensao_do_arquivo);
        oci_bind_by_name($stmt, ':cd_usuario_cadastro', $cd_usuario_cadastro);
        oci_bind_by_name($stmt, ':hr_cadastro', $hr_cadastro);
        oci_bind_by_name($stmt, ':cd_usuario_ult_alt', $cd_usuario_ult_alt);
        oci_bind_by_name($stmt, ':hr_ult_alt', $hr_ult_alt);
        oci_bind_by_name($stmt, ':blob', $blob, -1, OCI_B_BLOB);

        // Execute a consulta SQL
        $result = oci_execute($stmt, OCI_DEFAULT);

        if ($result) {
            // Escreva o conteúdo binário no BLOB
            if ($blob->save($conteudo_binario)) {
                oci_commit($conn_ora);
                //echo "Arquivo " . $nome_do_arquivo . " inserido com sucesso no banco de dados.<br>";

                $count3 = 1;

                $total = $count + $count2 + $count3;

                echo $total;

            } else {

                oci_rollback($conn_ora);
                echo "Erro ao escrever o conteúdo do arquivo " . $nome_do_arquivo . " no banco de dados.<br>";
            }

        } else {
            oci_rollback($conn_ora);
            echo "Erro ao inserir o arquivo " . $nome_do_arquivo . ": " . oci_error($stmt) . "<br>";
        }

        // Feche o cursor e o descritor do BLOB
        oci_free_statement($stmt);
        $blob->free();

    } else {

        echo "Erro ao abrir o arquivo " . $nome_do_arquivo . "<br>";

    }
}

?>
