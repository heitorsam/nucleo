<?php 
    include '../../conexao.php';

    session_start();

    $os = $_GET['cd_os'];

    $qtd = $_GET['qtd'];

    $consulta_pergunta = 'SELECT * FROM portal_projetos.pergunta';

    $resultado_perguntas = oci_parse($conn_ora,$consulta_pergunta);

    oci_execute($resultado_perguntas);

    $consulta_respostas = "SELECT * FROM portal_projetos.resposta res WHERE res.cd_solicitacao = $os ORDER BY CD_PERGUNTA";

    $resultado_respostas = oci_parse($conn_ora,$consulta_respostas);

    if($qtd > 0){
        $disabled = 'disabled';
    }

?>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> 
        Avaliação
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <form action="funcoes/avaliacao/salvar_avaliacao.php" method="POST">
        <div class="row">
            <?php while($row_perguntas = oci_fetch_array($resultado_perguntas)){ 

                $cd = $row_perguntas['CD_PERGUNTA'];

                $consulta_respostas = "SELECT DS_RESPOSTA FROM portal_projetos.resposta res 
                                        WHERE res.cd_solicitacao = $os 
                                        AND res.CD_PERGUNTA = $cd
                                        ORDER BY CD_PERGUNTA";

                $resultado_respostas = oci_parse($conn_ora,$consulta_respostas);

                oci_execute($resultado_respostas);

                $row_resposta = oci_fetch_array($resultado_respostas);


                echo '<div class="col-md-3">';
                echo $row_perguntas['DS_PERGUNTA'];
                if($row_perguntas['TP_PERGUNTA'] == 'NT'){
                    if($qtd == 0){
                        echo '</br>';
                        echo '<input type="hidden" id="'. $cd .'" name="'. $cd .'" >';
                        echo '<a id="div_1_'. $cd .'"><i class="fa-regular fa-star" id="estrela_1_'. $cd .'" onclick="fnc_estrelas('. $cd .',1)"></i></a>';
                        echo '<a id="div_2_'. $cd .'"><i class="fa-regular fa-star" id="estrela_2_'. $cd .'" onclick="fnc_estrelas('. $cd .',2)"></i></a>';
                        echo '<a id="div_3_'. $cd .'"><i class="fa-regular fa-star" id="estrela_3_'. $cd .'" onclick="fnc_estrelas('. $cd .',3)"></i></a>';
                        echo '<a id="div_4_'. $cd .'"><i class="fa-regular fa-star" id="estrela_4_'. $cd .'" onclick="fnc_estrelas('. $cd .',4)"></i></a>';
                        echo '<a id="div_5_'. $cd .'"><i class="fa-regular fa-star" id="estrela_5_'. $cd .'" onclick="fnc_estrelas('. $cd .',5)"></i></a>';
                    }else{
                        echo '</br>';
                        if($row_resposta['DS_RESPOSTA'] >= 1){
                            echo '<a style="color: #007bff"><i class="fa-solid fa-star"></i></a>';
                        }else{
                            echo '<a style="color: #000000"><i class="fa-regular fa-star"></i></a>';
                        }
                        if($row_resposta['DS_RESPOSTA'] >= 2){
                            echo '<a style="color: #007bff"><i class="fa-solid fa-star"></i></a>';
                        }else{
                            echo '<a style="color: #000000"><i class="fa-regular fa-star"></i></a>';

                        }
                        if($row_resposta['DS_RESPOSTA'] >= 3){
                            echo '<a style="color: #007bff"><i class="fa-solid fa-star"></i></a>';
                        }else{
                            echo '<a style="color: #000000"><i class="fa-regular fa-star"></i></a>';

                        }
                        if($row_resposta['DS_RESPOSTA'] >= 4){
                            echo '<a style="color: #007bff"><i class="fa-solid fa-star"></i></a>';
                        }else{
                            echo '<a style="color: #000000"><i class="fa-regular fa-star"></i></a>';

                        }
                        if($row_resposta['DS_RESPOSTA'] >= 5){
                            echo '<a style="color: #007bff"><i class="fa-solid fa-star"></i></a>';
                        }else{
                            echo '<a style="color: #000000"><i class="fa-regular fa-star"></i></a>';

                        }
                    }
                }else{
                    echo '<input type="text" class="form-control" value="'. @$row_resposta['DS_RESPOSTA'] .'" required name="'. $row_perguntas['CD_PERGUNTA'] .'" '. @$disabled .'>';
                }
                echo '</div>';
            } ?>
        </div>
            <input type="text" name="os" value="<?php echo $os ?>" hidden>
        </br>

        <div class="modal-footer">
            <?php if($qtd == 0){ ?>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            <?php } ?>
        </div>  
    </form>
</div>

<script>
    function fnc_estrelas(cd,num){
        for (var j = 1; j <= 5;  j++){
            document.getElementById('div_'+j+'_'+cd).style.color = '#000000'
            document.getElementById('estrela_'+j+'_'+cd).classList.remove('fa-solid')
            document.getElementById('estrela_'+j+'_'+cd).classList.add('fa-regular')
        }
        for (var i = 1; i <= num; i++){
            document.getElementById('div_'+i+'_'+cd).style.color = '#007bff'
            document.getElementById('estrela_'+i+'_'+cd).classList.remove('fa-regular')
            document.getElementById('estrela_'+i+'_'+cd).classList.add('fa-solid')
    
        }
        document.getElementById(cd).value = num
        
    }
    


</script>