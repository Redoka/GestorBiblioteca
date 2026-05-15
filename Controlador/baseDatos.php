<?php

function conectarDB(string $bdd): ?PDO
{
    $dsn = 'mysql:host=localhost;dbname='. $bdd . ';charset=utf8mb4';

    try {
        return new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        return null;
    }


    
}
