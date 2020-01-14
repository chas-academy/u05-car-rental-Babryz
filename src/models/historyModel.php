<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    class HistoryModel extends AbstractModel {

        public function checkOut($ssNr, $regNr){
            $historyQuery = "INSERT INTO history(regNr, ssNr) " . "VALUES (:regNr, :ssNr)";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyStatement->execute($historyParameters);
            if (!$historyStatement) die("Fatal Error.");
        }


        public function checkIn($regNr, $ssNr) {
            $historyQuery = "UPDATE history SET checkInTime = CURRENT_TIMESTAMP WHERE regNr = :regNr AND ssNr = :ssNr";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyStatement->execute($historyParameters);
            if (!$historyStatement) die("Fatal Error.");
        }

        public function setDays($regNr, $ssNr) {
            $historyQuery = "SELECT * FROM history WHERE regNr = :regNr AND ssNr = :ssNr";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyRows = $historyStatement->execute($historyParameters);
            if (!$historyRows) die("Fatal Error");

            if (is_array($historyRows) || is_object($historyRows)) {
                
                foreach ($historyRows as $historyRow) {
                $checkOut = htmlspecialchars($historyRow["checkOutTime"]);
                $checkIn = htmlspecialchars($historyRow["checkInTime"]);
                
                $checkOutTime = new \DateTime($checkOut);
                $checkInTime = new \DateTime($checkIn);
                
                $difference = $checkOutTime->diff($checkInTime);
                $minutes = $difference->days * 24 * 60;
                $minutes += $difference->h * 60;
                $minutes += $difference->i;

                echo $difference->i;
                
                $days = $minutes / 60 / 24;
                
                if ($days < 1) {
                    $days = 1;
                }
            
                $historyQuery = "UPDATE history SET days = :days WHERE regNr = :regNr AND ssNr = :ssNr";
                $historyStatement = $this->db->prepare($historyQuery);
                $historyParameters = ["days" => $days, "regNr" => $regNr, "ssNr" => $ssNr];
                $historyStatement->execute($historyParameters);
                if (!$historyStatement) die("Fatal Error");
                }
                
                } else {
                    $time = $historyStatement->fetch();

                    $checkOut = $time["checkOutTime"];
                    $checkIn = $time["checkInTime"];
                    
                    $checkOutTime = new \DateTime($checkOut);
                    $checkInTime = new \DateTime($checkIn);
                    
                    $difference = $checkOutTime->diff($checkInTime);
                    $minutes = $difference->days * 24 * 60;
                    $minutes += $difference->h * 60;
                    $minutes += $difference->i;
                    
                    $days = $minutes / 60 / 24;
                    
                    if ($days < 1) {
                        $days = 1;
                    }
                
                    $historyQuery = "UPDATE history SET days = :days WHERE regNr = :regNr AND ssNr = :ssNr";
                    $historyStatement = $this->db->prepare($historyQuery);
                    $historyParameters = ["days" => $days, "regNr" => $regNr, "ssNr" => $ssNr];
                    $historyStatement->execute($historyParameters);
                    if (!$historyStatement) die("Fatal Error");
                }
        }

        public function setTotalPrice($regNr, $ssNr) {
            $historyQuery = "SELECT * FROM history WHERE regNr = :regNr AND ssnr = :ssNr";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyRows = $historyStatement->execute($historyParameters);
            if (!$historyRows) die("Fatal Error");

            $priceQuery = "SELECT price FROM cars WHERE regNr = :regNr";
            $priceStatement = $this->db->prepare($priceQuery);
            $priceStatement->execute(["regNr" => $regNr]);
            if (!$priceStatement) die("Fatal Error.");
            $prices = $priceStatement->fetch();
            $dailyPrice = $prices["price"];

            if (is_array($historyRows) || is_object($historyRows)) {
                
                foreach ($historyRows as $historyRow) {
                $days = htmlspecialchars($historyRow["days"]);
                $cost = $dailyPrice * $days;
                echo $days;

                $historyQuery = "UPDATE history SET cost = :cost WHERE regNr = :regNr AND ssNr = :ssNr";
                $historyStatement = $this->db->prepare($historyQuery);
                $historyParameters = ["cost" => $cost, "regNr" => $regNr, "ssNr" => $ssNr];
                $historyStatement->execute($historyParameters);
                if (!$historyStatement) die("Fatal Error");
                }

            } else {
                $time = $historyStatement->fetch();
                $days = $time["days"];
                $cost = $dailyPrice * $days;

                $historyQuery = "UPDATE history SET cost = :cost WHERE regNr = :regNr AND ssNr = :ssNr";
                $historyStatement = $this->db->prepare($historyQuery);
                $historyParameters = ["cost" => $cost, "regNr" => $regNr, "ssNr" => $ssNr];
                $historyStatement->execute($historyParameters);
                if (!$historyStatement) die("Fatal Error");
            }
        }

        public function viewHistory() {
            $historyRows = $this->db->query("SELECT * FROM history");
            if (!$historyRows) die("Fatal Error.");

            $history = [];
            foreach($historyRows as $historyRow) {
                $regNr = htmlspecialchars($historyRow["regNr"]);
                $ssNr = htmlspecialchars($historyRow["ssNr"]);
                $checkOut = htmlspecialchars($historyRow["checkOutTime"]);
                $checkIn = htmlspecialchars($historyRow["checkInTime"]);
                $days = htmlspecialchars($historyRow["days"]);
                $cost = htmlspecialchars($historyRow["cost"]);

                if (!$checkIn) {
                    $checkIn = "Checked Out";
                    $days = 0;
                    $cost = 0;
                }
                
                $histor = ["regNr" => $regNr,
                        "ssNr" => $ssNr, 
                        "checkOut" => $checkOut,
                        "checkIn" => $checkIn, 
                        "days" => $days,
                        "cost" => $cost,
                        "days" => $days];
                
                $history[] = $histor;
            }
            return $history;
        }

        public function removeCarHistory($regNr) {
            $historyQuery = "DELETE FROM history WHERE regNr = :regNr";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyStatement->execute(["regNr" => $regNr]);
            if (!$historyStatement) die("Fatal Error History");

            return;
        }

        public function removeCustomerHistory($ssNr) {
            $historyQuery = "DELETE FROM history WHERE ssNr = :ssNr";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyStatement->execute(["ssNr" => $ssNr]);
            if (!$historyStatement) die("Fatal Error History");

            return;
        }

    }