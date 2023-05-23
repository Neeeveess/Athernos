<?php
    require_once "../config.php";
    require_once ABSPATH."classes/Crud.php";
    session_start();
    $obj = new Crud();   
    $titulo = "Editar - Athernos";
?>

<?php include_once ABSPATH.'layout/header.php';?>
<?php include_once ABSPATH.'layout/menu-lateral.php';?>
<body class="main-index">
    
    
    <section class="cadastrar-prod">
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
        <form class="box-cadastro" method='post' autocomplete="off">
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
  
                <select name="dados[id_categoria]" required>

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
            </div>

            <input type= "submit">
            <a href="<?php echo BASEURL;?>index.php">Voltar</a>
        </form>
        <?php
        }
        
        ?>
    </section>

</body>

   <!-- EDITAR USUARIOS  -->
<body>

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
            <div class="textfield categoria">
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
        }
        
        ?>

        
