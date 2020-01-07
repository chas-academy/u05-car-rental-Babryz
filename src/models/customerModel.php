<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    class CustomerModel extends AbstractModel {
        public function customers() {
            $customerRows = $this->db->query("SELECT * FROM customers where not ssNr=0");
            if (!$customerRows) die($this->db->errorInfo());

            $customers = [];
            foreach($customerRows as $customerRow) {
                $ssNr = htmlspecialchars($customerRow["ssNr"]);
                $nameCoded = htmlspecialchars($customerRow["name"]);
                $name = utf8_encode($nameCoded);
                $adress = htmlspecialchars($customerRow["adress"]);
                $postalAdress = htmlspecialchars($customerRow["postalAdress"]);
                $phonenumber = htmlspecialchars($customerRow["phonenumber"]);
                
                $customer = ["ssNr" => $ssNr,
                             "name" => $name, 
                             "adress" => $adress, 
                             "postalAdress" => $postalAdress, 
                             "phonenumber" => $phonenumber];
                
                $customers[] = $customer;
            }

            return $customers;

        }

        public function addCustomer($ssNr, $name, $adress, $postalAdress, $phonenumber) {

            $customerQuery = "INSERT INTO customers(ssNr, name, adress, postalAdress, phonenumber) " . "VALUES(:ssNr, :name, :adress, :postalAdress, :phonenumber)";
            $customerStatement = $this->db->prepare($customerQuery);
            $customerParameters = ["ssNr" => $ssNr, "name" => $name, "adress" => $adress, "postalAdress" => $postalAdress, "phonenumber" => $phonenumber];
            $customerStatement->execute($customerParameters);
            if (!$customerStatement) die("Fatal error.");

            return;
        }

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

        public function removeCustomer($ssNr) {
            $customerQuery  = "DELETE FROM customers WHERE ssNr = :ssNr";
            $customerStatement = $this->db->prepare($customerQuery);
            $customerStatement->execute(["ssNr" => $ssNr]);
            if (!$customerStatement) die("Fatal Error.");

            return;
        }

        public function checkOutList() {
            $customerRows = $this->db->query("SELECT * FROM customers where ssNr=0");
            if (!$customerRows) die($this->db->errorInfo());

            $customers = [];
            foreach($customerRows as $customerRow) {
                $ssNr = htmlspecialchars($customerRow["ssNr"]);
                $nameCoded = htmlspecialchars($customerRow["name"]);
                $name = utf8_encode($nameCoded);
                $adress = htmlspecialchars($customerRow["adress"]);
                $postalAdress = htmlspecialchars($customerRow["postalAdress"]);
                $phonenumber = htmlspecialchars($customerRow["phonenumber"]);
                
                $customer = ["ssNr" => $ssNr,
                             "name" => $name, 
                             "adress" => $adress, 
                             "postalAdress" => $postalAdress, 
                             "phonenumber" => $phonenumber];
                
                $customers[] = $customer;
            }

            return $customers;

        }
    }