<?php
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
                echo "<form action='' method='POST'>";
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
                    <label class="form-label" for="column">Nº Colunas</label>
                    <input class="form-control" type="number" name="column" id="column" min="1" value="<?php echo $column?>">
                </div>
                <div class="col">
                    <label class="form-label" for="row">Nº Linhas</label>
                    <input class="form-control" type="number" name="row" id="row" min="1" value="<?php echo $row?>">
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
                            <label class='form-label' for='column'>Nº Colunas</label>
                            <input class='form-control' type='number' name='column' id='column' min='1' value='{$column2}'>
                        </div>
                        <div class='col'>
                            <label class='form-label' for='row'>Nº Linhas</label>
                            <input class='form-control' type='number' name='row' id='row' min='1' value='{$row2}'>
                        </div>
                    </div>";
                }else{
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
                }

                echo "<div class='row'>
                    <div>
                        <a class='rounded-pill btn btn-outline-info mt-5 btnGoToBack' href='http://localhost/sitematrizes/'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 16 16'>
                                <path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8'/>
                            </svg>
                        </a>
                        <button class='rounded-pill btn btn-outline-info mt-5 btnOk' type='submit'>OK</button>
                    </div>
                </div>";
            }
            ?>
            
        </form>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
    crossorigin="anonymous"></script>
</html>