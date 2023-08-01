<?php

    session_start();

    include '../../conexao.php';

    if($_SESSION['SN_ADM'] == 'S'){
        $class = "btn-adm";
    }else{
        $class = "btn-primary";
    }

    $data = $_GET['data'];

    $usu = $_SESSION['usuarioLogin'];

    $lista_chamados = "SELECT vw.TIPO,
                            vw.CD_OS,
                            TO_CHAR(vw.DT_PEDIDO, 'DD/MM/YYYY') AS DT_PEDIDO,
                            vw.NM_USUARIO_SOL,
                            vw.NM_USUARIO_RESP,
                            sol.cd_usuario_cadastro,
                            vw.ICONE,
                            vw.ORDEM,
                            SUBSTR(vw.DS_SERVICO,0,40) AS DS,
                            (SELECT COUNT(*)
                            FROM portal_projetos.justificativa just
                            WHERE just.cd_sol = sol.cd_os_mv) AS QTD_JUST,
                            (SELECT COUNT(*)
                            FROM portal_projetos.resposta res
                            WHERE res.Cd_Solicitacao = sol.cd_os_mv) AS QTD_RESP,
                            (SELECT COUNT(*)
                            FROM portal_projetos.chat
                            WHERE chat.cd_os = sol.cd_os_mv) AS QTD_CHAT
                        FROM portal_projetos.VW_SOLICITACOES_USUARIO vw
                        INNER JOIN portal_projetos.solicitacao sol
                        ON sol.cd_os_mv = vw.CD_OS
                        ";
                        if($_SESSION['SN_ADM'] == 'N'){
                            $lista_chamados .= " WHERE sol.Cd_Usuario_Cadastro = UPPER('$usu')
                                                AND vw.ORDEM = 3";
                        } elseif($_SESSION['SN_AUX'] == 'S' && $_SESSION['SN_ADM'] == 'N'){

                            $lista_chamados .= " WHERE vw.CD_USUARIO_RESP = '$usu'
                                                 AND vw.ORDEM = 3";
                        } else{
                            $lista_chamados .= " WHERE vw.ORDEM = 3";
                        }
                        $lista_chamados .= " AND TO_CHAR(vw.DT_PEDIDO,'YYYY-MM') = '$data'
                                                    ORDER BY vw.CD_OS DESC";

    $result_chamados = oci_parse($conn_ora, $lista_chamados);

    oci_execute($result_chamados);
    
?>

<div class="row">

    <div class="col-md-3">
        Data:
        <input type="month" value="<?php echo $data ?>" class="form-control" onchange="ajax_filtro_mes(this.value)" >
    </div>

</div>

</br>

<?php

    $ultimo_tipo = '';
    $count_while = 0;

    while($row_os = oci_fetch_array($result_chamados)){  

        if($row_os['TIPO'] <> $ultimo_tipo OR $count_while == 0){

            if($count_while <> 0){
                //FECHA A TABLE
                    echo '</tbody>';
                    echo '</table>';                          
                echo '</div>';
                
            }
                       
            echo '<tr>';
                echo "<div class='fnd_azul'>" . $row_os['ICONE'] . ' '. $row_os['TIPO']  . "</div>";
            echo '</tr>';
?>

        
<!-- ABRE A TABELA -->
<div class="table-responsive col-md-12">
    <table class="table table-fixed table-hover table-striped " cellspacing="0" cellpadding="0">


        <div class="div_br"> </div>
        <thead><tr>
            <!--COLUNAS--> 
            <th class="align-middle" style="text-align: center !important;"><span>Tipo</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>OS</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Data Solicitação</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Descrição</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Solicitante</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Responsável</span></th>
            <th class="align-middle" style="text-align: center !important;"><span>Opções</span></th>
        </tr></thead> 
        <tbody>
<?php
        }
?>
                
            <tr>
                <td class='align-middle' style='text-align: center;'><?php echo $row_os['TIPO']; ?></td>
                <td class='align-middle' style='text-align: center;'><?php echo $row_os['CD_OS']; ?></td>
                <td class='align-middle' style='text-align: center;'><?php echo $row_os['DT_PEDIDO']; ?></td>
                <td class='align-middle' style='text-align: center;'><?php echo $row_os['DS']; ?></td>
                <td class='align-middle' style='text-align: center;'><?php echo $row_os['NM_USUARIO_SOL']; ?></td>
                <td class='align-middle' style='text-align: center;'><?php echo $row_os['NM_USUARIO_RESP']; ?></td>
                <td class='align-middle' style='text-align: center;'>
                <?php 
                if($row_os['TIPO'] != 'Solicitado'){ 
                    if($row_os['TIPO'] == 'Recebido' || $row_os['QTD_CHAT'] > 0){ ?>
                        <a class='btn <?php echo $class ?>' onclick="call_chat(<?php echo $row_os['CD_OS']; ?>,'<?php echo $row_os['TIPO'] ?>')"><i class="fa-solid fa-comment"></i></a>
                <?php 
                    }
                } 
                ?>
                <a class='btn <?php echo $class ?>' onclick="ajax_modal_sol(<?php echo $row_os['CD_OS']; ?>)"> <i class="fa-solid fa-info"></i> </a>
                <?php 
                if($row_os['QTD_JUST'] > 0){ 
                ?>
                    <a class='btn <?php echo $class ?>' onclick="ajax_modal_just(<?php echo $row_os['CD_OS']; ?>,'V')"><i class="fa-solid fa-scroll"></i></a>
                <?php 
                } 
                ?>
                <?php 
                if($row_os['TIPO'] == 'Concluído'){ 
                    if($row_os['QTD_RESP'] > 0 || $row_os['CD_USUARIO_CADASTRO'] == $usu){
                ?> 
                        <a class='btn <?php echo $class ?>' onclick="ajax_modal_avaliacao(<?php echo $row_os['CD_OS']; ?>,<?php echo $row_os['QTD_RESP']; ?>)"><i class="fa-solid fa-star"></i></a>
                <?php   
                    }
                } 
                ?>
                </td>

            </tr>
            
<?php 

            $ultimo_tipo = $row_os['TIPO'];
            $count_while = $count_while + 1;

        } 
?>
    
    </div>
</table>

<script>




</script>

