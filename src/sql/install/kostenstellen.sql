CREATE TABLE `kostenstellen` (
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `bezeichnung` VARCHAR(254) NULL DEFAULT NULL,
    `verkaeufe`  INT(1) NOT NULL DEFAULT 0,
    `einkaeufe` INT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;