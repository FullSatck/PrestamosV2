<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/inicio.css">

</head>

<body class="dashboard">
    <div class="navbar navbar-default">
        <div class="navbar-inner">
            <div class="navbar-header">
                <span class="navbar-brand">Supervisor | Inicio</span>
            </div>
        </div>
    </div>

    <h2 class="h22">Cobradores</h2>

    <table class="table table-striped table-bordered"> 
        <tr>
            <th scope="row">
                <a href="/resources/views/admin/usuarios/crudusuarios.php">Lista de Cobradores</a>
                <div class="button-container">
                    <button><a href="/admin/auth/user/add/">Añadir</a></button>
                    <button><a href="/admin/auth/user/">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="/resources/views/admin/usuarios/registrar.php">Registrar Cobrador</a>
                <div class="button-container">
                    <button><a href="/admin/empresa/cliente/add/">Añadir</a></button>
                    <button><a href="/admin/empresa/cliente/">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

    <h2 class="h22">Clientes</h2>

    <table class="table table-striped table-bordered">
    <tr>
            <th scope="row">
                <a href="/resources/views/admin/clientes/lista_clientes.php">Lista de Clientes </a>
                <div class="button-container">
                    <button><a href="/admin/recaudo/abono/add/">Añadir</a></button>
                    <button><a href="/admin/recaudo/abono/">Modificar</a></button>
                </div>
            </th>
        </tr>
        </table>
    
    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="/resources/views/admin/clientes/agregar_clientes.php">Registrar Clientes </a>
                <div class="button-container">
                    <button><a href="/admin/empresa/cliente/add/">Añadir</a></button>
                    <button><a href="/admin/empresa/cliente/">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

    <h2 class="h22">Prestamos</h2>

    <table class="table table-striped table-bordered"> 
    <tr>
            <th scope="row">
                <a href="/resources/views/admin/creditos/crudPrestamos.php">Lista de Prestamos </a>
                <div class="button-container">
                    <button><a href="##"><span class="glyphicon glyphicon-plus">Añadir</a></button>
                    <button><a href="##"><span class="glyphicon glyphicon-edit">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

    <table class="table table-striped table-bordered">
    <tr>
            <th scope="row">
                <a href="/resources/views/admin/creditos/prestamos.php">Agregar Prestamos </a>
                <div class="button-container">
                    <button><a href="##"><span class="glyphicon glyphicon-plus">Añadir</a></button>
                    <button><a href="##"><span class="glyphicon glyphicon-edit">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

    <h2 class="h22">Recaudo</h2>
    <table class="table table-striped table-bordered">
         
        

        <tr>
            <th scope="row">
                <a href="/resources/views/admin/cobros/cobros.php">Zona de cobros </a>
                <div class="button-container">
                    <button><a href="/admin/recaudo/cobro/add/">Añadir</a></button>
                    <button><a href="/admin/recaudo/cobro/">Modificar</a></button>
                </div>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/codeudor/">Codeudores </a>
                <div class="button-container">
                    <button><a href="/admin/recaudo/codeudor/add/">Añadir</a></button>
                    <button><a href="/admin/recaudo/codeudor/">Modificar</a></button>
                </div>
            </th>
        </tr>
 
        

        

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/gasto/">Gastos </a>
                <div class="button-container">
                    <button><a href="/admin/recaudo/gasto/add/">Añadir</a></button>
                    <button><a href="/admin/recaudo/gasto/">Modificar</a></button>
                </div>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/retiro/">Retiros </a>
                <div class="button-container">
                    <button><a href="##"><span class="glyphicon glyphicon-plus">Añadir</a></button>
                    <button><a href="##"><span class="glyphicon glyphicon-edit">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>
    <footer id="footer">Derechos reservados</footer>
</body>

</html>
