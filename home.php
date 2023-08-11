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
        <?php

            if($usu_adm == 'S'){

                echo '<h11><i class="fa-brands fa-telegram"></i> Recebidas</h11>';
                
            }else{

                echo '<h11><i class="fa-brands fa-telegram"></i> Solicitações Realizadas</h11>';

            }
        ?>
        
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
        <h11><i class="fa-brands fa-elementor"></i> Andamento</h11>
        <div id="lista_solic_recebidas"></div>

    <?php  
    }
    ?>


        <!-- //FIM DO BLOCO CHAMADOS SOLICITADOS PELO USUARIO// -->

        <!--BLOCO CHAMADOS RECEBIDOS PELO RESPONSAVEL-->
        <div class="div_br"> </div> 
        <div class="div_br"> </div> 
        <h11><i class="fa-solid fa-circle-check"></i> Finalizadas</h11>
        <div class="div_br"> </div> 
        <div class="row">

            <div class="col-md-3">

                Data:
                <input onchange="ajax_exibe_os_fechadas()" type="date" class="form form-control" id="filtro_data">

            </div>
        
        </div>

        <div id="lista_solic_finalizadas"></div>
        <div id="mensagem_acoes_finalizadas"></div>




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

                    <div id="mensagem_acoes"></div>

                </div>
                <?php

                    if($usu_adm == 'S'){
                
                ?>
                        <div class="modal-footer">
                            <button type="button" onclick="ajax_recebe_solicitacoes()" class="btn btn-primary"> <i class="fa-solid fa-floppy-disk"></i> Receber</button>
                        </div>
                <?php

                    }elseif($usu_adm == 'N' && $usu_global == 'S'){

                ?>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Fechar</button>
                        </div>
                <?php

                    }

                ?>

            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_detalhes_receb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <div class="fnd_azul" style="width: 100%; display: flex; justify-content: space-between;">
                        <h5 class="modal-title" id="exampleModalLabel">Solicitação em Andamento</h5>
                        <div>
                            <i id="iconeBotao2" onclick="ajax_volta_pagina_fecha_pagina_2()" class="fa-solid fa-xmark" style="cursor: pointer;"></i>
                        </div>
                    </div>

                </div>
                <div class="modal-body">

                    <div id="detalhes_solicitacao_recebe"></div>
                    <div id="mensagem_acoes2"></div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Fechar</button>
                    <button type="button" onclick="ajax_finaliza_solicitacao()" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Concluir</button>
                    
                </div>


            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_detalhes_finish" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <div class="fnd_azul" style="width: 100%; display: flex; justify-content: space-between;">
                        <h5 class="modal-title" id="exampleModalLabel">Solicitação Finalizadas</h5>
                        <div>
                            <i id="iconeBotao3" onclick="ajax_volta_pagina_fecha_pagina_3()" class="fa-solid fa-xmark" style="cursor: pointer;"></i>
                        </div>
                    </div>

                </div>
                <div class="modal-body">

                    <div id="detalhes_solicitacao_finish"></div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Fechar</button>

                </div>


            </div>

        </div>
    </div>

    <div id="mensagem_acoes_global"></div>
    

<script>

    //BLOCO NOVO PROJETO

    //VARIAVEIS GLOBAIS

    global_solic = '';
    global_os_mv = '';

    ckb_query = '';
    ckb_painel = '';
    ckb_relatorio = '';
    ckb_desenvolvimento = '';

    ///////////////////////////////

    //CONTROLE DE CHECKBOX//

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

    ////////////////////////////////////

    //FUNÇÕES PARA SEREM CARREGAS AO ABRIR A PAGINA
        
        window.onload = function() {

            //CHAMANDO ASSIM QUE CARREGA A PAGINA
            ajax_exibe_solicitacoes_usuario();
            ajax_exibe_solicitacoes_recebidas()

        };
    
    ////////////////////////////////////////////

    ///ATUALIZANDO TABELAS A CADA 30 SEGUNDOS///

    // Atualiza a cada 30 segundos (30000 milissegundos)
    setInterval(ajax_exibe_solicitacoes_usuario, 30000);


    ///////////////////////////////////////////

    //FUNÇÕES PARA EXIBIR AS TABELAS

        function ajax_exibe_solicitacoes_usuario(){

            $('#lista_solic_usuario').load('funcoes/solicitacao/ajax_exibe_solicitacoes_usuario_logado.php')

        }

        
        function ajax_exibe_solicitacoes_recebidas(){

            $('#lista_solic_recebidas').load('funcoes/solicitacao/ajax_exibe_solicitacoes_adm_logado.php')

        }

        function ajax_exibe_os_fechadas(){

            data = document.getElementById("filtro_data").value;
            // Dividir a data em partes (ano, mês e dia) usando o caractere "-"
            const partes = data.split("-");
            // Reorganizar as partes da data na ordem desejada (dia/mês/ano)
            const data_format = partes[2] + "/" + partes[1] + "/" + partes[0];
            data_finalizadas = data_format;

            //alert(var_beep);
            //MENSAGEM            
            var_ds_msg = 'Dados%20Encontrados%20com%20Sucesso!%20';
            var_tp_msg = 'alert-success';
            //var_tp_msg = 'alert-danger';
            //var_tp_msg = 'alert-primary';
            $('#mensagem_acoes_finalizadas').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);


            $('#lista_solic_finalizadas').load('funcoes/solicitacao/ajax_exibe_solicitacoes_finalizadas.php?data_filtro='+data_finalizadas);

        }

    //////////////////////////////////////////


    //FUNÇÕES MODAL 

        function ajax_modal_exibe_detalhes_adm(cd_solic, cd_os_mv){

            global_solic = cd_solic;
            global_os_mv = cd_os_mv;

            $('#modal_detalhes').modal('show')
            $('#detalhes_solicitacao').load('funcoes/solicitacao/ajax_modal_detalhes_solicitacao.php?os='+cd_os_mv+'&solicitacao='+cd_solic)
            
        }

        function ajax_modal_exibe_detalhes_adm_recebimento(cd_solic, cd_os_mv){

            global_solic = cd_solic;
            global_os_mv = cd_os_mv;

            $('#modal_detalhes_receb').modal('show')
            $('#detalhes_solicitacao_recebe').load('funcoes/solicitacao/ajax_modal_detalhes_solicitacao_recebida.php?os='+cd_os_mv+'&solicitacao='+cd_solic)

        }

        function ajax_modal_exibe_detalhes_adm_finalizada(cd_solic, cd_os_mv){

            global_solic = cd_solic;
            global_os_mv = cd_os_mv;

            $('#modal_detalhes_finish').modal('show')
            $('#detalhes_solicitacao_finish').load('funcoes/solicitacao/ajax_modal_detalhes_finalizadas.php?os='+cd_os_mv+'&solicitacao='+cd_solic)

        }

        function ajax_chama_modal_galeria_chamado_finalizado(os){

            //COLETANDO O BOTÃO
            var iconeBotao3 = document.getElementById("iconeBotao3");

            if (iconeBotao3.classList.contains("fa-xmark")) {
                iconeBotao3.classList.remove("fa-xmark");
                iconeBotao3.classList.add("fa-reply");

                $('#detalhes_solicitacao_finish').load('funcoes/solicitacao/ajax_modal_anexo.php?os_mv='+os)
                
            }

        }

        function ajax_chama_modal_galeria(os_mv){

            //COLETANDO O BOTÃO
            var iconeBotao = document.getElementById("iconeBotao");

            if (iconeBotao.classList.contains("fa-xmark")) {
                iconeBotao.classList.remove("fa-xmark");
                iconeBotao.classList.add("fa-reply");

                $('#detalhes_solicitacao').load('funcoes/solicitacao/ajax_modal_anexo.php?os_mv='+os_mv)
                
            }

        }

        
        function ajax_chama_modal_galeria_chamado_recebido(os){

            //COLETANDO O BOTÃO
            var iconeBotao2 = document.getElementById("iconeBotao2");

            if (iconeBotao2.classList.contains("fa-xmark")) {
                iconeBotao2.classList.remove("fa-xmark");
                iconeBotao2.classList.add("fa-reply");

                $('#detalhes_solicitacao_recebe').load('funcoes/solicitacao/ajax_modal_anexo.php?os_mv='+os)
                
            }

        }


    ////////////////////////////////////////////////

    //FUNÇÕES PARA VOLTAR PAGINAS NAS MODALS//

        function ajax_volta_pagina_fecha_pagina_3(){

            global_solic;
            global_os_mv;

            var iconeBotao3 = document.getElementById("iconeBotao3");

            if (iconeBotao3.classList.contains("fa-reply")){

                iconeBotao3.classList.remove("fa-reply");
                iconeBotao3.classList.add("fa-xmark");

                $('#detalhes_solicitacao_finish').load('funcoes/solicitacao/ajax_modal_detalhes_solicitacao_recebida.php?os='+global_os_mv+'&solicitacao='+global_solic)

            }else{

                $('#modal_detalhes_finish').modal('hide')

            }


        }

        function ajax_volta_pagina_fecha_pagina_2(){

            global_solic;
            global_os_mv;

            var iconeBotao2 = document.getElementById("iconeBotao2");

            if (iconeBotao2.classList.contains("fa-reply")){

                iconeBotao2.classList.remove("fa-reply");
                iconeBotao2.classList.add("fa-xmark");

                $('#detalhes_solicitacao_recebe').load('funcoes/solicitacao/ajax_modal_detalhes_solicitacao_recebida.php?os='+global_os_mv+'&solicitacao='+global_solic)

            }else{

                $('#modal_detalhes_receb').modal('hide')

            }


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


    ////////////////////////////////////////////////


    //FUNÇÕES PARA SOLICITAR E RECEBER E FINALIZAR 

        function ajax_finaliza_solicitacao(){

            Prestadorresp = document.getElementById("prestador_responsavel_receb").value;
            datar_entrega = document.getElementById("data_ent_recebida").value;
            Prestadovalidador = document.getElementById("prestador_validador_receb").value;
            data_recebimento_servico = document.getElementById("data_recebimento_serv").value;
            global_solic;
            global_os_mv;

            if(Prestadovalidador == 'All'){

                //alert(var_beep);
                //MENSAGEM            
                var_ds_msg = 'Preencha%20o%20usuario%20validador!%20';
                //var_tp_msg = 'alert-success';
                var_tp_msg = 'alert-danger';
                //var_tp_msg = 'alert-primary';
                $('#mensagem_acoes2').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

                
            }else if (datar_entrega == ''){


                //alert(var_beep);
                //MENSAGEM            
                var_ds_msg = 'Preencha%20a%20data%20de%20entrega!%20';
                //var_tp_msg = 'alert-success';
                var_tp_msg = 'alert-danger';
                //var_tp_msg = 'alert-primary';
                $('#mensagem_acoes2').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            
            }else{

                var var_data1 = data_recebimento_servico;
                var var_data2 = new Date();

                //FORMATANDO DATA2 PARA ENVIAR AO BANCO.
                var dia = String(var_data2.getDate()).padStart(2, '0');
                var mes = String(var_data2.getMonth() + 1).padStart(2, '0');
                var ano = var_data2.getFullYear();
                var horas = String(var_data2.getHours()).padStart(2, '0');
                var minutos = String(var_data2.getMinutes()).padStart(2, '0');
                var segundos = String(var_data2.getSeconds()).padStart(2, '0');

                //FINALIZANDO FORMATAÇÃO
                var data_final_servico = `${dia}/${mes}/${ano} ${horas}:${minutos}:${segundos}`;

                // Convertendo a primeira data para um objeto Date
                var dateParts1 = var_data1.split(/[\s\/:]+/);
                var date1 = new Date(dateParts1[2], dateParts1[1] - 1, dateParts1[0], dateParts1[3], dateParts1[4], dateParts1[5]);

                // Obtendo os componentes da data e hora da segunda data
                var year = var_data2.getFullYear();
                var month = var_data2.getMonth();
                var day = var_data2.getDate();
                var hours = var_data2.getHours();
                var minutes = var_data2.getMinutes();
                var seconds = var_data2.getSeconds();

                // Criando o objeto Date para a segunda data
                var date2 = new Date(year, month, day, hours, minutes, seconds);

                // Calculando a diferença em milissegundos entre as datas
                var diffInMilliseconds = date2 - date1;

                // Convertendo a diferença para minutos
                var totalMinutes = diffInMilliseconds / (1000 * 60);

                // Arredondando o valor dos minutos para o número inteiro mais próximo
                var roundedMinutes = Math.round(totalMinutes);
            
                // Dividir a data em partes (ano, mês e dia) usando o caractere "-"
                const partes = datar_entrega.split("-");

                // Reorganizar as partes da data na ordem desejada (dia/mês/ano)
                const dataFormatada = partes[2] + "/" + partes[1] + "/" + partes[0];

                dataEntragaFormatada = dataFormatada;
                
                //INICIANDO AJAX
                $.ajax({

                    url: "funcoes/solicitacao/ajax_finaliza_solicitacao.php",
                    type: "POST",
                    data: {


                        Prestadorresp: Prestadorresp,
                        datar_entrega: dataEntragaFormatada,
                        Prestadovalidador: Prestadovalidador,
                        roundedMinutes: roundedMinutes,
                        global_solic: global_solic,
                        global_os_mv: global_os_mv,
                        data_recebimento_servico: data_recebimento_servico,
                        data_final_servico: data_final_servico

                        },

                    cache: false,
                    success: function(dataResult){  

                        console.log(dataResult);

                        ajax_fecha_modal_recebe_sol_2();
                        ajax_exibe_solicitacoes_recebidas();

                        
                        //alert(var_beep);
                        //MENSAGEM            
                        var_ds_msg = 'Solicitação%20Finalizada%20com%20Sucesso!%20';
                        var_tp_msg = 'alert-success';
                        //var_tp_msg = 'alert-danger';
                        //var_tp_msg = 'alert-primary';
                        $('#mensagem_acoes_global').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);



                    },

                })
                

            }
        

        }

        function ajax_recebe_solicitacoes(){

            //RECEBENDO VALORES DOS INPUTS
            prestador_responsavel = document.getElementById('prestador_responsavel').value;
            data_prevista = document.getElementById('data_prevista').value;
            consideracoes = document.getElementById('considerações').value;
            ckb_query;
            ckb_painel;
            ckb_relatorio;
            ckb_desenvolvimento;
            global_solic;
            global_os_mv;

            if(prestador_responsavel == 'All'){

                //alert(var_beep);
                //MENSAGEM            
                var_ds_msg = 'Preencha%20o%20responsavel!%20';
                //var_tp_msg = 'alert-success';
                var_tp_msg = 'alert-danger';
                //var_tp_msg = 'alert-primary';
                $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);


            }else if(data_prevista == ''){

                //alert(var_beep);
                //MENSAGEM            
                var_ds_msg = 'Preencha%20a%20data!%20';
                //var_tp_msg = 'alert-success';
                var_tp_msg = 'alert-danger';
                //var_tp_msg = 'alert-primary';
                $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            }else if(consideracoes == ''){

                //alert(var_beep);
                //MENSAGEM            
                var_ds_msg = 'Preencha%20as%20Considerações!%20';
                //var_tp_msg = 'alert-success';
                var_tp_msg = 'alert-danger';
                //var_tp_msg = 'alert-primary';
                $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            }else if(ckb_query == '' && ckb_painel == '' && ckb_relatorio == '' && ckb_desenvolvimento == ''){

                //alert(var_beep);
                //MENSAGEM            
                var_ds_msg = 'Selecione%20alguma%20das%20Opções!%20';
                //var_tp_msg = 'alert-success';
                var_tp_msg = 'alert-danger';
                //var_tp_msg = 'alert-primary';
                $('#mensagem_acoes').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);

            }else{

         
                // Dividir a data em partes (ano, mês e dia) usando o caractere "-"
                const partes = data_prevista.split("-");

                // Reorganizar as partes da data na ordem desejada (dia/mês/ano)
                const dataFormatada = partes[2] + "/" + partes[1] + "/" + partes[0];

                dataPrevistaFormatada = dataFormatada;

                //INICIANDO AJAX
                $.ajax({

                    url: "funcoes/solicitacao/ajax_recebe_solicitacao.php",
                    type: "POST",
                    data: {


                        prestador_responsavel: prestador_responsavel,
                        data_prevista: dataPrevistaFormatada,
                        consideracoes: consideracoes,
                        ckb_query: ckb_query,
                        ckb_painel: ckb_painel,
                        ckb_relatorio: ckb_relatorio,
                        ckb_desenvolvimento: ckb_desenvolvimento,
                        global_solic: global_solic,
                        global_os_mv: global_os_mv

                        },

                    cache: false,
                    success: function(dataResult){  

                        console.log(dataResult);
                        ajax_exibe_solicitacoes_usuario();
                        ajax_exibe_solicitacoes_recebidas();


                        ajax_fecha_modal_recebe_sol_1();

                        //alert(var_beep);
                        //MENSAGEM            
                        var_ds_msg = 'Solicitação%20recebida%20com%20Sucesso!%20';
                        var_tp_msg = 'alert-success';
                        //var_tp_msg = 'alert-danger';
                        //var_tp_msg = 'alert-primary';
                        $('#mensagem_acoes_global').load('funcoes/ajax_mensagem_acoes.php?ds_msg='+var_ds_msg+'&tp_msg='+var_tp_msg);


                    },
                    

                })
                
                

            }

        
        }

    /////////////////////////////////////////////////////////

    //FUNÇÕES QUE FECHAM A MODAL//

        function ajax_fecha_modal_recebe_sol_1(){

            $('#modal_detalhes').modal('hide');

        }

        function ajax_fecha_modal_recebe_sol_2(){

            $('#modal_detalhes_receb').modal('hide');

        }


    ///////////////////////////////
        
    </script>


    <?php

        //RODAPE
        include 'rodape.php';

    ?>

