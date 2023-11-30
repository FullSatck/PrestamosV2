<!DOCTYPE html>
<html>
<head>
    <title>Generar Informe de Gastos</title>
</head>
<body>
    <h1>Generar Informe de Gastos</h1>
    <form action="generar_informe.php" method="post">
        <label for="categoria">Selecciona una categoría:</label>
        <select id="categoria" name="categoria">
            <option value="clientes">Clientes</option>
            <option value="prestamos">Préstamos</option>
            <option value="pagos">Pagos</option>
            <option value="gastos">Gastos</option>
        </select>
        <br>
        <label for="rango_fecha">Selecciona un rango de fechas:</label>
        <select id="rango_fecha" name="rango_fecha">
            <option value="diario">Diario</option>
            <option value="semanal">Semanal</option>
            <option value="mensual">Mensual</option>
            <option value="anual">Anual</option>
        </select>
        <br>
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>
        <br>
        <input type="submit" value="Generar Informe">
    </form>
</body>
</html>
