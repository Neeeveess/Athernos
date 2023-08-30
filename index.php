<?php 
    require_once 'config.php';
    require_once ABSPATH."classes/Crud.php";
    $crud = new Crud();
    //SELECT DO GRAFICO
    $select = $crud->select('c.id, c.nome AS categoria,
             COUNT(p.id) AS quantidade_de_produtos',
            'categoria c
            LEFT JOIN produtos p ON c.id = p.id_categoria
            GROUP BY c.id, c.nome');

    $selectProdutos = $crud->select('count(id) as qtd','produtos');
    $select3Entradas = $crud->select('p.id AS id_produto,
        p.codigo AS codigo_produto,
        p.nome AS nome_produto,
        c.nome AS nome_categoria,
        l.quantidade AS quantidade_lote,
        l.custo_unit AS custo_lote,
        l.validade AS validade_lote',
        'produtos p
        JOIN categoria c ON p.id_categoria = c.id
        JOIN lotes l ON p.id = l.id_produto',null,
        'l.data_entrada DESC
        LIMIT 3;');

    $categorias = [];
    $quantidades = [];
    
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
        <section class="box-grid">
            <div class="total-produtos">
                <h2>Qtd de produtos cadastrados</h2>
                <?php 
                
                if ($selectProdutos->num_rows > 0) {
                    while ($linhas = $selectProdutos->fetch_object()) {
                        echo $linhas->qtd;
                    }
                }
                
                ?>
            </div>
            <div class="ultimas-entradas-saidas">
                <?php 
                
                if ($select3Entradas->num_rows > 0) {
                    while ($linhas = $select3Entradas->fetch_object()) {
                        
                        echo $linhas->id_produto.' - ';
                        echo $linhas->codigo_produto.' - ';
                        echo $linhas->nome_produto.' - ';
                        echo $linhas->nome_categoria.' - ';
                        echo $linhas->quantidade_lote.' - ';
                        echo $linhas->custo_lote.' - ';
                        echo $linhas->validade_lote."<br>";
                    }
                }
                
                ?>
            </div>
            <div class="chart-container" style="position: relative; height:500px; width:500px">
            <h2>Categorias ativas</h2>
                <?php if ($select->num_rows > 0) { ?>
                    <canvas id="categorias-pizza"></canvas>
                <?php } ?>
            </div>  

        </section>
    </main>
</body>
<?php 



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
        const ctx = document.getElementById('categorias-pizza');
        
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
                pieSliceText: 'label',      
                plugins: {
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