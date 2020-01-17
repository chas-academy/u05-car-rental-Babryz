<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    // Class for statements involving the checkIn-/Out-proccess.
    class CheckModel extends AbstractModel {
        
        // Function for getting all available cars for the checkout dropdown list.
        public function checkOutList() {
            // Fetches all cars where personal number(ssNr) is not changed from default(0) which are the available cars.
            $carRows = $this->db->query("SELECT * FROM cars WHERE ssNr=0 AND NOT regNr = 'Removed'");
            if (!$carRows) die("Fatal Error.");

            // Looping through all rows of available cars.
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

        // Function for updating checkout time and personal number on car that got checked out.
        public function checkOut($ssNr, $regNr) {
            $checkQuery = "UPDATE cars SET ssNr = :ssNr, checkOutTime = CURRENT_TIMESTAMP WHERE regNr = :regNr";
            $checkStatement = $this->db->prepare($checkQuery);
            $checkParameters = ["ssNr" => $ssNr, "regNr" => $regNr];
            $checkStatement->execute($checkParameters);
            if (!$checkStatement) die("Fatal Error.");
        }

        // Function for getting all checked out cars for checkin list.
        public function checkInList() {
            // Fetches all cars where personal number(ssNr) is not default(0) which means it's has a customers personal number on it.
            $carRows = $this->db->query("SELECT * FROM cars where not ssNr=0");
            if (!$carRows) die("Fatal Error.");

            // Loops through all rows of checked out cars.
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

        // Function for getting ssNr for customer who checked out car to display who returned the car att checkin-screen.
        public function getSsNr($regNr) {
            $checkQuery = "SELECT ssNr FROM cars WHERE regNr = :regNr";
            $checkStatement = $this->db->prepare($checkQuery);
            $checkParameters = ["regNr" => $regNr];
            $checkStatement->execute($checkParameters);
            if (!$checkStatement) die("Fatal Error.");
            $ssNr = $checkStatement->fetch();

            return $ssNr['ssNr'];
        }

        // Function to set back personal number(ssNr) on car that is checked in to default(0).
        public function checkIn($regNr) {
                $checkQuery = "UPDATE cars SET ssNr = 0 WHERE regNr = :regNr";
                $checkStatement = $this->db->prepare($checkQuery);
                $checkParameters = ["regNr" => $regNr];
                $checkStatement->execute($checkParameters);
                if (!$checkStatement) die("Fatal Error.");
            }
            
    }