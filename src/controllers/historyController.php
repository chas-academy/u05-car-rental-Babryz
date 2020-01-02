<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\HistoryModel;

    class HistoryController extends AbstractController {
        public function viewHistory() {
            $historyModel = new HistoryModel($this->db);
            $history = $historyModel->viewHistory();

            $properties = ["history" => $history];
            return $this->render("history.twig", $properties);
        }
    }