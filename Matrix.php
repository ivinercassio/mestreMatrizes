<?php
    class Matrix {

        private $column;
        private $row;
        private $matrix;

        // initialize the object
        public function __construct($column, $row){
            $this->column = $column;
            $this->row = $row;
            $this->matrix = null;
        }

        // the class's methods
        public function receberMatriz($matrix){
            if(isset($matrix)){
                $this->matrix = $matrix;
                return true;
            }
            return false;
        }

        public function isEmpty(){
            for ($i=0; $i < $this->row; $i++) { 
                for ($j=0; $j < $this->column; $j++) { 
                    if ($this->matrix[$i][$j] != 0) {
                        return false;
                    }
                }
            }
            return true;
        }

        public function escalonarMatriz($reference){ // reference row
            // every time the funciton is started, it is need to check whether the column has been summed to 1
            // if so, 'reference' must also be added to 1
            $linhaPivo = $this->encontrarPivo($reference); 
            if($linhaPivo != -1) 
                $this->trocarLinhas($linhaPivo, $reference);
            else
                $this->forcarPivo($reference, $reference);
            $linhaPivo = $reference;
            $this->zerarLinhasAbaixo($linhaPivo, $reference);
        }

        private function encontrarPivo($reference){ // reference column
            for ($i = $reference; $i < $this->row; $i++)
                if($this->matrix[$i][$reference] == 1)
                    return $i;
            return -1;
        }
    
        private function trocarLinhas($from, $to){ // 'from' is the pivot's row
            if($from == 0)
                return;
            for ($j = 0; $j < $this->row; $j++) {
                $auxiliar = $this->matrix[$from][$j];                
                $this->matrix[$from][$j] = $this->matrix[$to][$j];
                $this->matrix[$to][$j] = $auxiliar;
            }
        }
    
        private function forcarPivo($row, $column) { // it means the position where the pivot is waited
            $divisor = $this->matrix[$row][$column];
            if ($divisor == 0 && ($column+1) < $this->column) {
                // O PROBLEMA ESTAH AQUI. A FUNCAO PULA PARA A PROXIMA COLUNA CORRETAMENTE,
                // MAS NAO AVISA O RESTANTE DO CODIGO. FAZENDO APARECER DOIS PIVOS NA MESMA COLUNA
                forcarPivo($row, ($column+1)); // search the pivot on the next column
            }
            else if ($divisor == 0) // caso o elemento seja nulo na ultima coluna
                    return;
                else
                    for ($j = $column; $j < $this->column; $j++) 
                        $this->matrix[$row][$j] /= $divisor;
        }

        private function zerarLinhasAbaixo($linhaPivo, $column){ // linhaPivo: this function works below it
            if(($linhaPivo+1) == $this->row || ($column+1) == $this->column) 
                return; // when is searching at the end of the matrix
    
            $repeat = (count($this->matrix)-1) - $linhaPivo;
    
            for ($i = 1; $i <= $repeat; $i++) {
                $fator = $this->matrix[$linhaPivo+$i][$column];
                for ($j = 0; $j < $this->column; $j++) 
                    $this->matrix[$linhaPivo+$i][$j] -= ($fator * $this->matrix[$linhaPivo][$j]);                
            }
        }

        public function reduzirMatrizPorLinhas(){
            $column = $this->posicaoUltimoPivo($this->row-1);
            if ($column >= 0)
                for ($i = $column; $i > 0; $i--) // 2 , 1 
                    $this->zerarLinhasAcima($i);
        }
    
        private function posicaoUltimoPivo($linha){
            for ($i = 0; $i < $this->column; $i++)
                if($this->matrix[$linha][$i] == 1)
                    return $i;
            return $this->posicaoUltimoPivo($linha-1);
        }
    
        private function zerarLinhasAcima($position){ // this is the pivot's position on the matrix's columns
            $repeat = $this->column - $position; // ==  vai repetir 1 , 2
            //              3           2 , 1
            for ($i = 0; $i < $repeat; $i++) { 
                $fator = $this->matrix[$position-1][$position]; 
                echo "<br> ----------- 1° for ----------- <br>"; 
                
                for ($j = $position-1; $j < $this->column; $j++){
                    echo "estou no for <br>"; 
                    var_dump($fator); echo "<br>";
                    $this->matrix[$position-1][$j] -= ($fator * $this->matrix[$position][$j]);
                }
                // for ($j = 0; $j < $this->column; $j++) 
                //     $this->matrix[$position-1][$j] -= ($fator * $this->matrix[$position][$j]);
            }
        }

        // getters and setters
        public function getMatrix(){
            return $this->matrix;
        }
    }
?>