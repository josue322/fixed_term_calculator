<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Calculadora Depósito a Plazo Fijo</title>
</head>

<body>
    <!--Header inicio de la pagina-->
    <header>
        <h1>CALCULADORA DE PLAZO FIJO</h1>
    </header>

    <div class="contenido">
        <strong>
                Calculadora basica que genera informacion y ganancias de un plazo fijo.
        </strong>
    </div>

    <div class="container">

        <!--formulario para la entrada de datos-->
        <form action="" method="POST" class="formulario">
            <label for="monto">Ingrese monto</label><br>
            <input type="number" name="monto" id="monto" step="0.01" required><br><br>

            <label for="moneda">Tipo de moneda</label><br>
            <select name="moneda" id="moneda" required>
                <option value="">Seleccione</option>
                <option value="soles">Sol Peruano</option>
            </select><br><br>

            <label for="plazo">Plazo</label><br>
            <select name="plazo" id="plazo" required>
                <option value="">Seleccione</option>
                <option value="1">1 Año</option>
                <option value="2">2 Años</option>
                <option value="3">3 Años</option>
                <option value="4">4 Años</option>
                <option value="5">5 Años</option>
                <option value="6">6 Años</option>
                <option value="7">7 Años</option>
                <option value="8">8 Años</option>
                <option value="9">9 Años</option>
                <option value="10">10 Años</option>
            </select><br><br>

            <label for="fecha">Fecha</label><br>
            <input type="date" name="fecha" id="fecha" required><br><br>

            <input type="submit" value="Calcular" class="boton">
        </form>

        <!--Inicio de la logica con PHP-->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $monto = $_POST["monto"];
            $moneda = $_POST["moneda"];
            $plazo = $_POST["plazo"];
            $fecha = $_POST["fecha"];

            // Calculando la tasa de interés
            $tasaInteres = calcularTasaInteres($monto, $plazo);

            // Realizando los cálculos
            $intereses = $monto * $tasaInteres * $plazo;
            $montoTotal = $monto + $intereses;
            $fechaVencimiento = date('Y-m-d', strtotime($fecha . "+$plazo years"));


            // Construccion el resultado
            echo "<h2>Resultados de su Ahorro</h2>";
            echo "<p>MONTO :  " . "<br>" . number_format($monto, 0, '.', ' ') . " " . $moneda . "</p>";
            echo "<p>PLAZO :  " . "<br>" . $plazo . " años</p>";
            echo "<p>FECHA :  " . "<br>" . $fecha . "</p>";
            echo "<p>TASA DE INTERES :  " . "<br>" . number_format($tasaInteres * 100, 0) . "%</p>";
            echo "<p>INTERESES GENERADOS :  " . "<br>" . number_format($intereses, 0, '.', ' ') . " " . $moneda . "</p>";
            echo "<p>MONTO TOTAL AL VENCIMIENTO :  " . "<br>" . number_format($montoTotal, 0, '.', ' ') . " " . $moneda . "</p>";
            echo "<p>FECHA DE VENCIMIENTO :  " . "<br>" . $fechaVencimiento . "</p>";
        }

        // Calculando la tasa de interés según el monto y el plazo
        function calcularTasaInteres($monto, $plazo)
        {
            $tasasInteres = [
                1 => 0.06,
                // Tasa de interés del 6% para 1 año
                2 => 0.08,
                // Tasa de interés del 8% para 2 años
                3 => 0.09,
                // Tasa de interés del 9% para 3 años
                4 => 0.09,
                // Tasa de interés del 9% para 4 años
                5 => 0.1,
                // Tasa de interés del 10% para 5 años
                6 => 0.1,
                // Tasa de interés del 10% para 6 años
                7 => 0.1,
                // Tasa de interés del 10% para 7 años
                8 => 0.1,
                // Tasa de interés del 10% para 8 años
                9 => 0.1,
                // Tasa de interés del 10% para 9 años
                10 => 0.1 // Tasa de interés del 10% para 10 años
            ];

            if ($plazo >= 1 && $plazo <= 10) {
                return $tasasInteres[$plazo];
            } else {
                return 0.0; // Tasa de interés por defecto si el plazo no está dentro del rango válido
            }
        }


        // Generando tabla con los pagos por año
        if (isset($monto) && isset($plazo)) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Año</th>";
            echo "<th>Fecha de Pago</th>";
            echo "<th>Capital</th>";
            echo "<th>Interés Anual</th>";
            echo "<th>Total</th>";
            echo "</tr>";

            $capital = $monto;
            for ($i = 1; $i <= $plazo; $i++) {
                $interesAnual = $monto * $tasaInteres;
                $total = $capital + $interesAnual;

                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . date('d-m-Y', strtotime($fecha . ' + ' . $i . ' year')) . "</td>";
                echo "<td>S/ " . number_format($monto, 0, '.', ' ') . "</td>";
                echo "<td>S/ " . number_format($interesAnual, 0, '.', ' ') . "</td>";
                echo "<td>S/ " . number_format($total, 0, '.', ' ') . "</td>";
                echo "</tr>";
                $capital += $interesAnual;
            }
        }
        echo "</table>";

        ?>
    </div>

</body>

</html>