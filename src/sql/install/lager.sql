CREATE TABLE `lager` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `bezeichnung` VARCHAR(254) NULL DEFAULT NULL,
    `kommission` INT(11) NOT NULL DEFAULT 0,
    `hauptlager` INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;