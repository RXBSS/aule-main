CREATE TABLE `modelle` (
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `hersteller_id` INT(11) NOT NULL ,
    `bezeichnung` VARCHAR(254) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;