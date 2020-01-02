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
            $checkQuery = "UPDATE cars SET ssNr = :ssNr WHERE regNr = :regNr";
            $checkStatement = $this->db->prepare($checkQuery);
            $checkParameters = ["ssNr" => $ssNr, "regNr" => $regNr];
            $checkStatement->execute($checkParameters);
            if (!$checkStatement) die("Fatal Error.");

            $historyQuery = "INSERT INTO history(regNr, ssNr) " . "VALUES (:regNr, :ssNr)";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyStatement->execute($historyParameters);
            if (!$historyStatement) die("Fatal Error.");
        }

        public function checkInList() {
            $carRows = $this->db->query("SELECT * FROM cars where not ssNr=0");
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

        public function checkIn($regNr) {
                $checkQuery = "UPDATE cars SET ssNr = 0 WHERE regNr = :regNr";
                $checkStatement = $this->db->prepare($checkQuery);
                $checkParameters = ["regNr" => $regNr];
                $checkStatement->execute($checkParameters);
                if (!$checkStatement) die("Fatal Error.");

                $historyQuery = "UPDATE history SET checkInTime = CURRENT_TIMESTAMP WHERE regNr = :regNr";
                $historyStatement = $this->db->prepare($historyQuery);
                $historyParameters = ["regNr" => $regNr];
                $historyStatement->execute($historyParameters);
                if (!$historyStatement) die("Fatal Error.");
            }
    
    }