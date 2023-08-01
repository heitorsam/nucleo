
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/logo/icone_santa_casa_sjc_colorido.png">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Portfólio</title>
    <!--CSS-->
    <?php 
        include 'css/style.php';
        include 'css/style_mobile.php';
    ?>
    <!-- Bootstrap CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/302b2cb8e2.js" crossorigin="anonymous"></script>
    <!--GRAFICOS CHART JS 
    <script src="js/Chart.js-2.9.4/dist/Chart.js"></script>--> 
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"> </script>
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
</head>
<body style="margin: 0px !important; padding:0px !important;">


                <div class="div_br"> </div>
                <div class="div_br"> </div>

        <div class="conteudo_login" style="margin: 0 auto; width: 95%; min-height: 230px; border-radius: 20px;">
    
            <div class="div_br"> </div>

            <div style="text-align: center;">
                <h3 style="color: #ffffff;">Portfólio</h3>
            </div>

            <div class="div_br"> </div>
            <div class="div_br"> </div>

                <!--INPUT DE PESQUISA-->
                <div class="col-md-6" style="margin: 0 auto;">
                <i class="fa fa-search" id="font" style="display: block";></i>
                <input type="text" id="campo_pesquisa" class="form form-control" 
                        placeholder="O que você procura?" 
                        onkeyup="verifica_texto_pesquisar()"
                        onkeypress="ajax_exibe_conteudo('CP','P')">
                </div>

                <div class="div_br"> </div>
            <div style="font-size: 14px; color: white; text-align: center;" >
                Inovações tecnológicas da equipe de Projetos da Santa Casa de São José dos Campos
            </div>

            <div class="div_br"> </div>
            <div class="div_br"> </div>

            
 


            <!--ICONS DE FILTRO-->
            <div class="row" style="display: flex; flex-wrap: nowrap; margin: 0 auto; padding-left: 15%; padding-top: 20px; ">

                <div class="col-md-2" style="text-align: center; color: #FFFFFF;">
                    <button class= "circle-icons" id="botao_projetos" onclick="ajax_exibe_conteudo('PR')"><i class="fa-solid fa-laptop-code"></i></button>
                    <div style="margin-top: 5px;"> </div>
                    Projetos
                </div>
                
                <div class="col-md-2" style="text-align: center; color: #FFFFFF;">
                    <button class= "circle-icons" onclick="ajax_exibe_conteudo('PA')"><i class="fa-solid fa-table-columns"></i></button>
                    <div style="margin-top: 5px;"> </div>
                    Painel
                </div>
                
                <div class="col-md-2" style="text-align: center; color: #FFFFFF;">
                    <button class= "circle-icons" onclick="ajax_exibe_conteudo('RP')"><i class="fa-solid fa-table-list"></i></button>   
                    <div style="margin-top: 5px;"> </div>
                    Relatório
                </div>
                
                <div class="col-md-2" style="text-align: center; color: #FFFFFF;">
                    <button class= "circle-icons" onclick="ajax_exibe_conteudo('DC')"><i class="fa-solid fa-file-signature"></i></button>
                    <div style="margin-top: 5px;"> </div>
                    Documento
                </div>

                <div class="col-md-2" style="text-align: center; color: #FFFFFF;"> 
                    <button class= "circle-icons" onclick="ajax_exibe_conteudo('OT')"><i class="fa-solid fa-gears"></i></button>
                    <div style="margin-top: 5px;"> </div> 
                    Outros
                </div>

            </div>

            <div class="div_br"> </div>

        </div> <!-- FIM CLASS CONTAINER -->

        <div class="div_br"> </div> 

        <div style="background-color: #ffffff; margin: 0 auto; width: 90%; border-radius: 20px; ">
        
            <div class='row'>
                    <!--FILTRO ORDEM ALFABETICA-->
                    <div class="col-md-2" style="padding:3px;">

                        <select class="form form-control" style="font-size: 12px; visibility: hidden;" id="select_ord" onchange="ajax_exibe_conteudo('PV')">
                            <option Value="ASC">De A a Z</option>
                            <option Value="DESC">De Z a A</option>
                            <!--<option Value="VISTO">Mais Vistos</option>--> 
                        </select>

                    </div>

                    <!--SALVANDO VALORES PARA VALIDAÇÃO-->
                    <input type="text" id="tp_projeto" style="font-size: 12px; border-color: red;" hidden >
                    <input type="text" id="select_ordem" style="font-size: 12px; border-color: red;" hidden >
            </div>

        </div>

        <div id="exibe_projetos"></div>  

        <div class="modal" tabindex="-1" role="dialog" id="modal_portfolio" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                
                    <div id="div_portfolio"></div>

                </div>
            </div>
        </div>

        <!--MODAL ANEXOS-->
        <div class="modal" tabindex="-1" role="dialog" id="modal_carrosel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anexos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ajax_passagem_entre_modals()">
                    <!--<span aria-hidden="true">&times;</span>-->
                    <a><i class="fa fa-reply" aria-hidden="true"></i></a>
                    </button>
                </div>
                <div class="modal-body">
                    <!--CARROSEL DE FOTOS-->
                    <div id="div_carrosel"></div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
        </div>
        </div>

        <!--MODAL EASTER EGG 1 -->
        <div class="modal" tabindex="-1" role="dialog" id="modal_ester_agg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">

                    <div style="margin: 0 auto; width: 400px; height: 400px; text-align: center;">
                        <img src="img/fotos_ti/leonardo.jpeg" alt="Girl in a jacket" style=" width: 350px; height: 350px;">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Concordo</button>
                </div>
                </div>
            </div>
        </div>

         <!--MODAL EASTER EGG 2 -->
         <div class="modal" tabindex="-1" role="dialog" id="modal_ester_agg2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">

                    <div style="margin: 0 auto; width: 400px; height: 400px; text-align: center;">
                        <img src="img/fotos_ti/HEMEN.jfif" alt="Girl in a jacket" style=" width: 350px; height: 350px;">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tenha a força</button>
                </div>
                </div>
            </div>
        </div>

        <!--MODAL EASTER EGG 3 -->
        <div class="modal" tabindex="-1" role="dialog" id="modal_ester_agg3" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">

                    <div style="margin: 0 auto; width: 400px; height: 400px; text-align: center;">
                        <img src="img/fotos_ti/boleto.png" alt="Girl in a jacket" style=" width: 350px; height: 350px">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Inspiration</button>
                </div>
                </div>
            </div>
        </div>

            <!--MODAL EASTER EGG 4 -->
            <div class="modal" tabindex="-1" role="dialog" id="modal_ester_agg4" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">

                    <div style="margin: 0 auto; width: 400px; height: 400px; text-align: center;">
                        <img src="img/fotos_ti/projetos.jpeg" alt="Girl in a jacket" style=" width: 500px; height: 375px;">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Pedir Demissão</button>
                </div>
                </div>
            </div>
        </div>



    <script>

        
    window.onload = function(){

        ajax_exibe_conteudo('PR');

    }

        function ajax_exibe_detalhes(cd_port){
            //alert(cd_port);
            
            $('#div_portfolio').load('funcoes/portfolio/ajax_modal_portfolio.php?cd_portfolio='+cd_port)
            $('#modal_portfolio').modal('show')

        }

        function verifica_texto_pesquisar(){

            campo_pesquisa_lenght = document.getElementById('campo_pesquisa').value.length;

            //alert(campo_pesquisa_lenght);

            //APARECE OU DESAPARECE
            if(campo_pesquisa_lenght == 0){
                document.getElementById('font').style.display = 'block'; 
            }else{
                document.getElementById('font').style.display = 'none'; 
            }

        }


        function ajax_exibe_conteudo(opcao,acao){

                if(opcao == 'PV'){

                    var_opcao = document.getElementById('tp_projeto').value;

                } else{

                    var_opcao = opcao;
                    document.getElementById('select_ord').style.visibility = 'visible';

                }

                //alert(var_opcao);
                //alert(acao);

                var_ord = document.getElementById('select_ord').value;

                document.getElementById('tp_projeto').value = var_opcao;
                document.getElementById('select_ordem').value = var_ord;
                campo_pesquisa = document.getElementById('campo_pesquisa').value; 

                if(campo_pesquisa == 'QUEM FEZ?'){
                    
                    setTimeout(function(){ $('#modal_ester_agg').modal('show');}, 300);

                }else if(campo_pesquisa == 'Grayskull'){

                    setTimeout(function(){ $('#modal_ester_agg2').modal('show');}, 300);

                } else if(campo_pesquisa == 'INSPIRAÇÃO'){
                    
                    setTimeout(function(){ $('#modal_ester_agg3').modal('show');}, 300);

                } else if(campo_pesquisa == 'PROJETOS'){
                    
                    setTimeout(function(){ $('#modal_ester_agg4').modal('show');}, 300);

                }



                if(opcao == 'CP' && acao == 'P'){

                    $('#exibe_projetos').load('funcoes/portfolio/ajax_exibe_conteudo.php?opcao='+var_opcao+'&ordem='+var_ord+'&pesquisa='+campo_pesquisa);
                    
                }else{

                    $('#exibe_projetos').load('funcoes/portfolio/ajax_exibe_conteudo.php?opcao='+var_opcao+'&ordem='+var_ord);
                    document.getElementById('campo_pesquisa').value = '';

                }
        };

    </script>

    <!--RODAPE -->
    <footer>
    </footer>

    <!-- JQUERY -->

    <!--VERIFICAR ESTE PRIMEIRO JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

     <!-- Bootstrap JAVASCRIPT -->  
     <script src="bootstrap/js/bootstrap.min.js"></script> 

    <!--JAVASCRIPTS-->
    <script src="js/scripts.js"></script>  
   
    <!-- Paralax -->
    <script src="https://cdn.jsdelivr.net/parallax.js/1.4.2/parallax.min.js"></script>

</body>
</html>


