<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';

$email = trim((string)getenv('FERRETERIA_SUPERADMIN_EMAIL'));
$password = (string)getenv('FERRETERIA_SUPERADMIN_PASSWORD');
$document = (string)getenv('FERRETERIA_SUPERADMIN_DOCUMENTO');

if (
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($password) < 12 ||
    !ctype_digit($document) ||
    (int)$document < 1
) {
    fwrite(STDERR, "Define FERRETERIA_SUPERADMIN_EMAIL, una contraseña de al menos 12 caracteres y FERRETERIA_SUPERADMIN_DOCUMENTO.\n");
    exit(2);
}

$db = Database::getInstance()->getConnection();
$roleCheck = $db->query("SELECT idRol FROM rol WHERE idRol = 4");
if (!$roleCheck || !$roleCheck->fetch_assoc()) {
    fwrite(STDERR, "Falta el rol 4. Ejecuta primero la migración multi-tenant.\n");
    exit(2);
}

$check = $db->prepare('SELECT idUsuario FROM usuario WHERE correo = ? LIMIT 1');
$check->bind_param('s', $email);
$check->execute();
if ($check->get_result()->fetch_assoc()) {
    fwrite(STDERR, "El correo ya existe; no se modificó ni elevó esa cuenta.\n");
    exit(3);
}

$documentId = (int)$document;
$firstName = 'Superadmin';
$lastName = 'Plataforma';
$hash = password_hash($password, PASSWORD_DEFAULT);
$status = 'Activo';
$roleId = 4;
$stmt = $db->prepare(
    'INSERT INTO usuario (tipoDocumentoUsuario, documentoUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario, estadoUsuario, rol_idRol, tenant_id) VALUES ("CC", ?, ?, ?, ?, ?, ?, ?, NULL)'
);
$stmt->bind_param('isssssi', $documentId, $firstName, $lastName, $email, $hash, $status, $roleId);
if (!$stmt->execute()) {
    fwrite(STDERR, "No se pudo crear el superadmin: {$stmt->error}\n");
    exit(1);
}

fwrite(STDOUT, "Cuenta superadmin creada: {$email}\n");
