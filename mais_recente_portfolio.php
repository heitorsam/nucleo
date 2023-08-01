
<?php 

	include 'conexao.php';

	$contador = $_GET['contador'];

	$consulta_recentes = "SELECT num.* 
							FROM (SELECT rownum as ordem, slt.*
									FROM (SELECT prt.cd_portfolio,
												prt.NM_PROJETO AS NM_PROJETO,
												slt.documento    AS documento,
												slt.extensao     AS EXTENSAO,
												prt.link_projeto     AS LINK_DOC
											FROM portal_projetos.portfolio prt
										INNER JOIN (SELECT *
														FROM portal_projetos.galeria gl
													WHERE gl.sn_principal = 'S') slt
											ON slt.cd_portfolio = prt.cd_portfolio
										ORDER BY prt.hr_cadastro DESC) slt) num
										WHERE num.ordem between $contador and $contador + 4";
	$consulta_recentes;

	$resultado_consulta = oci_parse($conn_ora, $consulta_recentes);

	oci_execute($resultado_consulta);

	$qtd_portfolio = 6;
	$tamanho = 180;
	$tamanho_redutor = 10;
	$margin_total = 0;

	echo '<div class="row">';

		echo '<div class="col-1 botoes_recentes" onclick="carrosel_recentes(1,'. $contador .')">';

			echo '<i class="fa-solid fa-chevron-left"></i>';

		echo '</div>';

		echo '<div class="col-10" style="height: 220px; background-color: #f9f9f9 !important;">';

			echo '<div class="row justify-content-center">';

				while($row_recente = oci_fetch_array($resultado_consulta)){

					$tamanho = $tamanho - $tamanho_redutor;
					$margin_total = $margin_total + $tamanho_redutor;

					echo '<div class="col-2 caixa_miniatura" style="height: ' . $tamanho  . 'px; margin-top: ' . $margin_total/2  . 'px;
					margin-bottom: -' . $margin_total/2  . 'px;  margin-right: 20px;">';

						echo $row_recente['NM_PROJETO'];		

						echo '<div class="caixa_miniatura_foto">';
							$imagem = $row_recente['DOCUMENTO']->load(); // (1000) = 1kB
							$imagem = base64_encode($imagem);?>
							<img style="height: 100% !important; width: 100% !important; margin: 0 auto !important;" onclick="ajax_modal_portfolio(<?php echo $row_recente['CD_PORTFOLIO'] ?>)" src="data:image/<?php echo $row_recente['EXTENSAO'] . ';base64,'. $imagem;?>" >						
							<?php
						echo '</div>';

						echo '<div class="caixa_abaixo_foto">';

							echo '<i class="fa-regular fa-eye"></i> ' . '1';

						echo '</div>';

					echo '</div>';

				}

			echo '</div>';

		echo '</div>';

		echo '<div class="col-1 botoes_recentes" onclick="carrosel_recentes(2,'. $contador .')">';

				echo '<i class="fa-solid fa-chevron-right"></i>';

		echo '</div>';

	echo '</div>';

?>

</br>


<style>

	.caixa_miniatura{

		transition: 300ms ease-in-out;
		border: solid 1px #c3c3c3;
		border-radius: 3px;
		float: left;
		padding: 4px !important;
		font-size: 14px;
	
	}

	.caixa_miniatura:hover{

		height: 200px !important;
		margin-top: -10px !important;

	}

	.caixa_miniatura_foto{

		 width: 90%; 
		 height: 60%; 
		 border: solid 1px #c3c3c3;
		 margin: 0 auto;
		 margin-top: 4px;

	}

	.caixa_abaixo_foto{
		
		width: 90%;
		text-align: right !important;
		font-size: 12px;
		margin-top: 4px;

	}

	.botoes_recentes{

		color: #e0e0e0; 
		text-shadow: 1px 1px 0 #d4d4d4; 
		font-size: 36px; 
		line-height: 180px; 
		background-color: #f9f9f9 !important;

	}

	.botoes_recentes:hover{

		color: #70aedc;
		cursor:pointer;

	}

</style>

<div class="modal fade" id="modal_portfolio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="div_portfolio">
            
        </div>
    </div>
</div>

<script>

    function ajax_modal_portfolio(cd_portfolio){
		
        $('#div_portfolio').load('funcoes/portfolio/ajax_modal_portfolio.php?cd_portfolio='+cd_portfolio)
        $('#modal_portfolio').modal('show')
    }

</script>