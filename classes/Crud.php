<?php
    //require_once "config.php";
    require_once ABSPATH."config/Conn.php";
    class Crud extends Conn {

        public function select($col, $tabela, $cond = null, $order = null){
            $this->connUser();
            
            $sql = "SELECT $col FROM $tabela";
            if ($cond !== null) {
                $sql .= " WHERE $cond";
            }
            if ($order !== null) {
                $sql .= " ORDER BY $order";
            }
            return $this->conn->query($sql);
        }
    
        public function insert($tabela, $dados){
            $this->connUser();
    
            if (is_array($dados)) {
                $columns = implode(', ', array_keys($dados));
                $values = "'" . implode("', '", $dados) . "'";
    
                $sql = "INSERT into $tabela ($columns) values ($values)";
            } else {
                $sql = "INSERT into $tabela values (null, '$dados')";
            }
    
            $this->conn->query($sql);
        }
    
        public function update($tabela, $param, $cond){
            $this->connUser();
            $sql = "UPDATE $tabela SET $param WHERE $cond";
            $this->conn->query($sql);
        }
    
        public function delete($tabela, $coluna, $valor){
            $this->connUser();
            $sql = "DELETE FROM $tabela WHERE $coluna = $valor";
            $this->conn->query($sql);
        }
    
        public function call($funcao){
            $this->connUser();
            $sql = "Call $funcao";
            $this->conn->query($sql);
        }
    }
    
?>