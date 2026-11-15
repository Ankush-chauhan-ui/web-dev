CREATE DATABASE IF NOT EXISTS technova
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE technova;

-- One row = one admission enquiry sent from the website form
CREATE TABLE IF NOT EXISTS enquiries (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,  -- unique number, MySQL fills it in
  name       VARCHAR(100) NOT NULL,
  email      VARCHAR(150) NOT NULL,
  phone      CHAR(10)     NOT NULL,                             -- exactly 10 digits
  course     VARCHAR(60)  NOT NULL,
  message    TEXT         NULL,                                 -- optional field
  status     ENUM('new', 'contacted') NOT NULL DEFAULT 'new',   -- admissions team updates this
  created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP    -- MySQL fills in the time
);
