<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-co">

<head>
    <title>Escoja cliente a modificar</title>
    <link rel="stylesheet" type="text/css" href="/views/assets/css/clientes.css" />

</head>

<body class=" recaudo- change-list">
    <!-- Container -->
    <div class="container">
        <!-- Header -->
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#header-navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- END Header -->
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li><a href="/admin/">Inicio</a></li>
                        <!--<li><a href="/admin/recaudo/"></a></li>-->
                        <li><a href="/admin/recaudo/">Recaudo</a></li>
                        <li>Clientes</li>
                    </ul>
                </div>
            </div>
            <!-- Content -->
            <div id="content" class="flex">
                <div class="navbar navbar-default">
                    <div class="navbar-inner">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#content-navbar-collapse" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <span class="navbar-brand">Escoja cliente a modificar</span>
                        </div>
                        <div id="content-navbar-collapse" class="navbar-collapse collapse">
                            <ul class="object-tools nav navbar-nav">
                                <li>
                                    <a role="button" href="/admin/recaudo/cliente/add/?_changelist_filters=o%3D"
                                        class="btn btn-primary">
                                        <span class="glyphicon glyphicon-plus"></span> Añadir cliente
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Filtro <span
                                            class="caret"></span></a>
                                    <ul class="dropdown-menu pull-right scrollable-dropdown-menu">
                                        <li class="dropdown-header"> Por cobro </li>
                                        <li class="active"><a href="?o=">Todo</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form class="navbar-form navbar-right" role="search" id="changelist-search" action=""
                                method="get">
                                <div class="form-group"><!-- DIV needed for valid HTML -->
                                    <input type="text" class="form-control search-query" placeholder="Buscar" size="25"
                                        name="q" value="" id="searchbar" />
                                </div>
                                <button type="submit" class="btn btn-default">Buscar</button>
                                <input type="hidden" name="o" value="" />
                            </form>
                            <script type="text/javascript">document.getElementById("searchbar").focus();</script>
                        </div>
                    </div>
                </div>
                <form class="" id="changelist-form" action="" method="post" novalidate><input type='hidden'
                        name='csrfmiddlewaretoken'
                        value='vAwJi8sYs63k1jDegumHANYqxGd1izXksMrwIXFAE2mK4MIEQrTXz3dEjWuvvNrP' />
                    <div class='pull-left'>
                        <div class="actions form-group">
                            <span style="vertical-align:sub">Acción:</span> <select class="form-control" name="action"
                                title="" required>
                                <option value="" selected="selected">---------</option>
                                <option value="delete_selected">Eliminar clientes seleccionado/s</option>
                            </select><input class="select-across" name="select_across" type="hidden" value="0" />
                            <button type="submit" class="btn btn-default" title="Ejecutar la acción seleccionada"
                                name="index" value="0">Ir</button>

                            <script type="text/javascript">var _actions_icnt = "100";</script>
                            <span class="action-counter">seleccionados 0 de 100</span>

                            <span class="all" style="vertical-align:sub">58211 seleccionados en total</span>
                            <span class="question"><a class="btn btn-default" href="javascript:;"
                                    title="Pulse aquí para seleccionar los objetos a través de todas las páginas">Seleccionar
                                    todos los 58211 clientes</a></span>
                            <span class="clear"><a class="btn btn-default" href="javascript:;">Limpiar
                                    selección</a></span>
                        </div>
                    </div>
                    <div id="content-main">
                        <div class="module filtered" id="_changelist">
                            <div class="results">
                                <table id="result_list" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="action-checkbox-column">
                                                <span><input type="checkbox" id="action-toggle" /></span>
                                            </th>
                                            <th scope="col" class="sortable column-codigo">
                                                <a href="?o=1">Código</a>
                                            </th>
                                            <th scope="col" class="sortable column-nombre">
                                                <a href="?o=2">Nombre</a>
                                            </th>
                                            <th scope="col" class="sortable column-cobro">
                                                <a href="?o=3">Cobro</a>
                                            </th>
                                            <th scope="col" class="sortable column-telefono">
                                                <a href="?o=4">Teléfono</a>
                                            </th>
                                            <th scope="col" class="sortable column-orden">
                                                <a href="?o=5">Orden</a>
                                            </th>
                                            <th scope="col" class="column-reorden">
                                                <span>Enrutar</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <tr class="row1">

                                            <td class="action-checkbox"><input class="action-select"
                                                    name="_selected_action" type="checkbox" value="12358" /></td>

                                            <th class="field-codigo"><a
                                                    href="/admin/recaudo/cliente/12358/change/?_changelist_filters=o%3D">43894466-1</a>
                                            </th>

                                            <td class="field-nombre">JUANA MIELES SALGADO</td>

                                            <td class="field-cobro nowrap">AYAPEL</td>

                                            <td class="field-telefono">3235916586</td>

                                            <td class="field-orden">1</td>

                                            <td class="field-reorden"><a href="/cliente/orden/12358/1/">1 - Enrutar</a>
                                            </td>

                                        </tr>


                                        <tr class="row2">

                                            <td class="action-checkbox"><input class="action-select"
                                                    name="_selected_action" type="checkbox" value="28739" /></td>

                                            <th class="field-codigo"><a
                                                    href="/admin/recaudo/cliente/28739/change/?_changelist_filters=o%3D">1040495733-5</a>
                                            </th>

                                            <td class="field-nombre">ARACELIS DIAZ RUIZ</td>

                                            <td class="field-cobro nowrap">AYAPEL</td>

                                            <td class="field-telefono">3218298414</td>

                                            <td class="field-orden">2</td>

                                            <td class="field-reorden"><a href="/cliente/orden/28739/1/">2 - Enrutar</a>
                                            </td>

                                        </tr>


                                        <tr class="row1">

                                            <td class="action-checkbox"><input class="action-select"
                                                    name="_selected_action" type="checkbox" value="35460" /></td>

                                            <th class="field-codigo"><a
                                                    href="/admin/recaudo/cliente/35460/change/?_changelist_filters=o%3D">9140226-5</a>
                                            </th>

                                            <td class="field-nombre">MISAEL MEZA CASTRO</td>

                                            <td class="field-cobro nowrap">AYAPEL</td>

                                            <td class="field-telefono">3108606879</td>

                                            <td class="field-orden">3</td>

                                            <td class="field-reorden"><a href="/cliente/orden/35460/1/">3 - Enrutar</a>
                                            </td>

                                        </tr>


                                        <tr class="row2">

                                            <td class="action-checkbox"><input class="action-select"
                                                    name="_selected_action" type="checkbox" value="49080" /></td>

                                            <th class="field-codigo"><a
                                                    href="/admin/recaudo/cliente/49080/change/?_changelist_filters=o%3D">11059384-2</a>
                                            </th>

                                            <td class="field-nombre">GREGORIO PACHECO CASTILLO</td>

                                            <td class="field-cobro nowrap">AYAPEL</td>

                                            <td class="field-telefono">3206874433</td>

                                            <td class="field-orden">4</td>

                                            <td class="field-reorden"><a href="/cliente/orden/49080/1/">4 - Enrutar</a>
                                            </td>

                                        </tr>


                                        <tr class="row1">

                                            <td class="action-checkbox"><input class="action-select"
                                                    name="_selected_action" type="checkbox" value="8768" /></td>

                                            <th class="field-codigo"><a
                                                    href="/admin/recaudo/cliente/8768/change/?_changelist_filters=o%3D">25996138</a>
                                            </th>

                                            <td class="field-nombre">PRESTAMO PARA LOS CLAVO</td>

                                            <td class="field-cobro nowrap">AYAPEL</td>

                                            <td class="field-telefono">3125159610</td>

                                            <td class="field-orden">5</td>

                                            <td class="field-reorden"><a href="/cliente/orden/8768/1/">5 - Enrutar</a>
                                            </td>

                                        </tr>


                                        <tr class="row2">

                                            <td class="action-checkbox"><input class="action-select"
                                                    name="_selected_action" type="checkbox" value="59712" /></td>

                                            <th class="field-codigo"><a
                                                    href="/admin/recaudo/cliente/59712/change/?_changelist_filters=o%3D">78110206-1</a>
                                            </th>

                                            <td class="field-nombre">EDUARDO LOPEZ RAMOS</td>

                                            <td class="field-cobro nowrap">AYAPEL</td>

                                            <td class="field-telefono">3227887473.</td>

                                            <td class="field-orden">6</td>

                                            <td class="field-reorden"><a href="/cliente/orden/59712/1/">6 - Enrutar</a>
                                            </td>

                                        </tr>


                                        <tr class="row1">

                                            <td class="action-checkbox"><input class="action-select"
                                                    name="_selected_action" type="checkbox" value="52929" /></td>

                                            <th class="field-codigo"><a
                                                    href="/admin/recaudo/cliente/52929/change/?_changelist_filters=o%3D">78110206</a>
                                            </th>

                                            <td class="field-nombre">EDUARDO LOPEZ RAMOS</td>

                                            <td class="field-cobro nowrap">AYAPEL</td>

                                            <td class="field-telefono">3227887473.</td>

                                            <td class="field-orden">7</td>

                                            <td class="field-reorden"><a href="/cliente/orden/52929/1/">7 - Enrutar</a>
                                            </td>

                                        </tr>


                                        <tr class="row2">

                                            <td class="action-checkbox"><input class="action-select"
                                                    name="_selected_action" type="checkbox" value="35172" /></td>

                                            <th class="field-codigo"><a
                                                    href="/admin/recaudo/cliente/35172/change/?_changelist_filters=o%3D">63486268-5</a>
                                            </th>

                                            <td class="field-nombre">OSIRIS FABRA</td>

                                            <td class="field-cobro nowrap">AYAPEL</td>

                                            <td class="field-telefono">3212948512</td>

                                            <td class="field-orden">8</td>

                                            <td class="field-reorden"><a href="/cliente/orden/35172/1/">8 - Enrutar</a>
                                            </td>

                                        </tr>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="navbar navbar-default">
                        <div class="navbar-inner">
                            <div class="navbar-form pull-left">

                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="pagination">
                            <li><span class="this-page">1</span> </li>
                            <li><a href="?o=&amp;p=1">2</a> </li>
                            <li><a href="?o=&amp;p=2">3</a> </li>
                            <li><a href="?o=&amp;p=3">4</a> </li>
                            <li><span>... </span></li>
                            <li><a href="?o=&amp;p=581">582</a> </li>
                            <li><a href="?o=&amp;p=582" class="end">583</a> </li>
                        </ul>
                    </div>
                </form>
            </div>
            <!-- END Content -->

            <footer id="footer"></footer>
        </div>
        <!-- END Container -->

</body>

</html>