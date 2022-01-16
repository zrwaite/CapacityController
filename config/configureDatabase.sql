CREATE DATABASE capacity_controller;

CREATE TABLE capacity_controller.stores (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	business_name CHAR(100) NOT NULL,
    admin_username CHAR(30) NOT NULL,
    admin_email CHAR(40) NOT NULL,
    public_email CHAR(40) NOT NULL,
    password_hash CHAR(200),
    image_link CHAR(200),
	store_address CHAR(100),
	store_hours CHAR(200),
	phone CHAR(40),
	max_capacity INT(10),
	actual_capacity INT(10),
	num_shoppers INT(10),
	bio TEXT(1000)
) ENGINE = InnoDB;

CREATE TABLE capacity_controller.users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username CHAR(30) NOT NULL,
    password_hash CHAR(200),
	store_id int
) ENGINE = InnoDB;