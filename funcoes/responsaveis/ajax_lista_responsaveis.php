<?php 

    include '../../conexao.php';

    $consulta = "SELECT rp.CD_RESPONSAVEL, 
                        rp.CD_USUARIO_MV,
                        (SELECT usu.NM_USUARIO FROM dbasgu.USUARIOS usu WHERE usu.CD_USUARIO = rp.CD_USUARIO_MV) AS NM_USUARIO,
                        rp.EMAIL
                     FROM nucleoinfo.RESPONSAVEL rp";

    $resultado = oci_parse($conn_ora, $consulta);

    oci_execute($resultado);
    
?>

<table class="table table-striped" cellspacing="0" cellpadding="0">

    <thead>

        <tr>

        <th style="text-align: center;">Código do Usuario</th>
        <th style="text-align: center;">Código do Responsavel</th>
        <th style="text-align: center;">Email</th>
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
                echo '<td class="align-middle" style="text-align: center;">' . $row['NM_USUARIO'] . '</td>';?>

                    <td class="align-middle"  style="text-align: center;" id="EMAIL<?php echo $row['CD_RESPONSAVEL'] ?>"
                    ondblclick="fnc_editar_campo('nucleoinfo.RESPONSAVEL', 'EMAIL', '<?php echo @$row['EMAIL']; ?>', 'CD_RESPONSAVEL', '<?php echo @$row['CD_RESPONSAVEL']; ?>', '')">
                    <?php echo $row['EMAIL'] ?> </td>

                    <td class="align-middle" style="text-align: center;">
                        <button class="btn btn-adm" id="btn_colet" onclick="ajax_apagar_responsavel('<?php echo $row['CD_RESPONSAVEL'] ?>')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>

        <?php 
            echo'</tr>';
        }

        ?>

    </tbody>

</table>

