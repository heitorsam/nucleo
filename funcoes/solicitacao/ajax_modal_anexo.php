<?php 
    $var_cd_os = $_GET['cd_os']; 
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> 
        <div style="background-color: #ffd9ac; border-radius: 10px; padding: 3px;">
            <?php echo 'ANEXOS - OS: ' . $var_cd_os; ?>
        </div>
    </h5>
    <button type="button" class="close" onclick="ajax_modal_sol(<?php echo $var_cd_os ?>)">
    <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div id="div_carrosel"></div>
</div>


<script>

    $(document).ready(function() {
        $('#div_carrosel').load('funcoes/solicitacao/ajax_galeria_anexos.php?cd_solicitacao=<?php echo $var_cd_os ?>')
        
    })

</script>