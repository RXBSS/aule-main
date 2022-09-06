CREATE TABLE `_todos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `zeitstempel` datetime DEFAULT NULL,
    `icon` varchar(254) NOT NULL,
    `titel` varchar(254) NOT NULL,
    `text` text DEFAULT NULL,
    `action` varchar(254) DEFAULT NULL,
    `gelesen` int(11) NOT NULL DEFAULT 0,
    `gelesen_zeitstempel` datetime DEFAULT NULL,
    `erledigt` int(11) NOT NULL DEFAULT 0,
    `erledigt_zeitstempel` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;