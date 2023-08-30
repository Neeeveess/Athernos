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

    //SELECT TOTAL DE PRODUTOS
    $selectProdutos = $crud->select('count(id) as qtd','produtos');

    //SELECT 3 ULTIMAS ENTRADAS
    $select3Entradas = $crud->select('
        p.id AS ID_Produto,
        p.nome AS Nome,
        l.codigo AS ID_do_Lote,
        l.quantidade AS Quantidade,
        l.data_entrada AS Data_de_Entrada',
        'produtos p
        JOIN lotes l ON p.id = l.id_produto',
        null,
        'l.data_entrada DESC
        LIMIT 3;');

    //SELECT 3 ULTIMAS SAIDAS
    $select3Saidas = $crud->select('
        ll.id_produto AS ID_Produto,
        p.nome AS Nome,
        ll.id_lotes AS ID_do_Lote,
        ll.quantidade AS Quantidade,
        ll.data_manipulacao AS Data_da_Saida',
        'log_lotes ll
        JOIN produtos p ON ll.id_produto = p.id',
        "ll.tipo = 'Saida'",
        'll.id DESC
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
            <h2>Entradas</h2>
                <?php  if ($select3Entradas->num_rows > 0) {
                    while ($linhas = $select3Entradas->fetch_object()) {
                        
                        echo $linhas->ID_Produto.' - ';
                        echo $linhas->Nome.' - ';
                        echo $linhas->ID_do_Lote.' - ';
                        echo $linhas->Quantidade.' - ';
                        echo $linhas->Data_de_Entrada."<br>";
                    }
                } ?>
                <h2>Saidas</h2>
                <?php if ($select3Saidas->num_rows > 0) {
                    while ($linhas = $select3Saidas->fetch_object()) {
                        
                        echo $linhas->ID_Produto.' - ';
                        echo $linhas->Nome.' - ';
                        echo $linhas->ID_do_Lote.' - ';
                        echo $linhas->Quantidade.' - ';                                           
                        echo $linhas->Data_da_Saida."<br>";
                    }
                } ?>
            </div>
            <div class="chart-container" >
            <h2>Quantidade de Produtos por Categoria</h2>
                <?php if ($select->num_rows > 0) { ?>
                    <!-- <canvas id="categorias-pizza"></canvas> -->
                <?php } ?>
                <div id="piechart" style="width: 900px; height: 500px;"></div>
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
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    </script> -->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      const categorias = <?php echo json_encode($categorias); ?>;
      const quantidades = <?php echo json_encode(array_map('intval', $quantidades)); ?>;
      const totalQuantidades = <?= array_sum($quantidades) ?>;

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Categoria');
      data.addColumn('number', 'Quantidade de Produtos');
      
      for (var i = 0; i < categorias.length; i++) {
        var porcentagem = (quantidades[i] / totalQuantidades) * 100;
        var label = categorias[i] + '\n' + quantidades[i] + ' (' + porcentagem.toFixed(2) + '%)';
        data.addRow([label, quantidades[i]]);
      }

      var options = {
        legend: {
          position: 'right', // Posição da legenda
          textStyle: {
            color: '#3d4759',
            fontSize: 14
          },
          // Inclui os valores e porcentagens nas legendas
          format: '0.##' // Formato para exibir os números
        },
        
        pieStartAngle: 100,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
  </script>
    
</html>