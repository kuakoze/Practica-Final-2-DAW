<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "cooperativa";  

function crearDB($server, $user, $password, $database) {
    try {
        
        $db = new PDO("mysql:host=$server", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        $stmt = $db->prepare("CREATE DATABASE IF NOT EXISTS $database");
        $stmt->execute();    
        echo "Base de datos '$database' creada o ya existente.<br>";

    } catch (PDOException $e) {
        echo "Error al crear la base de datos: " . $e->getMessage();
    }
}

function conexionBD($server, $user, $password, $database) {
    try {
        $db = new PDO("mysql:host=$server;dbname=$database", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Conectado a la base de datos '$database' correctamente.<br>";
        return $db;
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}
function crearTablas($database, $db) {
  
    echo "comprobando que existe la tabla usuario";
    $comprobacion = $db->query("SHOW TABLES LIKE 'usuario'");
    if ($comprobacion->fetch(PDO::FETCH_ASSOC)) {
        echo "La tabla 'usuario' ya existe.\n";
    } else {
        echo "Creando la tabla 'usuario'...\n";
        $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS usuario (
            id_usuario INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100),
            correo VARCHAR(100),
            contraseña VARCHAR(100)
        ) ENGINE=InnoDB;");
        $stmt->execute();
    }

    
    echo "comprobando que existe la tabla pedido";
    $comprobacion = $db->query("SHOW TABLES LIKE 'pedido'");
    if ($comprobacion->fetch(PDO::FETCH_ASSOC)) {
        echo "La tabla 'pedido' ya existe.\n";
    } else {
        echo "Creando la tabla 'pedido'...\n";
        $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS pedido (
            id_pedido INT AUTO_INCREMENT PRIMARY KEY,
            fecha DATE,
            id_usuario INT,
            FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
        ) ENGINE=InnoDB;");
        $stmt->execute();
    }

    
    echo "comprobando que existe la tabla categoria";
    $comprobacion = $db->query("SHOW TABLES LIKE 'categoria'");
    if ($comprobacion->fetch(PDO::FETCH_ASSOC)) {
        echo "La tabla 'categoria' ya existe.\n";
    } else {
        echo "Creando la tabla 'categoria'...\n";
        $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS categoria (
            id_categoria INT AUTO_INCREMENT PRIMARY KEY,
            nombre_categoria VARCHAR(100)
        ) ENGINE=InnoDB;");
        $stmt->execute();
    }

    
    echo "comprobando que existe la tabla producto";
    $comprobacion = $db->query("SHOW TABLES LIKE 'producto'");
    if ($comprobacion->fetch(PDO::FETCH_ASSOC)) {
        echo "La tabla 'producto' ya existe.\n";
    } else {
        echo "Creando la tabla 'producto'...\n";
        $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS producto (
            id_producto INT AUTO_INCREMENT PRIMARY KEY,
            nombre_producto VARCHAR(100),
            precio DECIMAL(10,2),
            id_categoria INT,
            FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria)
        ) ENGINE=InnoDB;");
        $stmt->execute();
    }

    
    echo "comprobando que existe la tabla detalles_pedido";
    $comprobacion = $db->query("SHOW TABLES LIKE 'detalles_pedido'");
    if ($comprobacion->fetch(PDO::FETCH_ASSOC)) {
        echo "La tabla 'detalles_pedido' ya existe.\n";
    } else {
        echo "Creando la tabla 'detalles_pedido'...\n";
        $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS detalles_pedido (
            id_pedido INT,
            id_producto INT,
            cantidad INT,
            PRIMARY KEY (id_pedido, id_producto),
            FOREIGN KEY (id_pedido) REFERENCES pedido(id_pedido),
            FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
        ) ENGINE=InnoDB;");
        $stmt->execute();
    }
}
?>
