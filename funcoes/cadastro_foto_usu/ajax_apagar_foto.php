<?php 

session_start();
include '../../conexao.php';

$var_usu = $_POST['usu_session'];

echo $cons_del_foto = "DELETE 
                       FROM portal_projetos.ANEXO_FOTOS af
                       WHERE af.CD_USUARIO_CADASTRO = '$var_usu'";

    $res_cons_del_foto = oci_parse($conn_ora,$cons_del_foto);

    oci_execute($res_cons_del_foto);

?>