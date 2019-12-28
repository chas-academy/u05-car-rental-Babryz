<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    class CarModel extends AbstractModel {
        public function cars() {
            $carRows = $this->db->query("SELECT * FROM cars");
            if (!$carRows) die($this->db->errorInfo());

            $cars = [];
            foreach($carRows as $carRow) {
                $regNr = htmlspecialchars($carRow["regNr"]);
                $year = htmlspecialchars($carRow["year"]);
                $price = htmlspecialchars($carRow["price"]);
                $make = htmlspecialchars($carRow["make"]);
                $color = htmlspecialchars($carRow["color"]);
                
                $car = ["regNr" => $regNr,
                        "name" => $name, 
                        "adress" => $adress, 
                        "postalAdress" => $postalAdress, 
                        "phonenumber" => $phonenumber];
                
                $customers[] = $customer;
            }

            return $customers;
    }