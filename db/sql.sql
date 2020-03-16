CREATE DATABASE minfamilie;

USE minfamilie;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pseudonym VARCHAR(255),
    forename VARCHAR(255),
    surename VARCHAR(255),
    password VARCHAR(255) -- midlertidig
);

CREATE TABLE families (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    family_name VARCHAR(255)
);

CREATE TABLE memberships (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    family_id INT,
    user_id INT
);

CREATE TABLE todo (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    status BOOLEAN,
    family_id INT,
    user_id INT,
    time DATETIME
);

CREATE TABLE calendarEvents (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    location VARCHAR(255),
    day DATE,
    startHour INT,
    startMinute INT,
    duration INT,
    user_id INT,
    family_id INT,
    private BOOLEAN
);

CREATE TABLE shoppingItems (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    status BOOLEAN,
    family_id INT,
    time DATETIME
);