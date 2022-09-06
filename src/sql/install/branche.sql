CREATE TABLE `branche` (
    `id` INT(11) NOT NULL AUTO_INCREMENT , 
    `branche` VARCHAR(254) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `branche` (`branche`) VALUES
('Automobilindustrie'),
('Baugewerbe'),
('Bergbau'),
('Biotechnologie'),
('Chemische Stoffy'),
('Dienstleistungsbranche'),
('Elektrische Geräte'),
('Energieversorgung'),
('Energiewirtschaft'),
('Erziehung und Unterricht'),
('Finanz- und Versicherungsdienstleister'),
('Gesundheits- und Sozialwesen'),
('Grundstücks- und Wohnungswesen'),
('Handle'),
('Hotel und Gastronomie'),
('IT-Branche'),
('Kosmetika'),
('Kunst, Unterhaltung und Erholung'),
('Land- und Forstwirtschaft, Fischerei'),
('Lebensmittelindustrie'),
('Logistikbranche'),
('Luft- und Raumfahrt'),
('Medizintechnik'),
('Öffentliche Verwaltung'),
('Pharmabranche'),
('Schiffbau und Meerestechnik'),
('Spielzeucgbranche'),
('Telekommunikationsbranche'),
('Textil- und Bekleidungsbranche'),
('Verkehr und Lagerei'),
('Wasser, Abwasser und Entsorgung');