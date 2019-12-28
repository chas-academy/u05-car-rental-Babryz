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
                
                $car = ["regNr" => $regNr,
                        "year" => $year, 
                        "price" => $price, 
                        "make" => $make, 
                        "color" => $color];
                
                $cars[] = $car;
            }
            return $cars;
        }

        public function makes() {
            $makeRows = $this->db->query("SELECT * FROM makes");
            if (!$makeRows) die("Fatal Error");

            $makes = [];
            foreach($makeRows as $makeRow) {
                $make = htmlspecialchars($makeRow["make"]);

                $map = ["make" => $make];
                $makes[] = $map;
                echo "Hellu";
            }

            if (!$makes) die("Fatal Error.");
            return $makes;

        }
        

        public function colors() {
            $colorTableRows = $this->db->query("SELECT * FROM colors");
            if (!$colorTableRows) die("Fatal Error");

            $colors = [];
            foreach($colorTableRows as $colorTableRow) {
                $color = htmlspecialchars($colorTableRow["color"]);
                
                
                $color = ["color" => $color];
                
                $colors[] = $color;
            }

            return $colors;
        }
    }