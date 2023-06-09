
<?php 
    require_once '../../config.php';

    session_start();

    if(!isset($_SESSION['email']) or $_SESSION['nivel']<1){
        header('Location:'.BASEURL.'index.php');
    }
    $titulo = "Importar Planilha - Athernos";
    if(isset($_SESSION['cad']) and $_SESSION['cad'] == true){
        ?>
        <script>alert('Produtos Importados com sucesso!')</script>
        <?php
        
        unset( $_SESSION['cad'] );        
    }
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index" >
<?php include_once ABSPATH.'layout/menu-lateral.php';?>
    <section class="box-importar">
        <h1>Importar Planilha</h1>
            <?php
                    if(isset($_GET['msg']) and $_GET['msg'] == '1'){
            ?>
                    <div class="msg-alerta" roles="alert" style="color:#ff3d3d;">Extensão Inválida!</div>
            <?php
                    }
            ?>
            <form action="<?php echo BASEURL;?>core/importar.php" method="post" enctype="multipart/form-data">                
                <div class="textfield">
                    <label><input type="file" name="file"> </label>
                </div>
                <button type="submit" class="botao-enviar">Enviar</button>
                <span class="loader"></span>
                <a class="" href="<?php echo BASEURL;?>index.php">Voltar</a>
            </form>
    </section>
            <script>
                const botao =  document.querySelector(".botao-enviar")

                botao.addEventListener("click", function(){
                    document.querySelector(".loader").style.display = 'block';
			        botao.style.display = 'none';
                });
                
            </script>


</body>
</html>