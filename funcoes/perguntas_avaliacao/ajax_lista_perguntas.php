<?php 
    include '../../conexao.php';

    $consulta = "SELECT perg.cd_pergunta,
                    perg.ds_pergunta,
                    CASE perg.tp_pergunta
                    WHEN 'NT' THEN
                    'Nota'
                    WHEN 'AT' THEN
                    'Alternativa'
                    WHEN 'DE' THEN
                    'Disertativa'
                    END AS TP,
                    (SELECT COUNT(*)
                        FROM portal_projetos.resposta rs
                        WHERE rs.cd_pergunta = perg.cd_pergunta) AS QTD

                FROM portal_projetos.pergunta perg
                ORDER BY perg.cd_pergunta
                ";
    
    $resultado = oci_parse($conn_ora,$consulta);

    oci_execute($resultado)

?>


<table class="table table-striped" cellspacing="0" cellpadding="0">

    <thead>

        <tr>

        <th style="text-align: center;">Código da pergunta</th>
        <th style="text-align: center;">Pergunta</th>
        <th style="text-align: center;">Tipo</th>
        <th style="text-align: center;">Opções</th>

        </tr>

    </thead>

    <tbody>

        <?php

        $count_lista = 0;

        while($row = oci_fetch_array($resultado)){
            
            echo '<tr>';
                echo '<td class="align-middle" style="text-align: center;">' . $row['CD_PERGUNTA'] . '</td>';
                echo '<td class="align-middle" style="text-align: center;">' . $row['DS_PERGUNTA'] . '</td>';
                echo '<td class="align-middle" style="text-align: center;">' . $row['TP'] . '</td>';?>

                    <td class="align-middle" style="text-align: center;">
                    <button class="btn btn-adm" id="btn_colet" onclick="ajax_apagar_pergunta('<?php echo $row['CD_PERGUNTA'] ?>')" <?php if($row['QTD'] != 0){ echo 'disabled'; } ?>>
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    </td>
        <?php 
            echo'</tr>';
        }
        ?>

    </tbody>

</table>