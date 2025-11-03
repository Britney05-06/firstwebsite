INSERT INTO users(lastname, firstname, email, phone, picture)
VALUES('ANDRIANARIVELO', 'Alicia', 'alicia.andvl@gmail.com', '0669290459', 'alicia.jpg');

INSERT INTO users (lastname, firstname, email, phone, picture)
VALUES('WANKPO-SONON', 'Britney', 'britneywankpo06@gmail.com', '0780703114', 'britney.jpg');

INSERT INTO experiences(user_id, name, description, startdate, enddate)
VALUES
(1, 'Projet universitaire - Portfolio', 'Création d''un Portfolio en HTML et CSS', '2025-10-23', '2024-10-24');

INSERT INTO experiences(user_id, name, description, startdate, enddate)
VALUES
(2, 'Projet universitaire - CV numérique',
'Développement d''un CV numérique professionnel; utilisation de GitHub.',
'2024-01-01', '2024-04-01');

INSERT INTO educations(user_id, name, description, startdate, enddate)
VALUES
(1, 'Bachelor - EPITECH', 
'Première année à Epitech Lyon, centrée sur la logique algorithmique, la programmation en python, le développement web et l''apprentissage par projets.',
'2025-09-15', '2026-07-31'),
(1, 'Bac PRO Assistante architechte - Lycée Tony Garnier Bron',
'Un bac professionelle en architecture',
'2020-09-01', '2023-07-31');

INSERT INTO educations(user_id, name, description, startdate, enddate)
VALUES
(2, 'Licence Informatique - Aix-Marseille Université',
'Formation en algorithmique, programmation (Python, Java, C), développement web, et bases de données. Développement de projets académiques en équipe.',
'2023-09-09', '2025-10-30'),
(2, 'Bachelor 1 - Epitech Lyon',
'Première année à Epitech Lyon, centrée sur la logique algorithmique, la programmation en python, le développement web et l''apprentissage par projets.',
'2025-09-15', '2026-07-31');

INSERT INTO skills(user_id, name, level)
VALUES
(1, 'HTML/CSS', 'Débutante'),
(1, 'JavaScript', 'Débutante'),
(1, 'PHP', 'Débutante'),
(1, 'SQL/MySQL', 'Débutante'),
(1, 'Docker', 'Débutante'),
(1, 'Git/GitHub', 'Débutante');

INSERT INTO skills(user_id, name, level)
VALUES
(2, 'HTML/CSS', 'Intermédiaire'),
(2, 'JavaScript', 'Débutant'),
(2, 'PHP', 'Débutant'),
(2, 'SQL/MySQL', 'Intermédiaire'),
(2, 'Docker', 'Débutant'),
(2, 'Git/GitHub', 'Intermédiaire');