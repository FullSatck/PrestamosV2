

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="es-co" >
<head>
    <title>Escoja cliente a modificar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    
  
  <link rel="stylesheet" type="text/css" href="/static/admin/css/changelists.css" />
  
  
    
    <script type="text/javascript" src="/admin/jsi18n/"></script>
  
  


    <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/views/assets/css/clientes.css" />
    

    <script type="text/javascript">
    //<![CDATA[
        window.__admin_media_prefix__ = "/static/admin/";
        window.__admin_utc_offset__ = "\u002D18000";
    //]]>
    </script>
    <script src="/static/admin/js/jquery-1.9.1.min.js"></script>
    <script src="/static/admin/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>

    

<script type="text/javascript" src="/static/admin/js/core.js"></script>
<script type="text/javascript" src="/static/admin/js/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/admin/js/jquery.init.js"></script>
<script type="text/javascript" src="/static/admin/js/admin/RelatedObjectLookups.js"></script>
<script type="text/javascript" src="/static/admin/js/actions.min.js"></script>
<script type="text/javascript" src="/static/admin/js/urlify.js"></script>
<script type="text/javascript" src="/static/admin/js/prepopulate.min.js"></script>
<script type="text/javascript" src="/static/admin/js/vendor/xregexp/xregexp.min.js"></script>

<script type="text/javascript">
(function($) {
    $(document).ready(function($) {
        $("tr input.action-select").actions();
    });
})(django.jQuery);
</script>



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


<body class=" recaudo- change-list">

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
                        
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#content-navbar-collapse" aria-expanded="false" aria-controls="navbar">
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
        
        <a role="button" href="/admin/recaudo/cliente/add/?_changelist_filters=o%3D" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span> Añadir cliente
        </a>
        </li>
        
        
    </ul>

    
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Filtro <span class="caret"></span></a>
            <ul class="dropdown-menu pull-right scrollable-dropdown-menu">
                
                    
    <li class="dropdown-header"> Por cobro </li>

    <li class="active"><a href="?o=">Todo</a></li>

    <li class=""><a href="?cobro__id__exact=1&amp;o=">AYAPEL</a></li>

    <li class=""><a href="?cobro__id__exact=2&amp;o=">BAGRE 1</a></li>

    <li class=""><a href="?cobro__id__exact=3&amp;o=">CARACOLI</a></li>

    <li class=""><a href="?cobro__id__exact=4&amp;o=">CAUCA 1</a></li>

    <li class=""><a href="?cobro__id__exact=5&amp;o=">CAUCASIA</a></li>

    <li class=""><a href="?cobro__id__exact=7&amp;o=">EL 27</a></li>

    <li class=""><a href="?cobro__id__exact=6&amp;o=">EL  50</a></li>

    <li class=""><a href="?cobro__id__exact=8&amp;o=">ESPERANZA</a></li>

    <li class=""><a href="?cobro__id__exact=9&amp;o=">JARDIN</a></li>

    <li class=""><a href="?cobro__id__exact=10&amp;o=">LA  APARTADA</a></li>

    <li class=""><a href="?cobro__id__exact=11&amp;o=">LA CRUZADA</a></li>

    <li class=""><a href="?cobro__id__exact=12&amp;o=">LA FLORESTA</a></li>

    <li class=""><a href="?cobro__id__exact=31&amp;o=">LAS BRISAS</a></li>

    <li class=""><a href="?cobro__id__exact=15&amp;o=">LAS MALVINAS</a></li>

    <li class=""><a href="?cobro__id__exact=13&amp;o=">LA VEGA</a></li>

    <li class=""><a href="?cobro__id__exact=34&amp;o=">MONACO</a></li>

    <li class=""><a href="?cobro__id__exact=38&amp;o=">MONTELIBANO</a></li>

    <li class=""><a href="?cobro__id__exact=29&amp;o=">PALIZADA</a></li>

    <li class=""><a href="?cobro__id__exact=17&amp;o=">PLANETA</a></li>

    <li class=""><a href="?cobro__id__exact=39&amp;o=">PORTUGAL</a></li>

    <li class=""><a href="?cobro__id__exact=18&amp;o=">PTO LIBERTADOR</a></li>

    <li class=""><a href="?cobro__id__exact=19&amp;o=">PUEBLO NUEVO</a></li>

    <li class=""><a href="?cobro__id__exact=30&amp;o=">REMEDIOS</a></li>

    <li class=""><a href="?cobro__id__exact=20&amp;o=">SAN BARTOLO</a></li>

    <li class=""><a href="?cobro__id__exact=35&amp;o=">SAN CLEMENTE</a></li>

    <li class=""><a href="?cobro__id__exact=32&amp;o=">SAN JOSE</a></li>

    <li class=""><a href="?cobro__id__exact=36&amp;o=">SAN PEDRO</a></li>

    <li class=""><a href="?cobro__id__exact=23&amp;o=">TIERRA ALTA</a></li>

    <li class=""><a href="?cobro__id__exact=24&amp;o=">TIERRA ALTA 2</a></li>

    <li class=""><a href="?cobro__id__exact=33&amp;o=">VALENCIA</a></li>

    <li class=""><a href="?cobro__id__exact=25&amp;o=">VILLA CLEMEN</a></li>

    <li class=""><a href="?cobro__id__exact=26&amp;o=">ZARAGOZA</a></li>

    <li class=""><a href="?cobro__id__exact=27&amp;o=">ZARAGOZA 2</a></li>


                
            </ul>
        </li>
    </ul>
    
    


<form class="navbar-form navbar-right" role="search" id="changelist-search" action="" method="get">
    <div class="form-group"><!-- DIV needed for valid HTML -->
        <input type="text" class="form-control search-query" placeholder="Buscar" size="25" name="q" value="" id="searchbar" />
    </div>
    <button type="submit" class="btn btn-default">Buscar</button>


    <input type="hidden" name="o" value=""/>

</form>
<script type="text/javascript">document.getElementById("searchbar").focus();</script>


</div>

            </div>
        </div>
        

        
        
        

        
<form class="" id="changelist-form" action="" method="post" novalidate><input type='hidden' name='csrfmiddlewaretoken' value='vAwJi8sYs63k1jDegumHANYqxGd1izXksMrwIXFAE2mK4MIEQrTXz3dEjWuvvNrP' />





    



<div class='pull-left'>
<div class="actions form-group">
    <span style="vertical-align:sub">Acción:</span> <select class="form-control" name="action" title="" required>
<option value="" selected="selected">---------</option>
<option value="delete_selected">Eliminar clientes seleccionado/s</option>
</select><input class="select-across" name="select_across" type="hidden" value="0" />
    <button type="submit" class="btn btn-default" title="Ejecutar la acción seleccionada" name="index" value="0">Ir</button>
    
        <script type="text/javascript">var _actions_icnt="100";</script>
        <span class="action-counter">seleccionados 0 de 100</span>
        
        <span class="all" style="vertical-align:sub">58211 seleccionados en total</span>
        <span class="question"><a class="btn btn-default" href="javascript:;" title="Pulse aquí para seleccionar los objetos a través de todas las páginas">Seleccionar todos los 58211 clientes</a></span>
        <span class="clear"><a class="btn btn-default" href="javascript:;">Limpiar selección</a></span>
        
    
</div>
</div>


<div id="content-main">
    <div class="module filtered" id="_changelist">
        
            

        

        

        
            


<div class="results">
<table id="result_list" class="table table-striped table-bordered">
<thead>
<tr>

<th scope="col"  class="action-checkbox-column">
   
   <span><input type="checkbox" id="action-toggle" /></span>
</th>
<th scope="col"  class="sortable column-codigo">
   
     
   
   <a href="?o=1">Código</a>
</th>
<th scope="col"  class="sortable column-nombre">
   
     
   
   <a href="?o=2">Nombre</a>
</th>
<th scope="col"  class="sortable column-cobro">
   
     
   
   <a href="?o=3">Cobro</a>
</th>
<th scope="col"  class="sortable column-telefono">
   
     
   
   <a href="?o=4">Teléfono</a>
</th>
<th scope="col"  class="sortable column-orden">
   
     
   
   <a href="?o=5">Orden</a>
</th>
<th scope="col"  class="column-reorden">
   
   <span>Enrutar</span>
</th>
</tr>
</thead>
<tbody>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="12358" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/12358/change/?_changelist_filters=o%3D">43894466-1</a></th>
    
        <td class="field-nombre">JUANA MIELES SALGADO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3235916586</td>
    
        <td class="field-orden">1</td>
    
        <td class="field-reorden"><a href="/cliente/orden/12358/1/">1 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="28739" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/28739/change/?_changelist_filters=o%3D">1040495733-5</a></th>
    
        <td class="field-nombre">ARACELIS DIAZ RUIZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3218298414</td>
    
        <td class="field-orden">2</td>
    
        <td class="field-reorden"><a href="/cliente/orden/28739/1/">2 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="35460" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/35460/change/?_changelist_filters=o%3D">9140226-5</a></th>
    
        <td class="field-nombre">MISAEL MEZA CASTRO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3108606879</td>
    
        <td class="field-orden">3</td>
    
        <td class="field-reorden"><a href="/cliente/orden/35460/1/">3 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="49080" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/49080/change/?_changelist_filters=o%3D">11059384-2</a></th>
    
        <td class="field-nombre">GREGORIO PACHECO CASTILLO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3206874433</td>
    
        <td class="field-orden">4</td>
    
        <td class="field-reorden"><a href="/cliente/orden/49080/1/">4 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="8768" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/8768/change/?_changelist_filters=o%3D">25996138</a></th>
    
        <td class="field-nombre">PRESTAMO PARA LOS CLAVO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3125159610</td>
    
        <td class="field-orden">5</td>
    
        <td class="field-reorden"><a href="/cliente/orden/8768/1/">5 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59712" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59712/change/?_changelist_filters=o%3D">78110206-1</a></th>
    
        <td class="field-nombre">EDUARDO LOPEZ RAMOS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3227887473.</td>
    
        <td class="field-orden">6</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59712/1/">6 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="52929" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/52929/change/?_changelist_filters=o%3D">78110206</a></th>
    
        <td class="field-nombre">EDUARDO LOPEZ RAMOS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3227887473.</td>
    
        <td class="field-orden">7</td>
    
        <td class="field-reorden"><a href="/cliente/orden/52929/1/">7 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="35172" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/35172/change/?_changelist_filters=o%3D">63486268-5</a></th>
    
        <td class="field-nombre">OSIRIS FABRA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3212948512</td>
    
        <td class="field-orden">8</td>
    
        <td class="field-reorden"><a href="/cliente/orden/35172/1/">8 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="4419" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/4419/change/?_changelist_filters=o%3D">1066569200-1</a></th>
    
        <td class="field-nombre">YINA CORREA MIELES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3227887473.</td>
    
        <td class="field-orden">9</td>
    
        <td class="field-reorden"><a href="/cliente/orden/4419/1/">9 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59589" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59589/change/?_changelist_filters=o%3D">39283997</a></th>
    
        <td class="field-nombre">GRISELIDA RODRIGUE CIERRA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3145223024</td>
    
        <td class="field-orden">10</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59589/1/">10 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="51297" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/51297/change/?_changelist_filters=o%3D">1066570979</a></th>
    
        <td class="field-nombre">MARYEINIS PAOLA ESCORSIA MIELES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3206762088.</td>
    
        <td class="field-orden">10</td>
    
        <td class="field-reorden"><a href="/cliente/orden/51297/1/">10 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="58651" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/58651/change/?_changelist_filters=o%3D">35163661</a></th>
    
        <td class="field-nombre">ENID ESCOBAR ALVARES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3043929502</td>
    
        <td class="field-orden">11</td>
    
        <td class="field-reorden"><a href="/cliente/orden/58651/1/">11 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59979" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59979/change/?_changelist_filters=o%3D">1003289238</a></th>
    
        <td class="field-nombre">KATIA JHOANA MIELES CORSIA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3218881399</td>
    
        <td class="field-orden">12</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59979/1/">12 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="16911" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/16911/change/?_changelist_filters=o%3D">1066568772</a></th>
    
        <td class="field-nombre">ANGIE MARCELA MONTERROSA MARTINEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3229315906</td>
    
        <td class="field-orden">12</td>
    
        <td class="field-reorden"><a href="/cliente/orden/16911/1/">12 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="16519" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/16519/change/?_changelist_filters=o%3D">98649859-1</a></th>
    
        <td class="field-nombre">HUMBERTO RUIZ VERGARA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3135154603</td>
    
        <td class="field-orden">13</td>
    
        <td class="field-reorden"><a href="/cliente/orden/16519/1/">13 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="4909" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/4909/change/?_changelist_filters=o%3D">1069469056-1</a></th>
    
        <td class="field-nombre">LILIANA PIMIENTA ALDANA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3135074232</td>
    
        <td class="field-orden">14</td>
    
        <td class="field-reorden"><a href="/cliente/orden/4909/1/">14 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="54358" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/54358/change/?_changelist_filters=o%3D">26050961</a></th>
    
        <td class="field-nombre">MARIA GARCES RAMOS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3122212615.</td>
    
        <td class="field-orden">15</td>
    
        <td class="field-reorden"><a href="/cliente/orden/54358/1/">15 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="53175" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/53175/change/?_changelist_filters=o%3D">15305767</a></th>
    
        <td class="field-nombre">OBIDIO SEGUNDO RUIZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3122212615</td>
    
        <td class="field-orden">16</td>
    
        <td class="field-reorden"><a href="/cliente/orden/53175/1/">16 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59980" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59980/change/?_changelist_filters=o%3D">1066574839</a></th>
    
        <td class="field-nombre">YULIETH HERAZO ESCOBAR</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3217724933</td>
    
        <td class="field-orden">17</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59980/1/">17 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59775" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59775/change/?_changelist_filters=o%3D">1007565076</a></th>
    
        <td class="field-nombre">ROXANA YANOS GUARNES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3043774035</td>
    
        <td class="field-orden">17</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59775/1/">17 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="30956" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/30956/change/?_changelist_filters=o%3D">1032252560</a></th>
    
        <td class="field-nombre">ERIS VALENCIA GARCES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3122175409.</td>
    
        <td class="field-orden">18</td>
    
        <td class="field-reorden"><a href="/cliente/orden/30956/1/">18 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="4486" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/4486/change/?_changelist_filters=o%3D">1066573604</a></th>
    
        <td class="field-nombre">CRISTINA ISABEL MADERA HOYOS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3106590411.</td>
    
        <td class="field-orden">19</td>
    
        <td class="field-reorden"><a href="/cliente/orden/4486/1/">19 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="26643" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/26643/change/?_changelist_filters=o%3D">39273520-1</a></th>
    
        <td class="field-nombre">LIRIA MARIA HOYOS PATERNINA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3106590412.</td>
    
        <td class="field-orden">20</td>
    
        <td class="field-reorden"><a href="/cliente/orden/26643/1/">20 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="12357" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/12357/change/?_changelist_filters=o%3D">43894466</a></th>
    
        <td class="field-nombre">JUANA FRANCISCA MIELES SALGADO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3235916586.</td>
    
        <td class="field-orden">20</td>
    
        <td class="field-reorden"><a href="/cliente/orden/12357/1/">20 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="41592" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/41592/change/?_changelist_filters=o%3D">1066574068</a></th>
    
        <td class="field-nombre">ARLEN MANUEL MONTIEL VAZQUEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3116260904.</td>
    
        <td class="field-orden">21</td>
    
        <td class="field-reorden"><a href="/cliente/orden/41592/1/">21 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="52370" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/52370/change/?_changelist_filters=o%3D">1003288771</a></th>
    
        <td class="field-nombre">LUISA ELY PESTANA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3116260904.</td>
    
        <td class="field-orden">22</td>
    
        <td class="field-reorden"><a href="/cliente/orden/52370/1/">22 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="40983" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/40983/change/?_changelist_filters=o%3D">1067093446</a></th>
    
        <td class="field-nombre">WENDY DAYANA OSORIO BERVEL</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3225853697.</td>
    
        <td class="field-orden">23</td>
    
        <td class="field-reorden"><a href="/cliente/orden/40983/1/">23 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="57224" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/57224/change/?_changelist_filters=o%3D">1003288468</a></th>
    
        <td class="field-nombre">CAMILA ANDREA MARSOLA CARMONA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3245652121</td>
    
        <td class="field-orden">24</td>
    
        <td class="field-reorden"><a href="/cliente/orden/57224/1/">24 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="40073" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/40073/change/?_changelist_filters=o%3D">1003290940</a></th>
    
        <td class="field-nombre">AMAURI JOSE MARZOLA CARMONA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3115433998.</td>
    
        <td class="field-orden">25</td>
    
        <td class="field-reorden"><a href="/cliente/orden/40073/1/">25 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="31604" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/31604/change/?_changelist_filters=o%3D">35145000</a></th>
    
        <td class="field-nombre">BERLIDES PADILLA PEREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3105338378.</td>
    
        <td class="field-orden">26</td>
    
        <td class="field-reorden"><a href="/cliente/orden/31604/1/">26 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="9416" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/9416/change/?_changelist_filters=o%3D">30571233-1</a></th>
    
        <td class="field-nombre">DANIS DEL ROSARIO ALDANA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3135077232</td>
    
        <td class="field-orden">26</td>
    
        <td class="field-reorden"><a href="/cliente/orden/9416/1/">26 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="7331" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/7331/change/?_changelist_filters=o%3D">15745458</a></th>
    
        <td class="field-nombre">JUAN DAVID HOYOS ALVAREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3128274524.</td>
    
        <td class="field-orden">27</td>
    
        <td class="field-reorden"><a href="/cliente/orden/7331/1/">27 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59685" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59685/change/?_changelist_filters=o%3D">22242554-1</a></th>
    
        <td class="field-nombre">ANA RAQUEL ESCOBAR ROMERO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3169244466</td>
    
        <td class="field-orden">28</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59685/1/">28 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="53479" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/53479/change/?_changelist_filters=o%3D">1067091053</a></th>
    
        <td class="field-nombre">CAROLINA PABUENA LERECHS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3106069879.</td>
    
        <td class="field-orden">28</td>
    
        <td class="field-reorden"><a href="/cliente/orden/53479/1/">28 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="10170" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/10170/change/?_changelist_filters=o%3D">35163104</a></th>
    
        <td class="field-nombre">GLENIS ROSA BOORQUEZ PEREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3145045715.</td>
    
        <td class="field-orden">29</td>
    
        <td class="field-reorden"><a href="/cliente/orden/10170/1/">29 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59794" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59794/change/?_changelist_filters=o%3D">1066569711</a></th>
    
        <td class="field-nombre">KAREN MILENA VELASQUES ESCOBAR</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3226262863</td>
    
        <td class="field-orden">30</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59794/1/">30 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="43632" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/43632/change/?_changelist_filters=o%3D">1066569713</a></th>
    
        <td class="field-nombre">YENIS PAOLA BARRIOS HERRERA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3223921848.</td>
    
        <td class="field-orden">30</td>
    
        <td class="field-reorden"><a href="/cliente/orden/43632/1/">30 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="15061" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/15061/change/?_changelist_filters=o%3D">78320073</a></th>
    
        <td class="field-nombre">ELIESER GARZON ORTEGA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3105117509.</td>
    
        <td class="field-orden">31</td>
    
        <td class="field-reorden"><a href="/cliente/orden/15061/1/">31 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59536" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59536/change/?_changelist_filters=o%3D">1064187859</a></th>
    
        <td class="field-nombre">MARIA JOSE CARASCAL RICARDO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3136344320.</td>
    
        <td class="field-orden">32</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59536/1/">32 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="40651" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/40651/change/?_changelist_filters=o%3D">25805645</a></th>
    
        <td class="field-nombre">NICOLASA CHICA CASTRO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3206804711.</td>
    
        <td class="field-orden">33</td>
    
        <td class="field-reorden"><a href="/cliente/orden/40651/1/">33 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59686" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59686/change/?_changelist_filters=o%3D">25998618-1</a></th>
    
        <td class="field-nombre">PAOLA FERNANDEZ HERRERA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3105042975</td>
    
        <td class="field-orden">34</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59686/1/">34 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="32677" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/32677/change/?_changelist_filters=o%3D">5587424</a></th>
    
        <td class="field-nombre">MANUEL CASTILLO GUTIERREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3108399864.</td>
    
        <td class="field-orden">35</td>
    
        <td class="field-reorden"><a href="/cliente/orden/32677/1/">35 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="20527" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/20527/change/?_changelist_filters=o%3D">50992589</a></th>
    
        <td class="field-nombre">JOSEFA DIAZ PEREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3145054738</td>
    
        <td class="field-orden">36</td>
    
        <td class="field-reorden"><a href="/cliente/orden/20527/1/">36 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59022" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59022/change/?_changelist_filters=o%3D">50946162</a></th>
    
        <td class="field-nombre">ARNUBIS ARRIETA HDEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3132782408.</td>
    
        <td class="field-orden">37</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59022/1/">37 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="29314" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/29314/change/?_changelist_filters=o%3D">39286535</a></th>
    
        <td class="field-nombre">MARYURIS HERNANDEZ ARRIETA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3215703270.</td>
    
        <td class="field-orden">38</td>
    
        <td class="field-reorden"><a href="/cliente/orden/29314/1/">38 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59231" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59231/change/?_changelist_filters=o%3D">1066568045</a></th>
    
        <td class="field-nombre">JAIME JAVIER GOMES CORONADO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3107210014.</td>
    
        <td class="field-orden">39</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59231/1/">39 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="5151" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/5151/change/?_changelist_filters=o%3D">10766445</a></th>
    
        <td class="field-nombre">RAFAEL ORTIS PADILLA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3123042381.</td>
    
        <td class="field-orden">40</td>
    
        <td class="field-reorden"><a href="/cliente/orden/5151/1/">40 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="19925" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/19925/change/?_changelist_filters=o%3D">50876121-1</a></th>
    
        <td class="field-nombre">MARIELA CARMONA TURIBIO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3135530811.</td>
    
        <td class="field-orden">41</td>
    
        <td class="field-reorden"><a href="/cliente/orden/19925/1/">41 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="4487" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/4487/change/?_changelist_filters=o%3D">1066573604-1</a></th>
    
        <td class="field-nombre">CRISTINA ISABEL MADERA HOYOS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3106590412</td>
    
        <td class="field-orden">41</td>
    
        <td class="field-reorden"><a href="/cliente/orden/4487/1/">41 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59795" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59795/change/?_changelist_filters=o%3D">1003309121</a></th>
    
        <td class="field-nombre">ESTEFANIA CARASCAL RICARDO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3135444320</td>
    
        <td class="field-orden">42</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59795/1/">42 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="52744" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/52744/change/?_changelist_filters=o%3D">50993505</a></th>
    
        <td class="field-nombre">CELINA GOMEZ CUADRADO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3007270638.</td>
    
        <td class="field-orden">42</td>
    
        <td class="field-reorden"><a href="/cliente/orden/52744/1/">42 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="57416" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/57416/change/?_changelist_filters=o%3D">1066523720</a></th>
    
        <td class="field-nombre">CESAR ORTEGA DAVILA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3007270638.</td>
    
        <td class="field-orden">43</td>
    
        <td class="field-reorden"><a href="/cliente/orden/57416/1/">43 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="56506" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/56506/change/?_changelist_filters=o%3D">71706069</a></th>
    
        <td class="field-nombre">LUIS AGUILAR CASTAÑEDA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3126663135.</td>
    
        <td class="field-orden">44</td>
    
        <td class="field-reorden"><a href="/cliente/orden/56506/1/">44 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="28479" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/28479/change/?_changelist_filters=o%3D">78112558-1</a></th>
    
        <td class="field-nombre">RAFAEL LOPEZ RAMOS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3244888840</td>
    
        <td class="field-orden">44</td>
    
        <td class="field-reorden"><a href="/cliente/orden/28479/1/">44 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="15173" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/15173/change/?_changelist_filters=o%3D">78586641</a></th>
    
        <td class="field-nombre">MARCELIANO MODESTO LOPEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3106261861.</td>
    
        <td class="field-orden">45</td>
    
        <td class="field-reorden"><a href="/cliente/orden/15173/1/">45 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="54920" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/54920/change/?_changelist_filters=o%3D">1066572274</a></th>
    
        <td class="field-nombre">ADRIANA DE HOYOS CORREA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3218107162</td>
    
        <td class="field-orden">46</td>
    
        <td class="field-reorden"><a href="/cliente/orden/54920/1/">46 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="7318" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/7318/change/?_changelist_filters=o%3D">15745019</a></th>
    
        <td class="field-nombre">JOSE MERCADO HERRERA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3502387888.</td>
    
        <td class="field-orden">47</td>
    
        <td class="field-reorden"><a href="/cliente/orden/7318/1/">47 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="10158" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/10158/change/?_changelist_filters=o%3D">35123224</a></th>
    
        <td class="field-nombre">YOLIMA MENCO ROJAS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3126627904.</td>
    
        <td class="field-orden">48</td>
    
        <td class="field-reorden"><a href="/cliente/orden/10158/1/">48 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="60016" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/60016/change/?_changelist_filters=o%3D">1003288676</a></th>
    
        <td class="field-nombre">LINA GOMEZ ORTIZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3004490165</td>
    
        <td class="field-orden">49</td>
    
        <td class="field-reorden"><a href="/cliente/orden/60016/1/">49 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="26529" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/26529/change/?_changelist_filters=o%3D">39273520</a></th>
    
        <td class="field-nombre">LIRIA HOYOS PATERNINA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3106590412.</td>
    
        <td class="field-orden">49</td>
    
        <td class="field-reorden"><a href="/cliente/orden/26529/1/">49 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="20514" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/20514/change/?_changelist_filters=o%3D">78296030</a></th>
    
        <td class="field-nombre">GUILLERMO FERNANDEZ MERCADO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3235939463</td>
    
        <td class="field-orden">50</td>
    
        <td class="field-reorden"><a href="/cliente/orden/20514/1/">50 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="54332" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/54332/change/?_changelist_filters=o%3D">39276455</a></th>
    
        <td class="field-nombre">GRACIELA HOYOS RICARDO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3137851121</td>
    
        <td class="field-orden">51</td>
    
        <td class="field-reorden"><a href="/cliente/orden/54332/1/">51 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="57851" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/57851/change/?_changelist_filters=o%3D">1066110436</a></th>
    
        <td class="field-nombre">YURIS HERNANDEZ BALSEIRO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3012026804</td>
    
        <td class="field-orden">52</td>
    
        <td class="field-reorden"><a href="/cliente/orden/57851/1/">52 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="6947" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/6947/change/?_changelist_filters=o%3D">15309030-1</a></th>
    
        <td class="field-nombre">FERNANDO ANTONIO MARZOLA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3235941983.</td>
    
        <td class="field-orden">52</td>
    
        <td class="field-reorden"><a href="/cliente/orden/6947/1/">52 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="55583" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/55583/change/?_changelist_filters=o%3D">1066725136</a></th>
    
        <td class="field-nombre">RAFAEL DARIO NARANJO RAMOS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3216975184.</td>
    
        <td class="field-orden">53</td>
    
        <td class="field-reorden"><a href="/cliente/orden/55583/1/">53 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="18460" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/18460/change/?_changelist_filters=o%3D">39276925</a></th>
    
        <td class="field-nombre">DORIS TORRES PEREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3205276824</td>
    
        <td class="field-orden">54</td>
    
        <td class="field-reorden"><a href="/cliente/orden/18460/1/">54 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="6120" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/6120/change/?_changelist_filters=o%3D">25991911</a></th>
    
        <td class="field-nombre">IBET PATRICIA PEÑA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3136351727.</td>
    
        <td class="field-orden">54</td>
    
        <td class="field-reorden"><a href="/cliente/orden/6120/1/">54 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="27938" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/27938/change/?_changelist_filters=o%3D">39276302</a></th>
    
        <td class="field-nombre">GLORIA PATRICIA TORRES TORRES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3235027869.</td>
    
        <td class="field-orden">55</td>
    
        <td class="field-reorden"><a href="/cliente/orden/27938/1/">55 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="29464" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/29464/change/?_changelist_filters=o%3D">1066574800</a></th>
    
        <td class="field-nombre">ANDRES DAVID RUIZ TORRES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3234119666.</td>
    
        <td class="field-orden">56</td>
    
        <td class="field-reorden"><a href="/cliente/orden/29464/1/">56 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="26899" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/26899/change/?_changelist_filters=o%3D">35163019</a></th>
    
        <td class="field-nombre">MIRIAM CECILIA MIELES SALGADO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3226267832.</td>
    
        <td class="field-orden">57</td>
    
        <td class="field-reorden"><a href="/cliente/orden/26899/1/">57 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="16634" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/16634/change/?_changelist_filters=o%3D">98654390</a></th>
    
        <td class="field-nombre">FRANKLIN DE JESUS MORALES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3217114402</td>
    
        <td class="field-orden">58</td>
    
        <td class="field-reorden"><a href="/cliente/orden/16634/1/">58 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="58102" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/58102/change/?_changelist_filters=o%3D">1066574345</a></th>
    
        <td class="field-nombre">JOSE FRANCISCO AGUILAR  ARAVIA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3143034932.</td>
    
        <td class="field-orden">59</td>
    
        <td class="field-reorden"><a href="/cliente/orden/58102/1/">59 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="32583" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/32583/change/?_changelist_filters=o%3D">73548562</a></th>
    
        <td class="field-nombre">RUFINO PEREZ DE LA CRUZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3205656356</td>
    
        <td class="field-orden">59</td>
    
        <td class="field-reorden"><a href="/cliente/orden/32583/1/">59 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59590" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59590/change/?_changelist_filters=o%3D">15676316-2</a></th>
    
        <td class="field-nombre">LUIS MIGUEL MANCILLA CALLE</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3217731075.</td>
    
        <td class="field-orden">60</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59590/1/">60 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="26492" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/26492/change/?_changelist_filters=o%3D">1063305856</a></th>
    
        <td class="field-nombre">WILMAR ANTONIO RIVERA CASTRO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3002233596</td>
    
        <td class="field-orden">61</td>
    
        <td class="field-reorden"><a href="/cliente/orden/26492/1/">61 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59776" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59776/change/?_changelist_filters=o%3D">1066569343</a></th>
    
        <td class="field-nombre">JORGE ARMANDO VALLESTERO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3137074256</td>
    
        <td class="field-orden">62</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59776/1/">62 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="23043" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/23043/change/?_changelist_filters=o%3D">35145000-1</a></th>
    
        <td class="field-nombre">BERLIDES PADILLA PEREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3217080188</td>
    
        <td class="field-orden">62</td>
    
        <td class="field-reorden"><a href="/cliente/orden/23043/1/">62 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="60391" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/60391/change/?_changelist_filters=o%3D">39280820-1</a></th>
    
        <td class="field-nombre">ELSA  MARGARITA  HERNANDEZ TORRES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3225197531.</td>
    
        <td class="field-orden">63</td>
    
        <td class="field-reorden"><a href="/cliente/orden/60391/1/">63 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="14805" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/14805/change/?_changelist_filters=o%3D">78296087</a></th>
    
        <td class="field-nombre">JAIME ANTONIO CANTERO SOLANO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3136636793.</td>
    
        <td class="field-orden">64</td>
    
        <td class="field-reorden"><a href="/cliente/orden/14805/1/">64 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="26530" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/26530/change/?_changelist_filters=o%3D">10875312</a></th>
    
        <td class="field-nombre">JULIO ENRRIQUE LOPEZ ARRIETA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3001115634.</td>
    
        <td class="field-orden">65</td>
    
        <td class="field-reorden"><a href="/cliente/orden/26530/1/">65 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59212" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59212/change/?_changelist_filters=o%3D">1081825444</a></th>
    
        <td class="field-nombre">JAINER JOSE DE LEON PERES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3233092557</td>
    
        <td class="field-orden">66</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59212/1/">66 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="44473" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/44473/change/?_changelist_filters=o%3D">78105864</a></th>
    
        <td class="field-nombre">GILBERTO GIL  BARRANGAN</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3132225020</td>
    
        <td class="field-orden">66</td>
    
        <td class="field-reorden"><a href="/cliente/orden/44473/1/">66 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="49668" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/49668/change/?_changelist_filters=o%3D">1066511546</a></th>
    
        <td class="field-nombre">LEONARDO FAVIO BEDOYA LOPEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3235067748.</td>
    
        <td class="field-orden">67</td>
    
        <td class="field-reorden"><a href="/cliente/orden/49668/1/">67 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="55241" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/55241/change/?_changelist_filters=o%3D">1193224937</a></th>
    
        <td class="field-nombre">ENITH HEREDIA MENDEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3235067748</td>
    
        <td class="field-orden">68</td>
    
        <td class="field-reorden"><a href="/cliente/orden/55241/1/">68 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="27178" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/27178/change/?_changelist_filters=o%3D">15745240-1</a></th>
    
        <td class="field-nombre">HECTOR ALFONSO PARADA YANEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3113891549.</td>
    
        <td class="field-orden">68</td>
    
        <td class="field-reorden"><a href="/cliente/orden/27178/1/">68 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="13193" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/13193/change/?_changelist_filters=o%3D">50943154</a></th>
    
        <td class="field-nombre">ANA ISABEL MORELO PEREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3117155677.</td>
    
        <td class="field-orden">69</td>
    
        <td class="field-reorden"><a href="/cliente/orden/13193/1/">69 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="50525" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/50525/change/?_changelist_filters=o%3D">78111091</a></th>
    
        <td class="field-nombre">SALVADOR JANNA VERGARA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3206094820.</td>
    
        <td class="field-orden">70</td>
    
        <td class="field-reorden"><a href="/cliente/orden/50525/1/">70 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="25432" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/25432/change/?_changelist_filters=o%3D">1066512897</a></th>
    
        <td class="field-nombre">ENEIDA DEL CARMEN HOYOS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3104153342.</td>
    
        <td class="field-orden">71</td>
    
        <td class="field-reorden"><a href="/cliente/orden/25432/1/">71 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59591" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59591/change/?_changelist_filters=o%3D">1007075999</a></th>
    
        <td class="field-nombre">DEIVER LUNA ARGUMEDO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3205322756</td>
    
        <td class="field-orden">72</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59591/1/">72 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="49756" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/49756/change/?_changelist_filters=o%3D">43611091</a></th>
    
        <td class="field-nombre">NARLIS NEGRETE TOUS</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3106275304.</td>
    
        <td class="field-orden">72</td>
    
        <td class="field-reorden"><a href="/cliente/orden/49756/1/">72 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="59687" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/59687/change/?_changelist_filters=o%3D">1066515736-1</a></th>
    
        <td class="field-nombre">DEIVIS MANUEL BEDOYA LOPEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3206655267</td>
    
        <td class="field-orden">73</td>
    
        <td class="field-reorden"><a href="/cliente/orden/59687/1/">73 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="37411" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/37411/change/?_changelist_filters=o%3D">1066518353</a></th>
    
        <td class="field-nombre">RAFAEL DARIO CORRALES CORRALES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">32089535104</td>
    
        <td class="field-orden">74</td>
    
        <td class="field-reorden"><a href="/cliente/orden/37411/1/">74 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="25537" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/25537/change/?_changelist_filters=o%3D">1007545822</a></th>
    
        <td class="field-nombre">MARIA JOSE MARQUEZ MARTINEZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3208953514.</td>
    
        <td class="field-orden">75</td>
    
        <td class="field-reorden"><a href="/cliente/orden/25537/1/">75 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="53587" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/53587/change/?_changelist_filters=o%3D">8048401</a></th>
    
        <td class="field-nombre">LEONARDO NISPERUZA FLOREZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3103841152.</td>
    
        <td class="field-orden">76</td>
    
        <td class="field-reorden"><a href="/cliente/orden/53587/1/">76 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="39712" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/39712/change/?_changelist_filters=o%3D">78296760</a></th>
    
        <td class="field-nombre">SANTIAGO SAEZ RIVERO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3233414995</td>
    
        <td class="field-orden">76</td>
    
        <td class="field-reorden"><a href="/cliente/orden/39712/1/">76 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="53681" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/53681/change/?_changelist_filters=o%3D">25808744</a></th>
    
        <td class="field-nombre">CARMEN NAVARRO ATENCIA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3145349596.</td>
    
        <td class="field-orden">77</td>
    
        <td class="field-reorden"><a href="/cliente/orden/53681/1/">77 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="43655" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/43655/change/?_changelist_filters=o%3D">1007925847</a></th>
    
        <td class="field-nombre">YIRLEY PAOLA MERCADO GONZALES</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3235986435.</td>
    
        <td class="field-orden">78</td>
    
        <td class="field-reorden"><a href="/cliente/orden/43655/1/">78 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="57801" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/57801/change/?_changelist_filters=o%3D">1064896182</a></th>
    
        <td class="field-nombre">EMAR DAVID VARGAS RUIZ</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3145209596</td>
    
        <td class="field-orden">79</td>
    
        <td class="field-reorden"><a href="/cliente/orden/57801/1/">79 - Enrutar</a></td>
    
</tr>


<tr class="row1">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="55292" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/55292/change/?_changelist_filters=o%3D">1066524447</a></th>
    
        <td class="field-nombre">YONI GERONIM0 RUIZ NAVARRO</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3145209596.</td>
    
        <td class="field-orden">80</td>
    
        <td class="field-reorden"><a href="/cliente/orden/55292/1/">80 - Enrutar</a></td>
    
</tr>


<tr class="row2">
    
        <td class="action-checkbox"><input class="action-select" name="_selected_action" type="checkbox" value="23631" /></td>
    
        <th class="field-codigo"><a href="/admin/recaudo/cliente/23631/change/?_changelist_filters=o%3D">78106889</a></th>
    
        <td class="field-nombre">EDER ENRRIQUE MASTINEZ VERGARA</td>
    
        <td class="field-cobro nowrap">AYAPEL</td>
    
        <td class="field-telefono">3013739556.</td>
    
        <td class="field-orden">81</td>
    
        <td class="field-reorden"><a href="/cliente/orden/23631/1/">81 - Enrutar</a></td>
    
</tr>

</tbody>
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
    <p>
        58211 clientes
        
    </p>
</div>



</form>

        
    </div>
    <!-- END Content -->

    <footer id="footer"></footer>
</div>
<!-- END Container -->

</body>
</html>
