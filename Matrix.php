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

        // public functions

        public function receberMatriz($matrix){
            if(isset($matrix)){
                $this->matrix = $matrix;
                return true;
            }
            return false;
        }

        public function isEmpty(){
            if($this->matrix == null)
                return true;
            for ($i=0; $i < $this->row; $i++) 
                for ($j=0; $j < $this->column; $j++) 
                    if ($this->matrix[$i][$j] != 0) 
                        return false;
            return true;
        }
        
        public function _addition($outher){
            $answer = __construct($this->column, $this->row);
            for ($i=0; $i < $this->row; $i++) 
                for ($j=0; $j < $this->column; $j++) 
                    $answer = $this->matrix[$i][$j] + $outher->getMatrix()[$i][$j];
            return $answer;
        }

        public function canAdditionMatrix($outher){
            if ($this->matrix == null || $outher == null)
                return false;
            if($this->row == $outher->getRow() && $this->column == $outher->getColumn())
                return true;
            return false;
        }
        
        private function multiplication($outher){
            /* TRADURIR O CODIGO DE PYTHON PARA PHP
            
            for linhaResposta in range(2):
                for colunaResposta in range(3):
                    value = 0
                    for colunaPrimeira in range(2):
                        value = value + (primeira[linhaResposta][colunaPrimeira] * segunda[colunaPrimeira][colunaResposta])
                    terceira[linhaResposta][colunaResposta] = value
            */
        }

        public function canMultiplicationMatrix($outher){
            if($this->matrix == null || $outher == null)
                return false;
            if($this->row == $outher->getColumn())
                return true;
            return false;
        }

        public function escalonarMatriz($reference){ // reference row
            $linhaPivo = $this->encontrarPivo($reference); 
            if($linhaPivo != -1) 
                $this->trocarLinhas($linhaPivo, $reference);
            else
                $this->forcarPivo($reference, $reference);
            $linhaPivo = $reference;
            $this->zerarLinhasAbaixo($linhaPivo, $reference);
        }

        // private functions

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

        private function forcarPivo($row, $coluna) { // it means the position where the pivot is waited
            $column = $this->column;
            $divisor = $this->matrix[$row][$coluna];
            if($divisor == 0){
                $position = $this->buscarElementoNaoNulo($coluna);
                if ($position != -1) {
                    $this->trocarLinhas($position, $row);
                    forcarPivo($row, $coluna);
                }else if (($coluna+1) < $column) 
                    forcarPivo($row, ($coluna+1));
            }else{
                for ($i= $coluna; $i < $column; $i++)
                    $this->matrix[$row][$i] /= $divisor;
                $this->zerarLinhasAbaixo($row, $coluna);
            }
        }

        private function buscarElementoNaoNulo($column){
            for ($i = $column; $i < $this->row; $i++)
                if($this->matrix[$i][$column] != 0)
                    return $i;
            return -1;
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
            $position = $this->posicaoUltimoPivo($this->row-1);
            if ($position[1] >= 1)
                for ($i= $position[1]; $i > 0; $i--) {
                    $this->zerarLinhasAcima($position[0], $i);
                    $position[0]--;
                }
        }

        private function posicaoUltimoPivo($linha){
            for ($i = 0; $i < $this->column; $i++)
                if($this->matrix[$linha][$i] == 1){
                    $position = [$linha, $i];
                    return $position;
                }
            return $this->posicaoUltimoPivo($linha-1);
        }

        private function zerarLinhasAcima($linha, $coluna){ // this is the pivot's position on the matrix's columns
            $column = $this->column;
            for ($i=1; $i <= $coluna; $i++) { 
                $fator = $this->matrix[$coluna-$i][$coluna];
                for ($j=0; $j < $column; $j++) 
                    $this->matrix[$coluna-$i][$j] -= ($fator * $this->matrix[$coluna][$j]); 
                    
            }
        }

        // getters and setters
        public function getMatrix(){
            return $this->matrix;
        }

        public function getColumn(){
            return $this->column;
        }
    }
?>