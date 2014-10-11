CREATE DATABASE cms;
USE cms;

CREATE TABLE role
( role_id INT PRIMARY KEY AUTO_INCREMENT
, role_name VARCHAR(10) NOT NULL
, role_value INT NOT NULL
, create_by INT NOT NULL
, creation_date DATE NOT NULL
, last_updated_by INT NOT NULL
, last_update_date DATE NOT NULL
);

CREATE TABLE user
( user_id INT PRIMARY KEY AUTO_INCREMENT
, user_first_name VARCHAR(20) NOT NULL
, user_middle_initial VARCHAR(1)
, user_last_name VARCHAR(20) NOT NULL
, create_by INT NOT NULL
, creation_date DATE NOT NULL
, last_updated_by INT NOT NULL
, last_update_date DATE NOT NULL
, role_id INT NOT NULL
, FOREIGN KEY (role_id) REFERENCES role(role_id)
);

CREATE TABLE comment
( comment_id INT PRIMARY KEY AUTO_INCREMENT
, comment text NOT NULL
, create_by INT NOT NULL
, creation_date DATE NOT NULL
, last_updated_by INT NOT NULL
, last_update_date DATE NOT NULL
, user_id INT NOT NULL
, FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE webpage
( page_id INT PRIMARY KEY AUTO_INCREMENT
, page_title VARCHAR(20) NOT NULL
, page_image_url VARCHAR(50)
, page_text TEXT NOT NULL
, create_by INT NOT NULL
, creation_date DATE NOT NULL
, last_updated_by INT NOT NULL
, last_update_date DATE NOT NULL
, user_id INT NOT NULL
, comment_id INT NOT NULL
, FOREIGN KEY (user_id) REFERENCES user(user_id)
, FOREIGN KEY (comment_id) REFERENCES comment(comment_id)
);
