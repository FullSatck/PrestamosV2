

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor</title>
    <link rel="stylesheet" href="/public/assets/css/inicio.css">

</head>

<body class="dashboard">
    <div class="navbar navbar-default">
        <div class="navbar-inner">
            <div class="navbar-header">
                <span class="navbar-brand">Supervisor</span>
                <div class="button-container">
                    <button><a href="/controllers/cerrar_sesion.php" class="aa"><strong>Cerrar
                                Sesion</strong></a></button>
                </div>
            </div>
        </div>
    </div> 

    <h2 class="h22">Usuarios</h2>

    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="/resources/views/supervisor/usuarios/crudusuarios.php">Usuarios </a>
                <div class="button-container">
                    <button><a href="###">Añadir</a></button>
                    <button><a href="###">Modificar</a></button>
                </div>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <a href="/resources/views/supervisor/usuarios/registrar.php">Registrar Usuario</a>
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
                <a href="/resources/views/supervisor/clientes/lista_clientes.php">Clientes </a>
                <div class="button-container">
                    <button><a href="###">Añadir</a></button>
                    <button><a href="###">Modificar</a></button>
                </div>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <a href="/resources/views/supervisor/clientes/agregar_clientes.php">Registrar Clientes </a>
                <div class="button-container">
                    <button><a href="###">Añadir</a></button>
                    <button><a href="###">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

    <h2 class="h22">Prestamos</h2>

    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="/resources/views/supervisor/creditos/crudPrestamos.php">Prestamos</a>
                <div class="button-container">
                    <button><a href="##"><span class="glyphicon glyphicon-plus">Añadir</a></button>
                    <button><a href="##"><span class="glyphicon glyphicon-edit">Modificar</a></button>
                </div>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <a href="/resources/views/supervisor/creditos/prestamos.php">Registrar Prestamos</a>
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
                <a href="/resources/views/supervisor/abonos/lista_super.php">Ruta </a>
                <div class="button-container">
                    <button><a href="###">Añadir</a></button>
                    <button><a href="###">Modificar</a></button>
                </div>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <a href="/resources/views/supervisor/abonos/abonos.php">Abonos </a>
                <div class="button-container">
                    <button><a href="###">Añadir</a></button>
                    <button><a href="###">Modificar</a></button>
                </div>
            </th>
        </tr>
        <tr>
        <tr>
            <th scope="row">
                <a href="####">Codeudores</a>
                <div class="button-container">
                    <button><a href="###">Añadir</a></button>
                    <button><a href="###">Modificar</a></button>
                </div>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <a href="/resources/views/supervisor/gastos/gastos.php">Gastos </a>
                <div class="button-container">
                    <button><a href="###">Añadir</a></button>
                    <button><a href="###">Modificar</a></button>
                </div>
            </th>
        </tr>
        <tr>
            <th scope="row">
                <a href="/resources/views/supervisor/retiros/retiros.php">Retiros </a>
                <div class="button-container">
                    <button><a href="##"><span class="glyphicon glyphicon-plus">Añadir</a></button>
                    <button><a href="##"><span class="glyphicon glyphicon-edit">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

</body>

</html>