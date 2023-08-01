<?php 

    include 'cabecalho.php';


?>
    <h11><i class="fa-solid fa-star"></i> Perguntas Avaliação</h11>
    <span class="espaco_pequeno" style="width: 6px;" ></span>
    <h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
    <div class="div_br"> </div>
    <div class="row">
        <div class="col-md-3">
            Pergunta:
            <input type="text" id="inpt_pergunta" class="form-control">
        </div>
        <div class="col-md-1" style="text-align: center">
            Dissertativa
            <input class="check_box" type="checkbox" onclick="document.getElementById('ck_nota').checked = false" value="D" id="ck_dissertativa" class="form-control">
        </div>
        <div class="col-md-1" style="text-align: center">
            Nota
            <input class="check_box" type="checkbox" onclick="document.getElementById('ck_dissertativa').checked = false" value="N" id="ck_nota" class="form-control">
        </div>
        <div class="col-md-1">
            </br>
            <a class="btn btn-primary" onclick="ajax_salvar_pergunta()" id="btn_salvar"><i class="fa-solid fa-floppy-disk"></i></a>
        </div>
    </div>

</br>
<div id="mensagem"></div>
</br>
<div class="row">
    <div id="div_perguntas" class="col-md-12"></div>
</div>


<?php 
    include 'rodape.php';
?>

<script>

    $(document).ready(function() {
            console.log('sai do console curioso')
            $('#div_perguntas').load('funcoes/perguntas_avaliacao/ajax_lista_perguntas.php')
    })

    function ajax_salvar_pergunta(){
        inpt_pergunta = document.getElementById('inpt_pergunta')
        ck_dissertativa = document.getElementById('ck_dissertativa').checked
        ck_nota = document.getElementById('ck_nota').checked
        if(ck_nota == false && ck_dissertativa == false){
            alert('Escolha o tipo da pergunta!')
        }else{
            if(inpt_pergunta.value == ''){
                alert('Informe o titulo da pergunta!')
                inpt_pergunta.focus()
            }else{
                if(ck_dissertativa == true){
                    ck = 'DE'
                }else{
                    ck = 'NT'
                }
                $.ajax({
                    url:"funcoes/perguntas_avaliacao/ajax_cad_pergunta.php",
                    type: "POST",
                    data: {
                        tipo: ck,
                        texto: inpt_pergunta.value
                    },
                    cache: false,
                    success: function(dataResult){                    
                        console.log(dataResult)

                        if(dataResult == ''){
                            //MENSAGEM            
                            var_ds_msg = 'Pergunta%20cadastrada%20com%20sucesso!';
                            var_tp_msg = 'alert-success';
                            //var_tp_msg = 'alert-danger';
                            //var_tp_msg = 'alert-primary';
                            $('#mensagem').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
                        }else{
                            //MENSAGEM
                            var_ds_msg = 'Ocorreu%20um%20erro!';
                            //var_tp_msg = 'alert-success';
                            var_tp_msg = 'alert-danger';
                            //var_tp_msg = 'alert-primary';
                            $('#mensagem').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
                        }
                        $('#div_perguntas').load('funcoes/perguntas_avaliacao/ajax_lista_perguntas.php')
                    }

                })               
            }
        }
    }

    function ajax_apagar_pergunta(cd_pergunta){
        resultado = confirm('Realmente deseja apagar essa pergunta?')

        if(resultado == true){
            $.ajax({
                url:"funcoes/perguntas_avaliacao/ajax_apagar_pergunta.php",
                type: "POST",
                data: {
                    cd_pergunta: cd_pergunta
                },
                cache: false,
                success: function(dataResult){                    
                    console.log(dataResult)
                    var_ds_msg = 'Pergunta%20apagada%20com%20sucesso!';
                    var_tp_msg = 'alert-success';
                    //var_tp_msg = 'alert-danger';
                    //var_tp_msg = 'alert-primary';
                    $('#mensagem').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
                    $('#div_perguntas').load('funcoes/perguntas_avaliacao/ajax_lista_perguntas.php')
                    
                }

            })   
        }
    }

</script>