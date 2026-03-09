<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id_editar = (int)$_GET['id'];
    $sql_buscar = "SELECT * FROM notas WHERE ID_NOTAS = $id_editar";
    $resultado = $conexion->query($sql_buscar);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
    } else {
        die("La nota que intentas editar no existe.");
    }
} else {
    header("Location: index.php#comentarios");
    exit();
}

if (isset($_POST['actualizar_nota'])) {
    $id = (int)$_POST['id_nota'];
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombreyapellido']);
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $nota = mysqli_real_escape_string($conexion, $_POST['nota']);

    date_default_timezone_set('America/Caracas');
    $fechanota = date("d/m/Y h:i A") . " (Editado)";

    $sql_actualizar = "UPDATE notas SET 
                        NOMBREYAPELLIDO = '$nombre', 
                        USUARIO = '$usuario', 
                        EMAIL = '$email', 
                        NOTA = '$nota',
                        FECHA_NOTA = '$fechanota'
                       WHERE ID_NOTAS = $id";

    if ($conexion->query($sql_actualizar) === TRUE) {
        header("Location: index.php#comentarios");
        exit();
    } else {
        echo "<script>alert('Error al actualizar: " . $conexion->error . "');</script>";
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Nota | MotorPassion</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">🏎️ Motor<span>Passion</span></div>
            <ul>
                <li><a href="index.php">Volver al Inicio</a></li>
            </ul>
        </nav>
    </header>

    <section class="autor-section" style="margin: 150px 10% 50px 10%;">
        <div class="autor-container">
            <h2>✏️ Editar Comentario</h2>

            <form action="editar.php?id=<?php echo $id_editar; ?>" method="POST" class="formulario-comentarios">
                <input type="hidden" name="id_nota" value="<?php echo $fila['ID_NOTAS']; ?>">

                <div class="input-group">
                    <label>Nombre y Apellido:</label>
                    <input type="text" name="nombreyapellido" value="<?php echo htmlspecialchars($fila['NOMBREYAPELLIDO']); ?>" required>
                </div>

                <div class="input-group">
                    <label>Usuario (Opcional):</label>
                    <input type="text" name="usuario" value="<?php echo htmlspecialchars($fila['USUARIO']); ?>">
                </div>

                <div class="input-group">
                    <label>Correo Electrónico:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($fila['EMAIL']); ?>" required>
                </div>

                <div class="input-group">
                    <label>Nota / Comentario:</label>
                    <textarea name="nota" rows="5" required><?php echo htmlspecialchars($fila['NOTA']); ?></textarea>
                </div>

                <div style="display: flex; gap: 15px;">
                    <button type="submit" name="actualizar_nota" class="btn">Guardar Cambios</button>
                    <a href="index.php#comentarios" class="btn" style="background: #333; text-decoration: none;">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>