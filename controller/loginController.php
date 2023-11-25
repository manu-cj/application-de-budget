<?php
 
require __DIR__ . '/../require.php';

if ($data = json_decode(file_get_contents('php://input'), true)) {

    $mail = htmlentities($data['mail']);
    $password = htmlentities($data['password']);
    $alert = [];


    if (empty($mail) or empty($password)) {
        $alert[] = "erreur : un champs n'a pas été remplis";
    }

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $alert[] = " erreur : l'adresse email est invalide";
    }

    if (count($alert) > 0) {
        echo json_encode($alert);

    }

    UserManager::ConnectUser($mail, $password);
}

?>