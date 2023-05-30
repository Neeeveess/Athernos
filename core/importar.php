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
        $array = [];
        $quantidade = [[]];
        $custo = [[]];
        $validade = [];            
        while(($dados = fgetcsv($objeto,1000,",")) !== FALSE){     
                $cont = 6;   
                $j = 1;                  
                $dado['codigo'] = utf8_encode($dados[0]);
                $dado['nome'] = strtoupper(utf8_encode($dados[1]));
                $dado['id_categoria'] = strtoupper(utf8_encode($dados[2]));
               
                $cond = "codigo ='$dado[codigo]'";                             
                $select3 = $obj->select("codigo","produtos", $cond);
                if ($select3->num_rows > 0){
                    while($rows=$select3->fetch_object()){
                            if(!in_array($rows->codigo, $array)){                                
                                array_push($array,$rows->codigo);
                            }
                    }
                }else{
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
                }
                $custo[$i][0] = utf8_encode($dados[4]);  
                $quantidade[$i][0] = utf8_encode($dados[3]);
                $validade[$i][0] = utf8_encode($dados[5]);  
                $dadoLote['custo_unit'] = $custo[$i][0];
                $dadoLote['quantidade'] = $quantidade[$i][0];
                $dadoLote['validade'] = $validade[$i][0];
                $loop = false;       
                if($loop == true){                   
                    loop:
                        $custo[$i][$j] = utf8_encode($dados[$cont]); 
                        $dadoLote['custo_unit'] = $custo[$i][$j];    
                        $cont++;
                        $quantidade[$i][$j] = utf8_encode($dados[$cont]);
                        $dadoLote['quantidade'] = $quantidade[$i][$j];
                        $cont++;        
                        $validade[$i][$j] = utf8_encode($dados[$cont]);
                        $dadoLote['validade'] = $validade[$i][$j];
                        $cont++;     
                        $j++;                     
                }
                    $cond = "nome ='$dado[nome]'"; 
                    $select = $obj->select("id","produtos", $cond);
                    if($select->num_rows > 0){
                        while($rows = $select->fetch_object()){
                            $dadoLote['id_produto'] = $rows->id;
                        }
                    }
                    $obj->insert("lotes",$dadoLote); 
                if(isset($dados[$cont])){
                    goto loop;
                }
                

                
                // echo $dado['codigo']." / ";
                // echo $dado['nome']." / ";
                // echo $dado['id_categoria']." / ";
                // echo $custo[$i][0]." / ";
                // echo $quantidade[$i][0]." / ";
                // echo $validade[$i][0];
                // if(count($quantidade[$i]) > 1){
                //     for ($j=1; $j < count($quantidade[$i]); $j++) { 
                //         echo $custo[$i][$j]." / ";
                //         echo " / ".$quantidade[$i][$j]." / ";
                //         echo $validade[$i][$j];
                //     }

                // }                
                // echo "<br>";
                $i++;
                

                
        }
        if(!is_null($array)){            
            foreach ($array as $valor){
                echo $valor." Já existe! Lotes Inseridos <br>";
            }
        }
    }
    // header('Location:'.BASEURL.'index.php');
?>