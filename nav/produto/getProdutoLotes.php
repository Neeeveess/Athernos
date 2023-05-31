
<?php
    require_once '../../config.php';
    require_once ABSPATH.'classes/Crud.php';

    $id_produto = $_POST['id'];

    $obj = new Crud;
    $view = $obj->select("codigo,quantidade","lotes","id_produto=$id_produto");
    if ($view -> num_rows > 0){
        echo json_encode($view->fetch_all(MYSQLI_ASSOC));          
    }


    
?>