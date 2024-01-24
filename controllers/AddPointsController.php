<?php

// --- NAMESPACE CONTROLLER ---
namespace Controllers;

// --- CLASS ADDPOINTSCONTROLLER ---
class AddPointsController
{

    // -- DISPLAY ADDPOINTS --
    public function AddPoints()
    {
        // ---- init method to get infos' game 
        $model = new \Models\Game();
        $game = $model->getGamesInfo($_GET['id']);

        // --- display template ---
        $template = 'addPoints.phtml';
        include_once 'views/layout.phtml';

    }

    public function addPointsOfPlayers()
    {
        // init errors array
        $errors = [];
        // ---- init method to get infos' game 
        $model = new \Models\Game();
        $game = $model->getGamesInfo($_SESSION['idGame']);





        foreach ($_POST as $player => $point) {


            // // CHECKING IF VALUE ISN4T NEGATIVE 
            // if ($point < 0) {
                // $errors[] = 'Veuillez entrer une valeur supérieure ou égale à zéro';
            // }
            // CHECKING IF  VALUE IS NUMERIC 
            if (!is_numeric($point)) {
                $errors[] = "Veuillez saisir une valeur numérique ";
            }

            // -- sending to db only if there's no errors
            if (count($errors) == 0) {
                $data = [$player, $_SESSION['idGame'], $point];
                $model = new \Models\Game();
                $model->sendPoints($data);

            }



        }



        foreach ($game as $player) {
            // -- INIT METHOD TO GET RESULT OF SUM IN TABLE SQL -- 
            $data = [$player['players_id'], $_SESSION["idGame"]];
            $model = new \Models\Game();
            $totalsScore = $model->TotalScores($data);
            // --- browse array data with a for loop 
            for ($i = 0; $i < count($totalsScore); $i++) {
                $totalPlayer = $totalsScore[$i]['SUM(points)'];
                // -- send total score in bd--- 
                $data = [$player['players_id'], $_SESSION["idGame"], $totalPlayer];
                $model = new \Models\Game();
                $model->sendTotalPoints($data);


            }
            // --- INIT METHOD TO GET RESULT OF SUM IN TABLE SQL  --- 
            $data = [$player['players_id'], $_SESSION["idGame"]];
            $model = new \Models\Game();
            $totalScore = $model->getTotalScores($data);




        }

        $template = 'addPoints.phtml';
        include_once 'views/layout.phtml';
    }
}