-- Artikelgruppe
CREATE TABLE `artikel_gruppen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bezeichnung` VARCHAR(254) NULL DEFAULT NULL,
    `zuordnung_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Data
INSERT INTO
    `artikel_gruppen` (`id`, `bezeichnung`, `zuordnung_id`)
VALUES
    (1, 'Toner', 2),
    (2, 'Tinte', 2),
    (3, 'Einzugsrolle', 2),
    (4, 'Heizung', 2),
    (5, 'Transferband/Roller', 2);
