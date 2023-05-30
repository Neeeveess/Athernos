<?php
    require_once '../config.php';
    require_once ABSPATH.'classes/Crud.php';

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
        
                
            $i = 0;
            
            $quantidade = [[]];
            $custo = [[]];
            $validade = [];            
            while(($dados = fgetcsv($objeto,1000,",")) !== FALSE){     
                $cont = 5;   
                $j = 1;                  
                $codigo = utf8_encode($dados[0]);
                $nome = utf8_encode($dados[1]);
                $categoria = utf8_encode($dados[2]);
                $quantidade[$i][0] = utf8_encode($dados[3]);
                $custo[$i][0] = utf8_encode($dados[4]);  
                $loop = false;       
                if($loop == true){                   
                    loop:
                        $quantidade[$i][$j] = utf8_encode($dados[$cont]);
                        $cont++;
                        $custo[$i][$j] = utf8_encode($dados[$cont]);     
                        $cont++;        
                        $j++;                     
                }
                if(!preg_match("/[-]/i",$dados[$cont])){
                    goto loop;
                }
                $validade[$i] = utf8_encode($dados[$cont]);  

                echo $codigo." / ";
                echo $nome." / ";
                echo $categoria." / ";
                echo $quantidade[$i][0]." / ";
                echo $custo[$i][0]." / ";
                if(count($quantidade[$i]) > 1){
                    for ($j=1; $j < count($quantidade[$i]); $j++) { 
                        echo $quantidade[$i][$j]." / ";
                        echo $custo[$i][$j]." / ";
                    }

                }
                echo $validade[$i];
                echo "<br>";
                
                $i++;

            // if($result){
            //     echo "dados inseridos";
            // }else{
            //     echo "Erro";
            // }
        }
    }
    // header('Location:'.BASEURL.'index.php');
?>