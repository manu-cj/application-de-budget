<?php

class UserManager
{

    public static function addUser(User $user)
    {
        $insert = Connect::getPDO()->prepare("INSERT INTO user (mail, password, username, verification_key)
                                                    VALUES (:mail, :password, :username, :verification_key)");

        $insert->bindValue(':mail', $user->getMail());
        $insert->bindValue(':password', $user->getPassword());
        $insert->bindValue(':username', $user->getUsername());
        $insert->bindValue(':verification_key', $user->getCode());

        if ($insert->execute()) {
            $user
                ->setMail('')
                ->setPassword('')
                ->setUsername('')
                ->setCode('');
            $alert = [];
            $alert[] = '<div class="alert-succes">Inscription réussi</div>';
            if (count($alert) > 0) {
                $_SESSION['alert'] = $alert;
                header('LOCATION: ?c=home');
            }
        }
    }

    public static function ConnectUser($mail, $password)
    {
        $get = Connect::getPDO()->prepare('SELECT * FROM user WHERE mail = :mail');
        $get->bindValue(':mail', $mail);

        if ($get->execute()) {
            $alert = [];

            $datas = $get->fetchAll();
            foreach ($datas as $data) {
                if (password_verify($password, $data['password'])) {
                    $code = (new DateTime())->format('mHdsiY') . uniqid();
                    $update = Connect::getPDO()->prepare("UPDATE user SET verification_key = :verification_key WHERE mail = :mail");
                    $update->bindValue(':mail', $mail);
                    $update->bindValue(':verification_key', $code);
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