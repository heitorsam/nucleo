<?php

    include '../../conexao.php';

    session_start();

    echo $cd_sol = $_POST['cd_sol'];
    echo '</br>';

    echo $resp = @$_POST['func'];
    echo '</br>';

    echo $prioridade = @$_POST['prioridade'];
    echo '</br>';

    echo $estimativa = @$_POST['estimativa'];
    echo '</br>';

    echo $tipo = @$_POST['tipo'];
    echo '</br>';

    echo $usu = $_SESSION['usuarioLogin'];
    echo '</br>';

    echo $consulta_pp = "UPDATE portal_projetos.solicitacao sol SET ";
    if($resp != ''){
        $consulta_pp .= " CD_RESPONSAVEL = (SELECT rs.cd_responsavel
                                                FROM portal_projetos.responsavel rs
                                            WHERE rs.cd_usuario_mv = $resp), ";
    }
    if($prioridade != ''){
        $consulta_pp .= " TP_PRIORIDADE = '$prioridade', ";
    }
    if($tipo != ''){
        $consulta_pp .= " TP_TIPO = '$tipo', "; 
    }else{
        $consulta_pp .= " ESTIMATIVA_ENTREGA = TO_DATE('$estimativa','YYYY-MM-DD'), ";
    }
    ECHO $consulta_pp .= " CD_USUARIO_ULT_ALT = '$usu',
                          HR_ULT_ALT = SYSDATE
                        WHERE CD_OS_MV = $cd_sol";

    $resultado_pp = oci_parse($conn_ora,$consulta_pp);

    oci_execute($resultado_pp);

    if($resp != '' || $prioridade != ''){
        $consulta_sol = "UPDATE dbamv.solicitacao_os os SET ";
        if($prioridade != ''){
            $consulta_sol .= " TP_PRIORIDADE = '$prioridade'";
        }
        if($resp != ''){
            if($prioridade != ''){
                $consulta_sol .= ", ";
            }
            $consulta_sol .= " SN_RECEBIDA = 'S',
                              CD_RESPONSAVEL = $resp,
                              CD_USUARIO_RECEBE_SOL_SERV = (SELECT MAX(usu.cd_usuario)
                              FROM dbamv.funcionario fun
                             INNER JOIN dbasgu.usuarios usu
                                ON usu.nm_usuario = fun.nm_func
                             WHERE fun.cd_func = $resp
                             AND usu.Sn_Ativo = 'S'
                             )
                              ";
                              //AND usu.cd_usuario LIKE '000%'
        }
        echo $consulta_sol .= " WHERE os.CD_OS = $cd_sol";

        $resultado_sol = oci_parse($conn_ora,$consulta_sol);

        oci_execute($resultado_sol);

    }



    

?>