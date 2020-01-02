drop database if exists carRental;	
create database carRental;	
use carRental;	

create table makes (make varchar(256), primary key(make));
create table colors (color varchar(256), primary key(color));

create table customers (ssNr bigint not null, primary key(ssNr), name varchar(256), adress varchar(256), postalAdress varchar(256), phonenumber varchar(10));	

create table cars (regNr varchar(6), primary key(regNr),
                   year integer,
                   price integer,
                   make varchar(256), foreign key(make) references makes(make),
                   color varchar(256), foreign key(color) references colors(color),
                   ssNr bigint default 0, foreign key(ssNr) references customers(ssNr));

create table history (regNr varchar(6), foreign key(regNr) references cars(regNr),
                      ssNr bigint not null, foreign key(ssNr) references customers(ssNr),
                      checkOutTime datetime default current_timestamp,
                      checkInTime datetime,
                      days int,
                      cost int); 



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

insert into customers(ssNr, name, adress, postalAdress, phonenumber) values (199309230465, 'Kajsa Dahlgren', 'Aspgatan 23A', '75254 Uppsala', '0735526970'), 	
                                                                            (195702130161, 'Stefan Backenfeldt', 'Faltorp 27', '75223 Uppsala', '0767894256'),	
                                                                            (197103130436, 'Karim Andersson', 'Stora torget 52', '75275 Uppsala', '0790597122'),	
                                                                            (196712075016, 'Karin Malmberg', 'Lilla gatan 3', '75272 Uppsala', '0735526666'),	
                                                                            (195704143295, 'Lindsey Adams', 'Havtornsgatan 25', '75223 Uppsala', '0722255878'),	
                                                                            (198703089543, 'Chen Li alm', 'Esplanaden 26C', '75212 Tierp', '0765568997'),	
                                                                            (197001266894, 'Rasmus Tallhjort', 'Segelfeldtsgatan 33F', '75215 Uppsala', '0731130897'),	
                                                                            (196107280833, 'Lisa Albrecht', 'Helveticatorg 32', '75289 Uppsala', '0708977377');
insert into customers(ssnr) values (0);
                                                                            

insert into cars(regNr, year, price, make, color) values ('AFG171', 1976, 100, 'Peugeot', 'Green'),
                                                         ('GUY253', 2016, 300, 'Honda', 'Black'),
                                                         ('TBG743', 1998, 200, 'Chrystler', 'Yellow'),
                                                         ('GUF906', 1992, 150, 'Hyundai', 'White'),
                                                         ('FUJ178', 2005, 250, 'Suzuki', 'Grey'),
                                                         ('AGS673', 2010, 300, 'Renault', 'Red'),
                                                         ('PQU374', 1980, 100, 'Ford', 'Orange'),
                                                         ('RUW790', 2008, 250, 'Toyota', 'Brown');











