
<?php
    require_once '../../config.php';
    require_once ABSPATH . 'classes/Crud.php';
    
    session_start();
    
    $titulo = "Saida de Produtos - Athernos";
    if(!isset($_SESSION['email']) or $_SESSION['nivel']<1){
        header('Location:'.BASEURL.'index.php');
    }

    if(isset($_POST['qtd'])and !empty($_POST['qtd'])){
        $obj = new Crud();
        $dados = $_POST['dados'];
        $dadosLote = $_POST['dadosLote'];
        $qtd =  $_POST['qtd'];
        $cond = "codigo='$dadosLote[id_lote]'";   
        $select = $obj->select("quantidade","lotes", $cond);
        if ($select->num_rows > 0){
            $i = 0;
            while($rows=$select->fetch_object()){
                $qtdLote = $rows->quantidade;                         
            }
            if($qtd <= $qtdLote){
                $param = $qtdLote - $qtd; 
                // $obj->update("lotes","quantidade = '$param'",$cond); 
                $obj->call("registrar_saida('$dadosLote[id_lote]','$qtd')");
            }else{
                echo "valor acima";
            }
        }     
    }
    

?>

<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';?>
    <form method='post'>
        <label for="dados[id_produto]">Id do Produto:</label>
        <input type = "text" name = "dados[id_produto]" id="id_produto">

        <label for="dados[codigo]">Codigo:</label>
        <input type = "text" name = "dados[codigo]" value readonly id="codigo_produto">

        <label for="dados[nome]">Nome:</label>
        <input type = "text" name = "dados[nome]" readonly id="nome_produto">        

        <label for="dadosLote[id_lote]">Lotes:</label>
        <select name="dadosLote[id_lote]" id="lotes">
            <option>Selecione o Lote</option>
        </select>

        <label for="qtd">Quantidade:</label>
        <input type = "int" name = "qtd">
        
        <input type="submit">
    </form>
    
</body>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

$(document).ready(() => {
  $('#id_produto').on('input', e => {	
    let id_produto = $(e.target).val();
    if (id_produto.trim() != "") {
        $.ajax({
            type: 'POST',
            url: 'getProduto.php',
            data: 'id='+id_produto, //x-www-form-urlencoded	
            dataType: 'json',
            success: dados => {
                
                if (dados.length > 0){
                $.each(dados, function(i, obj){
                    document.querySelector("#codigo_produto").value = obj.codigo;
                    document.querySelector("#nome_produto").value = obj.nome;
                })
                }
            },error: dados =>{
                document.querySelector("#codigo_produto").value = '';
            document.querySelector("#nome_produto").value = '';
            }	
        }) 
        $.ajax({
            type: 'POST',
            url: 'getProdutoLotes.php',
            data: 'id='+id_produto, //x-www-form-urlencoded	
            dataType: 'json',
            success: dados2 => {
                if (dados2.length > 0){
                    var option = '';	
                    option += '<option>'+ 'Selecione o Lote' +'</option>';		
                    if (dados2.length > 0){
                        $.each(dados2, function(i, obj){
                            option += `<option value =${obj.codigo}>Lote: ${obj.codigo} - Quantidade: ${obj.quantidade}</option>`;
                        })
                    }
                    $('#lotes').html(option).show();
                }
            },	
            error: dados2 =>{
                $('#lotes').html('<option>'+ 'Selecione o Lote' +'</option>').show();
            }
        }) 
    }else{
            document.querySelector("#codigo_produto").value = '';
            document.querySelector("#nome_produto").value = '';
            $('#lotes').html('<option>'+ 'Selecione o Lote' +'</option>').show();	
    }
  }) 


})




</script>