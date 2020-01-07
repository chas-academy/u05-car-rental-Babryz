<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    class CheckModel extends AbstractModel {
        
        public function checkOutList() {
            $carRows = $this->db->query("SELECT * FROM cars where ssNr=0");
            if (!$carRows) die("Fatal Error.");

            $cars = [];
            foreach($carRows as $carRow) {
                $regNr = htmlspecialchars($carRow["regNr"]);
                $year = htmlspecialchars($carRow["year"]);
                $price = htmlspecialchars($carRow["price"]);
                $make = htmlspecialchars($carRow["make"]);
                $color = htmlspecialchars($carRow["color"]);
                
                $car = ["regNr" => $regNr,
                        "year" => $year, 
                        "price" => $price, 
                        "make" => $make, 
                        "color" => $color];
                
                $cars[] = $car;
            }
            return $cars;
        }

        public function checkOut($ssNr, $regNr) {
            $checkQuery = "UPDATE cars SET ssNr = :ssNr, checkOutTime = CURRENT_TIMESTAMP WHERE regNr = :regNr";
            $checkStatement = $this->db->prepare($checkQuery);
            $checkParameters = ["ssNr" => $ssNr, "regNr" => $regNr];
            $checkStatement->execute($checkParameters);
            if (!$checkStatement) die("Fatal Error.");
        }

        public function checkInList() {
            $carRows = $this->db->query("SELECT * FROM cars where not ssNr=0");
            if (!$carRows) die("Fatal Error.");

            $cars = [];
            foreach($carRows as $carRow) {
                $regNr = htmlspecialchars($carRow["regNr"]);
                $price = htmlspecialchars($carRow["price"]);
                $make = htmlspecialchars($carRow["make"]);
                $ssNr = htmlspecialchars($carRow["ssNr"]);
                
                $car = ["regNr" => $regNr,
                        "price" => $price, 
                        "make" => $make, 
                        "ssNr" => $ssNr];
                
                $cars[] = $car;
            }
            return $cars;
        }

        public function getSsNr($regNr) {
            $checkQuery = "SELECT ssNr FROM cars WHERE regNr = :regNr";
            $checkStatement = $this->db->prepare($checkQuery);
            $checkParameters = ["regNr" => $regNr];
            $checkStatement->execute($checkParameters);
            if (!$checkStatement) die("Fatal Error.");
            $ssNr = $checkStatement->fetch();

            return $ssNr['ssNr'];
        }

        public function checkIn($regNr) {
                $checkQuery = "UPDATE cars SET ssNr = 0 WHERE regNr = :regNr";
                $checkStatement = $this->db->prepare($checkQuery);
                $checkParameters = ["regNr" => $regNr];
                $checkStatement->execute($checkParameters);
                if (!$checkStatement) die("Fatal Error.");
            }
            
    }