
<?php
    require_once '../../config.php';
    require_once ABSPATH.'classes/Crud.php';

    $id = $_POST['id'];
    $obj = new Crud;
    $view = $obj->select("codigo,custo_unit,quantidade,validade,data_entrada","lotes","id_produto =$id");
    $title = $obj->select("codigo,nome","produtos","id = $id")
?>
<div class="modal-header">
    <h5 class="modal-title" id="ModalLotesTitle">
    <?php if ($title -> num_rows > 0){
        while($r = $title->fetch_object()){
            echo $r->codigo. " - ";
            echo $r->nome;
        }
        
        
    }
    ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="ModalLotesBody">
<?php
    if ($view->num_rows > 0){
?>
    <table >
        <thead>
            <tr id="xy">
                <th scope="col">Lote</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Custo (UN)</th>
                <th scope="col">Validade</th>
                <th scope="col">Entrada</th>
            </tr>
        </thead>
        <tbody>
<?php
    }
    if ($view->num_rows > 0){
    while($linhas = $view->fetch_assoc()){
        $validade = strtotime($linhas['validade']); 
        $entrada = strtotime($linhas['data_entrada']); 
?>
    <?php if(!($linhas['quantidade'] <= 0)){ ?>
            <tr>
                <th scope="row"><?php echo $linhas['codigo'];?></th>
                <td><?php echo $linhas['quantidade'];?></td>
                <td><?php echo "R$ ".number_format($linhas['custo_unit'],2,",","");?></td>
                <td><?php echo date('d/m/Y', $validade);?></td>
                <td><?php echo date('d/m/Y - H:i', $entrada);?></td>
            </tr>
        
        <?php }?>
<?php } ?>
    </tbody>
</table>
</div>
<?php
    }else{
        echo "<i class=\"glyphicon glyphicon-info-sign\"></i> Nenhuma entrada encontrada!";
    }
?>