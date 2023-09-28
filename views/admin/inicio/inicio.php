<!DOCTYPE html>
<html lang="en">
<head>
    <title>Administrador Recaudo</title>
    <link rel="stylesheet" href="/views/assets/css/inicio.css">
</head>
<body class="dashboard">
<!-- Container -->
  
    <!-- Content -->
    <div id="content" class="colMS"> 
        <div class="navbar navbar-default">
            <div class="navbar-inner"> 
                    <div class="navbar-header"> 
                        <span class="navbar-brand">Administrador Recaudo</span>
                    </div> 
                </div>
            </div> 
        </div>
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
                    <a href="/views/admin/clientes/clientes.php">Cliesssstes</a>                
            </li>
            <li role="presentation" class="divider"></li>
            <li>
                <a href="#"><strong>Recaudo</strong></a>
            </li>            
            <li>                
                    <a href="../abonos/inicio.php">Abonos</a>                
            </li>            
            <li>                
                    <a href="../../clientes/clientes.php">Clientes</a>                
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
                            <button class="jeje"><a href="/admin/auth/group/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                                <strong>Añadir</strong></a></button>
                            <button class="jeje"><a href="/admin/auth/group/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            <a href="/admin/auth/user/">Usuarios</a>
                            <div class="pull-right">
                            <button class="jeje"><a href="/admin/auth/user/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</strong></a></button>
                            <button class="jeje"><a href="/admin/auth/user/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                               <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                </table>
            
            <h2 id='empresa' class="app-name"><a href="/admin/empresa/">Empresa</a></h2>

                <table summary="Models available in the Empresa application." class="table table-striped table-bordered">
                    <tr>
                        <th scope="row">
                            <a href="/views/admin/clientes/clientes.php">Clientes</a>
                            <div class="pull-right">
                            <button class="jeje"><a href="/admin/empresa/cliente/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</strong></a></button>
                            <button class="jeje"><a href="/admin/empresa/cliente/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                               <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                </table>      
                
            <h2 id='recaudo' class="app-name"><a href="/admin/recaudo/">Recaudo</a></h2>
                
                <table summary="Models available in the Recaudo application." class="table table-striped table-bordered">
                
                    <tr>
                        <th scope="row">
                            <a href="../abonos/abonos.php">Abonos</a>
                            <div class="pull-right">
                            <button class="jeje"><a href="/admin/recaudo/abono/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</strong></a></button>
                            <button class="jeje"><a href="/admin/recaudo/abono/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                               <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            <a href="/views/admin/clientes/clientes.php">Clientes</a>
                            <div class="pull-right">
                            <button class="jeje"><a href="/admin/recaudo/cliente/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</strong></a></button>
                            <button class="jeje"><a href="/admin/recaudo/cliente/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                               <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            <a href="/admin/recaudo/cobro/">Cobros</a>
                            <div class="pull-right">
                            <button class="jeje"><a href="/admin/recaudo/cobro/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</strong></a></button>
                            <button class="jeje"><a href="/admin/recaudo/cobro/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                               <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            <a href="/admin/recaudo/codeudor/">Codeudors</a>
                            <div class="pull-right">
                            <button class="jeje"><a href="/admin/recaudo/codeudor/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</strong></a></button>
                            <button class="jeje"><a href="/admin/recaudo/codeudor/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                               <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            <a href="/admin/recaudo/deuda/">Deudas</a>
                            <div class="pull-right">
                                <button class="jeje"><a href="/admin/recaudo/deuda/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</a></strong></button>
                                <button class="jeje"><a href="/admin/recaudo/deuda/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                                <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">
                            <a href="/admin/recaudo/gasto/">Gastos</a>
                            <div class="pull-right">
                            <button class="jeje"><a href="/admin/recaudo/gasto/add/" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</a></strong></button>
                            <button class="jeje"><a href="/admin/recaudo/gasto/" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                               <strong>Modificar</strong></a></button>
                            </div>
                        </th>
                    </tr>
                
                    <tr>
                        <th scope="row">                            
                            <a href="/admin/recaudo/retiro/">Retiros</a>
                         <div class="pull-right">                                
                            <button class="jeje"><a href="##" class="btn btn-xs addlink"><span class="glyphicon glyphicon-plus"></span>
                               <strong>Añadir</strong></a></button>
                            <button class="jeje"><a href="##" class="btn btn-xs changelink"><span class="glyphicon glyphicon-edit"></span>
                               <strong>Modificar</strong></a></button>                                
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