CREATE TABLE `notification` (
    `id` INT NOT NULL AUTO_INCREMENT , 
    `user_id` int(11) NOT NULL,
    `aktion` varchar(512) NOT NULL,
    `text` varchar(1024) DEFAULT NULL,
    `data` varchar(512) DEFAULT NULL,
    `mitarbeiter_abo` int(11) DEFAULT NULL,
    `gelesen` int(1) DEFAULT 0,
    `zeitstempel_gelesen` datetime DEFAULT NULL COMMENT 'Gelesen am: ',
    `zeitstempel_erstellt` datetime DEFAULT current_timestamp() COMMENT 'Erstellt am: ',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;