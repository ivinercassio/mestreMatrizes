
<?php
    $row = $_POST["row"];
    $column = $_POST["column"];

    if(isset($_POST["row2"]) && isset($_POST["column2"])){
        $row2 = $_POST["row2"];
        $column2 = $_POST["column2"];
    }

    for ($i=0; $i < $row; $i++) { 
        for ($j=0; $j < $column; $j++) { 
            $name = "cell" . $i . "" . $j;
            $matrix[$i][$j] = $_POST[$name];
        }
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
                for ($i=0; $i < $row; $i++) { 
                    echo "<tr>";
                    for ($j=0; $j < $column; $j++) { 
                        echo "<td><input class='form-control' type='number' name='{$name}' id='{$name}' value='{$matrix[$i][$j]}' disabled></td>";
                    }
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>";
    
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
    crossorigin="anonymous"></script>
</html>