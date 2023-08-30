<?php
    require_once '../../config.php';
    require_once ABSPATH . 'classes/Crud.php';
    
    session_start();
    $titulo = "Entrada de Produtos - Athernos";
    if(!isset($_SESSION['email']) or $_SESSION['nivel']<1){
        header('Location:'.BASEURL.'index.php');
    }

    if(isset($_POST['dados'])and !empty($_POST['dados'])){
        
        //var_dump($_POST['dados']);
        $dados = $_POST['dados'];

        $obj_insert = new Crud();
        $obj_insert->insert('lotes',$dados);

        header('Location:'.BASEURL.'nav/produto/produtos.php');
        
    }



?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';?>
        <section class="entrada-prod">
            <form method='post' class="box-cadastro">
                <h1>Entrada de Produtos</h1>
                <div class="textfield categoria">
                    <label for="codigo" class="">Nome do Produto:</label>
                    <select name="dados[id_produto]" id="" require class="select2">
                        <?php
                            require_once ABSPATH.'classes/Crud.php'; 
                            $obj_select = new Crud;
                            $select = $obj_select->select("id,nome","produtos", 1, "nome");
                            if($select->num_rows > 0){
                                while($rows = $select->fetch_object()){
                                    echo "<option value ='{$rows->id}'>{$rows->nome}</option>";
                                }
                            }                                      
                        ?>
                    </select>  
                </div>  
                <div class="textfield">
                    <label for="custo" class="">Custo Unitário:</label>
                    <input type="number" min="1" name="dados[custo_unit]" id="totalAmt" step=0.01 required>
                </div>  
                <div class="textfield">
                    <label for="quantidade" class="">Quantidade:</label>
                    <input type="number" min="1" name="dados[quantidade]" required>
                </div>   
                <div class="textfield">   
                    <label for="Validade" class="">Validade:</label>
                    <input type="date" name="dados[validade]" required>
                </div>    
                <input type= "submit">
                <a href="<?php echo BASEURL;?>index.php">Voltar</a>
            </form>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
</body>