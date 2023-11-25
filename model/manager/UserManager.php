<?php

class UserManager
{

    public static function addUser(User $user)
    {
        $insert = Connect::getPDO()->prepare("INSERT INTO user (mail, password, username, verification_key, token)
                                                    VALUES (:mail, :password, :username, :verification_key, :token)");

        $insert->bindValue(':mail', $user->getMail());
        $insert->bindValue(':password', $user->getPassword());
        $insert->bindValue(':username', $user->getUsername());
        $insert->bindValue(':verification_key', $user->getCode());
        $insert->bindValue(':token', $user->getToken());

        if ($insert->execute()) {
            $user
                ->setMail('')
                ->setPassword('')
                ->setUsername('')
                ->setCode('')
                ->setToken('');
            $alert = [];
            $alert[] = 'Inscription réussi';
            if (count($alert) > 0) {
                echo json_encode($alert); 
                
            }
        }
    }

    public static function ConnectUser($mail, $password)
    {

        function random($var){
            $string = "";
            $chaine = "a0b1c2d3e4f5g6h7i8j9klmnpqrstuvwxy123456789";
            srand((double)microtime()*1000000);
            for($i=0; $i<$var; $i++){
                $string .= $chaine[rand()%strlen($chaine)];
            }
            return $string;
        }
        $token = random(rand(15,25)).uniqid();
        $get = Connect::getPDO()->prepare('SELECT * FROM user WHERE mail = :mail');
        $get->bindValue(':mail', $mail);

        if ($get->execute()) {
            $alert = [];

            $datas = $get->fetchAll();
            foreach ($datas as $data) {
                if (password_verify($password, $data['password'])) {
                    $code = random(rand(15,25)).uniqid();
                    $update = Connect::getPDO()->prepare("UPDATE user SET verification_key = :verification_key, token = :token WHERE mail = :mail");
                    $update->bindValue(':mail', $mail);
                    $update->bindValue(':verification_key', $code);
                    $update->bindValue(':token', $token);
                    if ($update->execute()) {
                        $_SESSION['connected'] = '1';
                        $alert[] = "Connexion réussi";
                        if (count($alert) > 0) {
                           echo json_encode($alert);
                        }
                    }
                } else {
                    $alert[] = "l'adresse mail ou le mot de passe ne correspond pas !";
                    if (count($alert) > 0) {
                        echo json_encode($alert); 
                    }
                }
            }
        }
    }
}