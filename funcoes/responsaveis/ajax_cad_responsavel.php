<?php 

    include '../../conexao.php';
    session_start();

    $var_usuario = $_SESSION['usuarioLogin'];

    $usuario = $_POST['usuario'];

    $email = $_POST['email'];

    $funcao = $_POST['funcao'];

    $consulta_responsavel = "SELECT usu.cd_usuario, usu.nm_usuario, func.cd_func FROM dbasgu.usuarios usu
                                INNER JOIN dbamv.funcionario func
                                ON func.nm_func = usu.nm_usuario
                                WHERE usu.cd_usuario = '$usuario'";

    $resultado_responsavel = oci_parse($conn_ora, $consulta_responsavel);

    oci_execute($resultado_responsavel);

    $row_responsavel = oci_fetch_array($resultado_responsavel);

    $responsavel = $row_responsavel['CD_FUNC'];

    $consulta_insert = "INSERT INTO portal_projetos.responsavel 
                                    (
                                    CD_RESPONSAVEL,     
                                    CD_USUARIO_MV,  
                                    EMAIL, 
                                    TP_FUNCAO,
                                    CD_USUARIO_CADASTRO,
                                    HR_CADASTRO,
                                    CD_USUARIO_ULT_ALT,
                                    HR_ULT_ALT)  
                                VALUES(
                                        portal_projetos.SEQ_CD_RESPONSAVEL.nextval,
                                        '$responsavel',
                                        '$email',
                                        '$funcao',
                                        '$usuario',
                                        sysdate,
                                        '$var_usuario',
                                        sysdate)";
   
    $resultado_insert = oci_parse($conn_ora,$consulta_insert);

    oci_execute($resultado_insert);
                                                                

?>