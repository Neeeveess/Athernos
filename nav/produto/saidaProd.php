
<?php
    require_once '../../config.php';
    require_once ABSPATH . 'classes/Crud.php';
    
    session_start();
    $titulo = "Saida de Produtos - Athernos";
    if(!isset($_SESSION['email']) or $_SESSION['nivel']<1){
        header('Location:'.BASEURL.'index.php');
    }
?>

<?php include_once ABSPATH.'layout/header.php';?>

<body class="main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';?>
    <form>
        <input type = "text" name = "dados[id_produto]" id="id_produto">
        <input type = "text" name = "codigo" value readonly id="codigo_produto">
        <input type = "text" name = "nome" readonly id="nome_produto">        
        <select name="id_lote" id="lotes"></select>
        <input type = "int" name = "dados[quantidade]">
        
    </form>
    
</body>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

$(document).ready(() => {
  $('#id_produto').on('change', e => {	
    let id_produto = $(e.target).val();
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
        }		
    }) 
  }) 


})




</script>