<?php 

    include '../../conexao.php';

    session_start();

    $usuario = $_SESSION['usuarioLogin'];

    $cd_port = $_POST['cd_port_'];

    $nome = $_POST['nome'];

    $link = $_POST['link'];

    $ds = $_POST['descricao'];

    $consulta = "UPDATE portal_projetos.portfolio prt SET prt.NM_PROJETO = '$nome', 
                                                            prt.LINK_PROJETO = '$link', 
                                                            prt.DS_PROJETO = '$ds', 
                                                            CD_USUARIO_ULT_ALT = '$usuario', 
                                                            HR_ULT_ALT = SYSDATE  
                                                            WHERE prt.CD_PORTFOLIO = $cd_port";

    $resultado = oci_parse($conn_ora, $consulta);

    oci_execute($resultado);

    $sn_foto = $_POST['editado_foto'];

    if($sn_foto == 'S'){
        print_r($_FILES);
        $file = $_FILES['image']['name'];
        $image = $_FILES['image']['tmp_name'];
        $extensao = strtolower(pathinfo($file,PATHINFO_EXTENSION));

        $image = file_get_contents($image); 

        $insert_gal = "UPDATE PORTAL_PROJETOS.GALERIA SET DOCUMENTO = empty_blob(), 
                                                            EXTENSAO = '$extensao', 
                                                            CD_USUARIO_ULT_ALT = '$usuario', 
                                                            HR_ULT_ALT = SYSDATE
                                                            WHERE SN_PRINCIPAL = 'S' 
                                                            AND CD_PORTFOLIO = $cd_port 
                                     RETURNING DOCUMENTO INTO :image";
  
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

    $sn_video = $_POST['editado_video'];

    if($sn_video == 'S'){
        @unlink('../../upload_videos/'.$cd_port.'.mp4');

        $filename = $_FILES['video']['name'] ;
        //$vid_extensao = $_FILES['video']['type'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filetmpname = $_FILES['video']['tmp_name'];
        $folder = 'C:\xampp\htdocs\portal_projetos\upload_videos/';
        $new_vid_name = $cd_port . '.' . $ext;

        if(move_uploaded_file($filetmpname, $folder.$new_vid_name )){
        
            /*echo 'Deu Certo!';
            echo '</p>';*/

            // print_r($_FILES);

        }else{

            $error = '<li>Erro</li>';
        
        }
    }

    $sn_pdf = $_POST['editado_pdf'];

    if($sn_pdf == 'S'){
        print_r($_FILES);
        $file = $_FILES['pdf']['name'];
        $pdf = $_FILES['pdf']['tmp_name'];
        $extensao = strtolower(pathinfo($file,PATHINFO_EXTENSION));

        $pdf = file_get_contents($pdf); 

        $insert_gal = "UPDATE PORTAL_PROJETOS.GALERIA SET DOCUMENTO = empty_blob(), 
                                                            EXTENSAO = '$extensao', 
                                                            CD_USUARIO_ULT_ALT = '$usuario', 
                                                            HR_ULT_ALT = SYSDATE
                                                            WHERE SN_PRINCIPAL = 'S' 
                                                            AND CD_PORTFOLIO = $cd_port 
                                     RETURNING DOCUMENTO INTO :pdf";
  
                            //echo $consulta_insert;
                                $insere_dados = oci_parse($conn_ora, $insert_gal);
                                $blob = oci_new_descriptor($conn_ora, OCI_D_LOB);
                                oci_bind_by_name($insere_dados, ":pdf", $blob, -1, OCI_B_BLOB);
  
                                oci_execute($insere_dados, OCI_DEFAULT);
  
                                if(!$blob->save($pdf)) {
                                    oci_rollback($conn_ora);
                                }
                                else {
                                    oci_commit($conn_ora);
                                }
  
                                oci_free_statement($insere_dados);
                                $blob->free();
    }

    $_SESSION['msg'] = 'Portfolio editado com sucesso!';
    header('location: ../../config_portfolio.php')
?>