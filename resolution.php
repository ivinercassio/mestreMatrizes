
<?php
    include("Matrix.php");

    if (!isset($_POST["row"]) || !isset($_POST["column"]) || !isset($_POST["function"])) 
        header('Location: http://localhost/mestreMatrizes/index.php');

    $row = $_POST["row"];
    $column = $_POST["column"];
    $function = $_POST["function"];

    for ($i=0; $i < $row; $i++) 
        for ($j=0; $j < $column; $j++) { 
            $name = "cell" . $i . "" . $j;
            if(isset($_POST[$name]))
                $matrix[$i][$j] = $_POST[$name];
        }

    $objMatrix = new Matrix($column, $row);
    if($matrix != null)
        $objMatrix->receberMatriz($matrix);

    if(isset($_POST["row2"]) && isset($_POST["column2"])){
        $row2 = $_POST["row2"];
        $column2 = $_POST["column2"];

        $matrix = null;
        for ($i=0; $i < $row2; $i++) 
            for ($j=0; $j < $column2; $j++) { 
                $name = "cell2" . $i . "" . $j;
                if(isset($_POST[$name]))
                    $matrix[$i][$j] = $_POST[$name];
            }

        $objMatrix2 = new Matrix($column2, $row2);
        if($matrix != null)
            $objMatrix2->receberMatriz($matrix);
    }

?>

<!DOCTYPE html>
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

        <table align='center' class='mt-5'>
            <tbody>
            <?php
                if(isset($matrix)){
                    for ($i=0; $i < $row; $i++) { 
                        echo "<tr>";
                        for ($j=0; $j < $column; $j++) 
                            echo "<td><input class='form-control disabled' type='number' value='{$objMatrix->getMatrix()[$i][$j]}' disabled></td>";
                        echo "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>
        <?php
            if (isset($column2) && isset($row2)) {
                echo "<br><br>
                <table align='center'>
                <tbody>";
                for ($i=0; $i < $row2; $i++) { 
                    echo "<tr>";
                    for ($j=0; $j < $column2; $j++) 
                        echo "<td><input class='form-control disabled' type='number' value='{$objMatrix2->getMatrix()[$i][$j]}' disabled></td>";
                    echo "</tr>";
                }
                echo "</tbody>
                </table>";
            }
        ?>

        <form action="" method="post">
            <h5>Resultado:</h5>
            <h3 class="text-center">
                <?php
                    switch ($function) {
                        case "E":
                            echo "Matriz Escalonada";
                            break;
                        case "GJ":
                            echo "Matriz Reduzida por Gauss-Jordan";
                            break;
                        case "A":
                            echo "Matriz Soma Calculada";
                            break;
                        case "M":
                            echo "Matriz Produto Calculada";
                            break;
                    }
                ?>
            </h3>

            <table align="center" class="mt-5">
                <tbody>
                <?php
                    $answer = $objMatrix->isEmpty();
                    if($answer){
                        echo "<div id='alertMsg' class='alert text-center' role='alert'>
                            <span>
                                <b>Ops! A matriz está vazia ou nula</b><br>
                                Tente novamente
                            </span>
                        </div>";
                    }else{
                        switch ($function) {
                            case "E":
                                for ($i=0; $i < $row; $i++) 
                                    $objMatrix->escalonarMatriz($i);
                                break;
                            case "GJ":
                                for ($i=0; $i < $row; $i++) 
                                    $objMatrix->escalonarMatriz($i);
                                $objMatrix->reduzirMatrizPorLinhas();
                                break;
                            case "A":
                                // estah dando erro dentro da funcao ADDITION
                                $answer = $objMatrix->addition($objMatrix->getMatrix(), $objMatrix2->getMatrix());
                                break;
                            case "M":
                                $answer = $objMatrix->multiplication($objMatrix->getMatrix(), $objMatrix2->getMatrix());
                                break;
                        }
                        
    
                        if($function == "A" || $function == "M")
                            for ($i=0; $i < $answer->getRow(); $i++) { 
                                echo "<tr>";
                                for ($j=0; $j < $answer->getColumn(); $j++) 
                                    echo "<td><input class='form-control disabled' type='number' value='{$answer->getMatrix()[$i][$j]}' disabled></td>";
                                echo "</tr>";
                            }
                        else
                            for ($i=0; $i < $row; $i++) { 
                                echo "<tr>";
                                for ($j=0; $j < $column; $j++) 
                                        echo "<td><input class='form-control disabled' type='number' name='{$name}' id='{$name}' value='{$objMatrix->getMatrix()[$i][$j]}' disabled></td>";
                                echo "</tr>";
                            }
                        
                    }
                ?>
                </tbody>
            </table>

            <div class='row'>
                <div>
                    <!-- ALTERAR DEPOIS PARA O VOLTAR NAO APAGAR A MATRIZ -->
                    <a class='rounded-pill btn btn-outline-info mt-5 btnGoToBack' href='http://localhost/mestreMatrizes/'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 16 16'>
                            <path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8'/>
                        </svg>
                    </a>
                    <a class='rounded-pill btn btn-outline-info mt-5 btnOk' href='http://localhost/mestreMatrizes/'>Pronto</a>
                </div>
            </div>

            
        </form>
    
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
    crossorigin="anonymous"></script>
</html>