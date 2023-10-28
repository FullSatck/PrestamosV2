<?php
session_start();
if (!$_SESSION['logged_in']) {
  header("location: ../../Login_registro/login/validar.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>

  <title>admin</title>
</head>

<body>
  <div class="home">
    <h1>Bienvenido <?php echo $_SESSION['Nombre']; ?></h1>
    <p>Navega por el menú para acceder a las distintas funciones</p>
  </div>

  <nav class="sidebar">
    <div class="sidebar-inner">
      <header class="sidebar-header">
        <button type="button" class="sidebar-burger" onclick="toggleSidebar()"><i
            class="fa-solid fa-house-user fa-2xl"></i></button>
        <img src="/img/Inovatec.svg" class="sidebar-logo" />
      </header>
      <nav class="sidebar-menu">
        <button type="button" onclick="window.location.href = '/index.html'">
          <i class="fa-solid fa-house fa-xl" style="color: #000000;"></i>
          <span>Inicio</span>
        </button>

        <button type="button" onclick="window.location.href = '/index.html'" class="has-border">
          <i class="fa-solid fa-gear fa-xl"></i>
          <span>Configuracion</span>
        </button>

        <button type="button" onclick="window.location.href = '/lognprin/admi/horario/crud.php'">
          <i class="fa-regular fa-calendar fa-xl" style="color: #000000;"></i>
          <span>Agregar horarios</span>
        </button>

        <button type="button" onclick="window.location.href = '/lognprin/admi/estudiantes/crud.php'">
          <i class="fa-solid fa-graduation-cap fa-xl" style="color: #000000;"></i>
          <span>Estudiantes</span>
        </button>

        <button type="button" onclick="window.location.href = '/lognprin/admi/instructor/crud.php'">
          <i class="fa-solid fa-user-tie fa-2xl" style="color: #000000;"></i>
          <span>Instructores</span>
        </button>

        <button type="button" onclick="window.location.href = '/lognprin/admi/usuarios/crud.php'" class="has-border">
          <i class="fa-solid fa-users fa-xl" style="color: #000000;"></i>
          <span>Usuarios</span>
        </button>

        <button type="button" onclick="window.location.href = '../../../Login_registro/login/cerrar_sesion.php'"
          class="has-border">
          <i class="fa-solid fa-right-from-bracket fa-xl" style="color: #000000;"></i>
          <span>Log out</span>
        </button>
      </nav>
    </div>
  </nav>

  >

  <script type="text/javascript">
    const toggleSidebar = () => document.body.classList.toggle("open");

    
  </script>
</body>

</html>
