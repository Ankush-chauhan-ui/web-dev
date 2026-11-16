CREATE DATABASE IF NOT EXISTS technova
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE technova;


CREATE TABLE IF NOT EXISTS enquiries (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  name       VARCHAR(100) NOT NULL,
  email      VARCHAR(150) NOT NULL,
  phone      CHAR(10)     NOT NULL,                             
  course     VARCHAR(60)  NOT NULL,
  message    TEXT         NULL,                                 
  status     ENUM('new', 'contacted') NOT NULL DEFAULT 'new',   
  created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP    
);
