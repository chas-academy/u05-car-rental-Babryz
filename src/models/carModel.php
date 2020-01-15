<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    class CarModel extends AbstractModel {
        public function cars() {
            $carRows = $this->db->query("SELECT * FROM cars");
            if (!$carRows) die("Fatal Error.");

            $cars = [];
            foreach($carRows as $carRow) {
                $regNr = htmlspecialchars($carRow["regNr"]);
                $year = htmlspecialchars($carRow["year"]);
                $price = htmlspecialchars($carRow["price"]);
                $make = htmlspecialchars($carRow["make"]);
                $color = htmlspecialchars($carRow["color"]);
                $ssNr = htmlspecialchars($carRow["ssNr"]);
                $checkOutTime = htmlspecialchars($carRow["checkOutTime"]);
                
                $car = ["regNr" => $regNr,
                        "year" => $year, 
                        "price" => $price, 
                        "make" => $make, 
                        "color" => $color,
                        "ssNr" => $ssNr,
                        "checkOutTime" => $checkOutTime];
                
                $cars[] = $car;
            }
            return $cars;
        }

        public function makes() {
            $makeRows = $this->db->query("SELECT * FROM makes");
            if (!$makeRows) die("Fatal Error");

            $makes = [];
            foreach($makeRows as $makeRow) {
                $getMake = htmlspecialchars($makeRow["make"]);
                
                $make = ["getMake" => $getMake];
                $makes[] = $make;
            }

            return $makes;

        }
        

        public function colors() {
            $colorTableRows = $this->db->query("SELECT * FROM colors");
            if (!$colorTableRows) die("Fatal Error");

            $colors = [];
            foreach($colorTableRows as $colorTableRow) {
                $getColor = htmlspecialchars($colorTableRow["color"]);
                
                
                $color = ["getColor" => $getColor];
                
                $colors[] = $color;
            }

            return $colors;
        }

        public function addCar($regNr, $make, $color, $year, $price) {

            $carQuery = "INSERT INTO cars(regNr, year, price, make, color) " . "VALUES(:regNr, :year, :price, :make, :color)";
            $carStatement = $this->db->prepare($carQuery);
            $carParameters = ["regNr" => $regNr, "year" => $year, "price" => $price, "make" => $make, "color" => $color];
            $carStatement->execute($carParameters);
            if (!$carStatement) die("Fatal error.");

            return;
        }

        public function editCar($regNr, $newMake, $newColor, $newYear, $newPrice) {
            $carQuery = "UPDATE cars 
                              SET year = :year, price = :price, make = :make, color = :color
                              WHERE regNr = :regNr";
            $carStatement = $this->db->prepare($carQuery);
            $carParameters = ["year" => $newYear, "price" => $newPrice, "make" => $newMake, "color" => $newColor, "regNr" => $regNr];
            $carResult = $carStatement->execute($carParameters);
            if (!$carResult) die("Fatal error No price.");

            return;
        }

        public function removeCar($regNr) {
            $carQuery  = "DELETE FROM cars WHERE regNr = :regNr";
            $carStatement = $this->db->prepare($carQuery);
            $carStatement->execute(["regNr" => $regNr]);
            if (!$carStatement) die("Fatal Error Car.");

            return;
        }

        

    }