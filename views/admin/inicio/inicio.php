<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="es-co" >
<head>
    <title>Administrador Recaudo</title>

    <script type="text/javascript">
    //<![CDATA[
        window.__admin_media_prefix__ = "/static/admin/";
        window.__admin_utc_offset__ = "\u002D18000";
    //]]>
    </script>
    <script src="/static/admin/js/jquery-1.9.1.min.js"></script>
    <script src="/static/admin/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>

    

    <meta name="robots" content="NONE,NOARCHIVE" />
    <script type="text/javascript">
    //<![CDATA[
            (function($) {
                $(document).ready(function() {
                    $('input[type="submit"]').addClass('btn');
                    $('[title]').tooltip();
                });
            }(jQuery));
    //]]>
    </script>
</head>


<body class=" dashboard">

<!-- Container -->
<div class="container">

    
    <!-- Header -->
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
<a class="navbar-brand" href="/admin/">Administrador Recaudo</a> <a class="btn btn-primary navbar-btn" href="/">Ir Abonos</a>

                </div>
                <div id="header-navbar-collapse" class="navbar-collapse collapse navbar-right">
                    <ul class="nav navbar-nav">
                        
                        
                        <li class="dropdown">
                            
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bienvenido/a, <strong>Dubereg</strong> <span class="caret"></span></a>
                            
                            <ul class="dropdown-menu">
                                
                                    <li><a href="/">Ver el sitio</a></li>
                                
                                
                                    
                                    
                                
                                
                                <li><a href="/admin/password_change/">Cambiar contraseña</a></li>
                                
                                <li><a href="/admin/logout/">Terminar sesión</a></li>
                            </ul>
                        </li>
                        
                        
                        <li class="divider-vertical"></li>
                        
                        
                        
                        <li class="dropdown" id="recent-actions-module">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Recent Actions <b class="caret"></b></a>
                            
                            
                            <ul class="dropdown-menu">
                                
                                <li class="changelink">
                                    <a href="/admin/empresa/cliente/9/change/">
                                        <i class="glyphicon glyphicon-edit"></i>
                                        Barrancabermeja: barranca
                                        
                                        <span class="mini quiet">(Cliente)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="changelink">
                                    <a href="/admin/empresa/cliente/9/change/">
                                        <i class="glyphicon glyphicon-edit"></i>
                                        Barrancabermeja: barranca
                                        
                                        <span class="mini quiet">(Cliente)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="changelink">
                                    <a href="/admin/empresa/cliente/9/change/">
                                        <i class="glyphicon glyphicon-edit"></i>
                                        Barrancabermeja: barranca
                                        
                                        <span class="mini quiet">(Cliente)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="addlink">
                                    <a href="/admin/recaudo/retiro/1319/change/">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        Retiro object
                                        
                                        <span class="mini quiet">(Retiro)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="addlink">
                                    <a href="/admin/recaudo/retiro/1318/change/">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        Retiro object
                                        
                                        <span class="mini quiet">(Retiro)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="addlink">
                                    <a href="/admin/recaudo/retiro/1317/change/">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        Retiro object
                                        
                                        <span class="mini quiet">(Retiro)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="addlink">
                                    <a href="/admin/recaudo/retiro/1316/change/">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        Retiro object
                                        
                                        <span class="mini quiet">(Retiro)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="addlink">
                                    <a href="/admin/recaudo/retiro/1315/change/">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        Retiro object
                                        
                                        <span class="mini quiet">(Retiro)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="addlink">
                                    <a href="/admin/recaudo/retiro/1314/change/">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        Retiro object
                                        
                                        <span class="mini quiet">(Retiro)</span>
                                        
                                    </a>
                                </li>
                                
                                <li class="addlink">
                                    <a href="/admin/recaudo/retiro/1313/change/">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        Retiro object
                                        
                                        <span class="mini quiet">(Retiro)</span>
                                        
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        
                        
                        
                        
                        
                        
                        
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <!-- END Header -->
    <div class="row">
        <div class="col-sm-12">
            
<ul class="breadcrumb">
<li>Inicio</li>
</ul>

        </div>
    </div>
    

    <!-- Content -->
    <div id="content" class="colMS">
        
        <div class="navbar navbar-default">
            <div class="navbar-inner">
                
                    <div class="navbar-header">
                        

                    
                    
                        <span class="navbar-brand">Administrador Recaudo</span>
                    
                    
                    </div>
                
<ul class="nav navbar-nav">
    <li class="dropdown">
        <a role="button" href="#" class="dropdown-toggle" data-toggle="dropdown">Applications <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            
            <li>
                <a href="#"><strong>Autenticación y autorización</strong></a>
            </li>
            
            <li>
                
                    <a href="/admin/auth/group/">Grupos</a>
                
            </li>
            
            <li>
                
                    <a href="/admin/auth/user/">Usuarios</a>
                
            </li>
            
            
            <li role="presentation" class="divider"></li>
            
            
            <li>
                <a href="#"><strong>Empresa</strong></a>
            </li>
            
            <li>
                
                    <a href="/admin/empresa/cliente/">Clientes</a>
                
            </li>
            
            
            <li role="presentation" class="divider"></li>
            
            
            <li>
                <a href="#"><strong>Recaudo</strong></a>
            </li>
            
            <li>
                
                    <a href="/admin/recaudo/abono/">Abonos</a>
                
            </li>
            
            <li>
                
                    <a href="/admin/recaudo/cliente/">Clientes</a>
                
            </li>
            
            <li>
                
                    <a href="/admin/recaudo/cobro/">Cobros</a>
                
            </li>
            
            <li>
                
                    <a href="/admin/recaudo/codeudor/">Codeudors</a>
                
            </li>
            
            <li>
                
                    <a href="/admin/recaudo/deuda/">Deudas</a>
                
            </li>
            
            <li>
                
                    <a href="/admin/recaudo/gasto/">Gastos</a>
                
            </li>
            
            <li>
                
                    <a href="/admin/recaudo/retiro/">Retiros</a>
                
            </li>
            
            
            
        </ul>
    </li>
</ul>

            </div>
        </div>
        

        
        
        

        
<div class="row">
    <div id="content-main" class="col-sm-12">

        <div class="tabbable">
            
                
<h2 id='auth' class="app-name"><a href="/admin/auth/">Autenticación y autorización</a></h2>

                
                <table summary="Models available in the Autenticación y autorización application." class="table table-striped table-bordered">
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/auth/group/">Grupos</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/auth/group/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/auth/group/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/auth/user/">Usuarios</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/auth/user/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/auth/user/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                </table>
            
                
<h2 id='empresa' class="app-name"><a href="/admin/empresa/">Empresa</a></h2>

                
                <table summary="Models available in the Empresa application." class="table table-striped table-bordered">
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/empresa/cliente/">Clientes</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/empresa/cliente/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/empresa/cliente/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                </table>
            
                
<h2 id='recaudo' class="app-name"><a href="/admin/recaudo/">Recaudo</a></h2>

                
                <table summary="Models available in the Recaudo application." class="table table-striped table-bordered">
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/recaudo/abono/">Abonos</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/recaudo/abono/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/recaudo/abono/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/recaudo/cliente/">Clientes</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/recaudo/cliente/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/recaudo/cliente/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/recaudo/cobro/">Cobros</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/recaudo/cobro/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/recaudo/cobro/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/recaudo/codeudor/">Codeudors</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/recaudo/codeudor/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/recaudo/codeudor/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/recaudo/deuda/">Deudas</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/recaudo/deuda/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/recaudo/deuda/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/recaudo/gasto/">Gastos</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/recaudo/gasto/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/recaudo/gasto/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            
                            <a href="/admin/recaudo/retiro/">Retiros</a>
                            

                            
                            <div class="pull-right">
                                
                                <a href="/admin/recaudo/retiro/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                Añadir</a>
                                
                                
                                <a href="/admin/recaudo/retiro/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                Modificar</a>
                                
                            </div>
                            
                        </th>
                    </tr>
                
                </table>
            
        </div>
    </div>
</div>

        

    </div>
    <!-- END Content -->

    <footer id="footer"></footer>
</div>
<!-- END Container -->

</body>
</html>