<?php 
    $var_cd_os = $_GET['cd_os']; 
    session_start();

    include '../../conexao.php';

    $consulta_modal = "SELECT vw.TIPO,
                            vw.CD_OS,
                            TO_CHAR(vw.DT_PEDIDO, 'YYYY-MM-DD') as DT_PEDIDO,
                            vw.NM_USUARIO_SOL,
                            vw.NM_USUARIO_RESP,
                            CASE sol.tp_prioridade
                            WHEN 'M' THEN
                            'Muito Alta'
                            WHEN 'A' THEN
                            'Alta'
                            WHEN 'E' THEN
                            'Média'
                            WHEN 'B' THEN
                            'Baixa'
                            WHEN 'X' THEN
                            'Muito Baixa'
                            ELSE
                            'Erro'
                            END AS PRIORIDADE,
                            CASE sol.tp_tipo
                            WHEN 'PR' THEN
                            'Projeto'
                            WHEN 'RP' THEN
                            'Report'
                            WHEN 'PA' THEN
                            'Painel'
                            WHEN 'DC' THEN
                            'Documento de Prontuario'
                            WHEN 'OT' THEN
                            'Outros'
                            ELSE
                            'Erro'
                            END AS TP_TIPO,
                            TO_CHAR(sol.estimativa_entrega,'YYYY-MM-DD') AS ESTIMATIVA_ENTREGA,
                            os.ds_observacao,
                            sol.email_solicitante AS EMAIL,
                            sol.ramal_solicitante AS RAMAL,
                            vw.TIPO
                        FROM portal_projetos.VW_SOLICITACOES_USUARIO vw
                        INNER JOIN portal_projetos.solicitacao sol
                            ON sol.cd_os_mv = vw.CD_OS
                        INNER JOIN dbamv.solicitacao_os os
                            ON os.cd_os = sol.cd_os_mv
                            INNER JOIN portal_projetos.vw_solicitacoes_usuario vw
                            ON vw.CD_OS = sol.cd_os_mv
                        WHERE sol.cd_os_mv = $var_cd_os";

    $resultado_modal = oci_parse($conn_ora, $consulta_modal);

    oci_execute($resultado_modal);

    $row_modal = oci_fetch_array($resultado_modal);

?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> 
        <div style="background-color: #ffd9ac; border-radius: 10px; padding: 3px;">
            <?php echo 'OS: ' . $var_cd_os; ?>
        </div>
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="row">
        <div class="col-md-6">
            Solicitente:
            <input type="text" class="form-control" value="<?php echo $row_modal['NM_USUARIO_SOL'] ?>" disabled>
        </div>
        <div class="col-md-6">
            Responsavel:
            <?php if($_SESSION['SN_ADM'] == 'S' && $row_modal['TIPO'] != 'Concluído'){ 
                $resp = @$row_modal['NM_USUARIO_RESP'];
                $consulta_responsavel = "SELECT rs.cd_usuario_mv AS CD, fun.nm_func AS NM
                                                    FROM portal_projetos.responsavel rs
                                                INNER JOIN dbamv.funcionario fun
                                                ON fun.cd_func = rs.cd_usuario_mv";
                                                if($resp != ''){
                                                    $consulta_responsavel .= " WHERE fun.nm_func <> '$resp'";
                                                }
                $resultado_responsavel = oci_parse($conn_ora,$consulta_responsavel);
                oci_execute($resultado_responsavel);

                echo '<select class="form-control" id="slt_func">';
                        if($resp != ''){
                            echo '<option value="caio_esteve_aqui">'. $resp .'</option>';
                        }else{
                            echo '<option value="">Selecione</option>';
                        }
                        while($row_responsavel = oci_fetch_array($resultado_responsavel)){
                            echo '<option value="'. $row_responsavel['CD'] .'">'. $row_responsavel['NM'] .'</option>';
                        }
                echo '</select>';

            }else{ ?>
                <input type="text" class="form-control" value="<?php echo @$row_modal['NM_USUARIO_RESP'] ?>" disabled>
            <?php } ?>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="col-md-3">
            Data Solicitação:
            <input type="date" class="form-control" value="<?php echo $row_modal['DT_PEDIDO'] ?>" disabled>
        </div>
        <div class="col-md-3">
            Prioridade:
            <?php 
            if($_SESSION['SN_ADM'] == 'S' && $row_modal['TIPO'] != 'Concluído'){
                $prioridade = $row_modal['PRIORIDADE'];
                //estudar possibilidade de substituir essa consulta para o php ass: Caio 25/10/2022 13:18
                $consulta_prioridade = "SELECT * FROM (SELECT 'M' AS CD, 'Muito Alta' AS DS FROM DUAL
                UNION ALL
                SELECT 'A' AS CD, 'Alta' AS DS FROM DUAL
                UNION ALL
                SELECT 'E' AS CD, 'Média' AS DS FROM DUAL
                UNION ALL
                SELECT 'B' AS CD, 'Baixa' AS DS FROM DUAL
                UNION ALL
                SELECT 'X' AS CD, 'Muito Baixa' AS DS FROM DUAL) slt WHERE slt.ds <> '$prioridade'";

                $resultado_prioridade = oci_parse($conn_ora, $consulta_prioridade);

                oci_execute($resultado_prioridade);
            
                echo '<select class="form-control" id="slt_prioridade">';
                echo '<option value="">'. $prioridade .'</option>';
                while($row_prioridade = oci_fetch_array($resultado_prioridade)){
                    echo '<option value="'. $row_prioridade['CD'] .'">'. $row_prioridade['DS'] .'</option>';
                }
                
                echo'</select>';
            
            
            }else{ ?>
            <input type="text" class="form-control" value="<?php echo $row_modal['PRIORIDADE'] ?>" disabled>
            <?php } ?>
        </div>
        <div class="col-md-3">
            Tipo:
            <?php 
            if($_SESSION['SN_ADM'] == 'S' && $row_modal['TIPO'] != 'Concluído'){ 
                $tipo = $row_modal['TP_TIPO'];
                $consulta_tipo = "SELECT * FROM (SELECT 'PR' AS CD, 'Projeto' AS DS FROM DUAL
                UNION ALL
                SELECT 'RP' AS CD, 'Report' AS DS FROM DUAL
                UNION ALL
                SELECT 'PA' AS CD, 'Painel' AS DS FROM DUAL
                UNION ALL
                SELECT 'DC' AS CD, 'Documento de Prontuario' AS DS FROM DUAL
                UNION ALL
                SELECT 'OT' AS CD, 'Outros' AS DS FROM DUAL) slt WHERE slt.ds <> '$tipo'";

                $resultado_tipo = oci_parse($conn_ora, $consulta_tipo);

                oci_execute($resultado_tipo);

                echo '<select class="form-control" id="slt_tipo">';
                echo '<option value="">'. $tipo .'</option>';
                while($row_tipo = oci_fetch_array($resultado_tipo)){
                    echo '<option value="'. $row_tipo['CD'] .'">'. $row_tipo['DS'] .'</option>'; 
                }                
                echo'</select>';

            }else{ ?>
            <input type="text" class="form-control" value="<?php echo $row_modal['TIPO'] ?>" disabled>
            <?php } ?>
        </div>
        <div class="col-md-3">
            Estimativa Entrega:
            <input type="date" id="inpt_previsao" class="form-control" value="<?php echo $row_modal['ESTIMATIVA_ENTREGA'] ?>" <?php if($_SESSION['SN_ADM'] == 'N' || $row_modal['TIPO'] == 'Concluído'){ echo 'disabled'; } ?>>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="col-md-3">
            E-mail:
            <input type="text" class="form-control" value="<?php echo $row_modal['EMAIL'] ?>" disabled>
        </div>
        <div class="col-md-3">
            Ramal:
            <input type="text" class="form-control" value="<?php echo $row_modal['RAMAL'] ?>" disabled>
        </div>
        <div class="col-md-3">
            </br>
            <button type="button" class="btn btn-primary" onclick="ajax_modal_anexos('<?php echo $var_cd_os ?>')"><i class="fa-solid fa-link"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            Observação:
            <textarea class="form-control" disabled><?php echo $row_modal['DS_OBSERVACAO'] ?></textarea>
        </div>
    </div>

    </br>
    <?php 
    if(($_SESSION['SN_ADM'] == 'S' || $_SESSION['SN_AUX'] == 'S') && $row_modal['TIPO'] != 'Concluído'){ ?>
        <div class="modal-footer"> 
        <?php  
        if($row_modal['TIPO'] == 'Solicitado'){ ?>
            <button type="button" class="btn btn-primary" onclick="ajax_editar_solicitacao('<?php echo $var_cd_os ?>','A')" ><i class="fa-solid fa-check"></i> Aceitar</button>
            <button type="button" class="btn btn-adm" onclick="ajax_modal_just('<?php echo $var_cd_os ?>','R')" ><i class="fa-solid fa-xmark"></i> Recusar</button>
        <?php 
        }else{ 
            if($_SESSION['SN_ADM'] == 'S'){?>
            <button type="button" class="btn btn-primary" onclick="ajax_modal_just('<?php echo $var_cd_os ?>','E')" ><i class="fa-solid fa-pen-to-square"></i> Editar</button>
        <?php 
            }
        }

            if($row_modal['TIPO'] == 'Recebido'){ ?>
            <button type="button" class="btn btn-primary" style="background-color: #28a745 !important;border-color: #28a745 !important;" onclick="ajax_modal_just('<?php echo $var_cd_os ?>','C')"><i class="fa-solid fa-check"></i> Concluir</button>

        <?php }
        echo '</div>';
    } ?>
        
</div>