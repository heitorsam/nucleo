<?php 

    $cd_port = $_GET['cd_port'];

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> 
        Anexos
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <form action="funcoes/config_port/novo_anexo.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-2">
                
                Anexos:
                <input class="select_archive" id="anexos_fotos" accept="image/*" name="image[]" multiple="multiple" type="file" required>
                <input name="cd_port" type="text" value="<?php echo $cd_port ?>" hidden>
                
            </div>
            <div class="col-md-4" style="padding-left: 270px; padding-top: 12px;">
                </br>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i></button>

            </div>

        </div>
    </form>
    </br>
    <div id="div_carrosel"></div>
</div>


<script>

    $(document).ready(function() {
        $('#div_carrosel').load('funcoes/config_port/ajax_galeria_anexos.php?cd_port=<?php echo $cd_port ?>')
        
    })

    function ajax_apagar_anexo(cd_anexo, i){
        resposta = confirm('Deseja apagar esse anexo?')

        if(resposta == true){
            $.ajax({
                url:"funcoes/config_port/ajax_apagar_anexo.php",
                type: "POST",
                data: {
                    cd_anexo: cd_anexo
                },
                cache: false,
                success: function(dataResult){                    
                    $('#detalhejust'+i).modal('hide');
                    $('#div_carrosel').load('funcoes/config_port/ajax_galeria_anexos.php?cd_port=<?php echo $cd_port ?>')
      
                }

            })
        }else{
            $('#detalhejust'+i).modal('hide');


        }
    }

</script>