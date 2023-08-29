<?php
    session_start();
    require_once '../../config.php';
    require_once ABSPATH.'classes/Crud.php';
    $titulo = "Minha Conta - Athernos";

    if(isset($_SESSION['cad']) and $_SESSION['cad'] == true){
        ?>
        <script>alert('Dados alterados!')</script>
        <?php
        
        unset( $_SESSION['cad'] );        
    }
    


    if(isset($_POST['dados']) and !empty($_POST['dados'])){
        $dados = $_POST['dados'];
        $antiga = md5($dados['antiga']);
        $senha2 = $_POST['senha2'];

        $obj = new Crud();
        $cond = "senha='$antiga' and email='$_SESSION[email]'";
        $select = $obj->select("senha","usuarios", $cond);

        if ($select->num_rows > 0){ 
            if(empty($dados['senha']) and empty($senha2)){
                $dados['nome'] = ucfirst($dados['nome']);                       
                $obj->update("usuarios",
                    "nome='$dados[nome]'",
                    $cond);
                $_SESSION['nome'] = $dados['nome'];
                $_SESSION['cad'] = true;
                header('Location:'.BASEURL.'nav/usuario/minhaConta.php');
            }else{
                if("$dados[senha]" == $senha2){
                    $dados['senha'] = md5($dados['senha']);
                    $dados['nome'] = ucfirst($dados['nome']);
                    $cond = "email='$_SESSION[email]'";                        
                
                    $obj->update("usuarios",
                        "nome='$dados[nome]', senha='$dados[senha]'",
                        $cond);
                    $_SESSION['nome'] = $dados['nome'];
                    $_SESSION['cad'] = true;
                    header('Location:'.BASEURL.'nav/usuario/minhaConta.php');
    
                }else{
                    header('Location:'.BASEURL.'nav/usuario/minhaConta.php?msg=2');    
                    
                }
            }

        }else{
            header('Location:'.BASEURL.'nav/usuario/minhaConta.php?msg=1');
        }
    }

?>


<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index">
<?php include_once ABSPATH.'layout/menu-lateral.php';?>
        <form method="post" class="form" autocomplete="off">
            <h1>Minha Conta</h1>
            <?php
                if(isset($_GET['msg']) and $_GET['msg'] == '1'){
            ?>
                <div class="msg-alerta" roles="alert">Senha atual errada!</div>
            <?php
                }
            ?>
            <?php
                if(isset($_GET['msg']) and $_GET['msg'] == '2'){
            ?>
                <div class="msg-alerta" roles="alert">Senhas não conhecidem</div>
            <?php
                }
            ?>

            <p>Para alterar apenas o nome, basta preencher a senha atual!</p>
            <div class="textfield">
                
                <input class="input2" type="text" name="dados[nome]" placeholder="Nome" value="<?php echo $_SESSION['nome'];?>" required >
            </div>
            <div class="textfield">
                <input class="input2" type="password" name="dados[antiga]" placeholder="Digite sua senha Atual..." required >
            </div>
            <div class="textfield">
                <input class="input2" type="password" name="dados[senha]" placeholder="Digite sua nova Senha..." >
            </div>
            <div class="textfield">
                <input class="input2" type="password" name="senha2" placeholder="Confirme sua nova senha..." >
            </div>
            <input type="submit">
            <a href="<?php echo BASEURL;?>index.php">Voltar</a>
        </form>
</body>