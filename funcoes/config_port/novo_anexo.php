<?php 

    include '../../conexao.php';

    session_start();

    $var_usuario = $_SESSION['usuarioLogin'];

    $count = count($_FILES['image']['name']);

    $var_nextval_port = $_POST['cd_port'];

    for ($i= 0; $i < $count; $i++){
    
        $file = $_FILES['image']['name'][$i];
        
        $image = $_FILES['image']['tmp_name'][$i];
        $extensao = strtolower(pathinfo($file,PATHINFO_EXTENSION));
        //print_r($_FILES['arquivideo']);
        //$video = $_FILES['arquivideo']['tmp_name'];
        //$video = $_FILES['arquivideo']['error'];
        // $videos = var_dump($video);
  
        
  
  
      // Decode base64 data, resulting in an image
  
          $image = file_get_contents($image); 
        //$video = @base64_encode(file_get_contents($videoo)); 
          //      print_r($video);
            
        
        
        //Consulta seq_cd_galeria.nextval
  
        $cons_next = "SELECT SEQ_CD_GALERIA.NEXTVAL AS CD_GALERIA FROM DUAL";
  
        $result_nextval = oci_parse($conn_ora, $cons_next);			
        $nextval = oci_execute($result_nextval);
        $row_nextval = oci_fetch_array($result_nextval);
      
        $var_nextval = $row_nextval['CD_GALERIA']; 
  
  
  
        //Insert Galeria Fotos
  
          $insert_gal = "INSERT INTO PORTAL_PROJETOS.GALERIA
                                    (CD_GALERIA, CD_PORTFOLIO,TP_GALERIA, SN_PRINCIPAL,DOCUMENTO, LINK_DOC, EXTENSAO, CD_USUARIO_CADASTRO, HR_CADASTRO, CD_USUARIO_ULT_ALT, HR_ULT_ALT)
                                    VALUES ($var_nextval, $var_nextval_port, 'FT', 'N',empty_blob(),'edit','$extensao','$var_usuario',SYSDATE,NULL,NULL) RETURNING DOCUMENTO INTO :image";
  
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
        
        
        //Insert Galeria video   
  
                    if(isset($_FILES['arquivideo'])){
  
                      $filename = $_FILES['arquivideo']['name'] ;
                      //$vid_extensao = $_FILES['arquivideo']['type'];
                      $ext = pathinfo($filename, PATHINFO_EXTENSION);
                      $filetmpname = $_FILES['arquivideo']['tmp_name'];
                      $folder = 'C:\xampp\htdocs\portal_projetos\upload_videos/';
                      $new_vid_name = $var_nextval_port . '.' . $ext;
  
                      if(move_uploaded_file($filetmpname, $folder.$new_vid_name )){
                    
                        /*echo 'Deu Certo!';
                        echo '</p>';*/
  
                        // print_r($_FILES);
  
                      }else{
  
                        $error = '<li>Erro</li>';
                      
                      }
                                        
                    }
  
                  //print_r ($_FILES);
  
                  //var_dump ($_FILES);
  
  
        //Consulta seq_cd_galeria.nextval
    }

    $_SESSION['msg'] = 'Anexo(s) cadastrado com sucesso!';
    header('location:../../editar_portfolio.php?cd_port='.$var_nextval_port)

?>