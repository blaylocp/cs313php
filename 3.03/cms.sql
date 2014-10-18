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

INSERT INTO role VALUES(null, 'Admin', '40', '1',  UTC_DATE(), '1', UTC_DATE()); 
INSERT INTO role VALUES(null, 'Authenticated', '10', '1',  UTC_DATE(), '1', UTC_DATE()); 
INSERT INTO role VALUES(null, 'Anonymous', '0', '1',  UTC_DATE(), '1', UTC_DATE()); 

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

INSERT INTO user VALUES(null, 'Preston', 'S', 'Blaylock', '1', UTC_DATE(), '1', UTC_DATE(), '1');

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
, FOREIGN KEY (user_id) REFERENCES user(user_id)
);

INSERT INTO webpage VALUES(null, "About Me", '/cms/images/preston.png', 
"Preston Scott Blaylock is a senior at Brigham Young University Idaho studying computer information technology and web design. Preston has an extreme love of graphic design, web development, photography, and playing the guitar. He is the third oldest of six kids, and that has shaped him into a peoples person. Preston has a variety of work experience, from photography to web development. He currently works for Barton Consulting for the last 10 months as a Web Developer.",
'1', UTC_DATE(), '1', UTC_DATE(), '1'); 

INSERT INTO webpage VALUES(null, "Current Project", '/cms/images/horse.jpg', 
"The current project that I am working on at work is for horseesurance.com. Horse Esurance is a website that provides insurance for your horses. The website is a simple website built with the Drupal Framework, and Bootstrap 3. My job is to replace out the old quote form with an newer sleeker form. The new form will be a dynamic, multi-step form built in angualrJs. When a user completes the form it will display a quote that then can then download as a pdf. The user then can sign it and mail it to the company for approval.",
'1', UTC_DATE(), '1', UTC_DATE(), '1'); 

CREATE TABLE comment
( comment_id INT PRIMARY KEY AUTO_INCREMENT
, comment text NOT NULL
, page_id INT NOT NULL
, create_by INT NOT NULL
, creation_date DATE NOT NULL
, last_updated_by INT NOT NULL
, last_update_date DATE NOT NULL
, user_id INT NOT NULL
, FOREIGN KEY (user_id) REFERENCES user(user_id)
, FOREIGN KEY (page_id) REFERENCES webpage(page_id)
);



