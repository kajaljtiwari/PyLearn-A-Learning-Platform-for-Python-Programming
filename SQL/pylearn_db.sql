CREATE DATABASE pylearn_db;
USE pylearn_db;

--------------------------------------------------
-- TABLE : ID GENERATOR
--------------------------------------------------

CREATE TABLE id_generator(
table_name VARCHAR(50) PRIMARY KEY,
next_id INT NOT NULL
);

INSERT INTO id_generator(table_name,next_id) VALUES
('students',1),
('admins',1),
('categories',1),
('topics',1),
('quiz_questions',1),
('results',1),
('feedback',1),
('certificates',1);

--------------------------------------------------
-- TABLE : ADMINS
--------------------------------------------------

CREATE TABLE admins(
admin_id INT PRIMARY KEY,
username VARCHAR(50) UNIQUE,
password VARCHAR(255),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins(admin_id,username,password)
VALUES(1,'admin','admin123');

--------------------------------------------------
-- TABLE : STUDENTS
--------------------------------------------------

CREATE TABLE students(
student_id INT PRIMARY KEY,
full_name VARCHAR(100),
email VARCHAR(100) UNIQUE,
mobile VARCHAR(15),
password VARCHAR(255),
status VARCHAR(20) DEFAULT 'active',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--------------------------------------------------
-- TABLE : CATEGORIES
--------------------------------------------------

CREATE TABLE categories(
category_id INT PRIMARY KEY,
category_name VARCHAR(100)
);

INSERT INTO categories(category_id,category_name) VALUES
(1,'Python Basics'),
(2,'Python in Data Science'),
(3,'Python in AI'),
(4,'Python Web Development'),
(5,'Python Automation'),
(6,'Python in Cyber Security'),
(7,'Python Game Development'),
(8,'Python Desktop Apps'),
(9,'Python in Cloud / DevOps');

--------------------------------------------------
-- TABLE : TOPICS
--------------------------------------------------

CREATE TABLE topics(
topic_id INT PRIMARY KEY,
category_id INT,
title VARCHAR(150),
content TEXT,
example_code TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO topics(topic_id,category_id,title,content,example_code) VALUES
(1,1,'Introduction to Python',
'Python is easy and powerful programming language.',
'print("Hello World")'),

(2,1,'Variables',
'Variables store values in Python.',
'x = 10'),

(3,1,'Loops',
'Loops repeat code multiple times.',
'for i in range(5): print(i)'),

(4,2,'NumPy',
'NumPy is used for numerical computing.',
'import numpy as np'),

(5,2,'Pandas',
'Pandas is used for data analysis.',
'import pandas as pd'),

(6,3,'Machine Learning',
'Python is popular in machine learning.',
'from sklearn import datasets'),

(7,4,'Django',
'Django is Python web framework.',
'pip install django');

--------------------------------------------------
-- TABLE : QUIZ QUESTIONS
--------------------------------------------------

CREATE TABLE quiz_questions(
question_id INT PRIMARY KEY,
topic_id INT,
question TEXT,
option_a VARCHAR(255),
option_b VARCHAR(255),
option_c VARCHAR(255),
option_d VARCHAR(255),
correct_option CHAR(1)
);

INSERT INTO quiz_questions VALUES
(1,1,'Python was created by?','Dennis','Guido van Rossum','James','Mark','B'),

(2,1,'Which symbol used for comment?','#','//','--','/*','A'),

(3,2,'Which keyword used for loop?','if','for','case','goto','B');

--------------------------------------------------
-- TABLE : RESULTS
--------------------------------------------------

CREATE TABLE results(
result_id INT PRIMARY KEY,
student_id INT,
topic_id INT,
score INT,
total INT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--------------------------------------------------
-- TABLE : FEEDBACK
--------------------------------------------------

CREATE TABLE feedback(
feedback_id INT PRIMARY KEY,
student_id INT,
message TEXT,
rating INT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--------------------------------------------------
-- TABLE : CERTIFICATES
--------------------------------------------------

CREATE TABLE certificates(
certificate_id INT PRIMARY KEY,
student_id INT,
topic_id INT,
certificate_no VARCHAR(50),
issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);