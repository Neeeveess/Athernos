<?php
    session_start();
    require_once '../../config.php';
    require_once ABSPATH.'classes/Crud.php';
    $titulo = "Cadastro de Usuários - Athernos";

    if(!isset($_SESSION['email']) or $_SESSION['nivel']<2){
        header('Location:'.BASEURL.'index.php');
    }
    
    if(isset($_POST['dados']) and !empty($_POST['dados'])){
        $dados = $_POST['dados'];
        $senha2 = $_POST['senha2'];
        if("$dados[senha]" == $senha2){
            $dados['senha'] = md5($dados['senha']);
            $dados['nome'] = ucfirst($dados['nome']);
            $cond = "email='$dados[email]'";
            $obj = new Crud();
            $select = $obj->select("email","usuarios", $cond);
            
            if ($select->num_rows > 0){
                header('Location:'.BASEURL.'nav/usuario/cadastro.php?msg=2');    
            }else{
                $obj->insert("usuarios",$dados);
                $_SESSION['cad'] = true;
                header('Location:'.BASEURL.'index.php');
            }
        }else{
            header('Location:'.BASEURL.'nav/usuario/cadastro.php?msg=1');
        }
    }

?>


<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index">
<?php include_once ABSPATH.'layout/menu-lateral.php';?>
        <form method="post" class="form" autocomplete="off">
            <h1>Cadastrar Usuário</h1>
            <?php
                if(isset($_GET['msg']) and $_GET['msg'] == '1'){
            ?>
                <div class="msg-alerta" roles="alert">Senhas não conhecidem</div>
            <?php
                }
            ?>
            <?php
                if(isset($_GET['msg']) and $_GET['msg'] == '2'){
            ?>
                <div class="msg-alerta" roles="alert">Email já existe</div>
            <?php
                }
            ?>
            <div class="textfield">
                <input class="input2" type="text" name="dados[email]" required>
                <span class="focus-input2" data-placeholder="Email"></span>
            </div>
            <div class="textfield">
                <input class="input2" type="text" name="dados[nome]" required>
                <span class="focus-input2" data-placeholder="Nome"></span>
            </div>
            <div class="flex-field">
                <div class="textfield">
                    <input class="input2" type="password" name="dados[senha]" required>
                    <span class="focus-input2" data-placeholder="Senha"></span>
                </div>
                <div class="textfield">
                    <input class="input2" type="password" name="senha2" required>
                    <span class="focus-input2" data-placeholder="Confirme sua senha"></span>
                </div>
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
            <input type="submit">
            <a href="<?php echo BASEURL;?>index.php">Voltar</a>
        </form>
</body>