<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CheckModel;
    use Main\src\models\CustomerModel;
    use Main\src\models\HistoryModel;

    // Class for everything related to the rendering of checkin and checkout pages.
    class CheckController extends AbstractController {

        // Function that gets all customers and available cars to send them to twig to then render the checkOut page with them.
        public function checkOut() {
            // Calls functions customers for all customers and checkOutList for all available cars.
            $customerModel = new CustomerModel($this->db);
            $customers = $customerModel->customers();
            $checkModel = new CheckModel($this->db);
            $cars = $checkModel->checkOutList();

            $properties = ["customers" => $customers, "cars" => $cars];
            return $this->render("checkOut.twig", $properties);
        }

        // Function that gets all checked out cars for checkin list.
        public function checkIn() {
            // Calls function checkInList to get all currently checked out cars.
            $checkModel = new CheckModel($this->db);
            $cars = $checkModel->checkInList();

            $properties = ["cars" => $cars];
            return $this->render("checkIn.twig", $properties);
        }
        
        // Function that gets info from form, update the history and change personal number(ssNr) on car to the customer that rented it and then renders checkedOut page.
        public function checkedOut() {
            $form = $this->request->getForm();
            $customer = $form["customer"];
            $car = $form["car"];

            // Define that the ssNr is the first 10 characters in $customer and regNr is the first 10 characters in $car.
            $ssNr  = substr($customer, 0, 10);
            $regNr = substr($car, 0, 6);

            // Calls function checkout from both historyModel and checkModel to update it on both the car rented and then the history table.
            $checkModel = new CheckModel($this->db);
            $checkModel->checkOut($ssNr, $regNr);
            $historyModel = new HistoryModel($this->db);
            $historyModel->checkOut($ssNr, $regNr);

            $properties  = ["customer" => $customer, "car" => $car];
            return $this->render("checkedOut.twig", $properties);
        }

        // Function that gets information on car that is checked in and updates history, that cars personal number and then renders the checkedIn page.
        public function checkedIn() {
            $form = $this->request->getForm();
            $car = $form["car"];

            // Define that regNr is the first 10 characters in $car.
            $regNr = substr($car, 0, 6);

            // Calls function getSsNr to get the ssnr on customer who checked in the car.
            $checkModel = new CheckModel($this->db);
            $ssNr = $checkModel->getSsNr($regNr);
            // Calls funtion to update the cars personal number to default(0).
            $checkModel->checkIn($regNr);
            $historyModel = new HistoryModel($this->db);
            // Calls function to update the history with the checkin time of that car.
            $historyModel->checkIn($regNr, $ssNr);
            // Calls function to update the history table with the amount of started days customer rented the car.
            $historyModel->setDays($regNr, $ssNr);
            // Calls function to update the history table with the total price for the rental period.
            $historyModel->setTotalPrice($regNr, $ssNr);

            $properties  = ["car" => $car, "ssNr" => $ssNr];
            return $this->render("checkedIn.twig", $properties);
        }

    }