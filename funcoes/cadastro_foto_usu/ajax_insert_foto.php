<?php

session_start();

include '../../conexao.php';

//print_r($_FILES);

$var_usu = $_SESSION['usuarioLogin'];

$blob_ft = $_FILES['frm_selecao_arquivo'];

$file = $_FILES['frm_selecao_arquivo']['name'];

$image = $_FILES['frm_selecao_arquivo']['tmp_name'];

$extensao = strtolower(pathinfo($file,PATHINFO_EXTENSION));

$image = file_get_contents($image);

$insert_gal = "INSERT INTO portal_projetos.ANEXO_FOTOS
                                  (CD_ANEXO_FOTO, BLOB_FOTO, CD_USUARIO_CADASTRO, HR_CADASTRO, CD_USUARIO_ULT_ALT, HR_ULT_ALT)
                                  VALUES (portal_projetos.SEQ_CD_ANEXO_FOTO.nextval, empty_blob(), '$var_usu', SYSDATE, '$var_usu', SYSDATE ) RETURNING BLOB_FOTO INTO :image";


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

header("Location: ../../cadastro_perfil.php");

?>
