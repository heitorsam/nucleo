<?php 
    include '../../conexao.php';
    //phpinfo();
    session_start();

    $count = count($_FILES['image']['name']);
   // $video = $_FILES['video']['name'];

    print_r($_POST);
   
    $var_usuario = $_SESSION['usuarioLogin'];
    $nr_solic = $_POST['nr_solic'];
    $nome = $_POST['nome_proj'];
    $link = $_POST['link'];
    $desc_foto = $_POST['desc_foto'];
    $descricao_projeto = $_POST['descricao_projeto'];
    $videoo = $_FILES['arquivideo']['tmp_name'];
  //print_r($_FILES);


    echo $cons_next_port = "SELECT seq_cd_portfolio.nextval AS CD_PORTIFOLIO FROM DUAL";

    $result_nextval_port = oci_parse($conn_ora, $cons_next_port);			
    $nextval_port = oci_execute($result_nextval_port);
    $row_nextval_port = oci_fetch_array($result_nextval_port);
  
    $var_nextval_port = $row_nextval_port['CD_PORTIFOLIO'];

    
    
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
                                  VALUES ($var_nextval, $var_nextval_port, 'FT', 'N',empty_blob(),'$desc_foto','$extensao','$var_usuario',SYSDATE,NULL,NULL) RETURNING DOCUMENTO INTO :image";

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

                    $cons_next = "SELECT SEQ_CD_GALERIA.NEXTVAL AS CD_GALERIA FROM DUAL";

                    $result_nextval = oci_parse($conn_ora, $cons_next);			
                    $nextval = oci_execute($result_nextval);
                    $row_nextval = oci_fetch_array($result_nextval);
                  
                    $var_nextval = $row_nextval['CD_GALERIA']; 

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

                  if(isset($_FILES['pdf'])){

                    $cons_next = "SELECT SEQ_CD_GALERIA.NEXTVAL AS CD_GALERIA FROM DUAL";

                    $result_nextval = oci_parse($conn_ora, $cons_next);			
                    $nextval = oci_execute($result_nextval);
                    $row_nextval = oci_fetch_array($result_nextval);
                  
                    $var_nextval = $row_nextval['CD_GALERIA']; 


                    $file = $_FILES['pdf']['name'];
                    print_r($_FILES['pdf']);
                    $pdf = $_FILES['pdf']['tmp_name'];
                    echo $extensao = strtolower(pathinfo($file,PATHINFO_EXTENSION));
                    //print_r($_FILES['arquivideo']);
                    //$video = $_FILES['arquivideo']['tmp_name'];
                    //$video = $_FILES['arquivideo']['error'];
                    // $videos = var_dump($video);

                    


                    // Decode base64 data, resulting in an image

                    $pdf = file_get_contents($pdf); 

                    $insert_gal = "INSERT INTO PORTAL_PROJETOS.GALERIA
                    (CD_GALERIA, CD_PORTFOLIO,TP_GALERIA, SN_PRINCIPAL,DOCUMENTO, LINK_DOC, EXTENSAO, CD_USUARIO_CADASTRO, HR_CADASTRO, CD_USUARIO_ULT_ALT, HR_ULT_ALT)
                    VALUES ($var_nextval, $var_nextval_port, 'DC', 'N',empty_blob(),'$desc_foto','$extensao','$var_usuario',SYSDATE,NULL,NULL) RETURNING DOCUMENTO INTO :pdf";

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

                //print_r ($_FILES);

                //var_dump ($_FILES);


      //Consulta seq_cd_galeria.nextval
  }
       
    $file_principal = $_FILES['image_principal']['name'];

    $image_principal = $_FILES['image_principal']['tmp_name'];
    $extensao_principal = strtolower(pathinfo($file_principal,PATHINFO_EXTENSION));
    $image_principal = file_get_contents($image_principal); 

    $insert_principal = "INSERT INTO PORTAL_PROJETOS.GALERIA
                                  (CD_GALERIA, CD_PORTFOLIO,TP_GALERIA, SN_PRINCIPAL,DOCUMENTO, LINK_DOC, EXTENSAO, CD_USUARIO_CADASTRO, HR_CADASTRO, CD_USUARIO_ULT_ALT, HR_ULT_ALT)
                                  VALUES (portal_projetos.SEQ_CD_GALERIA.NEXTVAL, $var_nextval_port, 'FT', 'S',empty_blob(),'$desc_foto','$extensao','$var_usuario',SYSDATE,NULL,NULL) RETURNING DOCUMENTO INTO :image";

                          //echo $consulta_insert;
                              $insere_dados_principal = oci_parse($conn_ora, $insert_principal);
                              $blob = oci_new_descriptor($conn_ora, OCI_D_LOB);
                              oci_bind_by_name($insere_dados_principal, ":image", $blob, -1, OCI_B_BLOB);

                              oci_execute($insere_dados_principal, OCI_DEFAULT);

                              if(!$blob->save($image_principal)) {
                                  oci_rollback($conn_ora);
                              }
                              else {
                                  oci_commit($conn_ora);
                              }

                              oci_free_statement($insere_dados_principal);
                              $blob->free();

  //Insert tabela Portifolio
    echo $insert_port = "INSERT INTO PORTAL_PROJETOS.PORTFOLIO PT
                                    VALUES
                                   ($var_nextval_port,
                                    $nr_solic,
                                    '$nome',
                                    '$descricao_projeto',
                                    '$link',
                                    '$var_usuario',
                                    SYSDATE,
                                    NULL,
                                    NULL)";

            $insert_portifolio = oci_parse($conn_ora, $insert_port);			
            $portifolio = oci_execute($insert_portifolio);                        
            
  $_SESSION['msg'] = 'Portfolio cadastrado com sucesso!';
                 
  header('Location: ../../config_portfolio.php');

?>