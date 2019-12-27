<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    class CustomerModel extends AbstractModel {
        public function customers() {
            $customerRows = $this->db->query("SELECT * FROM customers");
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
            $customerStatement->execute(["ssNr" => $ssNr, "name" => $name, "adress" => $adress, "postalAdress" => $postalAdress, "phonenumber" => $phonenumber]);
            if (!$customerStatement) die("Fatal error.");

            return;
        }
    }