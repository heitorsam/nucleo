<?php
include 'conexao.php';
include 'cabecalho.php';
//session_start();
?>


<h11><i class="fa-solid fa-file-circle-plus"></i>Cadastro Portfólio</h11>
<span class="espaco_pequeno" style="width: 6px;" ></span>
<h27> <a href="config_portfolio.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
<div class="div_br"> </div> </br>

<?php
include 'js/mensagens.php';
include 'js/mensagens_usuario.php';
?>

<form action="funcoes/config_port/insert_cad_port.php" method="post" enctype="multipart/form-data">

    <div class="row">

        <div class="col-md-4">
            Solicitação:
            <select class="form-control" name="nr_solic" required>
                <?php
                    $consulta = "SELECT TO_CHAR(sol.cd_solicitacao) || ' - ' || substr(os.Ds_Servico,0,40)  AS DS_SOLICITA
                                        , sol.tp_tipo
                                        , sol.cd_solicitacao
                                        FROM portal_projetos.solicitacao sol
                                    INNER JOIN dbamv.solicitacao_os os
                                        ON os.cd_os = sol.cd_os_mv
                                        WHERE os.tp_situacao = 'C'
                                        AND sol.cd_solicitacao NOT IN
                                            (SELECT pr.cd_solicitacao FROM portal_projetos.portfolio pr)
                                        ORDER BY 1";
                    $resultado = oci_parse($conn_ora,$consulta);
                    oci_execute($resultado);

                    echo '<option value="">Selecione</option>';
                    while($row = oci_fetch_array($resultado)){
                        echo '<option value="'. $row['CD_SOLICITACAO'] .'">'. $row['DS_SOLICITA'] .'</option>';
                    }

                ?>
            </select>
                
        </div>

        <div class="col-md-4">
            Nome:
            <input class="form-control" id="nome_proj" name="nome_proj" required>
                
        </div>
        

        <div class="col-md-4">
            Link:
            <input class="form-control" id="link" name="link" required>
                
        </div>
        
    </div>

    </br>

    <div class="row">

        
        
        <div class="col-md-5">            
            Descrição da Foto:
            <input class="form-control" id="desc_foto" name="desc_foto" required>
        </div>
        
        
    </div>    
    
</br>

    <div class="row">   

        <div class="col-md-5">
            Anexar Foto Principal:</br>
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
            <input class="select_archive" id="anexos_foto_principal" accept="image/*" name="image_principal" type="file" required>
        </div>
                    
        <div class="col-md-5">
            Anexar Fotos:</br>
            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
            <input class="select_archive" id="anexos_fotos" accept="image/*" name="image[]" multiple="multiple" type="file" required>
        </div>
    </div>

</br>

    <div class="row">   

        <div class="col-md-5">
            Anexar Video:</br>
            <input type="hidden" name="MAX_FILE_SIZE" value=0 />
            <input class="select_archive" id="video" accept="video/*" name="arquivideo" type="file" required>
        </div>
        <div class="col-md-5">
            Tutorial:</br>
            <input type="hidden" name="MAX_FILE_SIZE" value=0 />
            <input class="select_archive"  id="pdf"  name="pdf" type="file" accept="application/pdf" required>
        </div>

        
    </div>

    </br>
    
    <div class="row">

        <div class="col-md-12">

            Descrição:
            <textarea style="background-color: white;"  id="descricao_projeto" name="descricao_projeto" class="textarea" rows="4" cols="50" placeholder="Descrição do Projeto" required></textarea>

        </div>

    </div>
    </br>
    
    <div class="row">
        <div class="col-md-3">
            <button type="submit"  class="btn btn-primary" value="Upload"><i class="fa-solid fa-floppy-disk"></i> Cadastrar</button>
        </div>
    </div>

</form>


<?php

    include 'rodape.php';



?>



<!-----
ANOTAÇÕES

tipo de os 87

CONSULTA RESPONSAVEL:
SELECT res.CD_RESPONSAVEL, usu.nm_usuario FROM portal_projetos.responsaveis res
INNER JOIN dbasgu.usuarios usu 
ON usu.cd_usuario = res.cd_usuario

------

<script>
    function ajax_incluir_portifolio(){
        nr_solicitacao = document.getElementById('nr_solic')
        nome = document.getElementById('nome')
        link = document.getElementById('link')
        video = document.getElementById('video')
        descricao_projeto = document.getElementById('descricao_projeto')
       
              
                    $.ajax({
                            url: "funcoes/cadastro/insert_cad_port.php",
                            type: "POST",
                            data: {
                                    nr_solicitacao: nr_solicitacao.value,
                                    nome: nome.value,
                                    link: link.value,
                                    descricao_projeto: descricao_projeto.value,
                                
                                    },
                            cache: false,
                                                        
                            success: function(data){   
                                console.log(data)
                                alert('Chamado ' + data + ' registrado com sucesso com sucesso!')

                                    prioridade.value = ''
                                    responsavel.value = ''
                                    descricao.value = ''
                                    anexos.value = ''
                                
                            },
                            
                        })
                }



    function ajax_anexar_foto(){

        anexos_fotos = document.getElementById('anexos_fotos')
        desc_foto = document.getElementById('desc_foto')

        file = $('#anexos_fotos').prop("files")[0]
        form = new FormData()
        form.append("image[]", file)

        $.ajax({
                            url: "funcoes/cadastro/insert_cad_port.php",
                            type: "POST",
                            data: {

                                anexos_fotos:anexos_fotos,
                                desc_foto:desc_foto
                                
                                    },
                            cache: false,
                                                        
                            success: function(data){   
                                console.log(data)
                                alert('Chamado ' + data + ' registrado com sucesso com sucesso!')

                                    prioridade.value = ''
                                    responsavel.value = ''
                                    descricao.value = ''
                                    anexos.value = ''
                                
                            },
                            
                        })





    }                

                
            
        

    






</script>---> 