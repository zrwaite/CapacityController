CREATE TABLE capacitycontroller.stores (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	business_name CHAR(100) NOT NULL,
    admin_username CHAR(30) NOT NULL,
    email CHAR(40) NOT NULL,
    password_hash CHAR(200),
    image_link CHAR(200),
	store_address CHAR(100),
	phone CHAR(40),
	max_capacity INT(10),
	current_capacity INT(10),
	actual_capacity INT(10),
	bio TEXT(1000)
) ENGINE = InnoDB;

CREATE TABLE capacitycontroller.users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username CHAR(30) NOT NULL,
    password_hash CHAR(200),
	store_id int FOREIGN KEY REFERENCES stores(id)
) ENGINE = InnoDB;