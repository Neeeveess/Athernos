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
        <h1>Bem vindo <br/>ao<span> Athernos</span></h1>
        <p>Esse é nosso projeto de estoque</p>
    </main>
</body>
</html>