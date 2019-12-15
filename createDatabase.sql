drop database if exists carRental;
create database carRental;
use carRental;

create table cars (RegNr varchar(6) primary key, Year integer, Price integer);
create table customers (SsNr bigint not null primary key, Name varchar(256), Adress varchar(256), `Postal Adress` varchar(256), Phonenumber varchar(10));
create table make (make varchar(256) primary key);
create table color (color varchar(256) primary key);

insert into customers(SsNr, Name, Adress, `Postal Adress`, Phonenumber) values (199309230465, 'Kajsa Dahlgren', 'Västertorp 23A', '75272 Uppsala', '0735526970'), 
                                                                  (195702130161, 'Stefan Backenfeldt', 'Fålhagsleden 27', '75272 Uppsala', '0767894256'),
                                                                  (197103130436, 'Karim Andersson', 'Stora torget 52', '75272 Uppsala', '0790597122'),
                                                                  (196712075016, 'Karin Malmberg', 'Lilla gatan 3', '75272 Uppsala', '0735526666'),
                                                                  (195704143295, 'Lindsey Adams', 'Havtornsvägen 25', '75272 Uppsala', '0722255878'),
                                                                  (198703089543, 'Chen Li alm', 'Älgtorp 26C', '75272 Uppsala', '0765568997'),
                                                                  (197001266894, 'Rasmus Tallhjort', 'Segelfeldtsgatan 33F', '75272 Uppsala', '0731130897'),
                                                                  (196107280833, 'Lisa Albrecht', 'Återvändsgränden 32', '75272 Uppsala', '0708977377');