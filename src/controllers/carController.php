<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CarModel;
    use Main\src\models\HistoryModel;

    class CarController extends AbstractController {
        public function cars() {
            $carModel = new CarModel($this->db);
            $cars = $carModel->cars();
            $properties = ["cars" => $cars];
            return $this->render("cars.twig", $properties);
        }

        public function addCar() {
            $carModel = new CarModel($this->db);
            $makes = $carModel->makes();
            $colors = $carModel->colors();
            $properties = ["makes" => $makes, "colors" => $colors];
            return $this->render("addCar.twig", $properties);
        }

        public function carAdded() {
            $form = $this->request->getForm();
            $regNr = $form["regNr"];
            $make = $form["make"];
            $color = $form["color"];
            $year = $form["year"];
            $price = $form["price"];

            $carModel = new CarModel($this->db);
            $carModel->addCar($regNr, $make, $color, $year, $price);

            $car = ["make" => $make, 
                    "regNr" => $regNr];

            $properties = ["car" => $car];
                        

            return $this->render("carAdded.twig", $properties);
        }

        public function editCar($regNr, $make, $color, $year, $price) {
            $carModel = new CarModel($this->db);
            $makes = $carModel->makes();
            $colors = $carModel->colors();

            $properties = ["regNr" => $regNr, "make" => $make, "color" => $color, "year" => $year, "price" => $price, "makes" => $makes, "colors" => $colors];
            
            return $this->render("editCar.twig", $properties);
        }

        public function carEdited() {
            $form = $this->request->getForm();
            $regNr = $form["regNr"];
            $newMake = $form["make"];
            $newColor = $form["color"];
            $newYear = $form["year"];
            $newPrice = $form["price"];
            
            $carModel = new CarModel($this->db);
            $carModel->editCar($regNr, $newMake, $newColor, $newYear, $newPrice);

            $properties = ["regNr" => $regNr, "make" => $newMake, "color" => $newColor, "year" => $newYear, "price" => $newPrice];

            return $this->render("carEdited.twig", $properties);
        }

        public function removeCar($regNr, $make) {
            $carModel = new CarModel($this->db);
            $carModel->removeCar($regNr);
            $historyModel = new HistoryModel($this->db);
            $historyModel->removeCarHistory($regNr);

            $properties = ["regNr" => $regNr, "make" => $make];

            return $this->render("carRemoved.twig", $properties);
        }

    }