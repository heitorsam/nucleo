<?php 

    include '../../conexao.php';

    $qtd = $_GET['qtd'];

    $port = $_GET['port'];

    $consulta_lista = "SELECT * FROM (SELECT rownum as linha, 
                            port.cd_portfolio,
                            port.nm_projeto, 
                            port.ds_projeto,
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
                                'ERRO'
                            END AS TP
                        FROM portal_projetos.portfolio port
                        INNER JOIN portal_projetos.solicitacao sol
                        ON sol.cd_solicitacao = port.cd_solicitacao ) slt
                        WHERE slt.linha BETWEEN 1 AND $qtd
                        AND slt.nm_projeto like '$port%'
                        ORDER BY SLT.nm_projeto";



    $resultado_lista = oci_parse($conn_ora, $consulta_lista);

    oci_execute($resultado_lista);

?>

<table class="table table-striped" cellspacing="0" cellpadding="0">

    <thead>

        <tr>

        <th style="text-align: center;">Nome do portfolio</th>
        <th style="text-align: center;">Descrição do portfolio</th>
        <th style="text-align: center;">Tipo</th>
        <th style="text-align: center;">Opções</th>

        </tr>

    </thead>

    <tbody>

        <?php


        while($row_lista = oci_fetch_array($resultado_lista)){
            
            echo '<tr>';
                echo '<td class="align-middle" style="text-align: center;">' . $row_lista['NM_PROJETO'] . '</td>';
                echo '<td class="align-middle" style="text-align: center;">' . $row_lista['DS_PROJETO'] . '</td>';
                echo '<td class="align-middle" style="text-align: center;">' . $row_lista['TP'] . '</td>';?>

                    <td class="align-middle" style="text-align: center;">
                        <a href="editar_portfolio.php?cd_port=<?php echo $row_lista['CD_PORTFOLIO'] ?>" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button class="btn btn-adm">
                            <i onclick="ajax_apagar_portfolio(<?php echo  $row_lista['CD_PORTFOLIO']; ?>)" class="fa-solid fa-trash"></i>
                        </button>
                    </td>
        <?php 
            echo'</tr>';
        }
        ?>

    </tbody>

</table>