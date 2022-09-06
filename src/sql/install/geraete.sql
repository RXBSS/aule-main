/*
CREATE TABLE `geraete` (
    `id` INT(11) NOT NULL AUTO_INCREMENT , 
    `modell_id` INT NOT NULL ,
    `seriennummer` VARCHAR(254) NOT NULL , 
    `betreiber_id` INT(11) NOT NULL , 
    `rechnungsempfaenger_id` INT(11) NOT NULL ,
    `standort` VARCHAR(254) NOT NULL ,
    `kundenreferenznummer1` VARCHAR(254) NULL DEFAULT NULL , 
    `kundenreferenznummer2` VARCHAR(254) NULL DEFAULT NULL , 
    `installationsdatum` DATE NULL DEFAULT NULL , 
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;
*/