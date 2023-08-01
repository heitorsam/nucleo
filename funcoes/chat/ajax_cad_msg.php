<?php
    include '../../conexao.php';

    session_start();

    $cd_usuario = $_SESSION['usuarioLogin'];

    $cd_os = $_POST['cd_os'];
    $tp_msg = $_POST['tp_msg'];
    $ds_msg = $_POST['msg'];

    $cons_msg = "INSERT INTO portal_projetos.CHAT
                            (CD_CHAT,
                            CD_OS,
                            TP_CHAT,
                            MSG,
                            CD_USUARIO_CADASTRO,
                            HR_CADASTRO,
                            CD_USUARIO_ULT_ALT,
                            HR_ULT_ALT)
                        VALUES
                            (portal_projetos.SEQ_CD_CHAT.NEXTVAL,
                            $cd_os,
                            '$tp_msg',
                            EMPTY_CLOB(),
                            '$cd_usuario',
                            SYSDATE,
                            NULL,
                            NULL)
                        RETURNING
                        MSG
                        INTO :msg1";

    $result_msg = oci_parse($conn_ora, $cons_msg);

    $myLOB1 = oci_new_descriptor($conn_ora, OCI_D_LOB);

    oci_bind_by_name($result_msg, ":msg1", $myLOB1, -1, OCI_B_CLOB);

    $resultado = oci_execute($result_msg, OCI_NO_AUTO_COMMIT);

    // Now save a value to the LOB
    $myLOB1->save($ds_msg);

    oci_commit($conn_ora);
    
    // Free resources
    oci_free_statement($result_msg);

    $myLOB1->free();


    //////////////////
    //ENVIANDO EMAIL//
    //////////////////

    $cons_email = "SELECT sol.email_solicitante AS EMAIL,
                    (SELECT usu.nm_usuario
                    FROM dbasgu.usuarios usu
                    WHERE usu.cd_usuario = sol.cd_usuario_cadastro) AS NOME
                    FROM portal_projetos.solicitacao sol 
                    WHERE sol.cd_os_mv = $cd_os";
    $result_email= oci_parse($conn_ora, $cons_email);
    oci_execute($result_email);
    $row_email = oci_fetch_array($result_email);

    $txt = "
    Tem uma nova mensagem no chat da solicitação ".$cd_os.".
    <p></p>";
    $titulo = 'Nova mensagem';
    $imagem = 'background-color: #12b24f;'; 
    
    $nome = $row_email['NOME'];
    $email = $row_email['EMAIL']; 
    include '../../email_enviar.php'

?>