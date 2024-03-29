
CREATE DATABASE IF NOT EXISTS xxx CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE xxx;

CREATE TABLE calendar
(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date INT(16) UNSIGNED DEFAULT 0,
    user_hash VARCHAR(40) NOT NULL,
    quartal_i VARCHAR(20) DEFAULT NULL,
    quartal_ii VARCHAR(20) DEFAULT NULL,
    quartal_iii VARCHAR(20) DEFAULT NULL,
    quartal_iV VARCHAR(20) DEFAULT NULL,
    checklist_i VARCHAR(20) DEFAULT NULL,
    checklist_ii VARCHAR(20) DEFAULT NULL,
    checklist_ii VARCHAR(20) DEFAULT NULL,
    checklist_iv VARCHAR(20) DEFAULT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

