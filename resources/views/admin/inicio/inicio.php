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
                <span class="navbar-brand">Administrador Recaudo</span>
            </div>
        </div>
    </div>

    <h2>Autenticación y autorización</h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="/admin/auth/group/">Grupos </a>
                <div class="button-container">
                    <button><a href="/admin/auth/group/add/">Añadir</a></button>
                    <button><a href="/admin/auth/group/">Modificar</a></button>
                </div>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/auth/user/">Usuarios </a>
                <div class="button-container">
                    <button><a href="/admin/auth/user/add/">Añadir</a></button>
                    <button><a href="/admin/auth/user/">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

    <h2>Empresa</h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="/resources/views/admin/usuarios/crudusuarios.php">Registrar Trabajadores </a>
                <div class="button-container">
                    <button><a href="/admin/empresa/cliente/add/">Añadir</a></button>
                    <button><a href="/admin/empresa/cliente/">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>
    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="##">Registrar Clientes </a>
                <div class="button-container">
                    <button><a href="/admin/empresa/cliente/add/">Añadir</a></button>
                    <button><a href="/admin/empresa/cliente/">Modificar</a></button>
                </div>
            </th>
        </tr>
    </table>

    <h2>Recaudo</h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="/resources/views/admin/abonos/abonos.php">Abonos </a>
                <div class="button-container">
                    <button><a href="/admin/recaudo/abono/add/">Añadir</a></button>
                    <button><a href="/admin/recaudo/abono/">Modificar</a></button>
                </div>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/views/admin/clientes/clientes.php">Clientes </a>
                <button><a href="/admin/recaudo/cliente/add/">Añadir</a></button>
                <button><a href="/admin/recaudo/cliente/">Modificar</a></button>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/cobro/">Cobros </a>
                <div class="button-container">
                    <button><a href="/admin/recaudo/cobro/add/">Añadir</a></button>
                    <button><a href="/admin/recaudo/cobro/">Modificar</a></button>
                </div>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/codeudor/">Codeudors </a>
                <div class="button-container">
                    <button><a href="/admin/recaudo/codeudor/add/">Añadir</a></button>
                    <button><a href="/admin/recaudo/codeudor/">Modificar</a></button>
                </div>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/deuda/">Deudas </a>
                <div class="button-container">
                    <button><a href="/admin/recaudo/deuda/add/">Añadir</a></button>
                    <button><a href="/admin/recaudo/deuda/">Modificar</a></button>
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
