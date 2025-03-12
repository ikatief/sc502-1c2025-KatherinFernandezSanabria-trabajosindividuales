<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacciones Crédito</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<div class="container">
    <h2>Registro de Transacciones</h2>

    <form method="post">
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <input type="number" step="0.01" name="monto" placeholder="Monto" required>
        <button type="submit" name="registrar">Registrar transacción</button>
    </form>

    <?php
    //Este comando inicia la sesión del php en xamp en la carpeta htdocs
    session_start();

    //Use el comando SESSION porque ocupo que las transacciones se guarden en la sesión, es decir que no se borren
    if (!isset($_SESSION['transacciones'])) {
        $_SESSION['transacciones'] = [];
    }

    function registrarTransaccion($descripcion, $monto) {
        global $_SESSION;
        $id = count($_SESSION['transacciones']) + 1;
        $_SESSION['transacciones'][] = [
            'id' => $id,
            'descripcion' => $descripcion,
            'monto' => $monto
        ];
    }

    //El comando POST es para que se pueda registrar la transacción
    if (isset($_POST['registrar'])) {
        registrarTransaccion($_POST['descripcion'], $_POST['monto']);
    }

    function generarEstadoDeCuenta() {
        global $_SESSION;
        $transacciones = $_SESSION['transacciones'];
        $montoContado = 0;

        foreach ($transacciones as $transaccion) {
            $montoContado += $transaccion['monto'];
        }

        $interes = $montoContado * 0.026;
        $montoConInteres = $montoContado + $interes;
        $cashback = $montoContado * 0.001;
        $montoFinal = $montoConInteres - $cashback;

        //Mostrar lo de la tarjeta de crédito en un txt
        echo "<h2>Estado de Cuenta</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Descripción</th><th>Monto</th></tr>";
        foreach ($transacciones as $transaccion) {
            echo "<tr><td>{$transaccion['id']}</td><td>{$transaccion['descripcion']}</td><td>$" . number_format($transaccion['monto'], 2) . "</td></tr>";
        }
        echo "</table>";

        echo "<div class='summary'>";
        echo "<p>Monto Total de Contado: $" . number_format($montoContado, 2) . "</p>";
        echo "<p>Monto Total con Interés (2.6%): $" . number_format($montoConInteres, 2) . "</p>";
        echo "<p>Cashback (0.1%): $" . number_format($cashback, 2) . "</p>";
        echo "<p>Monto Final a Pagar: $" . number_format($montoFinal, 2) . "</p>";
        echo "</div>";

        $archivo = "estado_cuenta.txt";
        $contenido = "Estado de Cuenta\n";
        $contenido .= "----------------------\n";
        foreach ($transacciones as $transaccion) {
            $contenido .= "ID: {$transaccion['id']} - {$transaccion['descripcion']} - $" . number_format($transaccion['monto'], 2) . "\n";
        }
        $contenido .= "\nMonto Total de Contado: $" . number_format($montoContado, 2);
        $contenido .= "\nMonto con Interés (2.6%): $" . number_format($montoConInteres, 2);
        $contenido .= "\nCashback (0.1%): $" . number_format($cashback, 2);
        $contenido .= "\nMonto Final a Pagar: $" . number_format($montoFinal, 2);

        //ya se guarda el contenido de las transacciones en un txt pero esto lo añadí para que
        //el usuario, si gusta, lo descargue y guarde en otra carpeta de su preferencia
        file_put_contents($archivo, $contenido);
        echo "<a class='download-link' href='$archivo' download>Descargar Estado de Cuenta</a>";
    }

    if (!empty($_SESSION['transacciones'])) {
        generarEstadoDeCuenta();
    }
    ?>

</div>

</body>
</html>
