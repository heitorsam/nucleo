<?php 

    //CABECALHO
    include 'cabecalho.php';
    include 'conexao.php';
    include 'js/mensagens.php';
    include 'js/mensagens_usuario.php';

    $date = date('Y-m', time());

    $usu_login_mv = $_SESSION['usuarioLogin'];
    $usu_global = $_SESSION['SN_USU_GLOBAL'];
    $usu_adm = $_SESSION['SN_USU_ADM'];
?>

<div class="div_br"> </div>

<!--MENSAGENS-->
<?php

?>
<div class="div_br"> </div>
<div class="div_br"> </div>

<h11><i class="fa-solid fa-globe efeito-zoom"></i> Nucleo de Informações<a style="color:black" href="http://localhost:8080/portal_projetos/portfolio.php"></a></h11>

    <?php
    if($usu_global == 'S'){
    ?>
        <div class="div_br"> </div>
        <a href="solicitacao.php" class="botao_home btn-primary" type="submit"><i class="fa-solid fa-file-circle-plus"></i> Solicitação</a>
        <span class="espaco_pequeno"></span>

    <?php  
    }
    ?>

    <?php
    if($usu_adm == 'S'){
    ?>
        
        <a href="responsaveis.php" class="botao_home btn-adm" type="submit"><i class="fa-solid fa-users"></i> Responsáveis</a>
        <span class="espaco_pequeno"></span>
        
        <a href="dashboard.php" class="botao_home btn-adm" type="submit"><i class="fa-solid fa-chart-column"></i> Dashboard</a>
        <span class="espaco_pequeno"></span>

    <?php  
    }
    ?>


    <!--BLOCO CHAMADOS SOLICITADOS PELO USUARIO-->
    <div class="div_br"> </div> 
    <div class="div_br"> </div> 
    <h11><i class="fa-brands fa-telegram"></i> Solicitações Realizadas</h11>
    
    <div id="lista_solic_usuario"></div>


    <!-- //FIM DO BLOCO CHAMADOS SOLICITADOS PELO USUARIO// -->

    <!-- Modal -->
    <div class="modal fade" id="modal_detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalhes da Solicitacao</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="detalhes_solicitacao"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>

        </div>
    </div>

    <script>

        //BLOCO NOVO PROJETO
        window.onload = function() {

            ajax_exibe_solicitacoes_usuario();

        };

        function ajax_exibe_solicitacoes_usuario(){

            $('#lista_solic_usuario').load('funcoes/solicitacao/ajax_exibe_solicitacoes_usuario_logado.php')

        }

        function ajax_modal_exibe_detalhes_adm(cd_solic, cd_os_mv){

            $('#modal_detalhes').modal('show')
            $('#detalhes_solicitacao').load('funcoes/solicitacao/ajax_modal_detalhes_solicitacao.php?os='+cd_os_mv+'&solicitacao='+cd_solic)
            
        }

        ////////////////////////////////////////////




        $(document).ready(function() {
            console.log('sai do console curioso')
            $('#lista_chamados').load('funcoes/solicitacao/ajax_lista_chamados_concluido.php?data=<?php echo $date ?>')
            
        })

        function ajax_filtro_mes(data){
            $('#lista_chamados').load('funcoes/solicitacao/ajax_lista_chamados_concluido.php?data='+ data)

        }

        function ajax_modal_sol(os){
            
            $('#div_modal').load('funcoes/solicitacao/ajax_modal_soli.php?cd_os='+os)
            $('#modal_universal').modal('show')
        }

        function ajax_modal_anexos(os){
            $('#div_modal').load('funcoes/solicitacao/ajax_modal_anexo.php?cd_os='+os)
        }

        function ajax_editar_solicitacao(cd_sol, tp_just){
            funcionario = document.getElementById('slt_func')
            prioridade = document.getElementById('slt_prioridade')
            tipo = document.getElementById('slt_tipo')
            previsao = document.getElementById('inpt_previsao')
            data = {}
            data_just = {}
            data['cd_sol'] = cd_sol
            data_just['os'] = cd_sol
            if(funcionario.value == '' && tp_just != 'R'){
                alert('Escolha um responsavel!')
                funcionario.focus()
            }else{
                if(previsao.value == '' && tp_just != 'R'){
                    alert('Informe uma estimativa de entrega!')
                    previsao.focus()
                }else{
                    if(funcionario.value != 'caio_esteve_aqui' && funcionario.value != '' && tp_just != 'R'){
                        
                        data['func'] = funcionario.value
                    }
                    if(prioridade.value != '' && tp_just != 'R'){
                        
                        data['prioridade'] = prioridade.value
                    }
                    if(previsao.value != '' && tp_just != 'R'){
                        
                        data['estimativa'] = previsao.value
                    }
                    if(tipo.value != '' && tp_just != 'R'){
                        data['tipo'] = tipo.value
                    }
                    if(tp_just != '' ){
                        data_just['tp_just'] = tp_just
                    }
                    txt_just = document.getElementById('txt_just')
                    
                    if(tp_just != 'A'){
                        
                        if(txt_just.value != ''){
                            $.ajax({
                                url:"funcoes/solicitacao/ajax_editar_sol.php",
                                type: "POST",
                                data: data,
                                cache: false,
                                success: function(dataResult){                    
                                    console.log(dataResult)
                                    data_just['txt_just'] = txt_just.value
                                    $.ajax({
                                        url:"funcoes/justificativa/ajax_cad_just.php",
                                        type: "POST",
                                        data: data_just,
                                        cache: false,
                                        success: function(dataResult){                    
                                            console.log(dataResult)
                                            location.reload();
                                        }
                                    })
                                        
                                }
                            })
                            
                        }else{
                            alert('Informe uma justificativa!')
                        }
                    }else{
                        $.ajax({
                            url:"funcoes/solicitacao/ajax_editar_sol.php",
                            type: "POST",
                            data: data,
                            cache: false,
                            success: function(dataResult){                    
                                console.log(dataResult)
                                console.log('aceito')
                                location.reload();
                            } 
                        })
                    }   
                }
            }
        }

        function ajax_modal_just(os,tp){
            $('#div_just').load('funcoes/justificativa/ajax_modal_just.php?cd_os='+os+'&tp='+tp)
            $('#modal_just').modal('show')
        }    

        function ajax_concluir_solicitacao(os){
            texto = document.getElementById('txt_just').value
            if(texto != ''){
                $.ajax({
                    url:"funcoes/solicitacao/ajax_concluir_solicitacao.php",
                    type: "POST",
                    data: {
                        os: os,
                        texto: texto
                    },
                    cache: false,
                    success: function(dataResult){                    
                        console.log(dataResult)
                        location.reload();
                        
                    }
                })
            }else{

                alert('Informe uma justificativa!')
            }
        }

        
    </script>


    <?php

        //RODAPE
        include 'rodape.php';

    ?>

