<?php 
    include 'cabecalho.php'; 
    include 'conexao.php';
    $date = date('Y-m', time());

?>

<h11><i class="fa-solid fa-chart-column"></i> Dashboard</h11>
<span class="espaco_pequeno" style="width: 6px;" ></span>
<h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
<div class="div_br"> </div> </br>


<div class="row">
    <div class="col-md-3">
        Visão:
        <select class="form-control" id="slt_visao" onchange="fnc_btn_filtro(this.value)">
            <option value="sol_anul">Solicitações anual</option>
            <option value="sol/resp">Solicitações/Responsavel</option>
        </select>
    </div>
    <div class="col-md-3" style="display: none" id="div_mes">
        Mês:
        <input class="form-control" id="inpt_mes" value="<?php echo $date ?>" type="month" onchange="ajax_dashboard()">
    </div>
    <div class="col-md-2" id="div_ano">
        Ano:
        <select id="slt_ano" class="form-control">
            <?php 
                $consulta_ano = "SELECT DISTINCT EXTRACT(YEAR FROM sol.hr_cadastro) AS ANO
                FROM portal_projetos.solicitacao sol";
                $resultado_ano = oci_parse($conn_ora, $consulta_ano);
                oci_execute($resultado_ano);
                while($row_ano = oci_fetch_array($resultado_ano)){
                    echo '<option value="'.$row_ano['ANO'].'" >'.$row_ano['ANO'].'</option>';
                }
            
            ?>
        </select>
    </div>
    <div class="col-md-3" style="display: none" id="div_responsavel">
        Responsavel:
        <select id="slt_responsavel" class="form-control" onchange="ajax_dashboard()">
            <?php 
                $consulta_ano = "SELECT res.cd_usuario_mv AS CD,
                (SELECT fnc.nm_func
                   FROM dbamv.funcionario fnc
                  WHERE fnc.cd_func = res.cd_usuario_mv) AS NM
           FROM portal_projetos.responsavel res";
                $resultado_ano = oci_parse($conn_ora, $consulta_ano);
                oci_execute($resultado_ano);
                while($row_ano = oci_fetch_array($resultado_ano)){
                    echo '<option value="'.$row_ano['CD'].'" >'.$row_ano['NM'].'</option>';
                }
            
            ?>
        </select>
    </div>

</div>
</br>
</br>
<div id="div_dashboard"></div>



<?php include 'rodape.php'; ?>

<script>
    $(document).ready(function() {
        ajax_dashboard()
    })

    function ajax_dashboard(){
        visao = document.getElementById('slt_visao').value
        if(visao == 'sol_anul'){
            ano = document.getElementById('slt_ano').value
            $('#div_dashboard').load('funcoes/dashboard/ajax_visao_soli_mensal.php?ano='+ano)
        }else if(visao == 'sol/resp'){
            mes = document.getElementById('inpt_mes').value
            $('#div_dashboard').load('funcoes/dashboard/ajax_visao_soli_resp.php?mes='+mes)

        }else{
            responsavel = document.getElementById('slt_responsavel').value
            $('#div_dashboard').load('funcoes/dashboard/ajax_relatorio_responsavel.php?responsavel='+responsavel)

        }
    }

    function fnc_btn_filtro(visao){
        if(visao == 'sol_anul'){
            document.getElementById('div_ano').style.display= 'block'
            document.getElementById('div_mes').style.display= 'none'
            document.getElementById('div_responsavel').style.display= 'none'
            ajax_dashboard()
        }else if(visao == 'sol/resp'){
            document.getElementById('div_ano').style.display= 'none'
            document.getElementById('div_mes').style.display= 'block'
            document.getElementById('div_responsavel').style.display= 'none'
            ajax_dashboard()

        }else{
            document.getElementById('div_ano').style.display= 'none'
            document.getElementById('div_mes').style.display= 'none'
            document.getElementById('div_responsavel').style.display= 'block'
            ajax_dashboard()
        }
    }



</script>