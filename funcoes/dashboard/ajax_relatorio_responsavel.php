<?php 
    $responsavel = $_GET['responsavel'];

    include '../../conexao.php';

    $consulta_imagem = "SELECT anf.blob_foto AS FOTO, usu.nm_usuario AS NOME 
    FROM portal_projetos.anexo_fotos anf
    INNER JOIN dbasgu.usuarios usu
    ON usu.cd_usuario = anf.cd_usuario_cadastro
    INNER JOIN dbamv.funcionario fnc
    ON fnc.nm_func = usu.nm_usuario
    WHERE fnc.cd_func = $responsavel
    ";

    $resultado_imagem = OCI_PARSE($conn_ora,$consulta_imagem);

    oci_execute($resultado_imagem);

    
    while($row_imagem = oci_fetch_array($resultado_imagem)){
        $imagem = $row_imagem['FOTO'] ->load(); 
        $nome = $row_imagem['NOME'];
        $imagem = base64_encode($imagem);
    }
?>

<img style="height: 150px;border-radius: 100px;border-color: #46a5d4 !important" src="data:image;base64,<?php echo $imagem ?>" alt="imagem_responsavel">
<label><?php echo $nome; ?></label>
</br>
