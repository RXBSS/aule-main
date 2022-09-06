-- Artikel Dokumente
CREATE TABLE `artikel_dokumente` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `artikel_id` VARCHAR(254) NULL DEFAULT NULL,
    `art_id` int(11) DEFAULT NULL,
    `bezeichnung` VARCHAR(254) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;