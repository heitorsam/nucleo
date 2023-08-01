<?php 
    include '../../conexao.php';

    session_start();

    $tp = $_POST['tipo'];

    $texto = $_POST['texto'];

    $usu = $_SESSION['usuarioLogin'];

    $consulta = "INSERT INTO portal_projetos.pergunta (CD_PERGUNTA,
                                                       TP_PERGUNTA,
                                                       DS_PERGUNTA,
                                                       CD_USUARIO_CADASTRO,
                                                       HR_CADASTRO,
                                                       CD_USUARIO_ULT_ALT,
                                                       HR_ULT_ALT)
                                                    VALUES(portal_projetos.seq_cd_pergunta.nextval,
                                                          '$tp',
                                                          '$texto',
                                                          '$usu',
                                                          SYSDATE,
                                                          NULL,
                                                          NULL)
                                                    ";

    $resultado = oci_parse($conn_ora,$consulta);

    oci_execute($resultado);




?>