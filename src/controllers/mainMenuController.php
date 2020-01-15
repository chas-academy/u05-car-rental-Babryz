<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;

    // Class for functions related to the main menu page.
    class MainMenuController extends AbstractController {
        // Function that renders the main menu page.
        public function mainMenu() {
            return $this->render("mainMenu.twig", []);
        }
    }