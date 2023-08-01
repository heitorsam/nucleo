<?php 
    session_start();
    include '../../conexao.php';

    $cd_portfolio = $_GET['cd_portfolio'];
 
    @$sup = $_SESSION['SN_SUP'];

    @$adm = $_SESSION['SN_ADM'];

    @$aux = $_SESSION['SN_AUX'];

    $consulta = "SELECT pf.nm_projeto, 
                            pf.ds_projeto,  
                            sol.cd_os_mv, 
                            func.nm_func,
                            pf.link_projeto,
                            pf.cd_portfolio,
                            TO_CHAR(sol.hr_ult_alt,'DD/MM/YYYY') AS DT_ENTREGA,
                            (SELECT round(SUM(rsp.ds_resposta)/COUNT(*),2) AS MEDIA 
                            FROM portal_projetos.resposta rsp
                            INNER JOIN portal_projetos.pergunta per
                            ON per.cd_pergunta = rsp.cd_pergunta
                            WHERE per.tp_pergunta = 'NT'
                            AND rsp.cd_solicitacao = sol.cd_os_mv
                            ) || '/5' AS NOTA
                    FROM portal_projetos.portfolio pf
                    INNER JOIN portal_projetos.solicitacao sol
                    ON sol.cd_solicitacao = pf.cd_solicitacao
                    INNER JOIN portal_projetos.responsavel res
                    ON res.cd_responsavel = sol.cd_responsavel
                    INNER JOIN dbamv.funcionario func
                    ON func.cd_func = res.cd_usuario_mv
                    WHERE pf.cd_portfolio = $cd_portfolio";

    $resultado = oci_parse($conn_ora, $consulta);

    oci_execute($resultado);

    $row = oci_fetch_array($resultado);
?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> 
        <div>
        </div>
    </h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="div_br"> </div>      
    <div class="row">
            <div class="col-md-12" style="text-align: center;">
                <h3 style="border-radius: 10px; text-align: center;"> <?php echo $row['NM_PROJETO'] ; ?></h3>
                <?php

                echo '<div>';

                    $cont_nota = 1;
                    $nota = $row['NOTA'];

                    while ($cont_nota <= 5){
                    
                        //echo $cont_nonta . '<br>';

                        if($cont_nota <= $nota){

                            //TODA ESTRELA
                            echo '<a style="color: #007bff"><i class="fa-solid fa-star"></i></a>';
                            
                        }else{

                            if($nota == $cont_nota - 0.5){

                                //MEIA ESTRELA
                                echo '<a style="color: #007bff"><i class="fa-solid fa-star-half-stroke"></i></a>';

                            }else{

                                //ESTRELA BRANCA
                                echo '<a style="color: #000000"><i class="fa-regular fa-star"></i></a>';

                            }
                            
                        }

                        $cont_nota = $cont_nota + 1;

                    }
                        
                echo '</div>';

            ?>

                <div class="div_br"> </div>

                <div style="width: 450px; margin: 0 auto; padding: 5px;
                            border: solid 1px #d7d7d7; border-radius: 5px;
                            background-color: #f7f6f6; text-align: center;">
                    <?php echo $row['DS_PROJETO'] ?>
                </div>

            </div>

    </div>


        <div class="div_br"> </div>
        <div class="div_br"> </div>

            
        <!--LINK DO PROJETO-->

        <div style="display: flex; justify-content: center;">
            <a href="http://<?php echo $row['LINK_PROJETO'] ?>/" target="_blank" type="button" class="btn btn-primary" style="text-align: center; text-decoration: none; width: 25rem; "><i class="fa-solid fa-link efeito-zoom"></i> Acesse o Projeto</a>        
        </div>
        
        <br>

     <!--VIDEO PROJETOS-->

    <div style="text-align: center;" class="col-md-12">
       <video style="width: 450px; height: 250px;" id='img_card' src= upload_videos\<?php echo $row['CD_PORTFOLIO'] . '.mp4'; ?> width="450" height="250" controls ></video>
    </div>

    <div class="div_br"> </div>
    <div class="div_br"> </div>

            <div style="display: flex; justify-content: center;">
               
                 <button class="form form-control efeito-zoom" style=" width: 25rem; !important; text-align: center; background-color: #3185c1; color: #ffffff;" onclick="ajax_constroi_modal_anexos('anexos')" id="abre_galeria"><i class="fa-regular fa-image"></i> Galeria de Fotos</button> 

            </div>

            <div class="div_br"> </div>
            <div class="div_br"> </div>

            <?php if($sup == 'S' || $adm == 'S' || $aux == 'S'){ ?>

                <div style="display: flex; justify-content: center;">
                            
                    <button class="btn btn-adm efeito-zoom" style="width: 10rem; !important; text-align: center; background-color: #3185c1; color: #ffffff;" onclick="ajax_constroi_modal_anexos('pdf')"><i class="fa-regular fa-file"></i> Documentação</button> 

                </div>

            <?php

            } ?>

    <div class="div_br"> </div>
    <div class="div_br"> </div> 

</div>

<script>

    function ajax_passagem_entre_modals(){

        $('#modal_carrosel').modal('hide');

        setTimeout(function(){ $('#modal_portfolio').modal('show');}, 250);
        
    }


    function ajax_constroi_modal_anexos(tp){

        $(document).ready(function() {

        $('#div_carrosel').load('funcoes/portfolio/ajax_galeria_anexos.php?cd_portfolio=<?php echo $cd_portfolio ?>&tp='+tp)

        $('#modal_portfolio').modal('hide');
        setTimeout(function(){ $('#modal_carrosel').modal('show');}, 250);
        
         })
    }


</script>