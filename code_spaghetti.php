<?php
function jsonencode($item){
    return json_encode($item, JSON_UNESCAPED_UNICODE);
};

$dsn = 'mysql:dbname=flapi;host=127.0.0.1;charset=UTF8';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
];
$username = 'homestead';
$password = 'secret';

$cx = new PDO($dsn, $username, $password, $options);

$methode = $_SERVER['REQUEST_METHOD'];

if ($methode == 'GET'){
    try{
        $sql = 'SELECT * FROM scores ORDER BY score DESC LIMIT 10';
        $pdoSt = $cx->query($sql);
        echo jsonencode($pdoSt->fetchAll());
    }catch (PDOException $e){
        echo jsonencode(['erreur' => $e->getMessage()]);
    }

}elseif ($methode == 'POST'){
    if (isset($_POST['score'])){
        if (ctype_digit($_POST['score'])){
            try{
                $sql = 'INSERT INTO scores (`score`) VALUES (:score)';
                $pdoSt = $cx->prepare($sql);
                $pdoSt->execute([':score' => $_POST['score']]);
                echo jsonencode(['success' => 'Le score a été enregistré']);
            }catch (PDOException $e){
                echo jsonencode(['erreur' => $e->getMessage()]);
            }
        }else{
            echo jsonencode(['error' => 'Le score doit être un entier positif']);
        }
    }else{
        die(jsonencode(['error' => 'Il faut envoyer un score']));
    }
}else{
    die(jsonencode(['error' => 'Vous avez demandé une méthode invalide']));
}