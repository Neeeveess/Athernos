<?php 
    require_once '../../config.php';
    require_once ABSPATH.'classes/Crud.php';

    session_start();
    if(!isset($_SESSION['email'])){
            header('Location:'.BASEURL.'login.php');
    }
    $titulo = "Produtos - Athernos";
    if(isset($_SESSION['cad']) and $_SESSION['cad'] == true){
        ?>
        <script>alert('Produto cadastrado com sucesso!')</script>
        <?php
        
        unset( $_SESSION['cad'] );        
    }
?>

<?php include_once ABSPATH.'layout/header.php';?>
<body class="main-index">
    <?php include_once ABSPATH.'layout/menu-lateral.php';
     
    
    ?>
    <main class="corpo-produto">
        <section class="cabecalho">
            <div class="box-busca">
                <form action="" method="get" autocomplete="off">
                <input class="busca" name="search" type="text" placeholder="Busca...">
                <button type="submit" class="btn-busca">
                <svg height="800px" width="800px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" enable-background="new 0 0 50 50" xml:space="preserve" fill="#ffffff" stroke="#ffffff">

                <g id="SVGRepo_bgCarrier" stroke-width="0"/>

                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>

                <g id="SVGRepo_iconCarrier"> <path fill="#ffffff" d="M20.745,32.62c2.883,0,5.606-1.022,7.773-2.881L39.052,40.3c0.195,0.196,0.452,0.294,0.708,0.294 c0.255,0,0.511-0.097,0.706-0.292c0.391-0.39,0.392-1.023,0.002-1.414L29.925,28.319c3.947-4.714,3.717-11.773-0.705-16.205 c-2.264-2.27-5.274-3.52-8.476-3.52s-6.212,1.25-8.476,3.52c-4.671,4.683-4.671,12.304,0,16.987 C14.533,31.37,17.543,32.62,20.745,32.62z M13.685,13.526c1.886-1.891,4.393-2.932,7.06-2.932s5.174,1.041,7.06,2.932 c3.895,3.905,3.895,10.258,0,14.163c-1.886,1.891-4.393,2.932-7.06,2.932s-5.174-1.041-7.06-2.932 C9.791,23.784,9.791,17.431,13.685,13.526z"/> </g>

                </svg>
                </button>
                </form>
            </div>
        </section>
        <?php  ?>
        <table>
            <thead>
                <tr>
                    <th class="id" scope="col">ID</th>
                    <th class="codigo" scope="col">Código Produto</th>
                    <th class="nome" scope="col">Nome</th>
                    <th class="nome" scope="col">Categoria</th>
                    <th class="total" scope="col">Quantidade</th>
                    <th class="custo" scope="col">Custo (UN)</th>
                    <th class="menorVal" scope="col">Menor Validade</th>
                    <th class="maiorVal" scope="col">Maior Validade</th>
                    <?php if($_SESSION['nivel'] > 0){?>
                    <th class="edit" scope="col">...</th>
                    <?php }?>
                    <th class="visuModal" scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $obj = new Crud; 
                if(isset($_GET) and !empty($_GET['search'])){
                    $var = $_GET['search'];
                    $select = $obj->select('*',"listProd","nome LIKE '$var%' or id LIKE '$var%' or categoria LIKE '$var%'");
                }else{
                    $select = $obj->select("*","listProd","1","id ASC");
                }
                if ($select->num_rows > 0){
                
                    while($rows = $select->fetch_object()){
                        $menor_validade = strtotime($rows->menor_validade); 
                        $maior_validade = strtotime($rows->maior_validade);                         
            ?>
                <tr>
                    <th class="id" scope="row"><?php echo $rows->id?></th>                    
                    <td class="codigo"><?php echo $rows->codigo?></td>
                    <td class="nome"><?php echo $rows->nome?></td>
                    <td class="categoria"><?php echo $rows->categoria?></td>
                    <td class="total"><?php if($rows->total !== null){echo $rows->total;}else{echo '-';}?></td>
                    <td class="custo"> <?php if($rows->custo !== null){echo "R$ ".number_format($rows->custo,2,",","");}else{echo "-";}?></td>
                    <td class="menorVal"><?php if((date('d/m/Y', $menor_validade) == '01/01/1970')or (date('d/m/Y', $menor_validade) == '31/12/1969') ){echo '-';}else{echo date('d/m/Y', $menor_validade);}?></td>
                    <td class="maiorVal"><?php if((date('d/m/Y', $maior_validade) == '01/01/1970')or (date('d/m/Y', $maior_validade) == '31/12/1969')){echo '-';}else{echo date('d/m/Y', $maior_validade);}?></td>
                    <?php if($_SESSION['nivel'] > 0){?>
                    <td class="edit">
                        <a href="<?php echo BASEURL;?>core/editar.php?idProd=<?php echo $rows->id?>">
                        <svg fill="#000000" height="800px" width="800px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                            viewBox="0 0 502.001 502.001" xml:space="preserve">
                            <g>
                                <g>
                                    <g>
                                        <path d="M489.809,32.002l-19.797-19.798C462.142,4.333,451.679,0,440.551,0s-21.59,4.333-29.459,12.202l-14.99,14.99
                                            l-1.959-1.959c-3.905-3.904-10.235-3.905-14.143,0L62.146,343.088l0.011,0.004c-0.911,0.91-1.658,1.992-2.169,3.215
                                            l-29.102,69.719L0.782,488.148c-1.562,3.742-0.71,8.056,2.157,10.923c1.913,1.914,4.472,2.93,7.073,2.93
                                            c1.297,0,2.605-0.252,3.851-0.772l72.123-30.105c0.002-0.001,0.004-0.002,0.005-0.003l69.712-29.099
                                            c1.223-0.51,2.305-1.257,3.215-2.168l0.004,0.011L476.778,122.01c1.875-1.875,2.929-4.419,2.929-7.071
                                            c0-2.652-1.054-5.196-2.929-7.071l-1.959-1.959l14.99-14.989C506.052,74.676,506.052,48.246,489.809,32.002z M28.611,473.399
                                            L43.596,437.5l20.915,20.914L28.611,473.399z M84.466,450.085l-32.541-32.54l20.772-49.763l61.532,61.531L84.466,450.085z
                                            M151.852,418.65L83.36,350.159l271.839-271.84l68.492,68.492L151.852,418.65z M437.834,132.669l-68.492-68.492l17.73-17.73
                                            l68.492,68.492L437.834,132.669z M475.666,76.776L460.822,91.62l-50.431-50.432l14.844-14.844
                                            c4.091-4.091,9.53-6.344,15.316-6.344s11.227,2.253,15.317,6.344l19.797,19.797C484.111,54.588,484.111,68.33,475.666,76.776z"/>
                                        <path d="M255.258,199.397L110.627,344.029c-3.905,3.905-3.905,10.237,0,14.143c1.953,1.953,4.512,2.929,7.071,2.929
                                            s5.118-0.977,7.071-2.929l144.632-144.633c3.905-3.905,3.905-10.237,0-14.142C265.495,195.492,259.165,195.492,255.258,199.397z"
                                            />
                                        <path d="M300.255,154.4l-18.213,18.213c-3.905,3.905-3.905,10.237,0,14.143c1.953,1.952,4.512,2.929,7.071,2.929
                                            s5.118-0.977,7.071-2.929l18.213-18.213c3.906-3.905,3.906-10.237,0.001-14.143C310.492,150.496,304.162,150.496,300.255,154.4z"
                                            />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </td>
                    <?php }?>
                    <td class="visuModal">
                        <button type="button" class="btn btn-primary" data-id="<?php echo $rows->id?>" data-toggle="modal" 
                        data-target="#ModalLotes">
                            +
                        </button>            
                    </td>
                </tr>
                
                <?php
                    }
                }
            ?>

            </tbody>
        </table>
        
    </main>
</body>

<!-- Modal -->
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="ModalLotes" tabindex="-1" role="dialog" aria-labelledby="ModalLotesTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="ModalContent">




        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
  	$(document).ready(function(){
  		$("#ModalLotes").modal({
  			keyboard: false,
  			backdrop: "static",
  			show: false,
  
  		}).on("show.bs.modal", function(event){
  		  var button = $(event.relatedTarget); 
          var produtoid = button.data("id");
            $.ajax({
                url: 'getLotes.php',
                type: 'POST',
                data: 'id='+produtoid
            })
            .done(function(data){
                //console.log(data);	
                $('#ModalContent').html('');
                $('#ModalContent').html(data); // load response
            })
            .fail(function(){
                $('#ModalContent').html('<i class="glyphicon glyphicon-info-sign"></i> Nenhuma entrada encontrada!');
            })
  		}).on("hide.bs.modal", function (event) {            
			// $(this).find("#ModalLotesBody").html("");
            // $('.modal-backdrop').modal('hide'); 
		});
  	});
</script>

</html>