<?php 

    //CABECALHO
    include 'cabecalho.php';

    include 'conexao.php';

    $date = date('Y-m', time());

    $usu_login_mv = $_SESSION['usuarioLogin'];

    $adm = $_SESSION['SN_ADM'];
    $sup = $_SESSION['SN_SUP'];

    if($adm == 'S'){
        $class = "btn-adm";
    }else{
        $class = "btn-primary";
    }

?>

<div class="div_br"> </div>
<!--MENSAGENS-->
<?php
include 'js/mensagens.php';
include 'js/mensagens_usuario.php';
?>
<div class="div_br"> </div>
<div class="div_br"> </div>
<h11><i class="fa-solid fa-laptop efeito-zoom"></i> Portal Projeto<a style="color:black" href="http://localhost:8080/portal_projetos/portfolio.php">s</a></h11>

    <div class="div_br"> </div>
    <a href="solicitacao.php" class="botao_home btn-primary" type="submit"><i class="fa-solid fa-file-circle-plus"></i> Solicitação</a>
    <span class="espaco_pequeno"></span>
    <a href="cadastro_perfil.php" class="botao_home btn-primary" type="submit"><i class="fa-solid fa-camera-retro"></i> Perfil</a>
    <span class="espaco_pequeno"></span>
    <a href="portfolio_att.php" class="botao_home btn-primary" type="submit"><i class="fa-brands fa-sistrix"></i> Portfólio</a>
    <div class="div_br"> </div>

<?php if($adm == 'S'){ ?>
   
        <h11><i class="fas fa-cog efeito-zoom"></i> Configurações</h11>
        
        <div class="div_br"> </div>
        <a href="responsaveis.php" class="botao_home btn-adm" type="submit"><i class="fa-solid fa-users"></i> Responsáveis</a>
        <span class="espaco_pequeno"></span>
        <a href="config_portfolio.php"class="botao_home btn-adm" type="submit"><i class="fas fa-cog efeito-zoom"></i> Configuração Portfólio</a>
        <span class="espaco_pequeno"></span>
        <a href="cadastro_perguntas.php" class="botao_home btn-adm" type="submit"><i class="fa-solid fa-star"></i> Perguntas Avaliação</a>
        <span class="espaco_pequeno"></span>
        <a href="dashboard.php" class="botao_home btn-adm" type="submit"><i class="fa-solid fa-chart-column"></i> Dashboard</a>

        <div class="div_br"> </div>

<?php } ?>


<div class="div_br"> </div>
<div class="div_br"> </div>

<?php include 'funcoes/solicitacao/ajax_lista_chamados_usuario.php'; ?>

    <div id="lista_chamados"></div>


<!--MODAL UNIVERSAL-->
<div class="modal fade" id="modal_universal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="div_modal">
            
        </div>
    </div>
</div>

<div class="modal fade" id="modal_just" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="div_just">
            
        </div>
    </div>
</div>
<div class="div_br"> </div>
<div class="div_br"> </div>
<div class="div_br"> </div>  

<?php
    //RODAPE
    include 'rodape.php';
?>

<script>

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

    function ajax_modal_avaliacao(os,qtd){
        $('#div_modal').load('funcoes/avaliacao/ajax_modal_avaliacao.php?cd_os='+os+'&qtd='+qtd)
        $('#modal_universal').modal('show')
    }

    
</script>
