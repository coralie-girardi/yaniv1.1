<?php

// <------ Début de session ------>

session_start();

// <------ Autoload ------>

spl_autoload_register(function (string $class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});

// <------ ROUTER (SWITCH) ------>
if (array_key_exists('route', $_GET)):
    switch ($_GET['route']) {
        // --DISPLAY PAGE 404 --

        // --DISPLAY HOMEPAGE--
        case 'home':
            $controller = new Controllers\HomeController();
            $controller->display();
            break;
        // -- DISPLAY REGISTER PAGE  --
        case 'register':
            $controller = new Controllers\UserController();
            $controller->displayFormRegister();
            break;
        // -- SUBMISSION REGISTRATION FORM --
        case 'addUser':
            $controller = new Controllers\UserController();
            $controller->register();
            break;
        // -- LOGIN --
        case 'login':
            $controller = new Controllers\UserController();
            $controller->login();
            break;
        // --LOGOUT --
        case 'logout':
            $controller = new Controllers\UserController();
            $controller->logout();
            break;
        // -- PROFILE --
        case 'displayProfile':
            $controller = new Controllers\ProfileController();
            $controller->displayProfile();
            break;
        // -- GAME --
        case 'game':
            $controller = new Controllers\GameController();
            $controller->displayGame();
            break;
        case 'formNbrPoints':
            $controller = new Controllers\GameController();
            $controller->formNbrPoints();
            break;
        // -- GAME IN PROCESS  --
        case 'gameInProcess':
            $controller = new Controllers\GameInProcessController();
            $controller->GameInProcess();
            break;
        // -- ADD PLAYER --
        case 'addPlayer':
            $controller = new Controllers\AddPlayerController();
            $controller->FormPlayers();
            break;

        // -- ADD PLAYER SUBMISSION --
        case 'addPlayerSubmission':
            $controller = new Controllers\AddPlayerController();
            $controller->AddPlayerSubmission();
            break;
        case 'addPoints':
            $_SESSION['idGame'] = $_GET['id'];
            $controller = new Controllers\AddPointsController();
            $controller->AddPoints();
            break;

        case 'addPointsOfPlayers':
            $controller = new Controllers\AddPointsController();
            $controller->addPointsOfPlayers();
            break;
        case 'rules':
            $controller = new Controllers\RulesController();
            $controller->rules();
            break;
        case 'AddRules':
            $controller = new Controllers\RulesController();
            $controller->AddRules();
            break;
        case 'DisplayUpdateRules':
            $controller = new Controllers\ModifyRulesController();
            $controller->DisplayUpdateRules();

            break;

        case 'ModifyRules':
            $controller = new Controllers\ModifyRulesController();
            $controller->ModifyRules();
            break;
        case 'DeleteRules':
            $controller = new Controllers\ModifyRulesController();
            $controller->DeleteRules();
            break;

        // -- REDIRECTION ON THE HOME PAGE BY DEFAULT--
        default:
            header('Location: index.php?route=home');
            break;
    }
else:
    // -- REDIRECT IF ROUTE DOESN'T EXIST --
    header('Location: index.php?route=home');
    exit;
endif;