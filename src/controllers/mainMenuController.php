<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;

    class MainMenuController extends AbstractController {
        public function mainMenu() {
            return $this->render("mainMenu.twig", []);
        }
    }