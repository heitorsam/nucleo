<?php 

include '../../conexao.php';


$var_op = $_GET['opcao'];
$var_ordem = $_GET['ordem'];
@$var_pesquisa = $_GET['pesquisa'];


$cons_exibe_projetos = "SELECT tot.* 
                        FROM(SELECT ROWNUM AS LINHA,
                                    res.* 
                             FROM (SELECT prt.cd_portfolio,
                                          prt.NM_PROJETO,
                                          slt.documento    AS DOCUMENTO,
                                          slt.extensao     AS EXTENSAO,
                                          slt.link_doc     AS LINK_DOC,
                                          TO_CHAR(prt.HR_CADASTRO,'DD/MM/YYYY HH24:MI:SS')  AS HR_CAD,  
                                  (SELECT sol.TP_TIPO 
                                   FROM portal_projetos.SOLICITACAO sol
                                   WHERE sol.CD_SOLICITACAO = prt.CD_SOLICITACAO) AS TP_TIPO,
                                   (SELECT COUNT(ac.HR_ACESSO) AS ACESSO
                                    FROM portal_projetos.ACESSO ac
                                    WHERE ac.CD_PORTFOLIO = prt.CD_PORTFOLIO) AS ACESSO
                        FROM portal_projetos.portfolio prt
                        INNER JOIN (SELECT *
                                    FROM portal_projetos.galeria gl
                                    WHERE gl.sn_principal = 'S') slt
                            ON slt.cd_portfolio = prt.cd_portfolio) res)tot";

if(isset($var_pesquisa)){

$cons_exibe_projetos .= " WHERE UPPER(tot.NM_PROJETO) LIKE UPPER('%$var_pesquisa%')";


} else{

        //VALIDAR DEPOIS ISSO, POIS ESTA TRAZENDO TUDO. CASO CONTRARIO TRAZER SOMENTE O ELSE DESTA LISTA.

        if($var_op == 'OT'){

                $cons_exibe_projetos .= " WHERE tot.TP_TIPO IN ('PR','PA','RP','DC')";

        }else{

                $cons_exibe_projetos .= " WHERE tot.TP_TIPO = '$var_op'";

        }


}



if($var_ordem == 'ASC'){

        $cons_exibe_projetos .= " ORDER BY tot.NM_PROJETO ASC";   

}

if($var_ordem == 'DESC'){

        $cons_exibe_projetos .= " ORDER BY tot.NM_PROJETO DESC";   

}


$res_exibe_projetos = oci_parse($conn_ora, $cons_exibe_projetos);

oci_execute($res_exibe_projetos);


?>



<div style="background-color: #ffffff; margin: 0 auto; width: 90%; border-radius: 20px; ">

        <div class="div_br"> </div> 

        <div class="row">
                <?php while($row_galeria = oci_fetch_array($res_exibe_projetos)){ 
                        
                        if(isset($row_galeria['DOCUMENTO'])){

                        $imagem = $row_galeria['DOCUMENTO'] ->load(); // (1000) = 1kB
                        $imagem = base64_encode($imagem);
                
                        }
                        
                ?>
                        <div class='col-md-2' style="padding: 4px;">

                                <div style=" cursor: pointer; border-radius: 5px; background-color: #f2f3f5; height: 140px; padding-top: 20px;" onclick="ajax_exibe_detalhes('<?php echo $row_galeria['CD_PORTFOLIO'] ?>')">


                                        <div class="efeito-zoom"  style="height: 100px; width: 80%; margin: 0 auto;
                                        background-image: url('data:image;base64,<?php echo $imagem; ?>');
                                        background-size: contain;
                                        background-repeat: no-repeat;
                                        background-position: center center;">

                                        </div>

                                
                                </div>

                        <div style="height: 6px"></div>
                        <h1 style=" font-size: 12.5px; color: #424242; margin-bottom: 4px !important;"><?php echo $row_galeria['NM_PROJETO'];?></h1>
                        <h1 style="font-size: 10px; color: #a2a2a2;"><i class="fa-regular fa-eye">  </i><?php echo $row_galeria['ACESSO'];?> Visualizações</h1>
                        
                        </div>  

                <?php } ?>

        </div>
        
        <div class="div_br"> </div>      
        <div class="div_br"> </div> 

</div>

