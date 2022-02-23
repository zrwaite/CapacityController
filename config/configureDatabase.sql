CREATE DATABASE capacity_controller;

CREATE TABLE capacity_controller.stores (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name CHAR(100) NOT NULL,
    admin_username CHAR(30) NOT NULL,
	max_capacity INT(10) NOT NULL,
	actual_capacity INT(10) NOT NULL,
	num_shoppers INT(10) DEFAULT 0,
    public_email CHAR(40),
    image_link CHAR(200),
	address CHAR(100),
    hours CHAR(200),
	phone CHAR(40),
	bio TEXT(1000)
) ENGINE = InnoDB;

CREATE TABLE capacity_controller.users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username CHAR(30) NOT NULL UNIQUE,
    password_hash CHAR(200) NOT NULL,
    admin boolean DEFAULT FALSE,
    email CHAR(40),
    store_id int
) ENGINE = InnoDB;