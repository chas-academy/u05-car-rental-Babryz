<?php

    namespace Main\models;

    class Model {
        private $connection;

        public function __construct($connection) {
            $this->connection = $connection;
        }

        public function getAllCustomers() {
            // Läser in alla kunder
            $customerRows = $this->connection->query("select * from customers");
            return $this->prepareCustomerRows($customerRows);
        }

        public function prepareCustomerRows($customerRows) {
            $customers = [];

            foreach ($customerRows as $customerRow) {
                $ssNr = $customerRow["SsNr"];
                $name = $customerRow["Name"];
                $adress = $customerRow["Adress"];
                $postal_adress = $customerRow["Postal Adress"];
                $phoneNumber = $customerRow["Phonenumber"];
                $customer = ["ssNr" => $ssNr, "name" => $name, "Adress" => $adress, "postal adress" => $postal_adress, "phonenumber" => $phoneNumber];
                $customers[] = $customer;
            }
            return $customers;
        }

        public function getAllCars() {
            // Läser in alla bilar
            $carRows = $this->connection->query("Create carView");
            return $this->prepareCarRows($carRows);
        }

        public function prepareCarRows($carRows) {
            $cars = [];

            foreach ($carRows as $carRow) {
                $regNr = $carRow["RegNr"];
                $make = $carRow["Make"];
                $color = $carRow["Color"];
                $year = $carRow["Year"];
                $price = $carRow["Price"];
                $car = ["regNr" => $regNr, "make" => $make, "color" => $color, "year" => $year, "price" => $price];
                $cars[] = $car;
            }
            return $cars;
        }

    }
?>