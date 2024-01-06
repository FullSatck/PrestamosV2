<?php

require_once 'conexion.php';

// Comprobar permisos
// Obtener el ID del usuario actual (suponiendo que ya tengas esta información)
$usuario_id = $_SESSION["usuario_id"];

// Consulta para verificar si el usuario tiene el permiso "Desatrasar"
$sql_permiso_desatrasar = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_desatrasar = $conexion->prepare($sql_permiso_desatrasar);
$permiso_desatrasar_id = 1; // Reemplaza con el ID del permiso "Desatrasar" en la tabla de permisos
$stmt_permiso_desatrasar->bind_param("ii", $usuario_id, $permiso_desatrasar_id);
$stmt_permiso_desatrasar->execute();
$stmt_permiso_desatrasar->bind_result($permiso_desatrasar_count);
$stmt_permiso_desatrasar->fetch();
$stmt_permiso_desatrasar->close();

// Consulta para verificar si el usuario tiene el permiso "VerFiltros"
$sql_permiso_ver_filtros = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_ver_filtros = $conexion->prepare($sql_permiso_ver_filtros);
$permiso_ver_filtros_id = 2; // Reemplaza con el ID del permiso "VerFiltros" en la tabla de permisos
$stmt_permiso_ver_filtros->bind_param("ii", $usuario_id, $permiso_ver_filtros_id);
$stmt_permiso_ver_filtros->execute();
$stmt_permiso_ver_filtros->bind_result($permiso_ver_filtros_count);
$stmt_permiso_ver_filtros->fetch();
$stmt_permiso_ver_filtros->close();

// Consulta para verificar si el usuario tiene el permiso "Abonos"
$sql_permiso_abonos = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_abonos = $conexion->prepare($sql_permiso_abonos);
$permiso_abonos_id = 3; // Reemplaza con el ID del permiso "Abonos" en la tabla de permisos
$stmt_permiso_abonos->bind_param("ii", $usuario_id, $permiso_abonos_id);
$stmt_permiso_abonos->execute();
$stmt_permiso_abonos->bind_result($permiso_abonos_count);
$stmt_permiso_abonos->fetch();
$stmt_permiso_abonos->close();

// Consulta para verificar si el usuario tiene el permiso "Comision"
$sql_permiso_comision = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_comision = $conexion->prepare($sql_permiso_comision);
$permiso_comision_id = 4; // Reemplaza con el ID del permiso "Comision" en la tabla de permisos
$stmt_permiso_comision->bind_param("ii", $usuario_id, $permiso_comision_id);
$stmt_permiso_comision->execute();
$stmt_permiso_comision->bind_result($permiso_comision_count);
$stmt_permiso_comision->fetch();
$stmt_permiso_comision->close();


// Permiso para "List De Clientes"
$permiso_listar_clientes_id = 5;
$sql_permiso_listar_clientes = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_listar_clientes = $conexion->prepare($sql_permiso_listar_clientes);
$stmt_permiso_listar_clientes->bind_param("ii", $usuario_id, $permiso_listar_clientes_id);
$stmt_permiso_listar_clientes->execute();
$stmt_permiso_listar_clientes->bind_result($permiso_listar_clientes_count);
$stmt_permiso_listar_clientes->fetch();
$stmt_permiso_listar_clientes->close();


// Permiso para "Recaudos"
$permiso_recaudos_id = 6;
$sql_permiso_recaudos = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_recaudos = $conexion->prepare($sql_permiso_recaudos);
$stmt_permiso_recaudos->bind_param("ii", $usuario_id, $permiso_recaudos_id);
$stmt_permiso_recaudos->execute();
$stmt_permiso_recaudos->bind_result($permiso_recaudos_count);
$stmt_permiso_recaudos->fetch();
$stmt_permiso_recaudos->close();


// Permiso para "Contabilidad"
$permiso_contabilidad_id = 7;
$sql_permiso_contabilidad = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_contabilidad = $conexion->prepare($sql_permiso_contabilidad);
$stmt_permiso_contabilidad->bind_param("ii", $usuario_id, $permiso_contabilidad_id);
$stmt_permiso_contabilidad->execute();
$stmt_permiso_contabilidad->bind_result($permiso_contabilidad_count);
$stmt_permiso_contabilidad->fetch();
$stmt_permiso_contabilidad->close();


// Permiso para "Prest Cancelados"
$permiso_prest_cancelados_id = 8;
$sql_permiso_prest_cancelados = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_prest_cancelados = $conexion->prepare($sql_permiso_prest_cancelados);
$stmt_permiso_prest_cancelados->bind_param("ii", $usuario_id, $permiso_prest_cancelados_id);
$stmt_permiso_prest_cancelados->execute();
$stmt_permiso_prest_cancelados->bind_result($permiso_prest_cancelados_count);
$stmt_permiso_prest_cancelados->fetch();
$stmt_permiso_prest_cancelados->close();


// Permiso para "Apagar Sistema"
$permiso_apagar_sistema_id = 9;
$sql_permiso_apagar_sistema = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_apagar_sistema = $conexion->prepare($sql_permiso_apagar_sistema);
$stmt_permiso_apagar_sistema->bind_param("ii", $usuario_id, $permiso_apagar_sistema_id);
$stmt_permiso_apagar_sistema->execute();
$stmt_permiso_apagar_sistema->bind_result($permiso_apagar_sistema_count);
$stmt_permiso_apagar_sistema->fetch();
$stmt_permiso_apagar_sistema->close();


// Permiso para "Lista Clavos"
$permiso_lista_clavos_id = 10;
$sql_permiso_lista_clavos = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_lista_clavos = $conexion->prepare($sql_permiso_lista_clavos);
$stmt_permiso_lista_clavos->bind_param("ii", $usuario_id, $permiso_lista_clavos_id);
$stmt_permiso_lista_clavos->execute();
$stmt_permiso_lista_clavos->bind_result($permiso_lista_clavos_count);
$stmt_permiso_lista_clavos->fetch();
$stmt_permiso_lista_clavos->close();

// Permiso para "List De Prestamos"
$permiso_list_de_prestamos_id = 11; // Asegúrate de usar el ID correcto para este permiso
$sql_permiso_list_de_prestamos = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_list_de_prestamos = $conexion->prepare($sql_permiso_list_de_prestamos);
$stmt_permiso_list_de_prestamos->bind_param("ii", $usuario_id, $permiso_list_de_prestamos_id);
$stmt_permiso_list_de_prestamos->execute();
$stmt_permiso_list_de_prestamos->bind_result($permiso_list_de_prestamos_count);
$stmt_permiso_list_de_prestamos->fetch();
$stmt_permiso_list_de_prestamos->close();

// Permiso para "Saldo Inicial"
$permiso_saldo_inicial_id = 12;
$sql_permiso_saldo_inicial = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_saldo_inicial = $conexion->prepare($sql_permiso_saldo_inicial);
$stmt_permiso_saldo_inicial->bind_param("ii", $usuario_id, $permiso_saldo_inicial_id);
$stmt_permiso_saldo_inicial->execute();
$stmt_permiso_saldo_inicial->bind_result($permiso_saldo_inicial_count);
$stmt_permiso_saldo_inicial->fetch();
$stmt_permiso_saldo_inicial->close();

// Permiso para "Hacer Préstamo"
$permiso_hacer_prestamo_id = 13; // Asegúrate de usar el ID correcto para este permiso
$sql_permiso_hacer_prestamo = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_hacer_prestamo = $conexion->prepare($sql_permiso_hacer_prestamo);
$stmt_permiso_hacer_prestamo->bind_param("ii", $usuario_id, $permiso_hacer_prestamo_id);
$stmt_permiso_hacer_prestamo->execute();
$stmt_permiso_hacer_prestamo->bind_result($permiso_hacer_prestamo_count);
$stmt_permiso_hacer_prestamo->fetch();
$stmt_permiso_hacer_prestamo->close();


// Permiso para "Prest Atrasado"
$permiso_prest_atrasado_id = 14;
$sql_permiso_prest_atrasado = "SELECT COUNT(*) FROM usuarios_permisos WHERE usuario_id = ? AND permiso_id = ?";
$stmt_permiso_prest_atrasado = $conexion->prepare($sql_permiso_prest_atrasado);
$stmt_permiso_prest_atrasado->bind_param("ii", $usuario_id, $permiso_prest_atrasado_id);
$stmt_permiso_prest_atrasado->execute();
$stmt_permiso_prest_atrasado->bind_result($permiso_prest_atrasado_count);
$stmt_permiso_prest_atrasado->fetch();
$stmt_permiso_prest_atrasado->close();



// Comprueba si el usuario tiene el permiso 
$tiene_permiso_abonos = ($permiso_abonos_count > 0);
$tiene_permiso_comision = ($permiso_comision_count > 0);
$tiene_permiso_desatrasar = ($permiso_desatrasar_count > 0);
$tiene_permiso_ver_filtros = ($permiso_ver_filtros_count > 0);
$tiene_permiso_contabilidad = ($permiso_contabilidad_count > 0);
$tiene_permiso_recaudos = ($permiso_recaudos_count > 0);
$tiene_permiso_listar_clientes = ($permiso_listar_clientes_count > 0);
$tiene_permiso_contabilidad = ($permiso_contabilidad_count > 0);
$tiene_permiso_prest_cancelados = ($permiso_prest_cancelados_count > 0);
$tiene_permiso_apagar_sistema = ($permiso_apagar_sistema_count > 0);
$tiene_permiso_lista_clavos = ($permiso_lista_clavos_count > 0);
$tiene_permiso_list_de_prestamos = ($permiso_list_de_prestamos_count > 0);
$tiene_permiso_saldo_inicial = ($permiso_saldo_inicial_count > 0);
$tiene_permiso_hacer_prestamo = ($permiso_hacer_prestamo_count > 0);
$tiene_permiso_prest_atrasado = ($permiso_prest_atrasado_count > 0);