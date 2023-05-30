<?php
    require_once '../config.php';
    require_once ABSPATH.'classes/Crud.php';

    $obj = new Crud();
    

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
                $cont = 6;   
                $j = 1;                  
                $dado['codigo'] = utf8_encode($dados[0]);
                $dado['nome'] = strtoupper(utf8_encode($dados[1]));
                $dado['id_categoria'] = strtoupper(utf8_encode($dados[2]));
                $quantidade[$i][0] = utf8_encode($dados[3]);
                $custo[$i][0] = utf8_encode($dados[4]);  
                $validade[$i][0] = utf8_encode($dados[5]);  
                $loop = false;       
                if($loop == true){                   
                    loop:
                        $quantidade[$i][$j] = utf8_encode($dados[$cont]);
                        $cont++;
                        $custo[$i][$j] = utf8_encode($dados[$cont]);     
                        $cont++;        
                        $validade[$i][$j] = utf8_encode($dados[$cont]);
                        $cont++;     
                        $j++;                     
                }
                if(isset($dados[$cont])){
                    goto loop;
                }
                 

                
                echo $dado['codigo']." / ";
                echo $dado['nome']." / ";
                echo $dado['id_categoria']." / ";
                echo $quantidade[$i][0]." / ";
                echo $custo[$i][0]." / ";
                echo $validade[$i][0];
                if(count($quantidade[$i]) > 1){
                    for ($j=1; $j < count($quantidade[$i]); $j++) { 
                        echo " / ".$quantidade[$i][$j]." / ";
                        echo $custo[$i][$j]." / ";
                        echo $validade[$i][$j];
                    }

                }

                $cond = "nome ='$dado[id_categoria]'";                             
                $select1 = $obj->select("id","categoria", $cond);
                if ($select1->num_rows > 0){
                    while($rows=$select1->fetch_object()){
                        $dado['id_categoria'] = $rows->id;
                    }                    
                }else{ 
                    $obj->insert("categoria",$dado['id_categoria']); 
                    $cond = "nome ='$dado[id_categoria]'";                             
                    $select2 = $obj->select("id","categoria", $cond);
                    if ($select2->num_rows > 0){
                        while($rows=$select2->fetch_object()){
                            $dado['id_categoria'] = $rows->id;
                        }                    
                    }
                }
                $obj->insert("produtos",$dado);
                
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