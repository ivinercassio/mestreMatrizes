<?php
    include("Matrix.php");

    $function = "";    
    $column = "";
    $row = "";
    $column2 = "";
    $row2 = "";
    $firstTime = true;  

    if(isset($_POST["function"]) && isset($_POST["column"]) && isset($_POST["row"])){
        $function = $_POST["function"];    
        $column = $_POST["column"];
        $row = $_POST["row"];
        $firstTime = false;
    }

    if (isset($_POST['column2']) && isset($_POST['row2'])) {
        $column2 = $_POST['column2'];
        $row2 = $_POST['row2'];
    }
?>

<html>
    <head>
        <title>Mestre Matrizes</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="background.jpg" type="image/x-icon">
        <link rel="stylesheet" href="styles.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
        crossorigin="anonymous">
    </head>
    <body>
        <div>
            <h1>Mestre Matrizes</h1>
            <h5> Escalonamento | Método de Gauss-Jordan | Operações Elementares</h5>
        </div>

        <?php 
            if(($function == "E" || $function == "GJ") && !$firstTime){
                echo "<form action='resolution.php' method='POST'>";
            }else{
                echo "<form action='' id='formIndex' method='POST'>";
            }   
        ?>
            <div class="row">
                <div class="col">
                    <label class="form-label" for="function">O Que Deseja Calcular</label>
                    <?php
                        $vetor = [
                            "E" => "Escalonamento", 
                            "GJ" => "Gauss-Jordan", 
                            "A" => "Adição de Matrizes", 
                            "M" => "Multiplicação de Matrizes"
                        ];

                        if($firstTime){
                            echo "<select class='form-select' name='function' id='function'>
                                <option value='' disabled selected>Escolha uma opção</option>";
                            foreach($vetor as $value => $texto){
                                echo "<option value='{$value}'>{$texto}</option>";
                            }
                            echo "</select>";
                        }else{
                            echo "<select class='form-select' name='function' id='function'>";
                            foreach($vetor as $value => $texto){
                                if($function == $value){
                                    echo "<option value='{$value}' selected>{$texto}</option>";
                                }else{
                                    echo "<option value='{$value}'>{$texto}</option>";
                                }
                            }
                            echo "</select>";
                        }
                    ?>
                </div>

                <div class="col">
                    <label class="form-label" for="row">Nº Linhas</label>
                    <input class="form-control" type="number" name="row" id="row" min="1" value="<?php echo $row?>" required>
                </div>
                <div class="col">
                    <label class="form-label" for="column">Nº Colunas</label>
                    <input class="form-control" type="number" name="column" id="column" min="1" value="<?php echo $column?>" required>
                </div>
            </div>

            <?php
            if($firstTime){
                echo "<div class='mt-5 text-center'>
                    <button class='rounded-pill btn btn-outline-warning' type='submit'>Iniciar</button>
                </div>";
            }else{
                if($function == "A" || $function == "M"){
                    echo "
                    <div class='row mt-3'>
                        <div id='hiddenBox' class='col'></div>
                        <div class='col'>
                            <label class='form-label' for='row2'>Nº Linhas</label>
                            <input class='form-control' type='number' name='row2' id='row2' min='1' value='{$row2}' required>
                        </div>
                        <div class='col'>
                            <label class='form-label' for='column2'>Nº Colunas</label>
                            <input class='form-control' type='number' name='column2' id='column2' min='1' value='{$column2}' required>
                        </div>
                    </div>";

                    if ($column2 == "" && $row2 == "") {
                        echo "<div class='row'>
                        <div>
                            <a class='rounded-pill btn btn-outline-info mt-5 btnGoToBack' href='http://localhost/mestreMatrizes/'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 16 16'>
                                    <path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8'/>
                                </svg>
                            </a>
                                <button id='submit' class='rounded-pill btn btn-outline-info mt-5 btnOk' type='submit'>OK</button>
                            </div>
                        </div>";
                    }else{
                        // VALIDANDO A SOMA OU MULTIPLICACAO E PREENCHENDO AS MATRIZES
                        $objMatrix = new Matrix($column, $row);
                        $objMatrix2 = new Matrix($column2, $row2);

                        if (($objMatrix->canAdditionMatrix($objMatrix2) && $function == "A") || ($objMatrix->canMultiplicationMatrix($objMatrix2) && $function == "M")) {
                            // first matrix
                            for ($i=0; $i < $row; $i++) 
                                for ($j=0; $j < $column; $j++) 
                                    $matrix[$i][$j] = 0;
                            $objMatrix->receberMatriz($matrix);

                            echo "<table align='center' class='mt-5'>
                            <tbody>";
                            for ($i=0; $i < $row; $i++) { 
                                echo "<tr>";
                                for ($j=0; $j < $column; $j++) { 
                                    $name = "cell" . $i . "" . $j;
                                    echo "<td><input class='form-control' type='number' name='{$name}' id='{$name}' value='{$objMatrix->getMatrix()[$i][$j]}'></td>";
                                }
                                echo "</tr>";
                            }
                            echo "</tbody>
                            </table>";
                            // second matrix
                            for ($i=0; $i < $row2; $i++) 
                                for ($j=0; $j < $column2; $j++) 
                                    $outher[$i][$j] = 0;
                            $objMatrix2->receberMatriz($outher);

                            echo "<table align='center' class='mt-5'>
                            <tbody>";
                            for ($i=0; $i < $row2; $i++) { 
                                echo "<tr>";
                                for ($j=0; $j < $column2; $j++) { 
                                    $name = "cell2" . $i . "" . $j; // outros id's
                                    echo "<td><input class='form-control' type='number' name='{$name}' id='{$name}' value='{$objMatrix2->getMatrix()[$i][$j]}'></td>";
                                }
                                echo "</tr>";
                            }
                            echo "</tbody>
                            </table><br><br>";

                            // BTN to RESOLUTION page
                            echo "<div class='row'>
                            <div>
                                <a class='rounded-pill btn btn-outline-info mt-5 btnGoToBack' href='http://localhost/mestreMatrizes/'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 16 16'>
                                        <path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8'/>
                                    </svg>
                                </a>
                                    <button id='submit' class='rounded-pill btn btn-outline-info mt-5 btnOk' type='button' onclick='AddActionForm()'>OK</button>
                                </div>
                            </div>";
                        }else{
                            echo "<div id='alertMsg' class='alert text-center' role='alert'>
                                <span>
                                    <b>Ops! Essa operação não pode ser realizada...</b><br>
                                    <i>Regra da Adição de Matrizes:</i> as matrizes devem apresentar o mesmo número de linhas e colunas<br>
                                    <i>Regra da Multiplicação de Matrizes:</i> o número de colunas da 1° matriz deve ser igual ao número de linhas da 2° matriz<br>
                                    Tente novamente
                                </span>
                            </div>";
                            
                            echo "<div class='row'>
                            <div>
                                <a class='rounded-pill btn btn-outline-info mt-5 btnGoToBack' href='http://localhost/mestreMatrizes/'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 16 16'>
                                        <path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8'/>
                                    </svg>
                                </a>
                                    <button id='submit' class='rounded-pill btn btn-outline-info mt-5 btnOk' type='submit'>OK</button>
                                </div>
                            </div>";
                        }
                        
                    }

                }else{
                    // MATRIZ NOS CASOS DE SER ESCALONAMENTOS
                    for ($i=0; $i < $row; $i++) { 
                        for ($j=0; $j < $column; $j++) { 
                            $matrix[$i][$j] = 0;
                        }
                    }

                    echo "<table align='center' class='mt-5'>
                    <tbody>";
                    for ($i=0; $i < $row; $i++) { 
                        echo "<tr>";
                        for ($j=0; $j < $column; $j++) { 
                            $name = "cell" . $i . "" . $j;
                            echo "<td><input class='form-control' type='number' name='{$name}' id='{$name}' value='{$matrix[$i][$j]}'></td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tbody>
                    </table>";

                    echo "<div class='row'>
                    <div>
                        <a class='rounded-pill btn btn-outline-info mt-5 btnGoToBack' href='http://localhost/mestreMatrizes/'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8'/>
                            </svg>
                        </a>
                            <button id='submit' class='rounded-pill btn btn-outline-info mt-5 btnOk' type='submit'>OK</button>
                        </div>
                    </div>";
                }
            }
            ?>
            
        </form>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
    crossorigin="anonymous"></script>
    <script src="script.js"></script>
</html>

<!-- 
    * EM ADICAO/MULTIPLICACAO, QUANDO O N DE COLUNAS E DE LINHAS DAS MATRIZES NAO SAO IGUAIS, ELE NAO DAH UMA MENSAGEM DE ERRO, NEM ACEITA A CORRECAO
    * QUANDO O N DE COLUNAS OU LINHAS EH NULL, ELE ACUSA ERRO E MOSTRA A MENSAGEM DE MATRIZ VAZIA
    * NA PAGINA RESOLUTION.PHP MUDAR O BOTAO VOLTAR PARA NAO APAGAR A MATRIZ PREENCHIDA // TALVEZ SEPARAR EM DUAS PAGINAS
-->