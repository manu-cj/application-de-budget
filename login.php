<?php



if ($data = json_decode(file_get_contents('php://input'), true)) {
   
    $mail = $data['mail'];
    echo $mail;
}
?>