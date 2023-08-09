<?php 
    include 'cabecalho.php'; 
    include 'conexao.php';
    $date = date('Y-m', time());

?>

<h11><i class="fa-solid fa-chart-column"></i> Dashboard</h11>
<span class="espaco_pequeno" style="width: 6px;" ></span>
<h27> <a href="home.php" style="color: #444444; text-decoration: none;"> <i class="fa fa-reply" aria-hidden="true"></i> Voltar </a> </h27> 
<div class="div_br"> </div> </br>

<div class="div_br"> </div>

<div style=" width: 100%; text-align: center; font-size: 25px;">

    <b>Visão Geral</b>

</div>

<div class="div_br"> </div>

<div style="width: 100%; min-height: 500px; display: flex; flex-wrap: wrap;">

    <div style="width: 50%; height: 250px; display: flex; justify-content: center; align-items: center;">

        <div style="width: 75%;">
            <h6>Finalizadas</h6>
            <canvas id="chart_os_concluidas"></canvas>
        </div>

    </div>
    
    <div style="width: 50%; height: 250px; display: flex; justify-content: center; align-items: center;">
        
        <div style="width: 75%;">
            <h6>Abertas</h6>
            <canvas id="chart_os_abertas"></canvas>
        </div>

    </div>
    <div style="width: 50%; height: 250px; display: flex; justify-content: center; align-items: center; border: solid 1px black;">
               
        <div style="width: 75%;">
            <h6></h6>
            <canvas id="chart_os_concluidas"></canvas>
        </div>

    </div>
    <div style="width: 50%; height: 250px; display: flex; justify-content: center; align-items: center; border: solid 1px black;">
               
        <div style="width: 75%;">
            <h6>Os Finalizadas</h6>
            <canvas id="chart_os_concluidas"></canvas>
        </div>

    </div>

</div>

<script>

    //DEFININDO CONSTANTES PARA PODER TRABALHAR COM O ELEMENTO

        const chart_os = document.getElementById('chart_os_concluidas');
        const chart_os_abertas = document.getElementById('chart_os_abertas');

    /////////////////////////////////////////////////////////////////////

    //CHAMANDO FUNÇÕES PARA SEREM CARREGADAS NA HORA QUE A PAGINA ABRIR

        window.onload = function() {

            atualizar_grafico_os(); 
            atualizar_grafico_os_abertas();

        };

    ///////////////////////////////////////////////////////////////////


    //AJAX PARA MANDAR OS DADOS PARA O CHART 

        function atualizar_grafico_os(){

            $.ajax({
                url: 'funcoes/dashboard/ajax_select_os.php',

                type: 'POST', cache: false,
                success: function(dataResult){

                    const array = JSON.parse(dataResult);

                    create_chart_os(array);

                }

            });

        }

        function atualizar_grafico_os_abertas(){

            $.ajax({
                url: 'funcoes/dashboard/ajax_select_os_abertas.php',

                type: 'POST', cache: false,
                success: function(dataResult){

                    const array = JSON.parse(dataResult);

                    create_chart_os_abertas(array);

                }

            });

        }


    //////////////////////////////////////////////

    //CRIANDO OS GRAFICOS

    function create_chart_os(quantidade){

        const coresMeses = [

            'rgba(255, 99, 132, 0.8)', // Jan
            'rgba(54, 162, 235, 0.8)', // Fev
            'rgba(255, 206, 86, 0.8)', // Mar
            'rgba(75, 192, 192, 0.8)', // Abr
            'rgba(153, 102, 255, 0.8)', // Mai
            'rgba(255, 159, 64, 0.8)', // Jun
            'rgba(255, 99, 132, 0.8)', // Jul
            'rgba(54, 162, 235, 0.8)', // Ago
            'rgba(255, 206, 86, 0.8)', // Set
            'rgba(75, 192, 192, 0.8)', // Out
            'rgba(153, 102, 255, 0.8)', // Nov
            'rgba(255, 159, 64, 0.8)', // Dez

        ];

        new Chart(chart_os, {
            type: 'bar',
            data: {

                labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                datasets: [
                    {
                        //label: 'Finalizadas',
                        data: quantidade,
                        backgroundColor: coresMeses,
                        borderWidth: 1
                    }
                ]
            },

            options: {

                scales: {

                    y: {
                        ticks: {
                            stepSize: 1, // Display integer values on Y-axis
                            precision: 0 // Display integer values without decimals
                        }
                    }

                },

                indexAxis: 'x',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                       display: false // Oculta a legenda
                    }
                }
            }
        });
    }

    function create_chart_os_abertas(quantidade){

        console.log(quantidade);
        const coresMeses = [

            'rgba(255, 99, 132, 0.8)', // Jan
            'rgba(54, 162, 235, 0.8)', // Fev
            'rgba(255, 206, 86, 0.8)', // Mar
            'rgba(75, 192, 192, 0.8)', // Abr
            'rgba(153, 102, 255, 0.8)', // Mai
            'rgba(255, 159, 64, 0.8)', // Jun
            'rgba(255, 99, 132, 0.8)', // Jul
            'rgba(54, 162, 235, 0.8)', // Ago
            'rgba(255, 206, 86, 0.8)', // Set
            'rgba(75, 192, 192, 0.8)', // Out
            'rgba(153, 102, 255, 0.8)', // Nov
            'rgba(255, 159, 64, 0.8)', // Dez

        ];

        new Chart(chart_os_abertas, {
            type: 'bar',
            data: {

                labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                datasets: [
                    {
                        //label: 'Finalizadas',
                        data: quantidade,
                        backgroundColor: coresMeses,
                        borderWidth: 1
                    }
                ]
            },

            options: {

                scales: {

                    y: {
                        ticks: {
                            stepSize: 1, // Display integer values on Y-axis
                            precision: 0 // Display integer values without decimals
                        }
                    }

                },

                indexAxis: 'x',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    display: false // Oculta a legenda
                    }
                }
            }
        });

    }


    //////////////////////////////////////////////////////////

</script>


<?php include 'rodape.php'; ?>
