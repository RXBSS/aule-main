CREATE TABLE `adressen_oeffnungszeiten` (
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `adressen_id` int(11) NOT NULL ,
    `tag` int(1) NOT NULL ,
    `offen` int(1) NOT NULL DEFAULT 0 , 
    `von1` TIME NULL DEFAULT NULL, 
    `bis1` TIME NULL DEFAULT NULL, 
    `von2` TIME NULL DEFAULT NULL, 
    `bis2` TIME NULL DEFAULT NULL, 
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;