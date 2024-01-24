<?php
// -- NAMESPACE FILE : CONTROLLER  --
namespace Controllers;

class RulesController
{
    public function rules()
    {


        // ----- SELECT FOR DISPLAYING RULES ADDED BY A PLAYER -----
        if (isset($_SESSION["players"]["id"])) {
            $data = [$_SESSION["players"]["id"]];
            $model = new \Models\Rules();
            $rules = $model->getRules($data);
        }

        // ---- GENERATE TOKEN FOR VERIFYING FORM -----
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(7);
        $_SESSION['auth'] = $token;

        // --- DISPLAY RULES' FORM
        $template = "rules.phtml";
        include_once "views/layout.phtml";
    }
    public function AddRules()
    {
        // --- VERIFICATIION FORM AND SUBMISSION ----

        // - Initialization of errors' array -
        $errors = [];
        $addRules = "";



        if (array_key_exists("rules", $_POST)) {
            // - "CLEANING" data  -
            $addRules = trim($_POST["rules"]);

            // -- CHECKING TOKEN --
            if ($_SESSION['auth'] != $_POST['token']) {
                $errors[] = "Une erreur est survenue lors de l'envoi du formulaire !";
            }
            // checking if rule is  missing
            if ($addRules == "") {
                $errors[] = "Veuillez saisir une règle à ajouter ";
            }
        }

        // -- Checking if there's errors messages for sending data to db --
        if (count($errors) == 0) {
            // -- create data array for insert into method --

            $playerID = $_SESSION["players"]["id"];
            $data = [htmlspecialchars($addRules), $playerID];
            // -- CALLING METHOD FOR SENDING TO DB --
            $model = new \Models\Rules();
            $model->sendRules($data);

        } // -- INIT METHOD TO SELECT DATA IN DB 
        $data = [$_SESSION["players"]["id"]];
        $model = new \Models\Rules();
        $rules = $model->getRules($data);

        // -- unset data --
        unset($addRules);

        // ---- DISPLAYING TEMPLATE ----
        // ---- GENERATE TOKEN FOR VERIFYING FORM -----
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(7);
        $_SESSION['auth'] = $token;

        $template = "rules.phtml";
        include_once "views/layout.phtml";
    }


}