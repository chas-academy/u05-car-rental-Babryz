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

        public function checkIn($regNr) {
            $historyQuery = "UPDATE history SET checkInTime = CURRENT_TIMESTAMP WHERE regNr = :regNr";
            $historyStatement = $this->db->prepare($historyQuery);
            $historyParameters = ["regNr" => $regNr];
            $historyStatement->execute($historyParameters);
            if (!$historyStatement) die("Fatal Error.");

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
                
                $histor = ["regNr" => $regNr,
                        "ssNr" => $ssNr, 
                        "checkOut" => $checkOut, 
                        "checkIn" => $checkIn, 
                        "days" => $days,
                        "cost" => $cost];
                
                $history[] = $histor;
            }
            return $history;
        }

    }