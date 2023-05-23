<?php
    include_once "config/connect.php";

    $arquivo = $_FILES['file']['tmp_name'];
    $nome = $_FILES['file']['name'];

    $ext = explode(".", $nome);

    $extensao = end($ext);

    if($extensao != "csv"){

    }else{
        //echo "Valida";

            $objeto = fopen($arquivo,'r');

            $dia_atual = date('Y-m-d');
            $hj = new DateTime($dia_atual);
        
                


            while(($dados = fgetcsv($objeto,1000,",")) !== FALSE){
                $nome = utf8_encode($dados[1]);
                $valor = utf8_encode($dados[2]);
                $qtde = utf8_encode($dados[3]);
                $validade = utf8_encode($dados[4]);
                $dt2 = new DateTime($validade);
                $intervalo = $dt2->diff ($hj);
                $dias = $intervalo->format('%R%a');

                if($validade == '2022-11-31'){
                    $validade = '2022-12-01';
                }
                $user = 1;

                
                if ($dias > 60){
                    //VENCIDOS
                    $produtos = "INSERT INTO solicitacaotroca(NomeProd,valorProd,qtdeProd,validadeProd,Usuario_idUser)
                    VALUES('$nome','$valor','$qtde','$validade','$user')";

                    $result = mysqli_query($conn,$produtos);
        
                }elseif($dias <61 and $dias > 0){
                    //PERTO DA VALIDADE
                    $produtos = "INSERT INTO solicitacaotroca(NomeProd,valorProd,qtdeProd,validadeProd,Usuario_idUser)
                    VALUES('$nome','$valor','$qtde','$validade','$user')";

                    $result = mysqli_query($conn,$produtos);
                }else{
                    //DATA BOA
                    $produtos = "INSERT INTO produto(NomeProd,valorProd,qtdeProd,validadeProd,Usuario_idUser)
                    VALUES('$nome','$valor','$qtde','$validade','$user')";

                    $result = mysqli_query($conn,$produtos);


                
               
            }

            if($result){
                echo "dados inseridos";
            }else{
                echo "Erro";
            }
        }
    }
    header('Location: index.php');
?>