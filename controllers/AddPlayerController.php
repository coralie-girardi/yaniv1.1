<?php

// --- NAMESPACE ---
namespace Controllers;

class AddPlayerController
{
    public function FormPlayers()
    {
        $gamesId = "";

        if (isset($_GET['id'])) {
            $gamesId = $_GET['id']; // Id de la partie
        } else {
            $gamesId = $_SESSION['idGame'];
        }
        // RECUPERER DANS BDD TT LES JOUEURS QUI SONT DANS LA PARTIE "$gamesId"
        $model = new \Models\AddPlayer();
        $playersGame = $model->getPlayersInGame($gamesId);

        // -- SELECT USERNAME DB --
        $model = new \Models\AddPlayer();
        $username = $model->getPlayerUsername();
        // -- DISPLAY --
        $template = "addPlayer.phtml";
        include_once "views/layout.phtml";


    }

    public function AddPlayerSubmission()
    {
        $gamesId = $_POST['games_id']; // Id de la partie
        $playersId = $_POST['players_id']; // Id du joueur


        // RECUPERER DANS BDD TT LES JOUEURS QUI SONT DANS LA PARTIE "$gamesId"
        $model = new \Models\AddPlayer();
        $playersGame = $model->getPlayersInGame($gamesId); // On a récupérer soit EMPTY si personne dans la partie, soit un array comportant la liste des joueurs DEJA dans la partie.

        $errors = [];

        if (empty($playersGame)) {
            // Si la recherche démontre que personne n'est dans la partie, on ajoute le joueur


            $data = [$_POST["players_id"], $_POST["games_id"]];
            $model = new \Models\AddPlayer();
            $model->addPlayerAndId($data);

            $_SESSION['idGame'] = $gamesId;

            $model = new \Models\AddPlayer();
            $playersGame = $model->getPlayersInGame($_SESSION['idGame']);

            $model = new \Models\AddPlayer();
            $username = $model->getPlayerUsername();



            $template = "addPlayer.phtml";
            include_once "views/layout.phtml";
        } else {
            // S'il y a DEJA quelqu'un dans la partie, il faut vérifier que le joueur que l'on souhaite ajouter n'est DEJA dans la partie pour éviter les doublons
            $playerExists = false;
            foreach ($playersGame as $player) {
                if ($player['players_id'] == $playersId) {
                    $playerExists = true; // On parcours la liste et si l'id du joueur est dans la partie, on passe $payerExists à true, sinon il reste à false
                }
            }

            // Pour l'ajout, $playerExists doit être à false
            if ($playerExists == true) {
                $errors[] = 'Participant déjà dans la partie';
                $_SESSION['idGame'] = $gamesId;

                $model = new \Models\AddPlayer();
                $username = $model->getPlayerUsername();

                $template = "addPlayer.phtml";
                include_once "views/layout.phtml";
            } else {
                $data = [$_POST["players_id"], $_POST["games_id"]];
                $model = new \Models\AddPlayer();
                $model->addPlayerAndId($data);

                $_SESSION['idGame'] = $gamesId;

                $model = new \Models\AddPlayer();
                $playersGame = $model->getPlayersInGame($_SESSION['idGame']);

                $model = new \Models\AddPlayer();
                $username = $model->getPlayerUsername();


                $template = "addPlayer.phtml";
                include_once "views/layout.phtml";

            }
        }
    }

}