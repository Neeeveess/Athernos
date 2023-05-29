<?php
    require_once '../../config.php';
    require_once ABSPATH . 'classes/Crud.php';
    
    session_start();
    $titulo = "Saida de Produtos - Athernos";
    if(!isset($_SESSION['email']) or $_SESSION['nivel']<1){
        header('Location:'.BASEURL.'index.php');
    }
?>

<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';?>

    
</body>