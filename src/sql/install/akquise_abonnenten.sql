CREATE TABLE `akquise_abonnenten` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `mitarbeiter_id` int(11) DEFAULT NULL,
    `akquise_id` int(11) DEFAULT NULL,
    `abonniert` int(11) NOT NULL DEFAULT 0,
     PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

