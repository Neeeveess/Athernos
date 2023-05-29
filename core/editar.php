<?php
    require_once "../config.php";
    require_once ABSPATH."classes/Crud.php";
    session_start();
    $obj = new Crud();   
    $titulo = "Editar - Athernos";
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php include_once ABSPATH.'layout/header.php';?>
<?php include_once ABSPATH.'layout/menu-lateral.php';?>
<body class="main-index">
    <?php 
        if(isset($_GET['idProd'])){ 
            $select = $obj->select("*","produtos","id='$_GET[idProd]'");
            if($select->num_rows > 0){
                while ($linhas = $select->fetch_object()){
                   $codigoProd = $linhas->codigo;
                   $nomeProd = $linhas->nome;
                   $idCat = $linhas->id_categoria;
                }  
            }

            if(isset($_POST['dados'])and !empty($_POST['dados'])){
                $dados = $_POST['dados'];
                $cond = "id='$dados[idProd]'";
                unset($dados['idProd']);
                $param= "";
                if(is_array($dados)){
                    foreach($dados as $chave => $valor ){
                        $param .= "$chave='$valor',";
                    }
                    $param = rtrim($param, ",");
                }
                $update = $obj->update("produtos", $param, $cond);
                header('Location:'.BASEURL.'nav/produto/produtos.php');  
            }
        ?>
        <section class="cadastrar-prod">
            <form class="box-cadastro" method='post' autocomplete="off">
                <h1>Editar Produto</h1>
                <input type="hidden" name="dados[idProd]" value="<?php echo $_GET['idProd'];?>" required>
                <div class="textfield">
                    <label for="codigo" class="">Codigo:</label>
                    <input type="text" name="dados[codigo]" value = "<?php echo $codigoProd;?>" required>
                </div>
                <div class="textfield">
                    <label for="nome" class="">Nome:</label>
                    <input type="text" name="dados[nome]" 
                    value = "<?php echo $nomeProd;?>"onChange= "javascript:this.value=this.value.toUpperCase()" required>
                </div>
                <div class="textfield categoria">
                    <label for="Categoria" class="">Categoria:</label>
    
                    <select name="dados[id_categoria]" id="" require class="select2">             
                        <?php
                        $selectcat = $obj->select("*","categoria");
                        if ($selectcat->num_rows > 0){
                            while($rows=$selectcat->fetch_object()){
                                ?>
                                <option value = "<?php echo $rows->id;?>" <?php if ($idCat == $rows->id){echo " selected";} ?>>
                                    <?php echo $rows->nome;?>
                                </option>                            
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <input type= "submit">
                <a href="<?php echo BASEURL;?>index.php">Voltar</a>
            </form>
        </section>
        <?php
        } ?>
    


   <!-- EDITAR USUARIOS  -->
   
   <?php 
        if(isset($_GET['idUsu'])){ 
            $select = $obj->select("*","usuarios","id='$_GET[idUsu]'");
            if($select->num_rows > 0){
                while ($linhas = $select->fetch_object()){
                   $emailUsu = $linhas->email;
                   $nomeUsu = $linhas->nome;
                   $nivelUsu = $linhas->nivel;
                }  
            }

            if(isset($_POST['dados'])and !empty($_POST['dados'])){
                $dados = $_POST['dados'];
                $cond = "id='$dados[idUsu]'";
                unset($dados['idUsu']);
                $param= "";
                if(is_array($dados)){
                    foreach($dados as $chave => $valor ){
                        $param .= "$chave='$valor',";
                    }
                    $param = rtrim($param, ",");
                }
                $update = $obj->update("usuarios", $param, $cond);
                header('Location:'.BASEURL.'nav/usuario/usuarios.php');  
            }
        ?>
        <section class="cadastrar-prod">
        <form class="box-cadastro" method='post' autocomplete="off">
        <h1>Editar Usuário</h1>
            <input type="hidden" name="dados[idUsu]" value="<?php echo $_GET['idUsu'];?>" required>
            
            <div class="textfield">
                <label for="codigo" class="">Email:</label>
                <input type="text" name="dados[email]" value = "<?php echo $emailUsu;?>" required>
            </div>
            <div class="textfield">
                <label for="nome" class="">Nome:</label>
                <input type="text" name="dados[nome]" 
                value = "<?php echo $nomeUsu;?>"onChange= "javascript:this.value=this.value.toUpperCase()" required>
            </div>
            <div class="textfield-radio">
            <label>
                    <input type="radio" name="dados[nivel]" value="2" required>
                    Administrador
                </label>
                <label>
                    <input type="radio" name="dados[nivel]" id="editor" value="1">
                    Editor
                </label>
                <label>
                    <input type="radio" name="dados[nivel]" id="user" value="0">
                    Normal
                </label>
            </div>

            <input type= "submit">
            <a href="<?php echo BASEURL;?>index.php">Voltar</a>
        </form>
        </section>
        <?php
        }?>
</body>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
