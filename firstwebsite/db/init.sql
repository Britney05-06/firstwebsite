CREATE TABLE IF NOT EXISTS users
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    lastname VARCHAR(100),
    firstname VARCHAR(100),
    email VARCHAR(255),
    phone VARCHAR(20),
    picture VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS experiences
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(200),
    description VARCHAR(1000),
    startdate DATE,
    enddate DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS educations
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(200),
    description VARCHAR(1000),
    startdate DATE,
    enddate DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS skills
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(200),
    level VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id)
);