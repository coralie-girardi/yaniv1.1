<?php
namespace Controllers ;
class GameInProcessController {
 
    public function GameInProcess() {
       
         
        // SELECT REQUEST DB
        
        $model = new \Models\GameInProcess();
     
       $list = $model->getGamesList();
       
        // --  DISPLAY --
        $template = 'gameInProcess.phtml';
        include_once 'views/layout.phtml';
    }
    
} 