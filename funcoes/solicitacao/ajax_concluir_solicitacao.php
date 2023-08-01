<?php 
    include '../../conexao.php';

    session_start();

    $os = $_POST['os'];

    $texto = $_POST['texto'];

    $usu = $_SESSION['usuarioLogin'];

    echo $consulta = "UPDATE dbamv.solicitacao_os os
                    SET os.dt_entrega = SYSDATE, 
                        os.Ds_Concluido = '$texto',
                        os.tp_situacao = 'C'
                WHERE os.cd_os = $os";

    $resultado = oci_parse($conn_ora,$consulta);

    oci_execute($resultado);

    echo $consulta_just = "INSERT INTO portal_projetos.justificativa (CD_JUST, 
                                                                        CD_SOL, 
                                                                        TP_JUST,
                                                                        DS_JUST,
                                                                        CD_USUARIO_CADASTRO, 
                                                                        HR_CADASTRO) 
                                                                        VALUES(portal_projetos.SEQ_CD_JUST.nextval,
                                                                            $os,
                                                                            'C',
                                                                            '$texto',
                                                                            '$usu',
                                                                            SYSDATE)";
    $resultado_just = oci_parse($conn_ora,$consulta_just);

    oci_execute($resultado_just);


?>