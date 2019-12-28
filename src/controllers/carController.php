<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CarModel;

    class CarController extends AbstractController {
        public function cars() {
            $carModel = new CarModel($this->db);
            $cars = $carModel->cars();
            $properties = ["cars" => $cars];
            return $this->render("cars.twig", $properties);
        }

    }