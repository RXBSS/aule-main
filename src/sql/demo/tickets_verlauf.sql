-- INSERT INTO
--     `tickets_verlauf` (
--         `ticket_id`,
--         `art`,
--         `event`,
--         `person_id`,
--         `text`,
--         `status`,
--         `status_vorher`,
--         `zeitstempel`
--     )
-- VALUES
--     (
--         30,
--         'beitrag',
--         'erstellt',
--         '5526',
--         '<p>Test Text oben</p><p><img style=\"width: 50%;\" src=\"&lt;%url%&gt;20210528-160745-680237892105485_inline_image_001.png\" data-filename=\"in_elo.png\"><img style=\"width: 605px;\" src=\"&lt;%url%&gt;20210528-160745-680237892105485_inline_image_002.jpeg\" data-filename=\"temp1.jpg\"></p><p>Test Text unten</p>',
--         1,
--         NULL,
--         '2021-05-28 16:07:45'
--     ),
--     (
--         31,
--         'beitrag',
--         'erstellt',
--         '5527',
--         '<p>Test Text oben</p><p><img style=\"width: 50%;\" src=\"&lt;%url%&gt;20210609-103949-1697362600405460_inline_image_001.png\" data-filename=\"in_elo.png\"><img style=\"width: 605px;\" src=\"&lt;%url%&gt;20210609-103949-1697362600405460_inline_image_002.jpeg\" data-filename=\"temp1.jpg\"></p><p>Test Text unten</p>',
--         1,
--         NULL,
--         '2021-06-09 10:39:49'
--     ),
--     (
--         32,
--         'beitrag',
--         'erstellt',
--         '5528',
--         '<p>Test Text oben</p><p><img style=\"width: 50%;\" src=\"&lt;%url%&gt;20210623-083708-2899601089051221_inline_image_001.png\" data-filename=\"in_elo.png\"><img style=\"width: 605px;\" src=\"&lt;%url%&gt;20210623-083708-2899601089051221_inline_image_002.jpeg\" data-filename=\"temp1.jpg\"></p><p>Test Text unten</p>',
--         1,
--         NULL,
--         '2021-06-23 08:37:08'
--     );


INSERT INTO `tickets_verlauf` (`id`, `ticket_id`, `art`, `event`, `person_id`, `text`, `status`, `status_vorher`, `zeitstempel`) VALUES
(1, 3, 'beitrag', 'erstellt', '11', '<p>Test Text oben</p><p>Test Text unten</p>', 1, NULL, '2021-05-28 16:07:45'),
(2, 3, 'beitrag', 'erstellt', '11', '<p>Test Text oben</p><p>Test Text unten</p>', 1, NULL, '2021-06-09 10:39:49'),
(3, 3, 'beitrag', 'erstellt', '11', '<p>Test Text oben</p><p>Test Text unten</p>', 1, NULL, '2021-06-23 08:37:08');
