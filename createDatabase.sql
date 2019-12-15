drop database if exists carRental;
create database carRental;
use carRental;

create table cars (RegNr varchar(6) primary key, Year integer, Price integer);
create table customers (SsNr integer(12) primary key, Name varchar(256), Adress varchar(256), [Postal adress] varchar(256));
create table make (make varchar(256) primary key);
create table color (color varchar(256) primary key);