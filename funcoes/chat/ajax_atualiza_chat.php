<?php

    session_start();
    //CONEXAO
    include '../../conexao.php';    

    $var_cd_os = $_GET['cd_os']; 

    $var_usuario_login = $_SESSION['usuarioLogin'];

    //CONSULTA OS
    $consulta_os = "SELECT *
                    FROM (SELECT  ROWNUM AS LINHA,
                                   res.*
                            FROM(SELECT usu.CD_USUARIO,
                                        ct.CD_CHAT,
                                        ct.CD_OS,
                                        ct.TP_CHAT,
                                        portal_projetos.FNC_RETORNA_TXT_LIMITE_CARACT(ct.MSG, 3999) AS MSG,
                                        usu.NM_USUARIO,
                                        TO_CHAR(ct.HR_CADASTRO, 'DD/MM/YYYY HH24:MI:SS') AS HR_CADASTRO,
                                        (SELECT resp.TP_FUNCAO
                                        FROM portal_projetos.RESPONSAVEL resp
                                        WHERE resp.CD_USUARIO_CADASTRO = usu.CD_USUARIO) AS TP_FUNCAO,
                                        CASE
                                        WHEN (SELECT resp.TP_FUNCAO
                                                FROM portal_projetos.RESPONSAVEL resp
                                                WHERE resp.CD_USUARIO_CADASTRO = usu.CD_USUARIO) = 'AN' THEN
                                        'ANALISTA DE PROJETOS'
                                        WHEN (SELECT resp.TP_FUNCAO
                                                FROM portal_projetos.RESPONSAVEL resp
                                                WHERE resp.CD_USUARIO_CADASTRO = usu.CD_USUARIO) = 'AD' THEN
                                        'AUXILIAR DE PROJETOS'
                                        ELSE
                                        'SOLICITANTE'
                                        END AS FUNCAO,
                                        (SELECT af.BLOB_FOTO
                                        FROM portal_projetos.ANEXO_FOTOS af
                                        WHERE af.CD_USUARIO_CADASTRO = usu.CD_USUARIO) AS FOTO
                                        FROM portal_projetos.CHAT ct
                                        INNER JOIN dbasgu.USUARIOS usu
                                        ON usu.CD_USUARIO = ct.CD_USUARIO_CADASTRO
                                        WHERE ct.CD_OS = '$var_cd_os'
                                        ORDER BY ct.HR_CADASTRO DESC) res)tot
                    WHERE tot.LINHA BETWEEN 1 AND 5
                    ORDER BY 1 DESC";

    $result_os  = oci_parse($conn_ora, $consulta_os);

    oci_execute($result_os);

?>

<div class="modal-header" style="border: none !important;">

    <h5 class="modal-title" id="exampleModalLabel" style="border: none !important;">

        <div style="background-color: #ffd9ac; border-radius: 10px; padding: 3px;">

            <?php echo 'OS: ' . $var_cd_os; ?>

        </div>
    
    </h5>

    <button type="button" class="close"  aria-label="Close" onclick="fechar_modal()">
        <span aria-hidden="true">&times;</span>
    </button>

</div>

<div class="div_br"> </div>

<div class="modal-footer" style="border: none !important; padding: 0px;">

    <div class="div_br"> </div>

    <div style="width: 100%; margin: 0 auto;"> 

    <?php

echo '<div style="margin: 0 auto; width: 98%; height: 20px; clear: both; border-bottom: 1px solid #dee2e6; margin-top: -35px !important; margin-bottom: 10px; "></div>';

        while($row_os = oci_fetch_array($result_os) ){

            echo '<div style="clear: both; width: 80%; height: 30px; font-size: 14px; text-align: center;
                               margin: 0 auto;">' . $row_os['HR_CADASTRO'] . ' - ' . $row_os['NM_USUARIO'] .'<div style="background-color: #ffd9ac; width: 45%; margin: 0 auto; border-radius: 5px;"> ' . $row_os['FUNCAO'] . '</div></div>';
  
            echo '<div class="div_br"> </div>';
            echo '<div class="div_br"> </div>';
            



            if(isset($row_os['TP_FUNCAO'])){

                if($row_os['TP_FUNCAO'] == 'AN'){

                    //FOTOS
                    $imagem = $row_os['FOTO'] ->load(); // (1000) = 1kB
                    $imagem = @base64_encode($imagem);

                    echo '<img alt="teste_img" class="foto_usu" style="width:50px; height: 50px; float:left; margin-right: 10px; border-radius: 30px; border-color: #d6eaf8 !important; border: solid 2px;" src="data:image;base64,' . $imagem . '">';
                    //echo $row_os['MSG'];
                    echo '<div class="mensagem_chat_an">' . @$row_os['MSG'] . '</div>';

                }elseif($row_os['TP_FUNCAO'] == 'AD'){

                    //FOTOS
                    $imagem = @$row_os['FOTO'] ->load(); // (1000) = 1kB
                    $imagem = @base64_encode($imagem);

                    echo '<img alt="teste_img" class="foto_usu" style="width:50px; height: 50px; float:left; margin-right: 10px; border-radius: 30px; border-color: #d6eaf8 !important; border: solid 2px;" src="data:image;base64,' . $imagem . '">';
                    //echo $row_os['MSG'];
                    echo '<div class="mensagem_chat_an">' . $row_os['MSG'] . '</div>';

                }

    

            } else{

                if($row_os['TP_FUNCAO'] == NULL && $row_os['FUNCAO']  == 'SOLICITANTE' && $row_os['FOTO'] <> NULL){

                    //FOTOS
                    $imagem = $row_os['FOTO'] ->load(); // (1000) = 1kB
                    $imagem = base64_encode($imagem);

                    echo '<img alt="teste_img" class="foto_usu" style="width:50px; height: 50px; float:right; margin-left: 10px; border-radius: 30px; border-color: #d6eaf8 !important; border: solid 2px;" src="data:image;base64,' . $imagem . '">';
                    echo '<div class="mensagem_chat_usu">' . $row_os['MSG'] . '</div>';

                }else{

                    echo '<img alt="teste_img" class="foto_usu" style="width:50px; height: 50px; float:right; margin-left: 10px; border-radius: 30px; border-color: #d6eaf8 !important; border: solid 2px; opacity: 30%;" src="img/outros/usuario.png">';
                    echo '<div class="mensagem_chat_usu">' . $row_os['MSG'] . '</div>';
                  

                }
                
            }     

            echo '<div style="margin: 0 auto; width: 98%; height: 20px; clear: both; border-bottom: 1px solid #dee2e6; margin-top: 10px !important; margin-bottom: 10px; "></div>';
            echo '<div style="clear: both;"> </div>';
        }

        echo '<div style="clear: both;"> </div>';
        echo '<div class="div_br"> </div>';

    ?>
        
        <?php if($_GET['tp'] == 'Recebido'){ ?>

            <center>

                <input id="input_msg" onclick="stop_interval()" class="btn_msg" type="text">

                <img class="btn_msg_enviar" src="img/botoes/enviar_msg.png" onclick="cad_msg(<?php echo $var_cd_os; ?>)">
                    
            </center>     
             
        <?php } ?>
            
    </div>

</div>