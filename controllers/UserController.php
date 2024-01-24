<?php

// -- NAMESPACE  CONTROLLER --
namespace Controllers;

class UserController
{
    public function displayFormRegister()
    {
        // -- GENERATE TOKEN --
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(20);
        $_SESSION['auth'] = $token;
        // -- DISPLAY REGISTRATION FORM --
        $template = "register.phtml";
        include_once 'views/layout.phtml';
    }
    // -- VERIFICATION AND FORM SUBMISSION --
    public function register()
    {

        $errors = [];
        $valids = [];

        $addUser = [
            'addLastname' => '',
            'addFirstname' => '',
            'addUsername' => '',
            'addEmail' => '',
            'addPassword' => '',
            'addPassword_confirm' => '',

        ];
        if (
            array_key_exists('firstname', $_POST)
            && array_key_exists('lastname', $_POST)
            && array_key_exists('username', $_POST)
            && array_key_exists('email', $_POST)
            && array_key_exists('password', $_POST)
            && array_key_exists('password_confirm', $_POST)
        ) {

            $addUser = [
                'addLastname' => trim(strtoupper($_POST['lastname'])),
                'addFirstname' => trim(ucfirst($_POST['firstname'])),
                'addUsername' => trim(ucfirst($_POST['username'])),
                'addEmail' => trim(strtolower($_POST['email'])),
                'addPassword' => trim($_POST['password']),
                'addPassword_confirm' => trim($_POST['password_confirm']),

            ];
            // -- DEFINITION OF ERRORS MESSAGES --
            if (isset($_SESSION['auth']) && $_SESSION['auth'] != $_POST['token']) {
                $errors[] = "Une erreur est survenue lors de l'envoi du formulaire !";
            }
            // username missing
            if ($addUser['addUsername'] == '') {
                $errors[] = "Veuillez saisir un Pseudo";
            }
            // invalid adress
            if (!filter_var($addUser['addEmail'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Veuillez saisir une adresse mail valide';
            }
            // password missing
            if (empty($addUser['addPassword'])) {
                $errors[] = "Veuillez saisir un mot de passe";
            }
            // password and confirm not matching
            if ($addUser['addPassword'] !== $addUser['addPassword_confirm']) {
                $errors[] = "Les deux mots de passe ne sont pas identiques";
            }
            // verify if email exists
            if (count($errors) == 0) {
                $model = new \Models\User();
                $userExist = $model->getUserByEmail($addUser['addEmail']);

                if (!empty($userExist)) {
                    $errors[] = 'Cette adresse email existe déjà';

                }

                if (empty($userExist)) {

                    // hash password

                    if (count($errors) == 0) {
                        $password = password_hash($addUser['addPassword'], PASSWORD_DEFAULT);
                        // create data array to send to the db
                        $data = [

                            htmlspecialchars(strtolower($addUser['addEmail'])),
                            htmlspecialchars($password),
                            htmlspecialchars(ucfirst($addUser['addUsername'])),
                            htmlspecialchars(strtoupper($addUser['addLastname'])),
                            htmlspecialchars(ucfirst($addUser['addFirstname']))


                        ];
                        // call method INSERT INTO DB
                        $model = new \Models\User();
                        $model->addNewUser($data);
                        // display message de validation
                        $valids[] = "Votre inscription à été enregistrée ! ";
                        // generate token
                        $model = new \Models\Results();
                        $token = $model->generateChaineAleatoire(20);
                        $_SESSION['auth'] = $token;
                        // -- unset data -- 
                        unset($addUser);

                        $template = "register.phtml";
                        include_once 'views/layout.phtml';


                    }



                }
            }

        }


        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(20);
        $_SESSION['auth'] = $token;

        $template = "register.phtml";
        include_once 'views/layout.phtml';

    }
    // --------DISPLAY LOGIN FORM ----------
    public function displayFormLogin()
    {
        $model = new \Models\Results();

        // ------TOKEN ---- 
        $token = $model->generateChaineAleatoire(30);
        $_SESSION['connectAuth'] = $token;

        $template = "login.phtml";
        include_once 'views/layout.phtml';
    }

    // LOGIN FUNCTION 
    public function login()
    {
        $errors = [];

        $authUser = [
            'email' => '',
            'password' => ''
        ];

        if (array_key_exists('email', $_POST) && array_key_exists('password', $_POST)) {
            $authUser = [
                'email' => trim(strtolower($_POST['email'])),
                'password' => trim($_POST['password'])
            ];
            if (!filter_var($authUser['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email Invalide';
            }
            if ($authUser['password'] == '') {
                $errors[] = 'Champ vide';
            }
            if (isset($_SESSION['connectAuth']) && $_SESSION['connectAuth'] != $_POST['token']) {
                $errors[] = 'Une erreur est apparue lors de l &apos; envoi du formulaire';
            }
            if (count($errors) == 0) {
                $model = new \Models\User();
                $userExist = $model->getUserByEmail($authUser['email']);

                if (empty($userExist)) {
                    $errors[] = "erreur de connexion";
                } else {
                    if ($userExist !== false && password_verify($authUser['password'], $userExist['password'])) {

                        // DEFINE $_SESSION 
                        $_SESSION['players'] = [
                            'id' => $userExist['id'],
                            'lastname' => $userExist['lastname'],
                            'firstname' => $userExist['firstname'],
                            'username' => $userExist['username'],
                            'email' => $userExist['email'],

                            'createdAt' => $userExist['createdAt']

                        ];
                        $valids[] = 'Connexion réalisé avec succès';
                        header('Location: index.php?route=home');
                        exit;
                    } else {
                        $errors[] = "Connexion échoué";

                    }
                }
            }

        }
        // -------TOKEN --------
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(30);
        $_SESSION['connectAuth'] = $token;

        $template = 'login.phtml';
        include_once 'views/layout.phtml';
    }
    //  LOGOUT FUNCTION 
    public function logout()
    {
        $_SESSION['players'] = [];
        session_destroy();

        header('Location: index.php?route=home');
        exit;
    }
// -----DISPLAY PROFILE ------



}