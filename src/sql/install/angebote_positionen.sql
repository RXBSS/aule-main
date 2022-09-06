--- Tabelle
CREATE TABLE `angebote_positionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `reihenfolge` int(11) DEFAULT NULL,
    `angebot_id` int(11) DEFAULT NULL,
    `artikel_id` int(11) DEFAULT NULL,
    `menge` decimal(18, 6) NOT NULL DEFAULT '0',
    `liefern` decimal(18, 6) NOT NULL DEFAULT '0',
    `bestellen` decimal(18, 6) NOT NULL DEFAULT '0',
    `ek` decimal(18, 6) NOT NULL DEFAULT '0',
    `vk` decimal(18, 6) NOT NULL DEFAULT '0',
    `steuer` decimal(18, 1) NOT NULL DEFAULT '0',
    `rabatt_wert` decimal(18, 6) NOT NULL DEFAULT '0',
    `langtext` TEXT DEFAULT NULL,
    `notiz` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german2_ci ROW_FORMAT = DYNAMIC;


CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `angebote_positionen_v` AS
SELECT
    `id` AS `id`,
    `reihenfolge` AS `reihenfolge`,
    `angebot_id` AS `angebot_id`,
    `artikel_id` AS `artikel_id`,
    `menge` AS `menge`,
    `liefern` AS `liefern`,
    `bestellen` AS `bestellen`,
    `ek` AS `ek`,
    `ek` * `menge` AS `ek_gesamt`,
    `vk` AS `vk`,
    `vk` - `rabatt_wert` AS `vk_inkl_rabatt`,
    `rabatt_wert` AS `rabatt_wert`,
    `rabatt_wert` * `menge` AS `rabatt_wert_gesamt`,
    `rabatt_wert` * 100 / `vk` AS `rabatt_prozent`,
    `menge` * `vk` AS `netto_gesamt`,
    `menge` * (`vk` - `rabatt_wert`) AS `netto_inkl_rabatt_gesamt`,
    `steuer` AS `steuer`,
    (`vk` - `rabatt_wert`) * (`steuer` / 100) AS `steuer_wert`,
    (`vk` - `rabatt_wert`) * `menge` * (`steuer` / 100) AS `steuer_wert_gesamt`,
    (`vk` - `rabatt_wert`) * (`steuer` / 100 + 1) AS `brutto`,
    (`vk` - `rabatt_wert`) * `menge` * (`steuer` / 100 + 1) AS `brutto_gesamt`,
    `vk` - `ek` AS `marge`,
    (`vk` - `ek`) * `menge` AS `marge_gesamt`,
    ((`vk` * 100) / `ek`) - 100 AS `marge_prozent`,
    `vk` - `rabatt_wert` - `ek` AS `marge_inkl_rabatt`,
    (`vk` - `rabatt_wert` - `ek`) * `menge`  AS `marge_inkl_rabatt_gesamt`,
    (((`vk` - `rabatt_wert`) * 100) / `ek`) - 100 AS `marge_inkl_rabatt_prozent`,
    `langtext` AS `langtext`,
    `notiz` AS `notiz`
FROM
    `angebote_positionen`;