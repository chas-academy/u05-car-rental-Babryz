<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CustomerModel;

    class CustomerController extends AbstractController {
        public function customers() {
            $customerModel = new CustomerModel($this->db);
            $customers = $customerModel->customers();
            $properties = ["customers" => $customers];
            return $this->render("customers.twig", $properties);
        }
    }