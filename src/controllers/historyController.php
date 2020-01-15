<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\HistoryModel;

    // Class for all history page functions.
    class HistoryController extends AbstractController {
        // Function for getting all history data and then rendering history page with that data.
        public function viewHistory() {
            
            // Calls function to get all data from history table.
            $historyModel = new HistoryModel($this->db);
            $history = $historyModel->viewHistory();

            $properties = ["history" => $history];
            return $this->render("history.twig", $properties);
        }
    }