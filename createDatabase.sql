drop database if exists carRental;
create database carRental;
use carRental;

create table cars (regNr varchar(6) primary key, year integer, price integer);
create table customers (ssNr bigint not null primary key, Name varchar(256), adress varchar(256), postalAdress varchar(256), phonenumber varchar(10));
create table makes (make varchar(256) primary key);
create table colors (color varchar(256) primary key);

insert into customers(ssNr, Name, adress, postalAdress, phonenumber) values (199309230465, 'Kajsa Dahlgren', 'Västertorp 23A', '75272 Uppsala', '0735526970'), 
                                                                               (195702130161, 'Stefan Backenfeldt', 'Fålhagsleden 27', '75272 Uppsala', '0767894256'),
                                                                               (197103130436, 'Karim Andersson', 'Stora torget 52', '75272 Uppsala', '0790597122'),
                                                                               (196712075016, 'Karin Malmberg', 'Lilla gatan 3', '75272 Uppsala', '0735526666'),
                                                                               (195704143295, 'Lindsey Adams', 'Havtornsvägen 25', '75272 Uppsala', '0722255878'),
                                                                               (198703089543, 'Chen Li alm', 'Älgtorp 26C', '75272 Uppsala', '0765568997'),
                                                                               (197001266894, 'Rasmus Tallhjort', 'Segelfeldtsgatan 33F', '75272 Uppsala', '0731130897'),
                                                                               (196107280833, 'Lisa Albrecht', 'Återvändsgränden 32', '75272 Uppsala', '0708977377');

insert into cars(regNr, year, price) values ('AFG171', 1976, 100),
                                            ('GUY253', 2016, 300),
                                            ('TBG743', 1998, 200),
                                            ('GUF906', 1992, 150),
                                            ('FUJ178', 2005, 250),
                                            ('AGS673', 2010, 300),
                                            ('PQU374', 1980, 100),
                                            ('RUW790', 2008, 250);

insert into makes(make) values ('Peugeot'),
                              ('Suzuki'),
                              ('Fiat'),
                              ('Honda'),
                              ('Ford'),
                              ('Hyundai'),
                              ('Renault'),
                              ('Toyota'),
                              ('Chrystler');

insert into colors(color) values ('Blue'),
                                ('Red'),
                                ('Green'),
                                ('Yellow'),
                                ('Black'),
                                ('White'),
                                ('Magenta'),
                                ('Orange'),
                                ('Grey'),
                                ('Brown');