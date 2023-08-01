<?php 

    include '../../conexao.php';

    $consulta = "SELECT rp.*,
                            CASE
                            WHEN rp.TP_FUNCAO = 'AN' THEN
                            'ANALISTA'
                            ELSE
                            'AUXILIR'
                            END AS FUNCAO,
                            (SELECT COUNT(*)
                            FROM portal_projetos.solicitacao sol
                            WHERE sol.cd_responsavel = rp.cd_responsavel) AS QTD
                        FROM portal_projetos.RESPONSAVEL rp";

    $resultado = oci_parse($conn_ora, $consulta);

    oci_execute($resultado);
    
?>

<table class="table table-striped" cellspacing="0" cellpadding="0">

    <thead>

        <tr>

        <th style="text-align: center;">Código do Usuario</th>
        <th style="text-align: center;">Código do Responsavel</th>
        <th style="text-align: center;">Email</th>
        <th style="text-align: center;">Função</th>
        <th style="text-align: center;">Opções</th>

        </tr>

    </thead>

    <tbody>

        <?php

        $count_lista = 0;

        while($row = oci_fetch_array($resultado)){
            

            $count_lista = $count_lista + 1;
            echo '<tr>';
                echo '<td class="align-middle" style="text-align: center;">' . $row['CD_RESPONSAVEL'] . '</td>';
                echo '<td class="align-middle" style="text-align: center;">' . $row['CD_USUARIO_CADASTRO'] . '</td>';?>

                    <td class="align-middle"  style="text-align: center;" id="EMAIL<?php echo $row['CD_USUARIO_CADASTRO'] ?>"
                    ondblclick="fnc_editar_campo('portal_projetos.RESPONSAVEL', 'EMAIL', '<?php echo @$row['EMAIL']; ?>', 'CD_USUARIO_CADASTRO', '<?php echo @$row['CD_USUARIO_CADASTRO']; ?>', '')">
                    <?php echo $row['EMAIL'] ?> </td>

                    <td class="align-middle" style="text-align: center;" id="TP_FUNCAO<?php echo $row['CD_USUARIO_CADASTRO'] ?>"
                    ondblclick="fnc_editar_campo('portal_projetos.RESPONSAVEL', 'TP_FUNCAO', '<?php echo @$row['TP_FUNCAO']; ?>', 'CD_USUARIO_CADASTRO', '<?php echo @$row['CD_USUARIO_CADASTRO']; ?>', 'SELECT ~AN~ AS COLUNA_DS, ~AN~ AS COLUNA_VL FROM DUAL UNION ALL SELECT ~AD~ AS COLUNA_DS, ~AD~ AS COLUNA_VL FROM DUAL')"> 
                    <?php echo $row['TP_FUNCAO'] ?> </td>

                    <td class="align-middle" style="text-align: center;">
                        <button class="btn btn-adm" id="btn_colet" onclick="ajax_apagar_responsavel('<?php echo $row['CD_USUARIO_CADASTRO'] ?>')" <?php if($row['QTD'] != 0){ echo 'disabled'; } ?>>
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
        <?php 
            echo'</tr>';
        }
        ?>

    </tbody>

</table>

