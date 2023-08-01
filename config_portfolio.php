<?php 

    include 'cabecalho.php';

    include 'conexao.php';


?>

<h11><i class="fas fa-cog efeito-zoom"></i> Configuração Portfólio</h11>
<span class="espaco_pequeno" style="width: 6px;" ></span>
<h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
<div class="div_br"></div>

<?php
include 'js/mensagens.php';
include 'js/mensagens_usuario.php';
?>

<div class="row">
    <div class="col-md-3">
        Potfolio:
        <input id="inpt_port" class="form-control" onkeyup="ajax_buscar_portfolio()" type="text">
    </div>
    <div class="col-md-1">
        Quantidade:
        <select id="slt_qtd" onchange="ajax_buscar_portfolio()" class="form-control">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="30">30</option>
        </select>
    </div>
    <div class="col-md-2">
        </br>
        <a href="cadastro_port.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Novo</a>
    </div>
</div>

</br>

<div id="div_lista"></div>


<?php 

    include 'rodape.php';

?>

<script>

    $(document).ready(function(){
        ajax_buscar_portfolio()
    })

    function ajax_buscar_portfolio(){
        qtd = document.getElementById('slt_qtd').value
        port = document.getElementById('inpt_port').value
        $('#div_lista').load('funcoes/config_port/ajax_lista_port.php?qtd='+qtd+'&port='+port)
    }

    function ajax_apagar_portfolio(cd_port){
        result = confirm('Deseja apagar esse portfolio?')

        if(result == true){
            console.log(cd_port)
            $.ajax({
                url:"funcoes/config_port/ajax_apagar_port.php",
                type: "POST",
                data: {
                    cd_port: cd_port
                },
                cache: false,
                success: function(dataResult){                    
                    console.log(dataResult)                
                    ajax_buscar_portfolio()            
                }

            })   
        } 
    }


</script>