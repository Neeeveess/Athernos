<?php
    //require_once "config.php";
    require_once ABSPATH."config/Conn.php";
    class Crud extends Conn {

        public function select($col, $tabela, $cond = null,$order = null){
            $this->connUser();
            if ($cond != null){
                if ($order != null){
                    $sql = "SELECT $col FROM $tabela WHERE $cond ORDER BY $order";
                    // echo "SELECT $col FROM $tabela WHERE $cond ORDER BY $order";                    
                }else{
                    $sql = "SELECT $col FROM $tabela WHERE $cond";
                    // echo  "SELECT $col FROM $tabela WHERE $cond";
                }
            }else{
                $sql = "SELECT $col FROM $tabela";
                // echo  "SELECT $col FROM $tabela";
            }         
            return $this->conn->query($sql);
            echo $this->conn->query($sql);
        }

        public function insert($tabela, $dados){
            $this->connUser();
            $col = "";
            $val = "";

            if(is_array($dados)){

                foreach($dados as $chave => $valor ){
                    $col .= $chave . ",";
                    $val .= "'".$valor . "',";
                }
                //id,nome,email,senha,nivel,
                $col = rtrim($col, ",");
                $val = rtrim($val, ",");
    
                $sql = "INSERT into $tabela ($col) values ($val)";
                $this->conn->query($sql);
            }else{
                $sql = "INSERT into $tabela values (null, '$dados')";                
                       
                $this->conn->query($sql);                
            }
        }

        public function update($tabela,$param,$cond){
            $this->connUser();
            $sql = "UPDATE $tabela SET $param WHERE $cond";
            $this->conn->query($sql);
        }

        public function delete($tabela, $coluna, $valor){
            $this->connUser();
            $sql = "DELETE FROM $tabela WHERE $coluna = $valor";
            $this->conn->query($sql);
        }
    }
?>