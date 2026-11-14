<?php
date_default_timezone_set(getenv('TZ') ?: 'America/Bogota');
mysqli_report(MYSQLI_REPORT_OFF);

$nombre = getenv('STUDENT_NAME') ?: 'Estudiante';
$conn = @new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Actividad Docker - <?= htmlspecialchars($nombre) ?></title>
  <style>
    body { font-family: system-ui, sans-serif; max-width: 760px; margin: 18px auto; padding: 0 16px; background: #f4f6fb; color: #1d2433; }
    .card { background: #fff; border-radius: 10px; padding: 4px 24px 14px; margin-bottom: 14px; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
    h1 { font-size: 26px; } h2 { font-size: 20px; } h3 { font-size: 16px; margin-bottom: 6px; } p { margin: 8px 0; }
    .ok { color: #1a7f37; font-weight: 600; } .err { color: #c62828; font-weight: 600; }
    table { border-collapse: collapse; width: 100%; } th, td { border-bottom: 1px solid #e3e6ee; padding: 6px 8px; text-align: left; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Bienvenido, soy <?= htmlspecialchars($nombre) ?></h1>
    <p>Fecha y hora del servidor: <strong><?= date('Y-m-d H:i:s') ?></strong></p>
    <p>Hostname del contenedor: <strong><?= gethostname() ?></strong></p>
  </div>

  <div class="card">
    <h2>Estado de la base de datos</h2>
<?php if ($conn->connect_error): ?>
    <p class="err">Error de conexión: <?= htmlspecialchars($conn->connect_error) ?></p>
<?php else:
    $conn->query("INSERT INTO visitas (fecha) VALUES (NOW())");
    $total = $conn->query("SELECT COUNT(*) AS n FROM visitas")->fetch_assoc()['n'];
    $estudiantes = $conn->query("SELECT id, nombre, programa FROM estudiantes ORDER BY id");
?>
    <p class="ok">Conexión exitosa</p>
    <p>MySQL: <?= $conn->server_info ?> | Base de datos: <?= htmlspecialchars(getenv('DB_NAME')) ?></p>
    <p>Total de visitas registradas: <strong><?= $total ?></strong></p>

    <h3>Tabla estudiantes</h3>
    <table>
      <tr><th>ID</th><th>Nombre</th><th>Programa</th></tr>
<?php while ($e = $estudiantes->fetch_assoc()): ?>
      <tr><td><?= $e['id'] ?></td><td><?= htmlspecialchars($e['nombre']) ?></td><td><?= htmlspecialchars($e['programa']) ?></td></tr>
<?php endwhile; ?>
    </table>
<?php $conn->close(); endif; ?>
  </div>
</body>
</html>
