<?php

include 'cabecalho.php';
include 'conexao.php';

$var_usuario_login = $_SESSION['usuarioLogin'];


$consulta_foto = "SELECT af.BLOB_FOTO,
                         af.CD_USUARIO_CADASTRO
                  FROM portal_projetos.ANEXO_FOTOS af
                  WHERE af.CD_USUARIO_CADASTRO = '$var_usuario_login'";

$res_consulta_foto = oci_parse($conn_ora, $consulta_foto);

oci_execute($res_consulta_foto);

$row_foto = oci_fetch_array($res_consulta_foto);

$var_usuario = @$row_foto['CD_USUARIO_CADASTRO'];

?>

<!--TITULO E BOTÃO VOLTAR-->
<h11><i class="fa-solid fa-camera-retro"></i> Perfil</h11>
<span class="espaco_pequeno" style="width: 6px;" ></span>
<h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
<div class="div_br"></div>

<div class="div_br"> </div>


    <!--ESTRUTURA CADASTRO DE PERFIL-->

        <?php if(isset($row_foto['BLOB_FOTO'])){

            $imagem = $row_foto['BLOB_FOTO'] ->load(); // (1000) = 1kB
            $imagem = base64_encode($imagem);

        ?>
            <div class='col-md-3'>

                <input type="text"  id="usu_session"class="form form-control" value = <?php echo $var_usuario ?> hidden></input>
                
            </div>

            <div class="foto_usu" style="width: 320px; height: 260px; border: solid 1px #c7c7c7; 
                        background-image: url('data:image;base64,<?php echo $imagem; ?>');
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center center;">
            </div>
            
            <a type="button" onclick="ajax_apagar_foto()" class="btn btn-adm" style="width: 320px;"><i class="fa-solid fa-trash-can"></i></a>

        <?php

        } else{
        
        ?>

            <div class="row">

                <!--FORM-->
                <form action="funcoes/cadastro_foto_usu/ajax_insert_foto.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="col-md-12">

                        <!--SELECIONA ARQUIVO-->
                        <input style="margin: 0px;" class="select_archive" id="selecao_arquivo" type="file" accept="image/*" name="frm_selecao_arquivo" required>
                        <button type="submit" id="bnt_envia_foto" class="select_archive"
                        style="border: none; padding: 9px 14px 9px 14px; margin: 0px;"><i class="fa-solid fa-plus"></i></button>

                    </div>

                    
                </form>

            </div>

<?php  } ?>


<script>

    /*FUNÇÃO DELETAR ITEM DA TABELA*/
    function ajax_apagar_foto(){

    var usuario = document.getElementById('usu_session').value;

    resultado = confirm("Deseja excluir a foto?");

    if(resultado == true){
        $.ajax({
            url: "funcoes/cadastro_foto_usu/ajax_apagar_foto.php",
            type: "POST",
            data: {
                usu_session: usuario
                },
            cache: false,
            success: function(dataResult){

                //alert(dataResult);
                //console.log(dataResult)
                document.location.reload(true);

            }

        });  

    }
    }

</script>

<?php

    include 'rodape.php';

?>


