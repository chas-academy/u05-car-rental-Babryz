<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CustomerModel;
    use Main\src\models\HistoryModel;

    class CustomerController extends AbstractController {
        public function customers() {
            $customerModel = new CustomerModel($this->db);
            $customers = $customerModel->customers();
            $properties = ["customers" => $customers];
            return $this->render("customers.twig", $properties);
        }

        public function addCustomer() {
            return $this->render("addCustomer.twig", []);
        }

        public function customerAdded() {
            $form = $this->request->getForm();
            $ssNr = $form["ssNr"];
            $name = $form["name"];
            $adress = $form["adress"];
            $postalAdress = $form["postalAdress"];
            $phonenumber = $form["phonenumber"];

            $customerModel = new CustomerModel($this->db);
            $customerModel->addCustomer($ssNr, $name, $adress, $postalAdress, $phonenumber);
            
            $customer = ["name" => $name, 
                         "ssNr" => $ssNr];

            $properties = ["customer" => $customer];
                        

            return $this->render("customerAdded.twig", $properties);
        }

        public function editCustomer($ssNr, $name, $adress, $postalAdress, $phonenumber) {
            $properties = ["ssNr" => $ssNr, "name" => $name, "adress" => $adress, "postalAdress" => $postalAdress, "phonenumber" => $phonenumber];
            
            return $this->render("editCustomer.twig", $properties);
        }

        public function customerEdited() {
            $form = $this->request->getForm();
            $ssNr = $form["ssNr"];
            $newName = $form["name"];
            $newAdress = $form["adress"];
            $newPostalAdress = $form["postalAdress"];
            $newPhonenumber = $form["phonenumber"];
            
            $customerModel = new CustomerModel($this->db);
            $customerModel->editCustomer($ssNr, $newName, $newAdress, $newPostalAdress, $newPhonenumber);

            $properties = ["ssNr" => $ssNr, "name" => $newName, "adress" => $newAdress, "postalAdress" => $newPostalAdress, "phonenumber" => $newPhonenumber];

            return $this->render("customerEdited.twig", $properties);
        }

        public function removeCustomer($ssNr, $name) {
            $customerModel = new CustomerModel($this->db);
            $numberOfCars = $customerModel->removeCustomer($ssNr);

            if ($numberOfCars == 0) {
                $historyModel = new HistoryModel($this->db);
                $historyModel->removeCustomerHistory($ssNr);
            }
            

            $properties = ["ssNr" => $ssNr, 
                           "name" => $name, 
                           "numberOfCars" => $numberOfCars];

            return $this->render("customerRemoved.twig", $properties);
        }
    }