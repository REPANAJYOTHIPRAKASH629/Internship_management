CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  rollno VARCHAR(20) NOT NULL UNIQUE,
  branch VARCHAR(50) NOT NULL,
  section VARCHAR(10) NOT NULL,
  year INT NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);


CREATE TABLE offer_letters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  rollno VARCHAR(20) NOT NULL,
  company VARCHAR(100) NOT NULL,
  role VARCHAR(100) NOT NULL,
  internshipstartdate DATE NOT NULL,
  offerletter VARCHAR(255) NOT NULL
);


CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    rollno VARCHAR(20) NOT NULL,
    startdate DATE NOT NULL,
    enddate DATE NOT NULL,
    company VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    filename VARCHAR(255) NOT NULL
);


CREATE TABLE admins (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE ,
  password VARCHAR(255) NOT NULL
);



