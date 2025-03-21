<?php
    session_start();

    $transacciones = [];

    //Esto inicializq las transacciones en la sesión si no existrn, para eso es el SESSION
    if (!isset($_SESSION['transacciones'])) {
    $_SESSION['transacciones'] = []; //Crea el arreglo en la SESION DE MI PHP practica 3
    }

    //Contador de id de transacciones para que se hagwn automaticamente y no tener que estarlos digitando yO
    if (!isset($_SESSION['contador_id'])) {
        $_SESSION['contador_id'] = 1; 
    }

    $transacciones = &$_SESSION['transacciones']; //Referencia al arreglo en la sesión de mis transacciones

    //Use el comando POST porque quiero que se registren las transacciones cuando el formulario ya haya sido enviado
    if (isset($_POST['registrar'])) { //isset verifica si los campos han sido enviados
    $id = $_SESSION['contador_id']++; //Incrementa el contador para generar un nuevo ID
    $descripcion = $_POST['descripcion'];
    $monto = floatval($_POST['monto']); //El floatval convierte el string a un número decimal

    //Guarda la nueva transacción en el arreglo de la sesión de mi practica 3
    $transacciones[] = [
        "id" => $id,
        "descripcion" => $descripcion,
        "monto" => $monto
    ];
}

    $monto = 0;
    $montoEIntereses = 0;
    $cashback = 0;
    $montoFinal = 0;

    function registrarTransaccion(&$transacciones, $id, $descripcion, $monto) {
        $nuevaTransaccion = [
            "id" => $id,
            "descripcion" => $descripcion,
            "monto" => $monto
        ];
    
        array_push($transacciones, $nuevaTransaccion);
    }

    function generarEstadoDeCuenta($transacciones, &$monto, &$montoEIntereses, &$cashback, &$montoFinal) {
        $monto = 0;
        
        foreach ($transacciones as $transaccion) {
            $monto += $transaccion["monto"];
        }

        $intereses = $monto * 0.026;
        $montoEIntereses = $monto + $intereses;
        $cashback = $monto * 0.001;
        $montoFinal = $montoEIntereses - $cashback;

        return [
            "monto" => $monto,
            "montoEIntereses" => $montoEIntereses,
            "cashback" => $cashback,
            "montoFinal" => $montoFinal
        ];
    }

    $estadoDeCuenta = generarEstadoDeCuenta($transacciones, $monto, $montoEIntereses, $cashback, $montoFinal);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

    <div class = "titulos">
        <h2>Registro de Transacciones</h2>
        <form method="post">
            <input type="text" name="descripcion" placeholder="Descripción" required>
            <input type="number" step="0.01" name="monto" placeholder="Monto" required>
            <button type="submit" name="registrar">Registrar transaccion</button>
        </form>
    </div>

    <div class = "registrar">
        <?php
            if (isset($_POST['registrar'])) {
                $estadoDeCuenta = generarEstadoDeCuenta($transacciones, $monto, $montoEIntereses, $cashback, $montoFinal);
                $archivo = fopen("estado_cuentq.txt", "w"); 
                foreach ($transacciones as $transaccion) {
                    $registrotransaccion = "Id de transacción: " . $transaccion['id'] . 
                    ", Descripción de transacción: " . $transaccion['descripcion'] . 
                    ", Monto de transacción: " . $transaccion['monto'] . "\n";
                    fwrite($archivo, $registrotransaccion);
                }
                $montostransaccion =  "\n\n" .
                "Monto sin intereses: " . $estadoDeCuenta['monto'] . "\n" .
                "Monto con intereses: " . $estadoDeCuenta['montoEIntereses'] . "\n" .
                "Cashback: " . $estadoDeCuenta['cashback'] . "\n" .
                "Monto final a pagar con los interesqs: " . $estadoDeCuenta['montoFinal'] . "\n";
                fwrite($archivo, $montostransaccion);
                fclose($archivo);
                echo "<p>Transaccion registrada exitosamente y guardada en el txt</p>";
            }
        ?>
    </div>
    
    <div class = "transacciones">
        <h2>Estado de Cuenta</h2>
        <table>
            <tr>
                <th>Descripción</th>
                <th>Monto</th>
            </tr>
            <?php
                foreach ($transacciones as $transaccion) {
                    echo "<tr>";
                    echo "<td>" . $transaccion['descripcion'] . "</td>";
                    echo "<td>" . $transaccion['monto'] . "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        </div>

        <div class="impresiones">
            <p>Monto Total de Contado: ₡<?php echo $estadoDeCuenta['monto']; ?></p>
            <p>Monto Total con Interés: ₡<?php echo $estadoDeCuenta['montoEIntereses']; ?></p>
            <p>Cashback: ₡<?php echo $estadoDeCuenta['cashback']; ?></p>
            <p>Monto Final a Pagar: ₡<?php echo $estadoDeCuenta['montoFinal']; ?></p>
        </div>
    
        
</body>
</html>