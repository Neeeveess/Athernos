
<header class="menu-lateral"><!-- MENU -->
    <a class="logo" href="<?php echo BASEURL;?>index.php"><img src="<?php echo BASEURL;?>assets/img/logo-projeto-estoque.png" alt=""></a>
    <section class="usuario">
        <h2>
            <?php echo "Bem vindo " . "<span>" . $_SESSION['nome'] . "</span>"; ?>
        </h2>
    </section>
    <nav class="nav-bar">
        <ul>
            <details>
                <summary>Produtos</summary>
                <a href="<?php echo BASEURL;?>nav/produto/produtos.php">Listar Produtos</a></li>
                <?php if($_SESSION['nivel'] >= 1){ ?>
                <a href="<?php echo BASEURL;?>nav/produto/importarCsv.php">Importar Planilha</a>
                <a href="<?php echo BASEURL;?>nav/produto/cadastroProd.php">Cadastrar Produtos</a>
                <a href="<?php echo BASEURL;?>nav/produto/entradaProd.php">Entrada de Produtos</a>
                <a href="<?php echo BASEURL;?>nav/produto/saidaProd.php">Saída de Produtos</a>
                
                <?php } ?>
                <?php if($_SESSION['nivel'] >= 2){ ?>
                <a href="<?php echo BASEURL;?>nav/produto/relatorio.php">Relatório de Entrada/Saída</a>
                <?php } ?>
            </details>
            <?php 
                if($_SESSION['nivel'] > 1){ ?>
                    <details>
                        <summary>Usuarios</summary>
                        <a href='<?php echo BASEURL;?>nav/usuario/usuarios.php'>Listar Usuários</a>
                        <a href='<?php echo BASEURL;?>nav/usuario/cadastro.php'>Cadastrar Usuario</a>
                    </details>
                <?php } ?>
        </ul>
    </nav>
    <footer class="footer-header">
        <img src="<?php echo BASEURL;?>assets/img/usuario.png" alt="" />
        <input type="checkbox" class="checkbox-conta">
        <div class="caixa-conta">
            <a href="">Minha Conta</a>
            <a href="">Configurações</a>
        </div>

        <a href="<?php echo BASEURL;?>index.php?id=1"><img src="<?php echo BASEURL;?>assets/img/sair.png" alt=""></a>
    </footer>
</header>

<!-- <div class="box-hamburguer"> HAMBURGUER 
    <div class="hamburguer">
        <span></span>
    </div>
    <input type="checkbox" class="checkbox"/>
</div> -->


<!-- <header class="menu-lateral-mobile">  MENU MOBILE 
    <a class="logo" href="./index.php"><img src="./img/logo-projeto-estoque.png" alt=""></a>
    <section class="usuario">
        <h2>
            <?php echo "Bem vindo " . "<span>" . $_SESSION['nome'] . "</span>"; ?>
        </h2>
    </section>
    <nav class="nav-bar">
        <ul>
            <li><a href="./funcoes/produto/produtos.php">Produtos</a></li>
            <li><a href="./funcoes/usuario/usuarios.php">Usuários</a></li>
            <?php 
                if($_SESSION['nivel'] > 1){
                    echo "<li><a href='cadastro.php'>Cadastrar Usuario</a></li>";
                }
            ?>
        </ul>
    </nav>
    <footer class="footer-header">
        <img src="./img/usuario.png" alt="" />
        <input type="checkbox" class="checkbox-conta">
        <div class="caixa-conta">
            <a href="">Minha Conta</a>
            <a href="">Configurações</a>
        </div>

        <a href="index.php?id=1"><img src="./img/sair.png" alt=""></a>
    </footer>
</header> -->