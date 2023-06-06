<?php
    require_once '../../config.php';
    require_once ABSPATH.'classes/Crud.php';
    
    session_start();
    $obj = new Crud();            

    $titulo = "Cadastro de Produtos - Athernos";
    if(!isset($_SESSION['email']) or $_SESSION['nivel']<1){
        header('Location:'.BASEURL.'index.php');
    }

    if(isset($_POST['categoria'])and !empty($_POST['categoria'])){
        $categoria = $_POST['categoria'];        
        $cond = "nome = '$categoria'";                
        $select1 = $obj->select("nome","categoria", $cond);
        if ($select1->num_rows > 0){
            $_SESSION['cad'] = true;
        }else{                           
            $obj->insert("categoria",$categoria);                     
            ?>
            <script>alert('Categoria cadastrada com sucesso!')</script>
            <?php  
        }
        unset($_POST['categoria']);  
    }
    if(isset($_SESSION['cad']) and $_SESSION['cad'] == true){
        ?>
        <script>alert('Categoria Já Existe!')</script>
        <?php
        
        unset( $_SESSION['cad'] );        
    }
                
    if(isset($_POST['dados'])and !empty($_POST['dados'])){
        $dados = $_POST['dados'];
        $cond = "codigo='$dados[codigo]'";   
        $cond2 = "nome='$dados[nome]'";   
        $select = $obj->select("codigo","produtos", $cond);
        $select2 = $obj->select("nome","produtos", $cond2);
        if (($select->num_rows > 0) or ($select2->num_rows > 0)){
            header('Location:'.BASEURL.'nav/produto/cadastroProd.php?msg=1');    
        }else{
            $obj->insert("produtos",$dados);
            $_SESSION['cad'] = true;
            header('Location:'.BASEURL.'nav/produto/produtos.php');
        }
    }
    
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';?>
    <section class="cadastrar-prod">        
        <section class="msg">
            <?php
                    if(isset($_GET['msg']) and $_GET['msg'] == '1'){
            ?>
                    <div class="msg-alerta" roles="alert">Código ou Nome já Existe!</div>
            <?php
                    }
            ?>
        </section>
        <form class="box-cadastro" method='post' autocomplete="off">
            <h1>Cadastro de Produtos</h1>
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
                
                <select name="dados[id_categoria]" id="" require class="select2">
                    <option>...</option>
                    <?php

                    $selectcat = $obj->select("*","categoria");
                    if ($selectcat->num_rows > 0){
                        while($rows=$selectcat->fetch_object()){
                            ?>
                            <option value = "<?php echo $rows->id;?>"><?php echo $rows->nome;?></option>                            
                            <?php
                        }
                    }
                    ?>
                </select>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#NovaCategoria">
                    +
                </button>
            </div>
            
            <input type= "submit">
            <a href="<?php echo BASEURL;?>index.php">Voltar</a>
        </form>
        <!-- MODAL -->
        <div class="modal modal-categoria fade" id="NovaCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Nova categoria:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" autocomplete="off">
                            <input type="text" name="categoria" id="categoria" onChange= "javascript:this.value=this.value.toUpperCase()" required> 
                            <input type="submit" value="Cadastrar">                       
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
</body>