-- Schéma complet pour l'application SolarSaaS
-- Ce schéma est conçu pour une architecture multi-client (SaaS)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Struc--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Table structure for table `inventory`
--
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `low_stock_threshold` int(11) NOT NULL DEFAULT 10,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `component_id` (`component_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE CASCADE;

--
-- Table structure for table `project_files`
--
CREATE TABLE `project_files` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `project_files`
--
ALTER TABLE `project_files`
  ADD CONSTRAINT `project_files_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Table structure for table `audit_logs`
--
CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- Add 2FA columns to users table
ALTER TABLE `users`
ADD `google2fa_secret` TEXT DEFAULT NULL,
ADD `google2fa_enabled` TINYINT(1) NOT NULL DEFAULT 0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
able `clients`
-- Chaque client représente une entreprise ou une entité qui s'abonne au service.
--
CREATE TABLE `clients` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `company_name` VARCHAR(255) NOT NULL,
  `contact_email` VARCHAR(255) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `subscriptions`
-- Gère les abonnements pour chaque client.
--
CREATE TABLE `subscriptions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT NOT NULL,
  `plan_name` VARCHAR(100) NOT NULL, -- Ex: '1 Utilisateur', '5 Utilisateurs'
  `max_users` INT NOT NULL DEFAULT 1,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `status` ENUM('active', 'expired', 'cancelled') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--
CREATE TABLE `roles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Données de base pour les rôles
--
INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Full access to all features, including user management and settings.'),
(2, 'Project Manager', 'Can manage projects and teams, but not client-level settings.'),
(3, 'Technician', 'Can only view assigned projects and update maintenance tasks.');

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--
CREATE TABLE `permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL UNIQUE COMMENT 'e.g., manage_users, view_projects',
  `description` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Données de base pour les permissions
--
INSERT INTO `permissions` (`id`, `name`, `description`) VALUES
(1, 'manage_users', 'Can create, update, and delete users.'),
(2, 'manage_projects', 'Can create, update, and delete projects.'),
(3, 'view_projects', 'Can view projects.'),
(4, 'manage_components', 'Can manage the material catalog.'),
(5, 'manage_settings', 'Can manage client-level settings.'),
(6, 'manage_company_profile', 'Can manage the company profile.'),
(7, 'manage_maintenance', 'Can manage maintenance schedules.'),
(8, 'view_dashboard_analytics', 'Can view dashboard analytics.');

-- --------------------------------------------------------

--
-- Structure de la table `role_permissions`
--
CREATE TABLE `role_permissions` (
  `role_id` INT NOT NULL,
  `permission_id` INT NOT NULL,
  PRIMARY KEY (`role_id`, `permission_id`),
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Données de base pour les permissions des rôles
--
-- Admin (role_id = 1)
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8);

-- Project Manager (role_id = 2)
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(2, 2), (2, 3), (2, 7), (2, 8);

-- Technician (role_id = 3)
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(3, 3), (3, 7);

-- --------------------------------------------------------

--
-- Structure de la table `users`
-- Les utilisateurs sont liés à un client. L'email est unique globalement.
--
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT NOT NULL,
  `role_id` INT NOT NULL DEFAULT 2,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `last_login` TIMESTAMP NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `regions`
-- Contient les données solaires prédéfinies pour chaque région.
--
CREATE TABLE `regions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `latitude` DECIMAL(10, 8) NOT NULL,
  `longitude` DECIMAL(11, 8) NOT NULL,
  `psh` DECIMAL(5, 2) NOT NULL COMMENT 'Rayonnement solaire moyen journalier (kWh/m²/jour)',
  `optimal_angle` DECIMAL(4, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Données de base pour les régions
--
INSERT INTO `regions` (`id`, `name`, `latitude`, `longitude`, `psh`, `optimal_angle`) VALUES
(1, 'Alger (Alger)', 36.776389, 3.058611, 4.80, 32.00),
(2, 'Tamanrasset (Tamanrasset)', 22.785000, 5.522778, 6.50, 20.00),
(3, 'Oran (Oran)', 35.696944, -0.633056, 5.10, 31.00),
(4, 'Constantine (Constantine)', 36.365000, 6.614722, 4.90, 33.00),
(5, 'Ghardaïa (Ghardaïa)', 32.483333, 3.666667, 5.90, 28.00);

-- --------------------------------------------------------

--
-- Structure de la table `projects`
-- Chaque projet est lié à un utilisateur et donc à un client.
--
CREATE TABLE `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `client_id` INT NOT NULL,
  `region_id` INT NOT NULL,
  `project_name` VARCHAR(255) NOT NULL,
  `customer_name` VARCHAR(255) NOT NULL,
  `total_daily_consumption` DECIMAL(10, 2) DEFAULT 0.00 COMMENT 'en Wh/jour',
  `status` VARCHAR(50) NOT NULL DEFAULT 'Planning' COMMENT 'Ex: Planning, In Progress, Completed, Cancelled',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`region_id`) REFERENCES `regions`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `project_appliances`
-- Liste des appareils électriques pour chaque projet.
--
CREATE TABLE `project_appliances` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `power` DECIMAL(10, 2) NOT NULL COMMENT 'Puissance en Watts',
  `quantity` INT NOT NULL,
  `daily_usage_hours` DECIMAL(4, 2) NOT NULL,
  `daily_consumption` DECIMAL(10, 2) GENERATED ALWAYS AS (`power` * `quantity` * `daily_usage_hours`) STORED,
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `components`
-- Catalogue des matériaux (panneaux, batteries, etc.).
--
CREATE TABLE `components` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT NOT NULL COMMENT 'Lié au client pour permettre des catalogues personnalisés',
  `type` ENUM('panel', 'battery', 'inverter', 'controller') NOT NULL,
  `brand` VARCHAR(255) NOT NULL,
  `model` VARCHAR(255) NOT NULL,
  `specs` JSON NOT NULL COMMENT 'Caractéristiques techniques en JSON (ex: { "power": 375, "voltage": 36.5 } pour un panneau)',
  `price` DECIMAL(10, 2),
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
-- Paramètres par défaut pour les calculs, spécifiques à chaque client.
--
CREATE TABLE `settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT NOT NULL UNIQUE,
  `battery_dod` DECIMAL(5, 2) NOT NULL DEFAULT 0.50 COMMENT 'Profondeur de décharge par défaut',
  `system_loss_factor` DECIMAL(5, 2) NOT NULL DEFAULT 0.77 COMMENT 'Facteur de pertes système',
  `days_of_autonomy` INT NOT NULL DEFAULT 2,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `maintenance_tasks`
-- Gère les tâches de maintenance pour chaque projet.
--
CREATE TABLE `maintenance_tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT NOT NULL,
  `task_description` TEXT NOT NULL,
  `due_date` DATE NOT NULL,
  `status` ENUM('Pending', 'Completed') NOT NULL DEFAULT 'Pending',
  `completed_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET_CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

