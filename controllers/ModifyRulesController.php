<?php
// --- NAMESPACE FILE ---
namespace Controllers;

class ModifyRulesController
{
    public function DisplayUpdateRules()
    {
        // -- INIT METHOD TO SELECT DATA IN DB
        $data = [$_SESSION["players"]["id"]];
        $model = new \Models\Rules();
        $rules = $model->getRules($data);
        // ---- GENERATE TOKEN FOR VERIFYING FORM -----
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(14);
        $_SESSION['auth'] = $token;

        // -- DISPLAY PAGE ---
        $template = "modifyRules.phtml";
        include_once "views/layout.phtml";

    }
    public function ModifyRules()
    {
        // -- init errors array --
        $errors = [];
        $modifiedRule = '';
        // -- Checking Error --
        if (array_key_exists('modifiedRule', $_POST)) {
            // -- Cleaning data
            $modifiedRule = trim($_POST['modifiedRule']);
            // -- checking token --
            if ($_SESSION['auth'] != $_POST['token']) {
                $errors[] = "Une erreur est survenue lors de l'envoi du formulaire !";
            }
            // -- checking if input is empty
            if ($modifiedRule == '') {
                // -- init errors message
                $errors[] = 'Champ vide';
            }
        }
        if (count($errors) == 0) {
            $ruleId = $_POST['id_rules'];
            $data = [htmlspecialchars($modifiedRule), $ruleId];
            $model = new \Models\Rules();
            $model->updateRule($data);

        }



        // -- INIT METHOD TO SELECT DATA IN DB
        $data = [$_SESSION["players"]["id"]];
        $model = new \Models\Rules();
        $rules = $model->getRules($data);
        unset($modifiedRule);

        // ---- GENERATE TOKEN FOR VERIFYING FORM -----
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(14);
        $_SESSION['auth'] = $token;

        // -- DISPLAY PAGE ---
        $template = "modifyRules.phtml";
        include_once "views/layout.phtml";
    }
    public function DeleteRules()
    {
        // -- INIT METHOD TO SELECT DATA IN DB
        $data = [$_SESSION["players"]["id"]];
        $model = new \Models\Rules();
        $rules = $model->getRules($data);
        // -- Init Method to delet data in db *
        $data = [$_GET['id']];
        $model = new \Models\Rules();
        $model->DeleteRule($data);
        // ---- GENERATE TOKEN FOR VERIFYING FORM -----
        $model = new \Models\Results();
        $token = $model->generateChaineAleatoire(14);
        $_SESSION['auth'] = $token;

        $template = 'modifyRules.phtml';
        include_once "views/layout.phtml";
    }
}