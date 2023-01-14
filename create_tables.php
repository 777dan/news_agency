<?php
include_once "dbconnect.php";

try {
    $conn->query("SET NAMES utf8mb4");
    $conn->query("SET CHARACTER SET utf8mb4");
    if (!$conn->query("CREATE TABLE IF NOT EXISTS News (id INT NOT NULL AUTO_INCREMENT, username VARCHAR (100), date DATETIME, message TEXT, category VARCHAR(255), name VARCHAR(255), PRIMARY KEY (id), FOREIGN KEY (category))")) {
        throw new Exception('Error creation table News: [' . $conn->error . ']');
    }

    if (!$conn->query("CREATE TABLE  IF NOT EXISTS Users (user_id INT NOT NULL AUTO_INCREMENT, log VARCHAR(255), pas  VARCHAR(255), PRIMARY KEY (user_id))")) {
        throw new Exception('Error creation table  Users: [' . $conn->error . ']');
    }
    if (!$conn->query("CREATE TABLE  IF NOT EXISTS Category (category VARCHAR(255), PRIMARY KEY (category))")) {
        throw new Exception('Error creation table  Users: [' . $conn->error . ']');
    }
    if (!$conn->query("INSERT INTO Users (log, pas) VALUES ('pit', '$2y$10$Or1GxFp2tUzZXGb66YLhY.JPPahtNbpL9raTRtvG4hiB9ntEnYWfu'), ('admin', '$2y$10$hksmcZazEDFpoILfWe/Lru3BErOIgHo4Kg.6fhp2C.f.SFEDQq4aO')")) {
        throw new Exception('Error creation table  Users: [' . $conn->error . ']');
    }
    if (!$conn->query("INSERT INTO Category (category) VALUES ('Здоровье'), ('Кухня'), ('Политика'), ('Природа'), ('Сад'), ('Спорт'), ('Шоубизнес')")) {
        throw new Exception('Error creation table  Users: [' . $conn->error . ']');
    }
    // INSERT INTO `gbooktable` (`id`, `username`, `date`, `message`) VALUES (NULL, 'admin', NULL, 'Hello');
    echo " Users and News tables created successfully";
    $conn->close();

} catch (Exception $e) {
    echo $e->getMessage();
}