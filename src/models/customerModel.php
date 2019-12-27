<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
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
    }