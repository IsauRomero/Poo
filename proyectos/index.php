<?php

require __DIR__ . "/vendor/autoload.php";

session_start();

use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Laptop;
use App\Models\Proyector;
use App\Services\ReservaService;
use App\Utils\SinExistenciasException;

$error = "";
$reserva = null;

if (!isset($_SESSION["equipos"])) {

    $_SESSION["equipos"] = [

        "laptop" =>
        new Laptop(
            "Laptop",
            5.00,
            5
        ),

        "proyector" =>
        new Proyector(
            "Proyector",
            7.00,
            3
        )
    ];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $nombre =
            trim($_POST["nombre"] ?? "");

        $correo =
            trim($_POST["correo"] ?? "");

        $tipo =
            $_POST["tipo"] ?? "";

        $equipoSeleccionado =
            $_POST["equipo"] ?? "";

        $cantidad =
            (int)($_POST["cantidad"] ?? 0);

        $horas =
            (int)($_POST["horas"] ?? 0);


        if ($nombre === "") {

            throw new InvalidArgumentException(
                "Ingrese el nombre."
            );
        }


        if (!filter_var(
            $correo,
            FILTER_VALIDATE_EMAIL
        )) {

            throw new InvalidArgumentException(
                "Correo inválido."
            );
        }


        $usuario = match ($tipo) {

            "estudiante" =>
            new Estudiante(
                $nombre,
                $correo
            ),

            "docente" =>
            new Docente(
                $nombre,
                $correo
            ),

            default =>
            throw new InvalidArgumentException(
                "Tipo de usuario inválido."
            )
        };


        if (!isset(
            $_SESSION["equipos"][$equipoSeleccionado]
        )) {

            throw new InvalidArgumentException(
                "Equipo inválido."
            );
        }


        $equipo =
            $_SESSION["equipos"][$equipoSeleccionado];


        $servicio =
            new ReservaService();


        $reserva =
            $servicio->reservar(
                $usuario,
                $equipo,
                $cantidad,
                $horas
            );


        $_SESSION["reservas"][] =
            $reserva;
    } catch (
        SinExistenciasException |
        InvalidArgumentException $e
    ) {

        $error =
            $e->getMessage();
    }
}
?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Préstamo de equipos
    </title>

</head>

<body>

    <h1>
        Sistema de préstamo
    </h1>


    <?php if ($error): ?>

        <p>
            <?= htmlspecialchars($error) ?>
        </p>

    <?php endif; ?>


    <form method="POST">

        <label>
            Nombre:
        </label>

        <input
            type="text"
            name="nombre"
            required>

        <br><br>


        <label>
            Correo:
        </label>

        <input
            type="email"
            name="correo"
            required>

        <br><br>


        <label>
            Tipo:
        </label>

        <select name="tipo">

            <option value="estudiante">
                Estudiante
            </option>

            <option value="docente">
                Docente
            </option>

        </select>

        <br><br>


        <label>
            Equipo:
        </label>

        <select name="equipo">

            <option value="laptop">
                Laptop
            </option>

            <option value="proyector">
                Proyector
            </option>

        </select>

        <br><br>


        <label>
            Cantidad:
        </label>

        <input
            type="number"
            name="cantidad"
            min="1"
            required>

        <br><br>


        <label>
            Horas:
        </label>

        <input
            type="number"
            name="horas"
            min="1"
            required>

        <br><br>


        <button type="submit">
            Reservar
        </button>

    </form>


    <?php if ($reserva): ?>

        <hr>

        <h2>
            Comprobante
        </h2>


        <p>
            Usuario:

            <?= htmlspecialchars(
                $reserva
                    ->getUsuario()
                    ->getNombre()
            ) ?>
        </p>


        <p>
            Equipo:

            <?= htmlspecialchars(
                $reserva
                    ->getEquipo()
                    ->getNombre()
            ) ?>
        </p>


        <p>
            Cantidad:

            <?= $reserva->getCantidad() ?>
        </p>


        <p>
            Horas:

            <?= $reserva->getHoras() ?>
        </p>


        <p>
            Subtotal:

            $<?= number_format(
                    $reserva->getTotal(),
                    2
                ) ?>
        </p>


        <p>
            Descuento:

            <?= number_format(
                $reserva->getDescuento(),
                0
            ) ?>%
        </p>


        <p>
            Total:

            $<?= number_format(
                    $reserva->getTotal(),
                    2
                ) ?>
        </p>


        <p>
            Fecha:

            <?= $reserva->getFecha() ?>
        </p>


        <p>
            Estado:

            <?= $reserva
                ->getEstado()
                ->etiqueta() ?>
        </p>

    <?php endif; ?>


    <hr>


    <h2>
        Existencias
    </h2>


    <?php foreach (
        $_SESSION["equipos"] as $equipo
    ): ?>

        <p>

            <?= htmlspecialchars(
                $equipo->getNombre()
            ) ?>

            :

            <?= $equipo->getExistencias() ?>

        </p>

    <?php endforeach; ?>


</body>

</html>