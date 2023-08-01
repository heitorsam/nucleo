<?php 
    $var_cd_os = $_GET['cd_os']; 

    $tipo = $_GET['tp'];

    session_start();

    include '../../conexao.php';

    if($tipo == 'V'){
        $disabled = 'disabled';

        $consulta = "SELECT TO_CHAR(just.hr_cadastro, 'DD/MM/YYYY HH24:MI') AS DT,
                            just.tp_just,
                            CASE just.tp_just
                                WHEN 'E' THEN
                                'Editado'
                                WHEN 'C' THEN
                                'Concluido'
                                WHEN 'R' THEN
                                'Recusado'
                            END as tipo,
                            just.cd_usuario_cadastro,
                            usu.nm_usuario,
                            just.ds_just,
                            just.cd_just
                    FROM portal_projetos.justificativa just
                    INNER JOIN dbasgu.usuarios usu
                    ON usu.cd_usuario = just.cd_usuario_cadastro
                    WHERE just.cd_sol = $var_cd_os
                    ORDER BY just.cd_just
                    ";

        $resultado = oci_parse($conn_ora,$consulta);

        oci_execute($resultado);

        
    }

?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> 
        Justificativa
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="row">
        <?php if($tipo == 'V'){
            while($row_just = oci_fetch_array($resultado)){
                echo '<div class="col-md-12" >';
                echo 'Tipo: '. $row_just['TIPO'] .' Data: '. $row_just['DT'] .'  Responsavel: '. $row_just['NM_USUARIO'] .' </br> Justificativa: '. $row_just['DS_JUST'] .'</br></br>';
                echo '</div>';
            }
        }else{ ?>
        <div class="col-md-12">
            <textarea id="txt_just" class="form-control" rows="10"></textarea>    
        </div>
        <?php } ?>
    </div>


    </br>

    <div class="modal-footer">
        <?php if($tipo == 'E'){ ?>
            <button type="button" class="btn btn-primary" onclick="ajax_editar_solicitacao('<?php echo $var_cd_os ?>','<?php echo $tipo ?>')" data-dismiss="modal" ><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
        <?php }elseif($tipo == 'C'){ ?>
            <button type="button" class="btn btn-primary" onclick="ajax_concluir_solicitacao('<?php echo $var_cd_os ?>')" data-dismiss="modal" ><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
        <?php }elseif($tipo != 'V'){ ?>
            <button type="button" class="btn btn-primary" onclick="ajax_editar_solicitacao('<?php echo $var_cd_os ?>','<?php echo $tipo ?>')" data-dismiss="modal" ><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
        <?php } ?>
    </div>
    
        
</div>