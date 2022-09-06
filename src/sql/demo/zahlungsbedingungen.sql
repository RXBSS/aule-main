INSERT INTO
    `zahlungsbedingungen` (
        `id`,
        `bezeichnung`,
        `text`,
        `abbuchung`,
        `tage`,
        `skonto_prozent`,
        `skonto_tage`
    )
VALUES
    (
        1,
        'Direkt Fällig',
        'Das Zahldatum entspricht dem Rechnungsdatum. Der Betrag ist sofort fällig.',
        0,
        0,
        NULL,
        NULL
    ),
    (
        2,
        '30 Tage Netto',
        'Der Betrag ist 30 Tage nach Rechnungsdatum fällig.',
        0,
        30,
        NULL,
        NULL
    ),
    (
        3,
        'Wird abgebucht',
        'Der Betrag wird von Ihrem Konto abgebucht.',
        1,
        30,
        0,
        0
    ),
    (
        4,
        '30 Tage, 14 Tage 2% Skonto',
        'Der Betrag ist 30 Tage nach Rechnungsdatum fällig.',
        0,
        30,
        2,
        14
    );

ALTER TABLE
    `zahlungsbedingungen` AUTO_INCREMENT = 5;