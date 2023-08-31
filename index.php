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
        ll.id_lotes AS ID_do_Lote,
        ll.quantidade AS Quantidade,
        ll.data_manipulacao AS Data_de_Entrada',
        'produtos p
        JOIN log_lotes ll ON p.id = ll.id_produto',
        "ll.tipo = 'Entrada'",
        'll.data_manipulacao DESC
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
        <section class="box-grid" >
            <?php if ($selectProdutos->num_rows > 0) { ?>
                <?php while ($linhas = $selectProdutos->fetch_object()) { ?>
                                <?php if(!$linhas->qtd == 0){ ?>
                           
                <div class="total-produtos" <?php if($_SESSION['nivel'] < 1){ ?> 
                    style="grid-column: 1; grid-row: 1/span 2;" <?php } ?> >
                        <h2>Quantidade de Produtos Castrados</h2>
                        <div class="value">                
                                <span><?= $linhas->qtd?></span>
                        </div>
                    </div>
                    <?php } ?>
            <?php } }?>
            <?php if ($select->num_rows > 0) { ?>
                <div class="chart-container" <?php if($_SESSION['nivel'] < 1){ ?> 
                    style="grid-column: 2; grid-row: 1/span 2;" <?php } ?> >
                    <h2>Quantidade de Produtos por Categoria</h2>
                    <div id="piechart"></div>
                    
                </div>  
            <?php } ?>
            <?php if(($_SESSION['nivel'] >= 1)){ ?> 
                <div class="ultimas-entradas-saidas">
                <?php if ($select3Entradas->num_rows > 0){ ?>
                    <h2>Entradas</h2>
                        <table class="table-entrada-saida">
                            <thead>
                                <tr>
                                    
                                    <th class="codigo" scope="col">ID Produto</th>
                                    <th class="codigo" scope="col">Nome</th>
                                    <th class="nome" scope="col">ID do lote</th>
                                    <th class="nome" scope="col">Quantidade</th>
                                    <th class="total" scope="col">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                                        <?php while($rows = $select3Entradas->fetch_object()){
                                            $data_manipulacao = strtotime($rows->Data_de_Entrada); 
                                            ?>
                                            <tr>

                                                <td><?php echo $rows->ID_Produto;?></td>
                                                <td><?php echo $rows->Nome;?></td>
                                                <td><?php echo $rows->ID_do_Lote;?></td>
                                                <td><?php echo $rows->Quantidade;?></td>                                                
                                                <td><?php echo date('d/m/Y - H:i:s', $data_manipulacao);?></td>
                                <?php
                                        } ?>
                                   
                            </tbody>
                        </table> 
                        <?php } ?>
                        <?php if ($select3Saidas->num_rows > 0){ ?>
                    <h2 style="border-radius: 0;">Saidas</h2>                       
                        <table style="border-radius: 0 0 20px 20px;" class="table-entrada-saida">
                            <thead>
                                <tr>
                                    
                                    <th class="codigo" scope="col">ID Produto</th>
                                    <th class="codigo" scope="col">Nome</th>
                                    <th class="nome" scope="col">ID do lote</th>
                                    <th class="nome" scope="col">Quantidade</th>
                                    <th class="total" scope="col">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                                    <?php while($rows = $select3Saidas->fetch_object()){
                                            $data_manipulacao = strtotime($rows->Data_da_Saida); 
                                            ?>
                                            <tr>

                                                <td><?php echo $rows->ID_Produto;?></td>
                                                <td><?php echo $rows->Nome;?></td>
                                                <td><?php echo $rows->ID_do_Lote;?></td>
                                                <td><?php echo $rows->Quantidade;?></td>                                                
                                                <td><?php echo date('d/m/Y - H:i:s', $data_manipulacao);?></td>
                                <?php } ?>
                                
                                
                            </tbody>
                        </table>
                        <?php  } ?>
                </div>
            <?php } ?>
            

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
        var label = categorias[i] + '\n' + quantidades[i] ;
        data.addRow([label, quantidades[i]]);
      }

      var options = {
        legend: {
          position: 'right', // Posição da legenda
          textStyle: {
            color: '#3d4759',
            fontSize: 12
          },
          // Inclui os valores e porcentagens nas legendas
          format: '0.##' // Formato para exibir os números
        },
        pieSliceText: 'label', // Exibir rótulos nas fatias
        pieStartAngle: 100,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
  </script>
    
</html>