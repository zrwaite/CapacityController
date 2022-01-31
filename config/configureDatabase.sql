CREATE DATABASE capacity_controller;

CREATE TABLE capacity_controller.stores (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name CHAR(100) NOT NULL,
    admin_username CHAR(30) NOT NULL,
    public_email CHAR(40) NOT NULL,
	max_capacity INT(10) NOT NULL,
	actual_capacity INT(10) NOT NULL,
	num_shoppers INT(10) NOT NULL,
    image_link CHAR(200),
	address CHAR(100),
    hours CHAR(200),
	phone CHAR(40),
	bio TEXT(1000)
) ENGINE = InnoDB;

CREATE TABLE capacity_controller.users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username CHAR(30) NOT NULL,
    password_hash CHAR(200),
    admin boolean,
    email CHAR(40),
    store_id int,
    FOREIGN KEY (store_id) REFERENCES stores (id)
) ENGINE = InnoDB;