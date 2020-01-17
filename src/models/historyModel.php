<?php
    namespace Main\src\models;

    use Main\src\models\AbstractModel;
    use Main\src\core\Request;
    use PDO;

    // Class for statements involving the history table.
    class HistoryModel extends AbstractModel {
        
        // Function for inserting registration number and personal number into history table upon checkout.
        public function checkOut($ssNr, $regNr){
            $historyQuery = "INSERT INTO history(regNr, ssNr) " . "VALUES (:regNr, :ssNr)";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyStatement->execute($historyParameters);
            if (!$historyStatement) die("Fatal Error.");
        }

        // Function for updating the history table with checkin time upon checkin
        public function checkIn($regNr, $ssNr) {
            $historyQuery = "UPDATE history SET checkInTime = CURRENT_TIMESTAMP WHERE regNr = :regNr AND ssNr = :ssNr ORDER BY checkOutTime DESC LIMIT 1";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyStatement->execute($historyParameters);
            if (!$historyStatement) die("Fatal Error.");
        }

        // Function for updating the history table with days upon checkin
        public function setDays($regNr, $ssNr) {
            // Selecting the right row from history table bases on the personal number and registration number to update on right place.
            $historyQuery = "SELECT * FROM history WHERE regNr = :regNr AND ssNr = :ssNr ORDER BY checkOutTime DESC LIMIT 1";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyRows = $historyStatement->execute($historyParameters);
            if (!$historyRows) die("Fatal Error");
                
            // Fetching the checkin and checkout time from row selected above.
            $time = $historyStatement->fetch();
            $checkOut = $time["checkOutTime"];
            $checkIn = $time["checkInTime"];
            
            // Redefining times as Datetime-objects.
            $checkOutTime = new \DateTime($checkOut);
            $checkInTime = new \DateTime($checkIn);
            
            // Adding days, hours, minutes and seconds to total amount of minutes car has been rented.
            $difference = $checkOutTime->diff($checkInTime);
            $minutes = $difference->days * 24 * 60;
            $minutes += $difference->h * 60;
            $minutes += $difference->i;
            $minutes += $difference->s / 60;
            
            // Divide minutes with minutes in an hour and then hours in a day to get the amount in days and then rounding it up so we get amount of started days.
            $unroundedDays = $minutes / 60 / 24;
            $days = ceil($unroundedDays);
            
            // Updating history row we selected above with the total amount of days started.
            $historyQuery = "UPDATE history SET days = :days WHERE regNr = :regNr AND ssNr = :ssNr ORDER BY checkOutTime DESC LIMIT 1";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["days" => $days, "regNr" => $regNr, "ssNr" => $ssNr];
            $historyStatement->execute($historyParameters);
            if (!$historyStatement) die("Fatal Error");
                
        }

        // Function for updating the history table with the price for the rental period upon checkIn
        public function setTotalPrice($regNr, $ssNr) {
            // Selecting the right row from history table bases on the personal number and registration number to update on right place.
            $historyQuery = "SELECT * FROM history WHERE regNr = :regNr AND ssnr = :ssNr ORDER BY checkOutTime DESC LIMIT 1";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr, "ssNr" => $ssNr];
            $historyRows = $historyStatement->execute($historyParameters);
            if (!$historyRows) die("Fatal Error");

            // Getting the daily price of the car rented.
            $priceQuery = "SELECT price FROM cars WHERE regNr = :regNr";
            $priceStatement = $this->db->prepare($priceQuery);
            $priceStatement->execute(["regNr" => $regNr]);
            if (!$priceStatement) die("Fatal Error.");
            $prices = $priceStatement->fetch();
            $dailyPrice = $prices["price"];

            // Inserting the daily price times the amount of days started and updating on the row selected on at the top.
            $time = $historyStatement->fetch();
            $days = $time["days"];
            $cost = $dailyPrice * $days;
            $historyQuery = "UPDATE history SET cost = :cost WHERE regNr = :regNr AND ssNr = :ssNr ORDER BY checkOutTime DESC LIMIT 1";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["cost" => $cost, "regNr" => $regNr, "ssNr" => $ssNr];
            $historyStatement->execute($historyParameters);
            if (!$historyStatement) die("Fatal Error");
        }

        // Function for getting all history data for the history page.
        public function viewHistory() {
            $historyRows = $this->db->query("SELECT * FROM history");
            if (!$historyRows) die("Fatal Error.");

            // Looping through all rows in the histoy table.
            $history = [];
            foreach($historyRows as $historyRow) {
                $regNr = htmlspecialchars($historyRow["regNr"]);
                $ssNr = htmlspecialchars($historyRow["ssNr"]);
                $checkOut = htmlspecialchars($historyRow["checkOutTime"]);
                $checkIn = htmlspecialchars($historyRow["checkInTime"]);
                $days = htmlspecialchars($historyRow["days"]);
                $cost = htmlspecialchars($historyRow["cost"]);

                // Setting 0 as default value on days and cost if car not checked in yet.
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

        // Function for removing everything related to the car from history table upon removal of that car.
        public function removeCarHistory($regNr) {
            $historyQuery = "UPDATE history set regNr = 'Removed' WHERE regNr = :regNr";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyStatement->execute(["regNr" => $regNr]);
            if (!$historyStatement) die("Fatal Error History");
        }

        // Function for removing everything related to the customer from history table upon removal of that customer.
        public function removeCustomerHistory($ssNr) {
            $historyQuery = "UPDATE history set ssNr = 0 WHERE ssNr = :ssNr";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyStatement->execute(["ssNr" => $ssNr]);
            if (!$historyStatement) die("Fatal Error History");
        }

    }