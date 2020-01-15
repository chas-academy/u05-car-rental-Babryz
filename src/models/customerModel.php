<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    // Class for statements involving the customer table.
    class CustomerModel extends AbstractModel {
        // Function for getting all customer data for the customers page.
        public function customers() {
            $customerRows = $this->db->query("SELECT * FROM customers where not ssNr=0");
            if (!$customerRows) die($this->db->errorInfo());

            // Looping through all rows in customers table.
            $customers = [];
            foreach($customerRows as $customerRow) {
                $ssNr = htmlspecialchars($customerRow["ssNr"]);
                $nameCoded = htmlspecialchars($customerRow["name"]);
                $name = utf8_encode($nameCoded);
                $adress = htmlspecialchars($customerRow["adress"]);
                $postalAdress = htmlspecialchars($customerRow["postalAdress"]);
                $phonenumber = htmlspecialchars($customerRow["phonenumber"]);

                // Checking and defining if customer has any cars rented to be able to have "edit/remove"-buttons as disabled.
                $customerQuery = "SELECT COUNT(*) FROM cars WHERE ssNr = :ssNr";
                $customerStatement = $this->db->prepare($customerQuery);
                $customerResult = $customerStatement->execute(["ssNr" => $ssNr]);
                if (!$customerResult) die("Fatal Error.");
                $carRows = $customerStatement->fetchAll();
                $numberOfCars = htmlspecialchars($carRows[0]["COUNT(*)"]);
                
                $customer = ["ssNr" => $ssNr,
                             "name" => $name, 
                             "adress" => $adress, 
                             "postalAdress" => $postalAdress, 
                             "phonenumber" => $phonenumber,
                             "numberOfCars" => $numberOfCars];
                
                $customers[] = $customer;
            }

            return $customers;

        }
        
        // Function for adding everything to the customer table for when you add a new car.
        public function addCustomer($ssNr, $name, $adress, $postalAdress, $phonenumber) {

            $customerQuery = "INSERT INTO customers(ssNr, name, adress, postalAdress, phonenumber) " . "VALUES(:ssNr, :name, :adress, :postalAdress, :phonenumber)";
            $customerStatement = $this->db->prepare($customerQuery);
            $customerParameters = ["ssNr" => $ssNr, "name" => $name, "adress" => $adress, "postalAdress" => $postalAdress, "phonenumber" => $phonenumber];
            $customerStatement->execute($customerParameters);
            if (!$customerStatement) die("Fatal error.");

            return;
        }

        // Function for updating edited fields when you edit a customer.
        public function editCustomer($ssNr, $newName, $newAdress, $newPostalAdress, $newPhonenumber) {
            $customerQuery = "UPDATE customers 
                              SET name = :name, adress = :adress, postalAdress = :postalAdress, phonenumber = :phonenumber
                              WHERE ssNr = :ssNr";
            $customerStatement = $this->db->prepare($customerQuery);
            $customerParameters = ["name" => $newName, "adress" => $newAdress, "postalAdress" => $newPostalAdress, "phonenumber" => $newPhonenumber, "ssNr" => $ssNr];
            $customerResult = $customerStatement->execute($customerParameters);
            if (!$customerResult) die("Fatal error.");

            return;
        }

        // Function for removing a customer from the customer table.
        public function removeCustomer($ssNr) {       
                $customerQuery  = "DELETE FROM customers WHERE ssNr = :ssNr";
                $customerStatement = $this->db->prepare($customerQuery);
                $customerStatement->execute(["ssNr" => $ssNr]);
                if (!$customerStatement) die("Fatal Error.");
        }
    }