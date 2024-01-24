<?php

// ----NAMESPACE CONTROLLER-----
namespace Controllers;

class GameController
{
    public function displayGame()
    {
        // ---GENERATE TOKEN ---
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(15);
        $_SESSION['auth'] = $token;
        // ---DISPLAY---
        $template = 'game.phtml';
        include_once 'views/layout.phtml';
    }
    public function formNbrPoints()
    {



        $errors = [];
        // verify if input is a int
        if (!is_numeric($_POST['nbrPoints'])) {

            $errors[] = "Veuillez saisir un nombre";
        }


        // verify if input is between 60 and 500
        if ($_POST['nbrPoints'] < 60 && $_POST['nbrPoints'] > 500) {
            $errors[] = "Veuillez saisir un nombre copmris entre 60 et 500";
        }
        if ($_POST['token'] != $_SESSION['auth']) {
            $errors[] = "Une erreur est survenue lors de l'envoi du formulaire";
        }
        if (count($errors) == 0) {

            $data = [$_POST['nbrPoints']];
            // insert into request
            $model = new \Models\Game();
            $model->addNbrPoints($data);
            header("Location: index.php?route=gameInProcess");

        }

        // ---GENERATE TOKEN ---
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(15);
        $_SESSION['auth'] = $token;

        $template = 'game.phtml';
        include_once 'views/layout.phtml';
    }


}