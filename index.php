<?php
include 'conexion.php';

if (isset($_POST['enviar_nota'])) {

  $nombreyapellido = mysqli_real_escape_string($conexion, $_POST['nombreyapellido']);
  $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
  $email = mysqli_real_escape_string($conexion, $_POST['email']);
  $nota = mysqli_real_escape_string($conexion, $_POST['nota']);

  date_default_timezone_set('America/Caracas');
  $fechanota = date("d/m/Y h:i A");

  $sql_insertar = "INSERT INTO notas (nombreyapellido, usuario, email, nota, fecha_nota) 
                       VALUES ('$nombreyapellido', '$usuario', '$email', '$nota', '$fechanota')";

  if ($conexion->query($sql_insertar) === TRUE) {
    header("Location: index.php#comentarios");
    exit();
  } else {
    echo "<script>alert('Hubo un error al guardar la nota: " . $conexion->error . "');</script>";
  }
}
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MotorPassion | Mi Portafolio de Carros</title>
  <link rel="icon" href="favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <header>
    <nav>
      <div class="logo">🏎️ Motor<span>Passion</span></div>
      <ul>
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#modelos">Modelos</a></li>
        <li><a href="#historia">Historia</a></li>
      </ul>
    </nav>
  </header>

  <section id="inicio" class="hero">
    <div class="hero-content">
      <h1>Velocidad y Diseño</h1>
      <p>Explorando la ingeniería detrás de los autos más icónicos.</p>
      <a href="#modelos" class="btn">Ver Modelos</a>
    </div>
  </section>

  <section id="modelos" class="modelos">
    <h2>Modelos Destacados</h2>
    <div class="grid-autos">
      <div class="card">
        <img
          src="https://images.pexels.com/photos/3311574/pexels-photo-3311574.jpeg?auto=compress&cs=tinysrgb&w=600"
          alt="Superdeportivo" />
        <h3>Superdeportivos</h3>
        <p>Potencia bruta y aerodinámica extrema.</p>
      </div>
      <div class="card">
        <img
          src="https://images.pexels.com/photos/210019/pexels-photo-210019.jpeg?auto=compress&cs=tinysrgb&w=600"
          alt="Clásico" />
        <h3>Clásicos</h3>
        <p>La elegancia que nunca pasa de moda.</p>
      </div>
      <div class="card">
        <img
          src="https://images.pexels.com/photos/2526127/pexels-photo-2526127.jpeg?auto=compress&cs=tinysrgb&w=600"
          alt="Eléctrico" />
        <h3>Eléctricos</h3>
        <p>El futuro de la conducción eficiente.</p>
      </div>
    </div>
  </section>

  <section id="historia" class="historia">
    <h2>Sobre Mi Pasión</h2>
    <p>
      Desde niño, los motores han sido mi inspiración. Este portafolio muestra
      mi colección favorita y los avances tecnológicos que están cambiando el
      mundo automotriz.
    </p>
  </section>

  <section id="autor" class="autor-section">
    <div class="autor-container">
      <div class="autor-info">
        <h2>Perfil del Desarrollador</h2>
        <div class="datos-grid">
          <div class="dato-item">
            <strong>Nombre:</strong>
            <span>Shedi Nasrallah</span>
          </div>
          <div class="dato-item">
            <strong>Nacimiento:</strong>
            <span>07/12/2005</span>
          </div>
          <div class="dato-item">
            <strong>Trimestre:</strong>
            <span>7mo Trimestre</span>
          </div>
          <div class="dato-item">
            <strong>Correo:</strong>
            <span><a href="mailto:snassrallah.8067@unimar.edu.ve">snassrallah.8067@unimar.edu.ve</a></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="comentarios" class="autor-section">
    <div class="autor-container">
      <h2>Dejar un Comentario</h2>

      <form action="index.php#comentarios" method="POST" class="formulario-comentarios">
        <div class="input-group">
          <label for="nombreyapellido">Nombre y Apellido:</label>
          <input type="text" id="nombreyapellido" name="nombreyapellido" required>
        </div>

        <div class="input-group">
          <label for="usuario">Usuario (Opcional):</label>
          <input type="text" id="usuario" name="usuario">
        </div>

        <div class="input-group">
          <label for="email">Correo Electrónico:</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="input-group">
          <label for="nota">Nota / Comentario:</label>
          <textarea id="nota" name="nota" rows="4" required></textarea>
        </div>

        <button type="submit" name="enviar_nota" class="btn">Enviar Comentario</button>
      </form>

      <h3 class="titulo-notas">Notas de los Lectores</h3>
      <div class="lista-notas">
        <?php
        $sql_leer = "SELECT * FROM notas ORDER BY ID_NOTAS DESC";
        $resultado = $conexion->query($sql_leer);

        if ($resultado->num_rows > 0) {
          while ($fila = $resultado->fetch_assoc()) {


            $mostrar_usuario = !empty($fila['USUARIO']) ? "<span>(@" . htmlspecialchars($fila['USUARIO']) . ")</span>" : "";

            echo '<div class="nota-item">';
            echo '  <div class="nota-header">';
            echo '    <strong>' . htmlspecialchars($fila['NOMBREYAPELLIDO']) . '</strong> ' . $mostrar_usuario;
            echo '    <small>' . htmlspecialchars($fila['FECHA_NOTA']) . '</small>';
            echo '  </div>';
            echo '  <p>' . nl2br(htmlspecialchars($fila['NOTA'])) . '</p>';
            echo '</div>';
          }
        } else {
          echo '<p style="color: #888; text-align: center;">Aún no hay comentarios. ¡Sé el primero en dejar una nota!</p>';
        }
        ?>
  </section>

  <footer>
    <p>
      &copy; 2026 Creado por Shedi Nasrallah |
      <a href="https://github.com/shedi365">GitHub</a>
    </p>
  </footer>
</body>

</html>