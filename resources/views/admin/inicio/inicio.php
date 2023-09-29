<!DOCTYPE html>
<html lang="en">

<head>
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
                <a href="/admin/auth/group/">Grupos</a>
                <button><a href="/admin/auth/group/add/">Añadir</a></button>
                <button><a href="/admin/auth/group/">Modificar</a></button>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/auth/user/">Usuarios</a>
                <button><a href="/admin/auth/user/add/">Añadir</a></button>
                <button><a href="/admin/auth/user/">Modificar</a></button>
            </th>
        </tr>
    </table>

    <h2><a href="/admin/empresa/">Empresa</a></h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="/views/admin/clientes/clientes.php">Clientes</a>
                <button><a href="/admin/empresa/cliente/add/">Añadir</a></button>
                <button><a href="/admin/empresa/cliente/">Modificar</a></button>
            </th>
        </tr>
    </table>

    <h2><a href="/admin/recaudo/">Recaudo</a></h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th scope="row">
                <a href="../abonos/abonos.php">Abonos</a>
                <button><a href="/admin/recaudo/abono/add/">Añadir</a></button>
                <button><a href="/admin/recaudo/abono/">Modificar</a></button>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/views/admin/clientes/clientes.php">Clientes</a>
                <button><a href="/admin/recaudo/cliente/add/">Añadir</a></button>
                <button><a href="/admin/recaudo/cliente/">Modificar</a></button>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/cobro/">Cobros</a>
                <button><a href="/admin/recaudo/cobro/add/">Añadir</a></button>
                <button><a href="/admin/recaudo/cobro/">Modificar</a></button>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/codeudor/">Codeudors</a>
                <button><a href="/admin/recaudo/codeudor/add/">Añadir</a></button>
                <button><a href="/admin/recaudo/codeudor/">Modificar</a></button>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/deuda/">Deudas</a>
                <button><a href="/admin/recaudo/deuda/add/">Añadir</a></button>
                <button><a href="/admin/recaudo/deuda/">Modificar</a></button>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/gasto/">Gastos</a>
                <button><a href="/admin/recaudo/gasto/add/">Añadir</a></button>
                <button><a href="/admin/recaudo/gasto/">Modificar</a></button>
            </th>
        </tr>

        <tr>
            <th scope="row">
                <a href="/admin/recaudo/retiro/">Retiros</a>
                <button><a href="##"><span class="glyphicon glyphicon-plus">Añadir</a></button>
                <button><a href="##"><span class="glyphicon glyphicon-edit">Modificar</a></button>
            </th>
        </tr>
    </table>
    <footer id="footer">Derechos reservados</footer>
</body>
</html>
