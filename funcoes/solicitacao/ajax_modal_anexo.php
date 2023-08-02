<?php 
    $var_cd_os = $_GET['os_mv']; 
?>

<div class="modal-body">
    <div id="div_carrosel"></div>
</div>


<script>

    $(document).ready(function() {
        $('#div_carrosel').load('funcoes/solicitacao/ajax_galeria_anexos.php?os_mv=<?php echo $var_cd_os ?>')
        
    })

</script>