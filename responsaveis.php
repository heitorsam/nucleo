<?php 

    include 'cabecalho.php'; 
    include 'conexao.php';

?>


<h11><i class="fa-solid fa-users"></i> Responsáveis</h11>
<span class="espaco_pequeno" style="width: 6px"></span>
<h27><a href="home.php" style="color: #444444; text-decoration: none;"><i class="fa fa-reply" aria-hidden="true"></i> Voltar</a></h27>

</br>
</br>

<div class="row">

    <div class="col-md-3">

        Código do Usuario:
        <?php 
            
            //CONSULTA_LISTA
            $consulta_lista = "SELECT usu.CD_USUARIO AS NOME
                                    FROM dbasgu.USUARIOS usu
                                    INNER JOIN dbamv.funcionario func
                                    ON func.nm_func = usu.nm_usuario
                                WHERE usu.SN_ATIVO = 'S'
                                AND usu.nm_usuario in ( SELECT nm_func from dbamv.funcionario)
                                ORDER BY usu.CD_USUARIO ASC";
            $result_lista = oci_parse($conn_ora, $consulta_lista);																									

            //EXECUTANDO A CONSULTA SQL (ORACLE)
            oci_execute($result_lista);            

        ?>

        <script>

            //LISTA
            var countries = [     
                <?php
                    while($row_lista = oci_fetch_array($result_lista)){	
                        echo '"'. str_replace('"' , '', $row_lista['NOME']) .'",';                
                    }
                ?>
            ];

            </script>

        <?php

            //AUTOCOMPLETE
            include 'funcoes/responsaveis/autocomplete_usuario.php';

        ?>

    </div>

    <div class="col-md-3">
        E-mail:
        <input type="email" id="inpt_email" class="form-control">
    </div>

    <div class="col-md-2">
        </br>
        <button class="btn btn-primary" onclick="ajax_cad_responsavel()" id="btn_cad"><i class="fa-solid fa-plus"></i></button>
    </div>

</div>

</br>

    <div id="mensagem"></div>

</br>

<div id="div_lista"></div>

<script>

    
    window.onload = function() {

        ajax_lista_responsavel();

    }; 

    function ajax_lista_responsavel(){
        
        $('#div_lista').load('funcoes/responsaveis/ajax_lista_responsaveis.php')

    }
   
        


    function ajax_cad_responsavel(){

        usuario = document.getElementById('input')
        email = document.getElementById('inpt_email')

        if(usuario.value == ''){
            alert("Usuario não informado!")
            usuario.focus()
        }else{
            if(email.value == ''){
                alert("E-mail não informado!")
                email.focus()
            }else{
                if(email.value.indexOf("@santacasasjc.com.br") == -1){
                    alert("E-mail invalido!")
                    email.focus()
                }else{  
                    $.ajax({
                        url: "funcoes/responsaveis/ajax_cad_responsavel.php",
                        type: "POST",
                        data: {
                            usuario: usuario.value,
                            email: email.value
                            },
                        cache: false,
                        success: function(dataResult){  

                            usuario.value = ''
                            email.value = ''

                            $('#div_lista').load('funcoes/responsaveis/ajax_lista_responsaveis.php')
                            
                            if(dataResult == ''){

                                //MENSAGEM            
                                var_ds_msg = 'Responsável%20cadastrado%20com%20sucesso!';
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
                        },
                        
                    })
                    
                }
            }
        }
        
    }

    function ajax_apagar_responsavel(cd_usuario){

        $.ajax({
            url: "funcoes/responsaveis/ajax_apagar_responsavel.php",
            type: "POST",
            data: {
                usuario: cd_usuario
                },
            cache: false,
            success: function(dataResult){   

                var_ds_msg = 'Responsável%20apagado%20com%20sucesso!';
                var_tp_msg = 'alert-success';
                //var_tp_msg = 'alert-danger';
                //var_tp_msg = 'alert-primary';
                $('#mensagem').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg); 
                $('#div_lista').load('funcoes/responsaveis/ajax_lista_responsaveis.php')
                
            },
            
        })
    }

</script>


<?php 

    include 'rodape.php';
    include 'funcoes/js_editar_campos.php';
?>

