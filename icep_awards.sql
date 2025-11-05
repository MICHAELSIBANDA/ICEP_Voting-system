CREATE DATABASE IF NOT EXISTS icep_awards;
USE icep_awards;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    campus VARCHAR(100),
    password VARCHAR(255)
);

CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE nominations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nominee_id INT,
    category VARCHAR(100),
    nominated_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nominee_id) REFERENCES students(id),
    FOREIGN KEY (nominated_by) REFERENCES students(id)
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200),
    description TEXT,
    campus VARCHAR(100)
);

