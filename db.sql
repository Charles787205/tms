create database if not exists tms;

use tms;


CREATE TABLE users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(255)
);

create table if not exists tasks (
    taskId int auto_increment primary key,
    taskName varchar(255) not null,
    is_done boolean default 0,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users (userId) ON DELETE CASCADE
);