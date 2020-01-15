<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CarModel;
    use Main\src\models\HistoryModel;

    // Class for everything related to the rendering car page.
    class CarController extends AbstractController {
        // Function that calls get all cars from carModel and then sends it two twig to then render the  Cars page.
        public function cars() {
            $carModel = new CarModel($this->db);
            $cars = $carModel->cars();
            $properties = ["cars" => $cars];
            return $this->render("cars.twig", $properties);
        }

        // Function that calls get all cars, makes and colors from carModel and then sends it to twig to then render the addCar page.
        public function addCar() {
            $carModel = new CarModel($this->db);
            $makes = $carModel->makes();
            $colors = $carModel->colors();
            $properties = ["makes" => $makes, "colors" => $colors];
            return $this->render("addCar.twig", $properties);
        }

        // Function that get information from the car added from the form and then sends it to twig to then render the carAdded page.
        public function carAdded() {
            // Gets info from form through getForm-function in in request class.
            $form = $this->request->getForm();
            $regNr = $form["regNr"];
            $make = $form["make"];
            $color = $form["color"];
            $year = $form["year"];
            $price = $form["price"];

            // Sends that info to the addCar-function in carModel to add new car to table.
            $carModel = new CarModel($this->db);
            $carModel->addCar($regNr, $make, $color, $year, $price);

            $car = ["make" => $make, 
                    "regNr" => $regNr];

            $properties = ["car" => $car];
                        

            return $this->render("carAdded.twig", $properties);
        }

        // Function that get the information on the car you want to edit and send it to twig to then render the editCar page.
        public function editCar($regNr, $make, $color, $year, $price) {
            // Calls function makes and colors and then sends them to twig to render the dropdown menus with them.
            $carModel = new CarModel($this->db);
            $makes = $carModel->makes();
            $colors = $carModel->colors();

            $properties = ["regNr" => $regNr, "make" => $make, "color" => $color, "year" => $year, "price" => $price, "makes" => $makes, "colors" => $colors];
            
            return $this->render("editCar.twig", $properties);
        }

        // Function that gets the new info on the car you edited, updates the car table with them and then renders the carEdited page.
        public function carEdited() {
            // Gets info from form through getForm-function in in request class.
            $form = $this->request->getForm();
            $regNr = $form["regNr"];
            $newMake = $form["make"];
            $newColor = $form["color"];
            $newYear = $form["year"];
            $newPrice = $form["price"];
            
            // Calls function editCar with the info from the form so it can update the values on the car with them in the database.
            $carModel = new CarModel($this->db);
            $carModel->editCar($regNr, $newMake, $newColor, $newYear, $newPrice);

            $properties = ["regNr" => $regNr, "make" => $newMake, "color" => $newColor, "year" => $newYear, "price" => $newPrice];

            return $this->render("carEdited.twig", $properties);
        }

        // Function for getting info through url on car you want to remove and sends it to remove function and then renders the carRemoved page.
        public function removeCar($regNr, $make) {
            $carModel = new CarModel($this->db);
            $historyModel = new HistoryModel($this->db);
            
            // Calls functions to remove car both from history- and car tables.
            $historyModel->removeCarHistory($regNr);
            $carModel->removeCar($regNr);

            $properties = ["regNr" => $regNr, "make" => $make];

            return $this->render("carRemoved.twig", $properties);
        }

    }