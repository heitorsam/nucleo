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

    <div style="width: 50%; height: 250px; display: flex; justify-content: center; align-items: center;">
               
        <div style="width: 75%;">
            <h6>Finalizadas Por Usuarios</h6>
            <canvas id="chart_os_finalizadas_por_usuario"></canvas>
        </div>

    </div>
    <div style="width: 50%; height: 250px; display: flex; justify-content: center; align-items: center;">
               
        <div style="width: 75%;">
            <h6>Abertas por Setor</h6>
            <canvas id="abertas_por_setor"></canvas>
        </div>

    </div>

</div>

<script>

    //DEFININDO CONSTANTES PARA PODER TRABALHAR COM O ELEMENTO

    const chart_os = document.getElementById('chart_os_concluidas');
    const chart_os_abertas = document.getElementById('chart_os_abertas');
    const finalizadas_usuario = document.getElementById('chart_os_finalizadas_por_usuario');
    const abertas_por_setor = document.getElementById('abertas_por_setor');

    /////////////////////////////////////////////////////////////////////

    //CHAMANDO FUNÇÕES PARA SEREM CARREGADAS NA HORA QUE A PAGINA ABRIR

        window.onload = function() {

            atualizar_grafico_os(); 
            atualizar_grafico_os_abertas();
            atualizar_grafico_os_fina_usuarios();
            atualizar_graficos_os_abertas_setores();

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

        function atualizar_graficos_os_abertas_setores() {
            $.ajax({
                url: 'funcoes/dashboard/ajax_select_os_abertas_setor.php', 
                type: 'POST',
                cache: false,
                success: function(dataResult) {

                    console.log(dataResult);
                    
                    const array = JSON.parse(dataResult);

                    const setores = [];
                    const quantidadesPorSetor = new Map();

                    // Inicializar um array de quantidades com zeros para todos os meses
                    const quantidadesZeradas = Array(12).fill(0);

                    // Processar e usar os dados recebidos diretamente
                    for (let i = 0; i < array.length; i++) {
                        const setor = array[i].NM_SETOR; 
                        const qtd = array[i].QTD;
                        const mes = array[i].MES - 1; // Ajustar o índice do mês (0-11)

                        if (!setores.includes(setor)) {
                            setores.push(setor);
                            quantidadesPorSetor.set(setor, quantidadesZeradas.slice());
                        }

                        const setorQuantidades = quantidadesPorSetor.get(setor);
                        setorQuantidades[mes] = qtd;

                        
                    }

                    create_chart_os_abertas_por_setor(setores, quantidadesPorSetor);

                   
                }
            });
        }


        function atualizar_grafico_os_fina_usuarios() {

            $.ajax({
                url: 'funcoes/dashboard/ajax_select_os_finalizadas_por_usuario.php',
                type: 'POST',
                cache: false,
                success: function(dataResult) {
                    const array = JSON.parse(dataResult);

                    const usuarios = [];
                    const quantidadesPorUsuario = new Map();

                    // Inicializar um array de quantidades com zeros para todos os meses
                    const quantidadesZeradas = Array(12).fill(0);

                    // Processar e usar os dados recebidos diretamente
                    for (let i = 0; i < array.length; i++) {
                        const usuario = array[i].NM_USUARIO;
                        const qtd = array[i].QTD;
                        const mes = array[i].MES - 1; // Ajustar o índice do mês (0-11)

                        if (!usuarios.includes(usuario)) {
                            usuarios.push(usuario);
                            quantidadesPorUsuario.set(usuario, quantidadesZeradas.slice());
                        }

                        const usuarioQuantidades = quantidadesPorUsuario.get(usuario);
                        usuarioQuantidades[mes] = qtd;
                    }

                    create_chart_os_finalizadas_por_usu(usuarios, quantidadesPorUsuario);
                }
            });
        }


    //////////////////////////////////////////////

    //CRIANDO OS GRAFICOS

    function create_chart_os(quantidade){

        const coresMeses = [

            'rgba(75, 192, 192, 0.8)', // Jan
            'rgba(153, 102, 255, 0.8)',// Fev
            'rgba(255, 159, 64, 0.8)', // Mar
            'rgba(255, 99, 132, 0.8)', // Abr
            'rgba(54, 162, 235, 0.8)',  // Mai
            'rgba(255, 206, 86, 0.8)', // Jun
            'rgba(75, 192, 192, 0.8)', // Jul
            'rgba(153, 102, 255, 0.8)',// Ago
            'rgba(255, 159, 64, 0.8)', // Set
            'rgba(255, 99, 132, 0.8)', // Out
            'rgba(54, 162, 235, 0.8)',  // Nov
            'rgba(255, 206, 86, 0.8)', // Dez
            

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
        const coresMeses2 = [

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
                        backgroundColor: coresMeses2,
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

    function create_chart_os_finalizadas_por_usu(usuarios, quantidadesPorUsuario) {

        const coresUsuario = [

            'rgba(255, 99, 132, 0.8)', // Jan
            'rgba(54, 162, 235, 0.8)', // Fev
            'rgba(75, 192, 192, 0.8)', // Mar
            'rgba(255, 206, 86, 0.8)', // Abr
            'rgba(255, 159, 64, 0.8)',  // Mai
            'rgba(153, 102, 255, 0.8)',// Jun
            'rgba(54, 162, 235, 0.8)', // Jul
            'rgba(255, 99, 132, 0.8)', // Ago
            'rgba(75, 192, 192, 0.8)', // Set
            'rgba(255, 206, 86, 0.8)', // Out
            'rgba(255, 159, 64, 0.8)',  // Nov
            'rgba(153, 102, 255, 0.8)',// Dez
            
        ];

        new Chart(finalizadas_usuario, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: usuarios.map((usuario, index) => ({
                    label: usuario,
                    data: quantidadesPorUsuario.get(usuario),
                    backgroundColor: coresUsuario[index % coresUsuario.length], // Usar cores cíclicas
                    borderWidth: 1
                }))
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        precision: 0
                    }
                },
                indexAxis: 'x',
                elements: {
                    bar: {
                        borderWidth: 2
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

    }

    function create_chart_os_abertas_por_setor(setores, quantidadesPorSetor) {
        
    console.log(setores);
    console.log(quantidadesPorSetor);

    const coresSetor = [
        'rgba(255, 99, 132, 0.8)', // Jan
        'rgba(54, 162, 235, 0.8)', // Fev
        'rgba(75, 192, 192, 0.8)', // Mar
        'rgba(255, 206, 86, 0.8)', // Abr
        'rgba(255, 159, 64, 0.8)',  // Mai
        'rgba(153, 102, 255, 0.8)',// Jun
        'rgba(54, 162, 235, 0.8)', // Jul
        'rgba(255, 99, 132, 0.8)', // Ago
        'rgba(75, 192, 192, 0.8)', // Set
        'rgba(255, 206, 86, 0.8)', // Out
        'rgba(255, 159, 64, 0.8)',  // Nov
        'rgba(153, 102, 255, 0.8)' // Dez
    ];

    new Chart(abertas_por_setor, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: setores.map((setor, index) => ({
                label: setor,
                data: quantidadesPorSetor.get(setor),
                backgroundColor: coresSetor[index % coresSetor.length],
                borderWidth: 1
            }))
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1,
                    precision: 0
                }
            },
            indexAxis: 'x',
            elements: {
                bar: {
                    borderWidth: 2
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const datasetLabel = context.dataset.label;
                            const value = context.parsed.y;
                            return datasetLabel + ': ' + value;
                        }
                    }
                }
            }
        }
    });
}




    

    //////////////////////////////////////////////////////////

</script>


<?php include 'rodape.php'; ?>
