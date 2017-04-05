--
-- Ajout de l'admin par défaut
--

INSERT INTO `person` (`id`, `last_name`, `first_name`, `birth_date`, `phone`, `street`, `zip`, `city`, `email`, `password`, `token`) VALUES
(1, 'Admin', 'Admin', NULL, NULL, NULL, NULL, NULL, 'asptt.imie@gmail.com', '$2y$12$2oz3PLuknd85m5HAoAeZeuvct7d5WSxVOhzDOkWxnR0wi68VlsQpi', NULL);

--
-- Ajout des roles
--

INSERT INTO `role` (`id`, `role_name`, `role_rights`) VALUES
(1, 'Manager', 'ROLE_MANAGER'),
(2, 'Admin', 'ROLE_ADMIN'),
(3, 'Joueur', 'ROLE_USER'),
(4, 'Parent\r\n', 'ROLE_USER'),
(5, 'Sponsor', 'ROLE_USER'),
(6, 'Entraîneur', 'ROLE_USER'),
(7, 'Président', 'ROLE_USER'),
(8, 'Trésorier', 'ROLE_USER'),
(10, 'Arbitre', 'ROLE_USER');

--
-- Ajout des droits admin au compte admin par défaut
--

INSERT INTO `roles_users` (`person_id`, `role_id`) VALUES
(1, 2);