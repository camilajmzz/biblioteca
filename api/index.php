<?php
require 'config.php';
require 'vendor/autoload.php';
require 'vendor/autoload.php';
require_once __DIR__ . '/phpqrcode/qrlib.php';

// =========================
//  CONEXIÓN A LA BD
// =========================
$pdo = getConnection();

header("Content-Type: application/json");

// =========================
//  PARSEO DE LA RUTA
// =========================
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

// Buscar dónde está "api" en la URL
$apiIndex = array_search('api', $uri);

if ($apiIndex === false) {
    http_response_code(404);
    echo json_encode(["error" => "Ruta no encontrada"]);
    exit;
}

// Extraer partes de la ruta
$resource = $uri[$apiIndex + 1] ?? '';
$id       = $uri[$apiIndex + 2] ?? null;
$extra    = $uri[$apiIndex + 3] ?? null;

// =========================
//  RUTEO PRINCIPAL
// =========================
switch ($resource) {

    case 'login':
        if ($method === 'POST') login($pdo);
        break;

    case 'register':
        if ($method === 'POST') register($pdo);
        break;

    case 'libros':
        handleLibros($pdo, $method, $id, $extra);
        break;

    case 'usuarios':
        if ($method === 'GET') listUsuarios($pdo);
        break;

    case 'prestamos':
        handlePrestamos($pdo, $method, $id, $extra);
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Recurso no encontrado"]);
        break;
}

// =========================
//  LOGIN
// =========================
function login($pdo) {
    $data = getJsonInput();
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && hash('sha256', $password) === $user['password']) {
        unset($user['password']);
        echo json_encode(["ok" => true, "usuario" => $user]);
    } else {
        http_response_code(401);
        echo json_encode(["ok" => false, "error" => "Credenciales incorrectas"]);
    }
}

// =========================
//  REGISTRO
// =========================
function register($pdo) {
    $data = getJsonInput();
    $nombre = $data['nombre'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $tipo = $data['tipo'] ?? 'usuario';

    $hash = hash('sha256', $password);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, tipo) VALUES (?,?,?,?)");
    try {
        $stmt->execute([$nombre, $email, $hash, $tipo]);
        echo json_encode(["ok" => true, "id" => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        http_response_code(400);
        echo json_encode(["ok" => false, "error" => "No se pudo registrar"]);
    }
}

// =========================
//  LIBROS
// =========================
function handleLibros($pdo, $method, $id, $extra) {

    if ($id && $extra === 'qr' && $method === 'GET') {
        return getLibroQR($pdo, $id);
    }

    switch ($method) {
        case 'GET':
            if ($id) getLibro($pdo, $id);
            else listLibros($pdo);
            break;

        case 'POST':
            createLibro($pdo);
            break;

        case 'PUT':
            if ($id) updateLibro($pdo, $id);
            break;

        case 'DELETE':
            if ($id) deleteLibro($pdo, $id);
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
    }
}

function listLibros($pdo) {
    $stmt = $pdo->query("SELECT * FROM libros");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getLibro($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM libros WHERE id = ?");
    $stmt->execute([$id]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($libro) echo json_encode($libro);
    else {
        http_response_code(404);
        echo json_encode(["error" => "Libro no encontrado"]);
    }
}

function createLibro($pdo) {
    $data = getJsonInput();
    $titulo = $data['titulo'] ?? '';
    $autor = $data['autor'] ?? '';
    $anio = $data['anio'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO libros (titulo, autor, anio, disponible) VALUES (?,?,?,1)");
    $stmt->execute([$titulo, $autor, $anio]);
    $id = $pdo->lastInsertId();

    // Generar QR
    $qrPath = generateQR($id);
    $upd = $pdo->prepare("UPDATE libros SET qr_code = ? WHERE id = ?");
    $upd->execute([$qrPath, $id]);

    echo json_encode(["ok" => true, "id" => $id, "qr" => $qrPath]);
}

function updateLibro($pdo, $id) {
    $data = getJsonInput();

    $titulo = $data['titulo'] ?? null;
    $autor = $data['autor'] ?? null;
    $anio = $data['anio'] ?? null;
    $disponible = $data['disponible'] ?? null;

    $stmt = $pdo->prepare("UPDATE libros SET titulo=?, autor=?, anio=?, disponible=? WHERE id=?");
    $stmt->execute([$titulo, $autor, $anio, $disponible, $id]);

    echo json_encode(["ok" => true]);
}

function deleteLibro($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM libros WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["ok" => true]);
}

function getLibroQR($pdo, $id) {
    $stmt = $pdo->prepare("SELECT qr_code FROM libros WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && $row['qr_code']) {
        echo json_encode(["qr" => $row['qr_code']]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "QR no encontrado"]);
    }
}

// =========================
//  GENERAR QR PNG REAL (ENDROID 6.x)
// =========================
require_once __DIR__ . '/phpqrcode/qrlib.php';

function generateQR($id_libro) {

    $file = __DIR__ . '/qr/libro_' . $id_libro . '.png';

    QRcode::png((string)$id_libro, $file, QR_ECLEVEL_L, 6, 2);

    return 'qr/libro_' . $id_libro . '.png';
}



// =========================
//  USUARIOS
// =========================
function listUsuarios($pdo) {
    $stmt = $pdo->query("SELECT id, nombre, email, tipo FROM usuarios");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// =========================
//  PRÉSTAMOS
// =========================
function handlePrestamos($pdo, $method, $id, $extra) {

    if ($method === 'GET') {
        listPrestamosActivos($pdo);
        return;
    }

    if ($method === 'POST') {
        createPrestamo($pdo);
        return;
    }

    if ($method === 'PUT' && $id && $extra === 'devolver') {
        devolverPrestamo($pdo, $id);
        return;
    }

    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}

function listPrestamosActivos($pdo) {
    $sql = "SELECT 
                p.id,
                p.id_usuario,
                u.nombre AS usuario,
                p.id_libro,
                l.titulo AS libro,
                p.fecha_prestamo,
                p.fecha_devolucion
            FROM prestamos p
            JOIN usuarios u ON p.id_usuario = u.id
            JOIN libros l ON p.id_libro = l.id";

    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function createPrestamo($pdo) {
    $data = getJsonInput();
    $id_usuario = $data['id_usuario'] ?? null;
    $id_libro = $data['id_libro'] ?? null;

    $stmt = $pdo->prepare("SELECT disponible FROM libros WHERE id = ?");
    $stmt->execute([$id_libro]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$libro || !$libro['disponible']) {
        http_response_code(400);
        echo json_encode(["error" => "Libro no disponible"]);
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO prestamos (id_usuario, id_libro) VALUES (?,?)");
    $stmt->execute([$id_usuario, $id_libro]);

    $upd = $pdo->prepare("UPDATE libros SET disponible = 0 WHERE id = ?");
    $upd->execute([$id_libro]);

    echo json_encode(["ok" => true, "id" => $pdo->lastInsertId()]);
}

function devolverPrestamo($pdo, $id_prestamo) {
    $stmt = $pdo->prepare("SELECT id_libro FROM prestamos WHERE id = ? AND fecha_devolucion IS NULL");
    $stmt->execute([$id_prestamo]);
    $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$prestamo) {
        http_response_code(400);
        echo json_encode(["error" => "Préstamo no encontrado o ya devuelto"]);
        return;
    }

    $pdo->beginTransaction();

    $upd1 = $pdo->prepare("UPDATE prestamos SET fecha_devolucion = NOW() WHERE id = ?");
    $upd1->execute([$id_prestamo]);

    $upd2 = $pdo->prepare("UPDATE libros SET disponible = 1 WHERE id = ?");
    $upd2->execute([$prestamo['id_libro']]);

    $pdo->commit();

    echo json_encode(["ok" => true]);
}

// =========================
//  UTILIDAD
// =========================
function getJsonInput() {
    return json_decode(file_get_contents("php://input"), true);
}
