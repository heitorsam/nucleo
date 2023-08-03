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

    <?php

    if($usu_adm == 'S' || $usu_global == 'S'){

    ?>

        <!--BLOCO CHAMADOS SOLICITADOS PELO USUARIO-->
        <div class="div_br"> </div> 
        <div class="div_br"> </div> 
        <h11><i class="fa-brands fa-telegram"></i> Solicitações Realizadas</h11>
        <div id="lista_solic_usuario"></div>


    <?php  
    }
    ?>


    <?php

    if($usu_adm == 'S'){

    ?>

        <!-- //FIM DO BLOCO CHAMADOS SOLICITADOS PELO USUARIO// -->

        <!--BLOCO CHAMADOS RECEBIDOS PELO RESPONSAVEL-->
        <div class="div_br"> </div> 
        <div class="div_br"> </div> 
        <h11><i class="fa-brands fa-telegram"></i> Solicitações Recebidas</h11>

    <?php  
    }
    ?>



    <!-- //FIM DO BLOCO CHAMADOS RECEBIDOS PELO RESPONSAVEL// -->

    <!-- Modal -->
    <div class="modal fade" id="modal_detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <div class="fnd_azul" style="width: 100%; display: flex; justify-content: space-between;">
                        <h5 class="modal-title" id="exampleModalLabel">Detalhes da Solicitacao</h5>
                        <div>
                            <i id="iconeBotao" onclick="ajax_volta_pagina_fecha_pagina()" class="fa-solid fa-xmark" style="cursor: pointer;"></i>
                        </div>
                    </div>

                </div>
                <div class="modal-body">

                    <div id="detalhes_solicitacao"></div>

                </div>
                <?php

                    if($usu_adm == 'S' && $usu_global == 'S'){
                
                ?>
                        <div class="modal-footer">
                            <button type="button" onclick="ajax_recebe_solicitacoes()" class="btn btn-primary" data-dismiss="modal">Receber</button>
                        </div>
                <?php

                    }elseif($usu_adm == 'N' && $usu_global == 'S'){

                ?>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                <?php

                    }

                ?>

            </div>

        </div>
    </div>


<script>

//BLOCO NOVO PROJETO

    global_solic = '';
    global_os_mv = '';

    ckb_query = '';
    ckb_painel = '';
    ckb_relatorio = '';
    ckb_desenvolvimento = '';

    function controla_check_box(tp_check_box){

        if(tp_check_box == '1'){

            checkbox1 = document.getElementById('ckb_query');
            checkbox2 = document.getElementById('ckb_painel');
            checkbox3 = document.getElementById('ckb_relatorio');
            checkbox4 = document.getElementById('ckb_desenvolvimento');

            if(checkbox1.checked){

                ckb_query = 'true';
                ckb_painel = 'false';
                ckb_relatorio = 'false';
                ckb_desenvolvimento = 'false';
                
                checkbox2.checked = false;
                checkbox3.checked = false;
                checkbox4.checked = false;

            }

        }

        if(tp_check_box == '2'){

            checkbox1 = document.getElementById('ckb_query');
            checkbox2 = document.getElementById('ckb_painel');
            checkbox3 = document.getElementById('ckb_relatorio');
            checkbox4 = document.getElementById('ckb_desenvolvimento');

            if(checkbox2.checked){

                ckb_query = 'false';
                ckb_painel = 'true';
                ckb_relatorio = 'false';
                ckb_desenvolvimento = 'false';

                checkbox1.checked = false;
                checkbox3.checked = false;
                checkbox4.checked = false;

            }

        }

        if(tp_check_box == '3'){

            checkbox1 = document.getElementById('ckb_query');
            checkbox2 = document.getElementById('ckb_painel');
            checkbox3 = document.getElementById('ckb_relatorio');
            checkbox4 = document.getElementById('ckb_desenvolvimento');

            if(checkbox3.checked){

                ckb_query = 'false';
                ckb_painel = 'false';
                ckb_relatorio = 'true';
                ckb_desenvolvimento = 'false';

                checkbox1.checked = false;
                checkbox2.checked = false;
                checkbox4.checked = false;

            }

        }

        
        if(tp_check_box == '4'){

            checkbox1 = document.getElementById('ckb_query');
            checkbox2 = document.getElementById('ckb_painel');
            checkbox3 = document.getElementById('ckb_relatorio');
            checkbox4 = document.getElementById('ckb_desenvolvimento');

            if(checkbox4.checked){

                ckb_query = 'false';
                ckb_painel = 'false';
                ckb_relatorio = 'false';
                ckb_desenvolvimento = 'true';

                checkbox1.checked = false;
                checkbox2.checked = false;
                checkbox3.checked = false;

            }

        }


    }

        
        window.onload = function() {

            ajax_exibe_solicitacoes_usuario();

        };

        function ajax_exibe_solicitacoes_usuario(){

            $('#lista_solic_usuario').load('funcoes/solicitacao/ajax_exibe_solicitacoes_usuario_logado.php')

        }

        function ajax_modal_exibe_detalhes_adm(cd_solic, cd_os_mv){

            global_solic = cd_solic;
            global_os_mv = cd_os_mv;

            $('#modal_detalhes').modal('show')
            $('#detalhes_solicitacao').load('funcoes/solicitacao/ajax_modal_detalhes_solicitacao.php?os='+cd_os_mv+'&solicitacao='+cd_solic)
            
        }

        function ajax_volta_pagina_fecha_pagina(){

            global_solic;
            global_os_mv;

            var iconeBotao = document.getElementById("iconeBotao");
            if (iconeBotao.classList.contains("fa-reply")){

                iconeBotao.classList.remove("fa-reply");
                iconeBotao.classList.add("fa-xmark");
                $('#detalhes_solicitacao').load('funcoes/solicitacao/ajax_modal_detalhes_solicitacao.php?os='+global_os_mv+'&solicitacao='+global_solic)

            }else{

                $('#modal_detalhes').modal('hide')

            }


        }

        function ajax_chama_modal_galeria(os_mv){

            var iconeBotao = document.getElementById("iconeBotao");

            if (iconeBotao.classList.contains("fa-xmark")) {
                iconeBotao.classList.remove("fa-xmark");
                iconeBotao.classList.add("fa-reply");

                $('#detalhes_solicitacao').load('funcoes/solicitacao/ajax_modal_anexo.php?os_mv='+os_mv)
                
            }

        }

        ajax_recebe_solicitacoes(){




            
        }


        ////////////////////////////////////////////
        
    </script>


    <?php

        //RODAPE
        include 'rodape.php';

    ?>

