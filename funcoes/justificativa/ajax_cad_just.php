<?php 
    include './../../conexao.php';

    session_start();

    
    $os = $_POST['os'];
    
    $tipo = $_POST['tp_just'];
    
    if($tipo != 'A'){
    $justi = $_POST['txt_just'];

    $usu = $_SESSION['usuarioLogin'];

        echo $consulta_just = "INSERT INTO portal_projetos.justificativa (CD_JUST, 
                                                                        CD_SOL, 
                                                                        TP_JUST,
                                                                        DS_JUST,
                                                                        CD_USUARIO_CADASTRO, 
                                                                        HR_CADASTRO) 
                                                                        VALUES(portal_projetos.SEQ_CD_JUST.nextval,
                                                                            $os,
                                                                            '$tipo',
                                                                            '$justi',
                                                                            '$usu',
                                                                            SYSDATE)";
        $resultado_just = oci_parse($conn_ora,$consulta_just);

        oci_execute($resultado_just);

        if($tipo == 'R'){
            echo $consulta_os = "UPDATE dbamv.SOLICITACAO_OS SET TP_SITUACAO = 'D' WHERE CD_OS = $os";
            $resultado_os = oci_parse($conn_ora,$consulta_os);

            oci_execute($resultado_os);
        }
    }


    //////////////////
    //ENVIANDO EMAIL//
    //////////////////

    $cons_email = "SELECT sol.email_solicitante AS EMAIL,
                    (SELECT usu.nm_usuario
                    FROM dbasgu.usuarios usu
                    WHERE usu.cd_usuario = sol.cd_usuario_cadastro) AS NOME
                    FROM portal_projetos.solicitacao sol 
                    WHERE sol.cd_os_mv = $os";
    $result_email= oci_parse($conn_ora, $cons_email);
    oci_execute($result_email);

    $row_email = oci_fetch_array($result_email);

    if($tipo == 'R'){
        $txt = "
        A sua solicitação foi recusada pois,
        <br><br>
        $justi
        <br><br>
        ";
        $titulo = 'Solictação Recusada';
        $imagem = 'background-color: #ff0f0f;'; 
    }elseif($tipo == 'E'){

        $txt = "
        A sua solicitação foi editada pois,
        <br><br>
        $justi
        <br><br>
        ";
        $titulo = 'Solicitação Editada';
        $imagem = 'background-color: #12b24f;'; 
    }else{
        $txt = "
        A sua solicitação foi aceita";
        $titulo = 'Solicitação Aceita';
        $imagem = 'background-color: #12b24f;'; 
    }
    $nome = $row_email['NOME'];
    $email = $row_email['EMAIL']; 
    include '../../email_enviar.php'

?>