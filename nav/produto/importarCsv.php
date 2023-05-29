
<?php 
    require_once '../../config.php';

    session_start();

    if(!isset($_SESSION['email']) or $_SESSION['nivel']<1){
        header('Location:'.BASEURL.'index.php');
    }
    $titulo = "Importar Planilha - Athernos";
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index" >
<?php include_once ABSPATH.'layout/menu-lateral.php';?>
    <section class="box-importar">
        <h1>Importar Planilha</h1>
            <form action="<?php echo BASEURL;?>core/importar.php" method="post" enctype="multipart/form-data">                
                <div class="textfield">
                    <label><input type="file" name="file"> </label>
                </div>
                <button type="submit" class="">Enviar</button>
                <a class="" href="<?php echo BASEURL;?>index.php">Voltar</a>
            </form>
    </section>
            

    <!-- JavaScript Bundle with Popper -->


</body>
</html>