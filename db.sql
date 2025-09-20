-- phpMyAdmin SQL Dump-- Schéma complet pour l'application SolarSaaS

-- version 5.2.1-- Ce schéma est conçu pour une architecture multi-client (SaaS)

-- https://www.phpmyadmin.net/

--SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- Hôte : 127.0.0.1START TRANSACTION;

-- Généré le : sam. 20 juil. 2024 à 14:01SET time_zone = "+00:00";

-- Version du serveur : 10.4.32-MariaDB

-- Version de PHP : 8.2.12-- --------------------------------------------------------



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";--

START TRANSACTION;-- Struc--

SET time_zone = "+00:00";-- Constraints for table `notifications`

--

ALTER TABLE `notifications`

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;--

-- Table structure for table `inventory`

----

-- Base de données : `solarsaas_db`CREATE TABLE `inventory` (

--  `id` int(11) NOT NULL,

  `component_id` int(11) NOT NULL,

-- --------------------------------------------------------  `quantity` int(11) NOT NULL DEFAULT 0,

  `low_stock_threshold` int(11) NOT NULL DEFAULT 10,

--  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()

-- Structure de la table `audit_logs`) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

--

CREATE TABLE `audit_logs` (-- Indexes for dumped tables

  `id` int(11) NOT NULL,--

  `user_id` int(11) DEFAULT NULL,

  `action` varchar(255) NOT NULL,--

  `details` text DEFAULT NULL,-- Indexes for table `inventory`

  `ip_address` varchar(45) DEFAULT NULL,--

  `created_at` timestamp NOT NULL DEFAULT current_timestamp()ALTER TABLE `inventory`

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;  ADD PRIMARY KEY (`id`),

  ADD UNIQUE KEY `component_id` (`component_id`);

-- --------------------------------------------------------

--

---- AUTO_INCREMENT for dumped tables

-- Structure de la table `clients`--

--

--

CREATE TABLE `clients` (-- AUTO_INCREMENT for table `inventory`

  `id` int(11) NOT NULL,--

  `company_name` varchar(255) NOT NULL,ALTER TABLE `inventory`

  `contact_email` varchar(255) NOT NULL,  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  `created_at` timestamp NOT NULL DEFAULT current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;--

-- Constraints for dumped tables

----

-- Déchargement des données de la table `clients`

----

-- Constraints for table `inventory`

INSERT INTO `clients` (`id`, `company_name`, `contact_email`, `created_at`) VALUES--

(1, 'Default Company', 'contact@default.com', '2024-07-20 11:59:00');ALTER TABLE `inventory`

  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE;

-- --------------------------------------------------------

--

---- Table structure for table `project_files`

-- Structure de la table `components`--

--CREATE TABLE `project_files` (

  `id` int(11) NOT NULL,

CREATE TABLE `components` (  `project_id` int(11) NOT NULL,

  `id` int(11) NOT NULL,  `user_id` int(11) NOT NULL,

  `client_id` int(11) NOT NULL COMMENT 'Lié au client pour permettre des catalogues personnalisés',  `file_name` varchar(255) NOT NULL,

  `type` enum('panel','battery','inverter','controller') NOT NULL,  `file_path` varchar(255) NOT NULL,

  `brand` varchar(255) NOT NULL,  `file_type` varchar(100) NOT NULL,

  `model` varchar(255) NOT NULL,  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()

  `specs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Caractéristiques techniques en JSON (ex: { "power": 375, "voltage": 36.5 } pour un panneau)' CHECK (json_valid(`specs`)),) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  `price` decimal(10,2) DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;--

-- Indexes for table `project_files`

-- ----------------------------------------------------------

ALTER TABLE `project_files`

--  ADD PRIMARY KEY (`id`),

-- Structure de la table `inventory`  ADD KEY `project_id` (`project_id`),

--  ADD KEY `user_id` (`user_id`);



CREATE TABLE `inventory` (--

  `id` int(11) NOT NULL,-- AUTO_INCREMENT for table `project_files`

  `component_id` int(11) NOT NULL,--

  `quantity` int(11) NOT NULL DEFAULT 0,ALTER TABLE `project_files`

  `low_stock_threshold` int(11) NOT NULL DEFAULT 10,  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;--

-- Constraints for table `project_files`

-- ----------------------------------------------------------

ALTER TABLE `project_files`

--  ADD CONSTRAINT `project_files_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,

-- Structure de la table `maintenance_tasks`  ADD CONSTRAINT `project_files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--

--

CREATE TABLE `maintenance_tasks` (-- Table structure for table `audit_logs`

  `id` int(11) NOT NULL,--

  `project_id` int(11) NOT NULL,CREATE TABLE `audit_logs` (

  `task_description` text NOT NULL,  `id` int(11) NOT NULL,

  `due_date` date NOT NULL,  `user_id` int(11) DEFAULT NULL,

  `status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending',  `action` varchar(255) NOT NULL,

  `completed_at` timestamp NULL DEFAULT NULL,  `details` text DEFAULT NULL,

  `created_at` timestamp NOT NULL DEFAULT current_timestamp()  `ip_address` varchar(45) DEFAULT NULL,

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;  `created_at` timestamp NOT NULL DEFAULT current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--

---- Indexes for table `audit_logs`

-- Structure de la table `notifications`--

--ALTER TABLE `audit_logs`

  ADD PRIMARY KEY (`id`),

CREATE TABLE `notifications` (  ADD KEY `user_id` (`user_id`);

  `id` int(11) NOT NULL,

  `user_id` int(11) NOT NULL,--

  `client_id` int(11) NOT NULL,-- AUTO_INCREMENT for table `audit_logs`

  `message` text NOT NULL,--

  `is_read` tinyint(1) NOT NULL DEFAULT 0,ALTER TABLE `audit_logs`

  `link` varchar(255) DEFAULT NULL,  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  `created_at` timestamp NOT NULL DEFAULT current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;--

-- Constraints for table `audit_logs`

-- ----------------------------------------------------------

ALTER TABLE `audit_logs`

--  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Structure de la table `permissions`

---- Add 2FA columns to users table

ALTER TABLE `users`

CREATE TABLE `permissions` (ADD `google2fa_secret` TEXT DEFAULT NULL,

  `id` int(11) NOT NULL,ADD `google2fa_enabled` TINYINT(1) NOT NULL DEFAULT 0;

  `name` varchar(255) NOT NULL COMMENT 'e.g., manage_users, view_projects',COMMIT;

  `description` text DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

--/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Déchargement des données de la table `permissions`able `clients`

---- Chaque client représente une entreprise ou une entité qui s'abonne au service.

--

INSERT INTO `permissions` (`id`, `name`, `description`) VALUESCREATE TABLE `clients` (

(1, 'manage_users', 'Can create, update, and delete users.'),  `id` INT AUTO_INCREMENT PRIMARY KEY,

(2, 'manage_projects', 'Can create, update, and delete projects.'),  `company_name` VARCHAR(255) NOT NULL,

(3, 'view_projects', 'Can view projects.'),  `contact_email` VARCHAR(255) NOT NULL UNIQUE,

(4, 'manage_components', 'Can manage the material catalog.'),  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP

(5, 'manage_settings', 'Can manage client-level settings.'),) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

(6, 'manage_company_profile', 'Can manage the company profile.'),

(7, 'manage_maintenance', 'Can manage maintenance schedules.'),-- --------------------------------------------------------

(8, 'view_dashboard_analytics', 'Can view dashboard analytics.');

--

-- ---------------------------------------------------------- Structure de la table `subscriptions`

-- Gère les abonnements pour chaque client.

----

-- Structure de la table `projects`CREATE TABLE `subscriptions` (

--  `id` INT AUTO_INCREMENT PRIMARY KEY,

  `client_id` INT NOT NULL,

CREATE TABLE `projects` (  `plan_name` VARCHAR(100) NOT NULL, -- Ex: '1 Utilisateur', '5 Utilisateurs'

  `id` int(11) NOT NULL,  `max_users` INT NOT NULL DEFAULT 1,

  `user_id` int(11) NOT NULL,  `start_date` DATE NOT NULL,

  `client_id` int(11) NOT NULL,  `end_date` DATE NOT NULL,

  `region_id` int(11) NOT NULL,  `status` ENUM('active', 'expired', 'cancelled') NOT NULL DEFAULT 'active',

  `project_name` varchar(255) NOT NULL,  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  `customer_name` varchar(255) NOT NULL,  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE

  `total_daily_consumption` decimal(10,2) DEFAULT 0.00 COMMENT 'en Wh/jour',) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  `status` varchar(50) NOT NULL DEFAULT 'Planning' COMMENT 'Ex: Planning, In Progress, Completed, Cancelled',

  `created_at` timestamp NOT NULL DEFAULT current_timestamp()-- --------------------------------------------------------

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- ---------------------------------------------------------- Structure de la table `roles`

--

--CREATE TABLE `roles` (

-- Structure de la table `project_appliances`  `id` INT AUTO_INCREMENT PRIMARY KEY,

--  `name` VARCHAR(50) NOT NULL UNIQUE,

  `description` TEXT

CREATE TABLE `project_appliances` () ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  `id` int(11) NOT NULL,

  `project_id` int(11) NOT NULL,--

  `name` varchar(255) NOT NULL,-- Données de base pour les rôles

  `power` decimal(10,2) NOT NULL COMMENT 'Puissance en Watts',--

  `quantity` int(11) NOT NULL,INSERT INTO `roles` (`id`, `name`, `description`) VALUES

  `daily_usage_hours` decimal(4,2) NOT NULL,(1, 'Admin', 'Full access to all features, including user management and settings.'),

  `daily_consumption` decimal(10,2) GENERATED ALWAYS AS (`power` * `quantity` * `daily_usage_hours`) STORED(2, 'Project Manager', 'Can manage projects and teams, but not client-level settings.'),

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;(3, 'Technician', 'Can only view assigned projects and update maintenance tasks.');



-- ---------------------------------------------------------- --------------------------------------------------------



----

-- Structure de la table `project_files`-- Structure de la table `permissions`

----

CREATE TABLE `permissions` (

CREATE TABLE `project_files` (  `id` INT AUTO_INCREMENT PRIMARY KEY,

  `id` int(11) NOT NULL,  `name` VARCHAR(255) NOT NULL UNIQUE COMMENT 'e.g., manage_users, view_projects',

  `project_id` int(11) NOT NULL,  `description` TEXT

  `user_id` int(11) NOT NULL,) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  `file_name` varchar(255) NOT NULL,

  `file_path` varchar(255) NOT NULL,--

  `file_type` varchar(100) NOT NULL,-- Données de base pour les permissions

  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()--

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;INSERT INTO `permissions` (`id`, `name`, `description`) VALUES

(1, 'manage_users', 'Can create, update, and delete users.'),

-- --------------------------------------------------------(2, 'manage_projects', 'Can create, update, and delete projects.'),

(3, 'view_projects', 'Can view projects.'),

--(4, 'manage_components', 'Can manage the material catalog.'),

-- Structure de la table `regions`(5, 'manage_settings', 'Can manage client-level settings.'),

--(6, 'manage_company_profile', 'Can manage the company profile.'),

(7, 'manage_maintenance', 'Can manage maintenance schedules.'),

CREATE TABLE `regions` ((8, 'view_dashboard_analytics', 'Can view dashboard analytics.');

  `id` int(11) NOT NULL,

  `name` varchar(255) NOT NULL,-- --------------------------------------------------------

  `latitude` decimal(10,8) NOT NULL,

  `longitude` decimal(11,8) NOT NULL,--

  `psh` decimal(5,2) NOT NULL COMMENT 'Rayonnement solaire moyen journalier (kWh/m²/jour)',-- Structure de la table `role_permissions`

  `optimal_angle` decimal(4,2) NOT NULL--

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;CREATE TABLE `role_permissions` (

  `role_id` INT NOT NULL,

--  `permission_id` INT NOT NULL,

-- Déchargement des données de la table `regions`  PRIMARY KEY (`role_id`, `permission_id`),

--  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,

  FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE

INSERT INTO `regions` (`id`, `name`, `latitude`, `longitude`, `psh`, `optimal_angle`) VALUES) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

(1, 'Alger (Alger)', 36.77638900, 3.05861100, 4.80, 32.00),

(2, 'Tamanrasset (Tamanrasset)', 22.78500000, 5.52277800, 6.50, 20.00),--

(3, 'Oran (Oran)', 35.69694400, -0.63305600, 5.10, 31.00),-- Données de base pour les permissions des rôles

(4, 'Constantine (Constantine)', 36.36500000, 6.61472200, 4.90, 33.00),--

(5, 'Ghardaïa (Ghardaïa)', 32.48333300, 3.66666700, 5.90, 28.00);-- Admin (role_id = 1)

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES

-- --------------------------------------------------------(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8);



---- Project Manager (role_id = 2)

-- Structure de la table `roles`INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES

--(2, 2), (2, 3), (2, 7), (2, 8);



CREATE TABLE `roles` (-- Technician (role_id = 3)

  `id` int(11) NOT NULL,INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES

  `name` varchar(50) NOT NULL,(3, 3), (3, 7);

  `description` text DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;-- --------------------------------------------------------



----

-- Déchargement des données de la table `roles`-- Structure de la table `users`

---- Les utilisateurs sont liés à un client. L'email est unique globalement.

--

INSERT INTO `roles` (`id`, `name`, `description`) VALUESCREATE TABLE `users` (

(1, 'Admin', 'Full access to all features, including user management and settings.'),  `id` INT AUTO_INCREMENT PRIMARY KEY,

(2, 'Project Manager', 'Can manage projects and teams, but not client-level settings.'),  `client_id` INT NOT NULL,

(3, 'Technician', 'Can only view assigned projects and update maintenance tasks.');  `role_id` INT NOT NULL DEFAULT 2,

  `name` VARCHAR(255) NOT NULL,

-- --------------------------------------------------------  `email` VARCHAR(255) NOT NULL UNIQUE,

  `password` VARCHAR(255) NOT NULL,

--  `last_login` TIMESTAMP NULL,

-- Structure de la table `role_permissions`  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

--  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE,

  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`)

CREATE TABLE `role_permissions` () ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  `role_id` int(11) NOT NULL,

  `permission_id` int(11) NOT NULL-- --------------------------------------------------------

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

---- Structure de la table `regions`

-- Déchargement des données de la table `role_permissions`-- Contient les données solaires prédéfinies pour chaque région.

----

CREATE TABLE `regions` (

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES  `id` INT AUTO_INCREMENT PRIMARY KEY,

(1, 1),  `name` VARCHAR(255) NOT NULL,

(1, 2),  `latitude` DECIMAL(10, 8) NOT NULL,

(1, 3),  `longitude` DECIMAL(11, 8) NOT NULL,

(1, 4),  `psh` DECIMAL(5, 2) NOT NULL COMMENT 'Rayonnement solaire moyen journalier (kWh/m²/jour)',

(1, 5),  `optimal_angle` DECIMAL(4, 2) NOT NULL

(1, 6),) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

(1, 7),

(1, 8),--

(2, 2),-- Données de base pour les régions

(2, 3),--

(2, 7),INSERT INTO `regions` (`id`, `name`, `latitude`, `longitude`, `psh`, `optimal_angle`) VALUES

(2, 8),(1, 'Alger (Alger)', 36.776389, 3.058611, 4.80, 32.00),

(3, 3),(2, 'Tamanrasset (Tamanrasset)', 22.785000, 5.522778, 6.50, 20.00),

(3, 7);(3, 'Oran (Oran)', 35.696944, -0.633056, 5.10, 31.00),

(4, 'Constantine (Constantine)', 36.365000, 6.614722, 4.90, 33.00),

-- --------------------------------------------------------(5, 'Ghardaïa (Ghardaïa)', 32.483333, 3.666667, 5.90, 28.00);



---- --------------------------------------------------------

-- Structure de la table `settings`

----

-- Structure de la table `projects`

CREATE TABLE `settings` (-- Chaque projet est lié à un utilisateur et donc à un client.

  `id` int(11) NOT NULL,--

  `client_id` int(11) NOT NULL,CREATE TABLE `projects` (

  `battery_dod` decimal(5,2) NOT NULL DEFAULT 0.50 COMMENT 'Profondeur de décharge par défaut',  `id` INT AUTO_INCREMENT PRIMARY KEY,

  `system_loss_factor` decimal(5,2) NOT NULL DEFAULT 0.77 COMMENT 'Facteur de pertes système',  `user_id` INT NOT NULL,

  `days_of_autonomy` int(11) NOT NULL DEFAULT 2  `client_id` INT NOT NULL,

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;  `region_id` INT NOT NULL,

  `project_name` VARCHAR(255) NOT NULL,

--  `customer_name` VARCHAR(255) NOT NULL,

-- Déchargement des données de la table `settings`  `total_daily_consumption` DECIMAL(10, 2) DEFAULT 0.00 COMMENT 'en Wh/jour',

--  `status` VARCHAR(50) NOT NULL DEFAULT 'Planning' COMMENT 'Ex: Planning, In Progress, Completed, Cancelled',

  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

INSERT INTO `settings` (`id`, `client_id`, `battery_dod`, `system_loss_factor`, `days_of_autonomy`) VALUES  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,

(1, 1, 0.50, 0.77, 2);  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE,

  FOREIGN KEY (`region_id`) REFERENCES `regions`(`id`)

-- --------------------------------------------------------) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



---- --------------------------------------------------------

-- Structure de la table `subscriptions`

----

-- Structure de la table `project_appliances`

CREATE TABLE `subscriptions` (-- Liste des appareils électriques pour chaque projet.

  `id` int(11) NOT NULL,--

  `client_id` int(11) NOT NULL,CREATE TABLE `project_appliances` (

  `plan_name` varchar(100) NOT NULL,  `id` INT AUTO_INCREMENT PRIMARY KEY,

  `max_users` int(11) NOT NULL DEFAULT 1,  `project_id` INT NOT NULL,

  `start_date` date NOT NULL,  `name` VARCHAR(255) NOT NULL,

  `end_date` date NOT NULL,  `power` DECIMAL(10, 2) NOT NULL COMMENT 'Puissance en Watts',

  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',  `quantity` INT NOT NULL,

  `created_at` timestamp NOT NULL DEFAULT current_timestamp()  `daily_usage_hours` DECIMAL(4, 2) NOT NULL,

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;  `daily_consumption` DECIMAL(10, 2) GENERATED ALWAYS AS (`power` * `quantity` * `daily_usage_hours`) STORED,

  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE

--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Déchargement des données de la table `subscriptions`

---- --------------------------------------------------------



INSERT INTO `subscriptions` (`id`, `client_id`, `plan_name`, `max_users`, `start_date`, `end_date`, `status`, `created_at`) VALUES--

(1, 1, 'Admin Plan', 99, '2024-07-20', '2034-07-20', 'active', '2024-07-20 11:59:00');-- Structure de la table `components`

-- Catalogue des matériaux (panneaux, batteries, etc.).

-- ----------------------------------------------------------

CREATE TABLE `components` (

--  `id` INT AUTO_INCREMENT PRIMARY KEY,

-- Structure de la table `users`  `client_id` INT NOT NULL COMMENT 'Lié au client pour permettre des catalogues personnalisés',

--  `type` ENUM('panel', 'battery', 'inverter', 'controller') NOT NULL,

  `brand` VARCHAR(255) NOT NULL,

CREATE TABLE `users` (  `model` VARCHAR(255) NOT NULL,

  `id` int(11) NOT NULL,  `specs` JSON NOT NULL COMMENT 'Caractéristiques techniques en JSON (ex: { "power": 375, "voltage": 36.5 } pour un panneau)',

  `client_id` int(11) NOT NULL,  `price` DECIMAL(10, 2),

  `role_id` int(11) NOT NULL DEFAULT 2,  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE

  `name` varchar(255) NOT NULL,) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  `email` varchar(255) NOT NULL,

  `password` varchar(255) NOT NULL,-- --------------------------------------------------------

  `last_login` timestamp NULL DEFAULT NULL,

  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),--

  `google2fa_secret` text DEFAULT NULL,-- Structure de la table `settings`

  `google2fa_enabled` tinyint(1) NOT NULL DEFAULT 0-- Paramètres par défaut pour les calculs, spécifiques à chaque client.

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;--

CREATE TABLE `settings` (

--  `id` INT AUTO_INCREMENT PRIMARY KEY,

-- Déchargement des données de la table `users`  `client_id` INT NOT NULL UNIQUE,

--  `battery_dod` DECIMAL(5, 2) NOT NULL DEFAULT 0.50 COMMENT 'Profondeur de décharge par défaut',

  `system_loss_factor` DECIMAL(5, 2) NOT NULL DEFAULT 0.77 COMMENT 'Facteur de pertes système',

INSERT INTO `users` (`id`, `client_id`, `role_id`, `name`, `email`, `password`, `last_login`, `created_at`, `google2fa_secret`, `google2fa_enabled`) VALUES  `days_of_autonomy` INT NOT NULL DEFAULT 2,

(1, 1, 1, 'Admin', 'admin@solarsaas.com', '$2y$10$g0rA1FvF.1iS.F8v.2iS.O3t.1iS.F8v.2iS.O3t.1iS.F8v.2iS.O', NULL, '2024-07-20 11:59:00', NULL, 0);  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--

-- Index pour les tables déchargées-- --------------------------------------------------------

--

--

---- Structure de la table `maintenance_tasks`

-- Index pour la table `audit_logs`-- Gère les tâches de maintenance pour chaque projet.

----

ALTER TABLE `audit_logs`CREATE TABLE `maintenance_tasks` (

  ADD PRIMARY KEY (`id`),  `id` INT AUTO_INCREMENT PRIMARY KEY,

  ADD KEY `user_id` (`user_id`);  `project_id` INT NOT NULL,

  `task_description` TEXT NOT NULL,

--  `due_date` DATE NOT NULL,

-- Index pour la table `clients`  `status` ENUM('Pending', 'Completed') NOT NULL DEFAULT 'Pending',

--  `completed_at` TIMESTAMP NULL,

ALTER TABLE `clients`  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  ADD PRIMARY KEY (`id`),  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE

  ADD UNIQUE KEY `contact_email` (`contact_email`);) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



---- --------------------------------------------------------

-- Index pour la table `components`

----

ALTER TABLE `components`-- Structure de la table `notifications`

  ADD PRIMARY KEY (`id`),--

  ADD KEY `client_id` (`client_id`);CREATE TABLE `notifications` (

  `id` int(11) NOT NULL,

--  `user_id` int(11) NOT NULL,

-- Index pour la table `inventory`  `client_id` int(11) NOT NULL,

--  `message` text NOT NULL,

ALTER TABLE `inventory`  `is_read` tinyint(1) NOT NULL DEFAULT 0,

  ADD PRIMARY KEY (`id`),  `link` varchar(255) DEFAULT NULL,

  ADD UNIQUE KEY `component_id` (`component_id`);  `created_at` timestamp NOT NULL DEFAULT current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- Index pour la table `maintenance_tasks`--

---- Indexes for dumped tables

ALTER TABLE `maintenance_tasks`--

  ADD PRIMARY KEY (`id`),

  ADD KEY `project_id` (`project_id`);--

-- Indexes for table `notifications`

----

-- Index pour la table `notifications`ALTER TABLE `notifications`

--  ADD PRIMARY KEY (`id`),

ALTER TABLE `notifications`  ADD KEY `user_id` (`user_id`),

  ADD PRIMARY KEY (`id`),  ADD KEY `client_id` (`client_id`);

  ADD KEY `user_id` (`user_id`),

  ADD KEY `client_id` (`client_id`);--

-- AUTO_INCREMENT for dumped tables

----

-- Index pour la table `permissions`

----

ALTER TABLE `permissions`-- AUTO_INCREMENT for table `notifications`

  ADD PRIMARY KEY (`id`),--

  ADD UNIQUE KEY `name` (`name`);ALTER TABLE `notifications`

  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--

-- Index pour la table `projects`--

---- Constraints for dumped tables

ALTER TABLE `projects`--

  ADD PRIMARY KEY (`id`),

  ADD KEY `user_id` (`user_id`),--

  ADD KEY `client_id` (`client_id`),-- Constraints for table `notifications`

  ADD KEY `region_id` (`region_id`);--

ALTER TABLE `notifications`

--  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,

-- Index pour la table `project_appliances`  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--COMMIT;

ALTER TABLE `project_appliances`

  ADD PRIMARY KEY (`id`),/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

  ADD KEY `project_id` (`project_id`);/*!40101 SET_CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--

-- Index pour la table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_id` (`client_id`);

--
-- Index pour la table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `maintenance_tasks`
--
ALTER TABLE `maintenance_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `project_appliances`
--
ALTER TABLE `project_appliances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `components`
--
ALTER TABLE `components`
  ADD CONSTRAINT `components_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `maintenance_tasks`
--
ALTER TABLE `maintenance_tasks`
  ADD CONSTRAINT `maintenance_tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_ibfk_3` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);

--
-- Contraintes pour la table `project_appliances`
--
ALTER TABLE `project_appliances`
  ADD CONSTRAINT `project_appliances_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `project_files`
--
ALTER TABLE `project_files`
  ADD CONSTRAINT `project_files_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Structure de la table `invoices`
--
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `paid_date` date DEFAULT NULL,
  `status` enum('draft','sent','paid','overdue','void') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_number` (`invoice_number`),
  KEY `client_id` (`client_id`),
  KEY `subscription_id` (`subscription_id`),
  CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Structure de la table `invoice_items`
--
CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Structure de la table `payments`
--
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('succeeded','pending','failed') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id` (`transaction_id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;