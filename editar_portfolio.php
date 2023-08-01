<?php 
    include 'cabecalho.php'; 

    include 'conexao.php';

    $cd_port = $_GET['cd_port'];

    $consulta_port = "SELECT * FROM portal_projetos.portfolio port WHERE port.cd_portfolio = $cd_port";

    $resultado_port = oci_parse($conn_ora, $consulta_port);

    oci_execute($resultado_port);

    $row_post = oci_fetch_array($resultado_port);
?>

<h11><i class="fa-solid fa-pen-to-square"></i> Editar Portfólio</h11>
<span class="espaco_pequeno" style="width: 6px;" ></span>
<h27> <a href="config_portfolio.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
<div class="div_br"> </div> </br>
<!--MENSAGENS-->
<?php
include 'js/mensagens.php';
include 'js/mensagens_usuario.php';
?>
<form method="post" action="funcoes/config_port/ajax_editar_port.php" onsubmit="return confirm('Deseja editar esse portfolio?')" enctype="multipart/form-data">
    <input type="text" name="cd_port "value="<?php echo $cd_port ?>" hidden>
    <div class="row">
        <div class="col-md-3">
            Nome:
            <input type="text" name="nome" class="form-control" value="<?php echo $row_post['NM_PROJETO'] ?>" required>
        </div>
        <div class="col-md-4">
            Link:
            <input type="text" name="link" class="form-control" value="<?php echo $row_post['LINK_PROJETO'] ?>" required>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="col-md-12">
            Descrição:
            <textarea name="descricao" class="form-control" required><?php echo $row_post['DS_PROJETO'] ?></textarea>
        </div>
    </div>
    </br>

        <div class="col-md-2">
            </br>
            <a class="btn btn-primary" onclick="ajax_anexos(<?php echo $cd_port ?>,'A')"><i class="fa-solid fa-link"></i> Anexos</a>
        </div>
        <div class="div_br"> </div>
        

        <div class="col-md-2">
            Foto Principal:
            <input class="select_archive" name="image" onchange="$(function(){ if(this.value != ''){ document.getElementById('editado_foto').value = 'S'}else{ document.getElementById('editado_foto').value = 'N' } })" type="file" accept="image/*">      
            <input name="editado_foto" id="editado_foto" type="text" value="N" hidden>  
        </div>
        
        <div class="div_br"> </div>

        <div class="col-md-2">
            Vídeo:
            <input class="select_archive" name="video" onchange="$(function(){ if(this.value != ''){ document.getElementById('editado_video').value = 'S'}else{ document.getElementById('editado_video').value = 'N' } })" type="file" accept="image/*">      
            <input name="editado_video" id="editado_video" type="text" value="N" hidden>  
        </div>

        <div class="div_br"> </div>

        <div class="col-md-2">
            Tutorial:</br>
            <input class="select_archive" name="pdf" onchange="$(function(){ if(this.value != ''){ document.getElementById('editado_pdf').value = 'S'}else{ document.getElementById('editado_pdf').value = 'N' } })" type="file" accept="application/pdf" >
            <input name="editado_pdf" id="editado_pdf" type="text" value="N" hidden>  
        </div>

    </br>
    <div class="row">
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
        </div>
    </div>
</form>
<div class="modal fade" id="modal_anexo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="div_anexo">
            
        </div>
    </div>
</div>




<?php 
    include 'rodape.php'; 
?>

<script>

    function ajax_anexos(cd_port, tp){
        $('#div_anexo').load('funcoes/config_port/ajax_modal_anexos.php?cd_port='+ cd_port)
        $('#modal_anexo').modal('show')
        
        
    }

    

</script>