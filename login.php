<?php
    session_start();
    session_destroy();          

    require_once 'config.php';
    $titulo = "Login - Athernos";
    
    if(isset($_POST['email'])and !empty($_POST['email'])){
        $email = $_POST['email'];
        $senha = md5($_POST['pass']);
        require_once ABSPATH.'classes/Crud.php';
        $valida = new Crud();
        $select = $valida->select("*","usuarios","email = '$email' and senha = '$senha'");
        if($select->num_rows > 0){
            session_start();
            while($rows = $select->fetch_object()){
                $_SESSION['email'] = $rows->email;
                $_SESSION['nome'] = $rows->nome;
                $_SESSION['nivel'] = $rows->nivel;
            }
            header('Location:'.BASEURL.'index.php');
        }else{
            header('Location:'.BASEURL.'login.php?msg=1');
        }
    }
?>

<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-login">
        <form method="post" class="form" autocomplete="off">
            <img src="<?php echo BASEURL;?>assets/img/logo-projeto-estoque.png" alt="">
            <h1>Login</h1>
            <?php

                if(isset($_GET['msg'])){
            ?>
                <div class="msg-alerta" roles="alert">Informações Inválidas</div>
            <?php
                }
            ?>
            <div class="textfield">
                <input class="input2" type="text" name="email" required>
                <span class="focus-input2" data-placeholder="Email"></span>
            </div>
            <div class="textfield">
                <input class="input2" type="password" name="pass" required>
                <span class="focus-input2" data-placeholder="Senha"></span>
            </div>
            <input type="submit">
            
        </form>
        
</body>


</html>