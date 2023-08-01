<?php

    include 'conexao.php';
    include 'cabecalho.php';

    //VARIAVEL DO USUARIO LOGADO 
    $var_usuario = $_SESSION['usuarioLogin'];

    //CONSULTA PARA PEGAR OS DADOS DO SOLICITANTE LOGADO
    $cons_solic_logado = "SELECT * 
                          FROM dbasgu.USUARIOS usu
                          WHERE usu.CD_USUARIO = '$var_usuario'
                          ";
    $res_solic_logado = oci_parse($conn_ora, $cons_solic_logado);
                        oci_execute($res_solic_logado);
    
    $row_usuario = oci_fetch_array($res_solic_logado);

    //CONSULTA PARA PEGAR OS SETORES SOLICITANTES
    $setor = "SELECT stf.CD_SETOR,
                     stf.NM_SETOR
              FROM dbamv.STA_TB_FUNCIONARIO stf
              INNER JOIN dbasgu.USUARIOS usu
              ON usu.NR_MATRICULA = stf.CHAPA
              WHERE stf.TP_SITUACAO = 'A'
              AND usu.CD_USUARIO = '$var_usuario'";

    $res_setor = oci_parse($conn_ora, $setor);
    oci_execute($res_setor);

    $row_setor = oci_fetch_array($res_setor);


?>

<h11><i class="fa-solid fa-file-circle-plus"></i> Solicitação</h11>
<span class="espaco_pequeno" style="width: 6px;" ></span>
<h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
<div class="div_br"></div>


    <div class="row">

        <div class="col-md-3">

            Solicitante:
            <input readonly type="text" id="nm_solicitante" class="form form-control" value="<?php echo $row_usuario['NM_USUARIO']; ?>">

        </div>

        <div class="col-md-4">

        
            Setor:
            <input readonly type="text" id="nm_solicitante" class="form form-control" value="<?php echo $row_setor['NM_SETOR']; ?>">


        </div>


    </div>

    <div class="div_br"> </div>

    <div class="row">

        <div class="col-md-2">
            Ramal:
             <input type="text" class="form-control" id="inpt_ramal" autocomplete="off">
        </div>
        
        <div class="col-md-3">
            Email:
             <input type="email" class="form-control" id="inpt_email" autocomplete="off">
        </div>

    </div>
    <div class="div_br"> </div>
    <div class="row">

        <div class="col-md-12">
            Descrição da Solicitação:
            <textarea style="background-color: white" class="textarea"  id="descricao" rows="4"></textarea>
        </div>

    </div>

    <div class="div_br"> </div>
    
    <div class="row">

        <div class="col-md-12">
            Motivo
            <textarea style="background-color: white" class="textarea"  id="motivo" rows="4"></textarea>
        </div>

    </div>

    <div class="div_br"> </div>

    <div class="row">

        <div class="col-md-12">

            Anexos:
            <input class="select_archive" accept="image/*" name="image[]" multiple type="file" id="file">
            
        </br>

    </div>
    <div class="div_br"> </div>

    <div class="col-md-3" style="padding-top: 20px;">

        <button onclick="ajax_abrir_os()"class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Solicitar</button>
        
    </div>




<script>


function ajax_abrir_os(){

   //RECEBENDO OS DADOS DO FORMULARIO
    var usuario_logado = '<?php echo $var_usuario ?>';
    var nome_usuario_logado = '<?php echo $row_usuario['NM_USUARIO'] ?>';
    var setor_usuario_logado = '<?php echo $row_setor['CD_SETOR'] ?>';

    var inpt_ramal = $("#inpt_ramal").val();
    var inpt_email = $("#inpt_email").val();
    var descricao = $("#descricao").val();
    var motivo = $("#motivo").val();

    var fileInput = document.getElementById('file');
    var formData = new FormData();

    //ADICIONANDO OS DADOS AO FORMDATA
    formData.append('inpt_ramal', inpt_ramal);
    formData.append('inpt_email', inpt_email);
    formData.append('descricao', descricao);
    formData.append('motivo', motivo);
    formData.append('usuariologado', usuario_logado);
    formData.append('nm_usuario_logado', nome_usuario_logado);
    formData.append('st_usuario_logado', setor_usuario_logado);

    // Adicionar os arquivos anexados ao objeto FormData
    for (var i = 0; i < fileInput.files.length; i++) {

        formData.append('arquivos[]', fileInput.files[i]);
    }

    // Enviar a requisição AJAX com o FormData
    $.ajax({
        url: "funcoes/solicitacao/ajax_abrir_solicitacao.php",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(dataResult) {
            console.log(dataResult);
        }
    });
    
}



</script>

<?php

    include 'rodape.php';

?>


