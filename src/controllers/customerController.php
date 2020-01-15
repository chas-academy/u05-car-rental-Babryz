<?php
    namespace Main\src\controllers;

    use Main\src\controllers\AbstractController;
    use Main\src\models\CustomerModel;
    use Main\src\models\HistoryModel;

    // Class for everything related to the customer pages.
    class CustomerController extends AbstractController {
        // Function that calls function in carModel to get all cars and then render cars page.
        public function customers() {
            $customerModel = new CustomerModel($this->db);
            $customers = $customerModel->customers();
            $properties = ["customers" => $customers];
            return $this->render("customers.twig", $properties);
        }

        // Function that just renders the page were you add a customer.
        public function addCustomer() {
            return $this->render("addCustomer.twig", []);
        }

        // Function that gets info on customer added through form and sends it to addCustomer function and then renders customerAdded function with the customer addeds info.
        public function customerAdded() {
            $form = $this->request->getForm();
            $ssNr = $form["ssNr"];
            $name = $form["name"];
            $adress = $form["adress"];
            $postalAdress = $form["postalAdress"];
            $phonenumber = $form["phonenumber"];

            // Calls function to add new customer to the customer table.
            $customerModel = new CustomerModel($this->db);
            $customerModel->addCustomer($ssNr, $name, $adress, $postalAdress, $phonenumber);
            
            $customer = ["name" => $name, 
                         "ssNr" => $ssNr];

            $properties = ["customer" => $customer];
                        

            return $this->render("customerAdded.twig", $properties);
        }

        // Function that gets info on customer you want to edit through url and then render editCustomer page.
        public function editCustomer($ssNr, $name, $adress, $postalAdress, $phonenumber) {
            $properties = ["ssNr" => $ssNr, "name" => $name, "adress" => $adress, "postalAdress" => $postalAdress, "phonenumber" => $phonenumber];
            
            return $this->render("editCustomer.twig", $properties);
        }

        // Function that gets new info on customer edited through form, updates the customer and renders customerEdited page with new info.
        public function customerEdited() {
            // Gets all info through form.
            $form = $this->request->getForm();
            $ssNr = $form["ssNr"];
            $newName = $form["name"];
            $newAdress = $form["adress"];
            $newPostalAdress = $form["postalAdress"];
            $newPhonenumber = $form["phonenumber"];
            
            // Calls function editCustomer from customerModel to edit the values on the customer in the database.
            $customerModel = new CustomerModel($this->db);
            $customerModel->editCustomer($ssNr, $newName, $newAdress, $newPostalAdress, $newPhonenumber);

            $properties = ["ssNr" => $ssNr, "name" => $newName, "adress" => $newAdress, "postalAdress" => $newPostalAdress, "phonenumber" => $newPhonenumber];

            return $this->render("customerEdited.twig", $properties);
        }

        // Function that gets info on customer removed through url, removes it from customers and history table and then renders customerRemoved page.
        public function removeCustomer($ssNr, $name) {
            // Calls function to remove customer from all occurences in history table.
            $historyModel = new HistoryModel($this->db);
            $customerModel = new CustomerModel($this->db);

            // Calls function to remove customer from customer table.
            $historyModel->removeCustomerHistory($ssNr);
            $customerModel->removeCustomer($ssNr);
        
            $properties = ["ssNr" => $ssNr, 
                           "name" => $name];

            return $this->render("customerRemoved.twig", $properties);
        }
    }