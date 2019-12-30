<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CarModel;
    use Main\src\models\CustomerModel;

    class CheckController extends AbstractController {

        public function checkOut() {
            $customerModel = new CustomerModel($this->db);
            $customers = $customerModel->customers();
            $carModel = new CarModel($this->db);
            $cars = $carModel->cars();

            $properties = ["customers" => $customers, "cars" => $cars];
            return $this->render("checkOut.twig", $properties);
        }
        
    }