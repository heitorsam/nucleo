<?php
include 'conexao.php';
include 'cabecalho.php';
//session_start();



?>

<h11><i class="fa-solid fa-file-circle-plus"></i> Solicitação</h11>
<span class="espaco_pequeno" style="width: 6px;" ></span>
<h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
<div class="div_br"></div>

<form action="funcoes/solicitacao/ajax_abrir_solicitacao.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-3">
            Tipo:
            <select class="form-control" name="tipo" required>
                <option value="">Selecione</option>
                <option value="PR">Projeto</option>
                <option value="RP">Report</option>
                <option value="PA">Painel</option>
                <option value="DC">Documento de Prontuario</option>
                <option value="OT">Outros</option>
            </select>
        </div>
        <div class="col-md-3">
            Prioridade:
            <select class="form-control" name="prioridade" required>
                <option value="">Selecione</option>
                <option value="M">Muito Alta</option>
                <option value="A">Alta</option>
                <option value="E">Média</option>
                <option value="B">Baixa</option>
                <option value="X">Muito Baixa</option>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2">
            Ramal:
             <input type="text" class="form-control" name="inpt_ramal" required>
        </div>
        <div class="col-md-3">
            Email:
             <input type="email" class="form-control" name="inpt_email" required>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            Descrição
            <textarea style="background-color: white" class="textarea"  name="descricao" rows="4" required></textarea>
        </div>
        <div class="col-md-3">
              Anexos:
            <input class="select_archive" accept="image/*" name="image[]" multiple type="file">
        </div>   
    </div>
    </br>
    </br>
    <div class="row">
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Solicitar</button>
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

------>

<script>
    function ajax_abrir_os(){
        prioridade = document.getElementById('prioridade')
        tipo = document.getElementById('tipo')
        ramal = document.getElementById('inpt_ramal')
        email = document.getElementById('inpt_email')
        anexos = document.getElementById('anexos')
        descricao = document.getElementById('descricao')

        file = $('#anexos').prop("files")[0]
        form = new FormData()
        form.append("image[]", file)

        if(prioridade.value == ''){
            alert('Informe uma prioridade!')
            prioridade.focus()
        }else{
            if(tipo.value == ''){
                alert('Informe o Tipo da Os !')
                tipo.focus()
            }else{
                if(ramal.value == ''){
                    alert('Informe o seu ramal !')
                    ramal.focus()
                }else{
                    if(email.value == ''){
                        alert('Informe o seu email !')
                        email.focus()
                    }else{
                        $.ajax({
                            url: "funcoes/solicitacao/ajax_abrir_solicitacao.php",
                            type: "POST",
                            data: {
                                    prioridade: prioridade.value,
                                    tipo: tipo.value,
                                    prioridade: prioridade.value,
                                    descricao: descricao.value,
                                    anexos: anexos.value,
                                    ramal: ramal.value,
                                    email: email.value
                                
                                    },
                            cache: false,
                                                        
                            success: function(data){   
                                console.log(data)
                                alert('Chamado ' + data + ' registrado com sucesso com sucesso!')

                                    prioridade.value = ''
                                    descricao.value = ''
                                    anexos.value = ''
                                    tipo.value = ''
                                    ramal.value = ''
                                    email.value =''
                                    
                            },
                                
                        })
                    } 
                }
                    
            }
        }
    }

    






</script>