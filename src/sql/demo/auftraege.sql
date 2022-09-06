INSERT INTO
    `auftraege` (
        `id`,
        `status_id`,
        `lieferanschrift_id`,
        `rechnungsanschrift_id`,
        `ersteller_id`,
        `erstellt_datum`,
        `bearbeiter_id`,
        `angebot_id`,
        `besteller_id`,
        `herkunft`,
        `referenz`,
        `liefertermin`,
        `kostenstelle_id`,
        `zahlungsbedingung_id`,
        `auslieferung_id`,
        `teillieferung`
    )
VALUES
    (
        300000,
        1,
        2,
        2,
        1,
        '2021-10-23 21:39:48',
        1,
        NULL,
        0,
        'E-Mail',
        'EB-123456',
        '2021-12-10',
        2000,
        1,
        0,
        0
    ),
    (
        300001,
        2,
        4,
        4,
        1,
        '2021-11-23 11:37:44',
        0,
        NULL,
        0,
        'Telefon',
        '123456',
        NULL,
        1000,
        2,
        1,
        0
    ),
    (
        300002,
        2,
        8,
        8,
        1,
        '2021-11-23 13:11:40',
        0,
        NULL,
        0,
        'E-Mail',
        '987654321',
        NULL,
        1000,
        NULL,
        2,
        0
    ),
    (
        300003,
        2,
        1,
        1,
        1,
        '2021-11-23 13:12:39',
        0,
        NULL,
        0,
        'Website',
        NULL,
        NULL,
        1000,
        4,
        3,
        0
    ),
    (
        300004,
        2,
        7,
        7,
        1,
        '2021-11-23 13:13:39',
        0,
        NULL,
        0,
        'E-Mail',
        '12344',
        NULL,
        1000,
        4,
        4,
        0
    ),
    (
        300005,
        4,
        3,
        3,
        1,
        '2021-11-23 16:59:31',
        0,
        NULL,
        0,
        'Telefon',
        'ABAB',
        '2021-12-01',
        3000,
        NULL,
        0,
        0
    );

ALTER TABLE
    `auftraege` AUTO_INCREMENT = 300006;