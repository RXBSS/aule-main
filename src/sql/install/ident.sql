CREATE TABLE `ident` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `haupt_id` int(11) DEFAULT NULL,
    `artikel_id` int(11) NOT NULL,
    `betreiber_id` INT(11) NOT NULL,
    `rechnungsempfaenger_id` INT(11) NOT NULL,
    `seriennummer` varchar(254) NOT NULL,
    `kunden_referenz` varchar(254) DEFAULT NULL,
    `standort` text DEFAULT NULL,
    `kunden_kostenstelle` varchar(254) DEFAULT NULL,
    `installationsdatum` DATE NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;