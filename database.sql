-- Contenu complet et commenté du fichier database.sql
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `maintenance_tasks`, `project_components`, `settings`, `components`, `project_appliances`, `projects`, `regions`, `users`, `subscriptions`, `clients`;

-- Chaque client (entreprise) est une entité séparée. C'est la table racine pour l'isolation des données.
CREATE TABLE `clients` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `company_name` VARCHAR(255) NOT NULL,
  `contact_email` VARCHAR(255) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Gère le plan d'abonnement pour chaque client, notamment la limite d'utilisateurs.
CREATE TABLE `subscriptions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT NOT NULL,
  `plan_name` VARCHAR(100) NOT NULL,
  `max_users` INT NOT NULL DEFAULT 1,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `status` ENUM('active', 'expired', 'cancelled') NOT NULL DEFAULT 'active',
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chaque utilisateur appartient à un client. Le rôle 'admin' peut gérer les autres utilisateurs du même client.
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données géographiques pour les calculs de rayonnement.
CREATE TABLE `regions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `psh` DECIMAL(5, 2) NOT NULL COMMENT 'Peak Sun Hours (kWh/m²/day)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Insérer les données des régions algériennes ici...
INSERT INTO `regions` (`id`, `name`, `psh`) VALUES
(1, 'Adrar', 6.50),
(2, 'Chlef', 5.20),
(3, 'Laghouat', 5.80),
(4, 'Oum El Bouaghi', 5.10),
(5, 'Batna', 5.30),
(6, 'Béjaïa', 4.90),
(7, 'Biskra', 6.00),
(8, 'Béchar', 6.30),
(9, 'Blida', 5.00),
(10, 'Bouira', 5.10),
(11, 'Tamanrasset', 6.80),
(12, 'Tébessa', 5.40),
(13, 'Tlemcen', 5.30),
(14, 'Tiaret', 5.50),
(15, 'Tizi Ouzou', 5.00),
(16, 'Alger', 5.00),
(17, 'Djelfa', 5.70),
(18, 'Jijel', 4.80),
(19, 'Sétif', 5.20),
(20, 'Saïda', 5.60),
(21, 'Skikda', 4.90),
(22, 'Sidi Bel Abbès', 5.40),
(23, 'Annaba', 4.80),
(24, 'Guelma', 5.00),
(25, 'Constantine', 5.10),
(26, 'Médéa', 5.20),
(27, 'Mostaganem', 5.20),
(28, 'M''Sila', 5.60),
(29, 'Mascara', 5.40),
(30, 'Ouargla', 6.20),
(31, 'Oran', 5.30),
(32, 'El Bayadh', 5.90),
(33, 'Illizi', 6.70),
(34, 'Bordj Bou Arreridj', 5.30),
(35, 'Boumerdès', 5.00),
(36, 'El Tarf', 4.80),
(37, 'Tindouf', 6.60),
(38, 'Tissemsilt', 5.40),
(39, 'El Oued', 6.10),
(40, 'Khenchela', 5.50),
(41, 'Souk Ahras', 5.20),
(42, 'Tipaza', 5.00),
(43, 'Mila', 5.10),
(44, 'Aïn Defla', 5.20),
(45, 'Naâma', 5.80),
(46, 'Aïn Témouchent', 5.30),
(47, 'Ghardaïa', 6.00),
(48, 'Relizane', 5.30);


-- Chaque projet appartient à un client et a été créé par un utilisateur.
CREATE TABLE `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `client_id` INT NOT NULL,
  `region_id` INT NOT NULL,
  `project_name` VARCHAR(255) NOT NULL,
  `customer_name` VARCHAR(255) NOT NULL,
  `total_daily_consumption` DECIMAL(10, 2) DEFAULT 0.00,
  `total_price` DECIMAL(12, 2) DEFAULT 0.00,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`region_id`) REFERENCES `regions`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `project_appliances` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `power` DECIMAL(10, 2) NOT NULL,
  `quantity` INT NOT NULL,
  `daily_usage_hours` DECIMAL(4, 2) NOT NULL,
  `daily_consumption` DECIMAL(10, 2) GENERATED ALWAYS AS (`power` * `quantity` * `daily_usage_hours`) STORED,
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Le catalogue de matériel est propre à chaque client.
CREATE TABLE `components` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT NOT NULL,
  `type` ENUM('panel', 'battery', 'inverter', 'controller') NOT NULL,
  `brand` VARCHAR(255) NOT NULL,
  `model` VARCHAR(255) NOT NULL,
  `specs` JSON NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `project_components` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT NOT NULL,
  `component_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `unit_price` DECIMAL(10, 2) NOT NULL,
  `total_price` DECIMAL(12, 2) GENERATED ALWAYS AS (`quantity` * `unit_price`) STORED,
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`component_id`) REFERENCES `components`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `project_component` (`project_id`, `component_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Les paramètres de calcul sont aussi personnalisables par chaque client.
CREATE TABLE `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT NOT NULL UNIQUE,
  `battery_dod` DECIMAL(5, 2) NOT NULL DEFAULT 0.50,
  `system_loss_factor` DECIMAL(5, 2) NOT NULL DEFAULT 0.77,
  `days_of_autonomy` INT NOT NULL DEFAULT 2,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `maintenance_tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `component_type` ENUM('panel', 'battery', 'inverter', 'general') NOT NULL,
  `task_description` TEXT NOT NULL,
  `frequency` ENUM('monthly', 'quarterly', 'biannual', 'annual') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Insérer les tâches de maintenance ici...
INSERT INTO `maintenance_tasks` (`id`, `component_type`, `task_description`, `frequency`) VALUES
(1, 'panel', 'Nettoyer la surface des panneaux solaires pour enlever la poussière et les débris.', 'quarterly'),
(2, 'panel', 'Inspecter les panneaux pour détecter toute fissure, jaunissement ou dommage physique.', 'biannual'),
(3, 'battery', 'Vérifier le niveau d''électrolyte et compléter avec de l''eau distillée si nécessaire (batteries au plomb-acide).', 'monthly'),
(4, 'battery', 'Nettoyer les bornes des batteries pour éviter la corrosion.', 'quarterly'),
(5, 'battery', 'Vérifier la tension de chaque batterie pour s''assurer de leur bon équilibrage.', 'monthly'),
(6, 'inverter', 'Dépoussiérer les ventilateurs et les grilles de ventilation de l''onduleur.', 'quarterly'),
(7, 'inverter', 'Vérifier que les indicateurs LED de l''onduleur fonctionnent correctement.', 'monthly'),
(8, 'general', 'Inspecter le câblage et les connexions pour détecter tout signe d''usure ou de dommage.', 'annual'),
(9, 'general', 'Vérifier le bon fonctionnement du régulateur de charge.', 'biannual'),
(10, 'general', 'Serrer toutes les connexions électriques pour éviter les points chauds.', 'annual');


-- Triggers pour les calculs automatiques
DELIMITER $$
CREATE TRIGGER `after_appliance_insert` AFTER INSERT ON `project_appliances` FOR EACH ROW BEGIN UPDATE projects SET total_daily_consumption = (SELECT SUM(daily_consumption) FROM project_appliances WHERE project_id = NEW.project_id) WHERE id = NEW.project_id; END$$
CREATE TRIGGER `after_appliance_delete` AFTER DELETE ON `project_appliances` FOR EACH ROW BEGIN UPDATE projects SET total_daily_consumption = (SELECT IFNULL(SUM(daily_consumption), 0) FROM project_appliances WHERE project_id = OLD.project_id) WHERE id = OLD.project_id; END$$
CREATE TRIGGER `after_project_component_insert` AFTER INSERT ON `project_components` FOR EACH ROW BEGIN UPDATE projects SET total_price = (SELECT SUM(total_price) FROM project_components WHERE project_id = NEW.project_id) WHERE id = NEW.project_id; END$$
CREATE TRIGGER `after_project_component_delete` AFTER DELETE ON `project_components` FOR EACH ROW BEGIN UPDATE projects SET total_price = (SELECT IFNULL(SUM(total_price), 0) FROM project_components WHERE project_id = OLD.project_id) WHERE id = OLD.project_id; END$$
CREATE TRIGGER `after_project_component_update` AFTER UPDATE ON `project_components` FOR EACH ROW BEGIN UPDATE projects SET total_price = (SELECT IFNULL(SUM(total_price), 0) FROM project_components WHERE project_id = NEW.project_id) WHERE id = NEW.project_id; END$$
DELIMITER ;

COMMIT;
