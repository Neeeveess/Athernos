
<?php
    require_once '../../config.php';
    require_once ABSPATH . 'classes/Crud.php';
    
    session_start();
    
    $titulo = "Saida de Produtos - Athernos";
    if(!isset($_SESSION['email']) or $_SESSION['nivel']<2){
        header('Location:'.BASEURL.'index.php');
    }

?>
<?php include_once ABSPATH.'layout/header.php';?>
<body class= "main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';?>
    <main class="corpo-produto">
    <table style="width:100%;">
        <thead>
            <tr>

                <th class="codigo" scope="col">Tipo de transação</th>
                <th class="nome" scope="col">ID do lote</th>
                <th class="nome" scope="col">Quantidade</th>
                <th class="total" scope="col">Data</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $obj = new Crud; 
                $select = $obj->select("*","log_lotes",1,"data_manipulacao DESC");
                if ($select->num_rows > 0){
            
                    while($rows = $select->fetch_object()){
                        $data_manipulacao = strtotime($rows->data_manipulacao); 
                        ?>
                        <tr>

                            <td><?php echo $rows->tipo;?></td>
                            <td><?php echo $rows->id_lotes;?></td>
                            <td><?php echo $rows->quantidade;?></td>
                            <td><?php echo date('d/m/Y - H:i:s', $data_manipulacao);?></td>
            <?php
                    }
                }
            ?>
        </tbody>
    
</body>
      