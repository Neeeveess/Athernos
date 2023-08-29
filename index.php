<?php 
    require_once 'config.php';

    $titulo = "Pagina Inicial - Athernos";
    session_start();
    if(!isset($_SESSION['email'])){
            header('Location:'.BASEURL.'login.php');
    }
    if(isset($_SESSION['cad']) and $_SESSION['cad'] == true){
        ?>
        <script>alert('Usuario Cadastrado com Sucesso!')</script>
        <?php
        unset( $_SESSION['cad'] );        
    }

    if(isset($_GET['id'])== 1){
        session_destroy();
        unset( $_SESSION );
        header('Location: login.php');
    }
?>

<?php include_once ABSPATH.'layout/header.php';?>


<body class="main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';?>
    <main class="corpo">
        <!-- <h1>Bem vindo <br/>ao<span> Athernos</span></h1>
        <p>Esse é nosso projeto de estoque</p> -->
        <div class="chart-container" style="position: relative; height:500px; width:500px">
        <canvas id="myChart"></canvas>
        </div>  
    </main>
</body>
<?php 

require_once ABSPATH."classes/Crud.php";
$crud = new Crud();
$select = $crud->select('c.id, c.nome AS categoria,
         COUNT(p.id) AS quantidade_de_produtos',
        'categoria c
        LEFT JOIN produtos p ON c.id = p.id_categoria
        GROUP BY c.id, c.nome');
$categorias = [];
$quantidades = [];

if ($select->num_rows > 0) {
while ($linhas = $select->fetch_object()) {
    $categorias[] = $linhas->categoria;
    $quantidades[] = $linhas->quantidade_de_produtos;
}
}

// Ordenar os arrays de categorias e quantidades em ordem decrescente
array_multisort($quantidades, SORT_DESC, $categorias);

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        const ctx = document.getElementById('myChart');
        
        // Dados vindos do PHP
        const categorias = <?php echo json_encode($categorias); ?>;
        const quantidades = <?php echo json_encode($quantidades); ?>;
        
        // Cores para as fatias
        const backgroundColors = [
            'rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)',
            'rgb(128, 0, 128)', 'rgb(255, 165, 0)', 'rgb(0, 128, 0)',
            'rgb(128, 128, 128)', 'rgb(186, 85, 211)', 'rgb(0, 255, 255)',
            'rgb(255, 0, 0)'
        ];
        

        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: quantidades,
                    backgroundColor: backgroundColors,
                }],
                labels: categorias.map((label, i) => `${label} - ${quantidades[i]}`), // Adiciona os valores numéricos
            },
            options: {
                
                plugins: {
                    title: {
                        display: true,
                        text: 'Categorias ativas',
                        color: '#3d4759',
                        font: {
                            weight: 'bold',
                            size: 20
                        }
                    },
                    legend: {
                        display: true,
                        labels: {
                            color: '#3d4759',
                            font: {
                                size: 14
                            }
                        }
                    }  
                                      
                }
            }
        });
    </script>
</html>