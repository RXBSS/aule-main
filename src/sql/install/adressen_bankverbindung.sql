CREATE TABLE `adressen_bankverbindung` (
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `adressen_id` int(11) NOT NULL ,
    `iban` VARCHAR(254) NOT NULL ,
    `bic` VARCHAR(100) NOT NULL , 
    `bank` VARCHAR(254) NOT NULL , 
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;