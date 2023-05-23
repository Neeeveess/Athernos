<?php
    require_once '../../config.php';
    require_once ABSPATH.'classes/Crud.php';
    
    session_start();
    
    $titulo = "Cadastro de Categorias - Athernos";
    if(!isset($_SESSION['email']) or $_SESSION['nivel']<1){
        header('Location:'.BASEURL.'index.php');
    }

    if(isset($_POST['dados'])and !empty($_POST['dados'])){
        $dados = $_POST['dados'];
        $cond = "codigo='$dados[codigo]'";

        $obj = new Crud();
        $select = $obj->select("codigo","produtos", $cond);
        if ($select->num_rows > 0){
            header('Location:'.BASEURL.'nav/produto/cadastroProd.php?msg=1');    
        }else{
            $obj->insert("produtos",$dados);
            header('Location:'.BASEURL.'nav/produto/produtos.php');
        }


    }
?>

<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';?>
    <section class="cadastrar-prod">
        <section class="msg">
            <?php
                if(isset($_GET['msg'])){
            ?>
                <div class="msg-alerta" roles="alert">Código ja cadastrado!</div>
            <?php
                }
            ?>
        </section>
        <form class="box-cadastro" method='post' autocomplete="off">
            <div class="textfield">
                <label for="codigo" class="">Codigo:</label>
                <input type="text" name="dados[codigo]" required>
            </div>
            <div class="textfield">
                <label for="nome" class="">Nome:</label>
                <input type="text" name="dados[nome]" onChange= "javascript:this.value=this.value.toUpperCase()" required>
            </div>
            <div class="textfield categoria">
                <label for="Categoria" class="">Categoria:</label>
                <input type="text" name="dados[categoria]" onChange= "javascript:this.value=this.value.toUpperCase()" required>
            </div>
            <!-- <input type="radio" name="categoria" required> -->
            <input type= "submit">
            <a href="<?php echo BASEURL;?>index.php">Voltar</a>
        </form>
    </section>
</body>