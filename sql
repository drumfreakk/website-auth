CREATE DATABASE website;

CREATE OR REPLACE USER 'website'@'localhost';
GRANT ALL PRIVILEGES ON website.* TO 'website'@'localhost';
SET PASSWORD FOR 'website'@'localhost' = PASSWORD('password');
FLUSH PRIVILEGES;

USE website;

CREATE TABLE users ( 
	uID INT NOT NULL AUTO_INCREMENT, 
	username VARCHAR(255) NOT NULL UNIQUE, 
	password VARCHAR(255) NOT NULL, 
	PRIMARY KEY (uID) 
);

CREATE TABLE authcodes ( 
	codeId INT NOT NULL AUTO_INCREMENT, 
	uID INT NOT NULL, 
	code VARCHAR(255) NOT NULL UNIQUE, 
	expiry INT UNSIGNED NOT NULL, 
	p_basic BOOL,
	PRIMARY KEY (codeID) 
);

