CREATE TABLE `akquise_meilenstein` (
    `id` INT NOT NULL AUTO_INCREMENT , 
    `reihenfolge` int(11) NOT NULL,
    `text` varchar(254) DEFAULT NULL,
    `aktion_id` int(11) DEFAULT NULL COMMENT 'Akquise Aktion ID',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
