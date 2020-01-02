<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CheckModel;
    use Main\src\models\CustomerModel;

    class CheckController extends AbstractController {

        public function checkOut() {
            $customerModel = new CustomerModel($this->db);
            $customers = $customerModel->customers();
            $checkModel = new CheckModel($this->db);
            $cars = $checkModel->checkOutList();

            $properties = ["customers" => $customers, "cars" => $cars];
            return $this->render("checkOut.twig", $properties);
        }

        public function checkIn() {
            $checkModel = new CheckModel($this->db);
            $cars = $checkModel->checkInList();

            $properties = ["cars" => $cars];
            return $this->render("checkIn.twig", $properties);
        }
        
        public function checkedOut() {
            $form = $this->request->getForm();
            $customer = $form["customer"];
            $car = $form["car"];

            $ssNr  = substr($customer, 0, 12);
            $regNr = substr($car, 0, 6);

            $checkModel = new CheckModel($this->db);
            $checkModel->checkOut($ssNr, $regNr);

            $properties  = ["customer" => $customer, "car" => $car];
            return $this->render("checkedOut.twig", $properties);
        }

        public function checkedIn() {
            $form = $this->request->getForm();
            $car = $form["car"];

            $regNr = substr($car, 0, 6);

            $checkModel = new CheckModel($this->db);
            $checkModel->checkIn($regNr);

            $properties  = ["car" => $car];
            return $this->render("checkedIn.twig", $properties);
        }
    }