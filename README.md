SolarSaaS - Application de Dimensionnement Solaire
Bienvenue sur SolarSaaS, une application web complète pour le dimensionnement d'installations de panneaux solaires, conçue pour les professionnels.

Architecture
L'application est développée en PHP natif et suit une architecture MVC (Modèle-Vue-Contrôleur) avec un point d'entrée unique pour garantir la sécurité et la maintenabilité.

Point d'entrée unique : Toutes les requêtes passent par public/index.php.

Routage : Un routeur personnalisé (app/Core/Router.php) analyse l'URL et appelle le contrôleur et la méthode appropriés.

Contrôleurs : Situés dans app/Controllers, ils gèrent la logique de l'application et font le lien entre les modèles et les vues.

Modèles : Situés dans app/Models, ils interagissent avec la base de données.

Vues : Situées dans app/Views, elles sont responsables de l'affichage des données. Le design est géré avec Tailwind CSS.

Multi-client (SaaS) : La structure de la base de données est conçue pour isoler les données de chaque client.

Autoloading: Utilise Composer et la norme PSR-4 pour charger les classes automatiquement.

Installation
Dépendances :

Si vous n'avez pas Composer, installez-le.

Exécutez composer install à la racine du projet pour générer le fichier vendor/autoload.php.

Base de données :

Créez une nouvelle base de données (par exemple, solarsaas).

Importez le fichier database.sql pour créer toutes les tables nécessaires.

Configuration :

Ouvrez le fichier app/config.php.

Modifiez les informations de connexion à la base de données (DB_HOST, DB_NAME, DB_USER, DB_PASS).

Configurez l'URL de base de l'application (APP_URL).

Serveur Web (Apache) :

Assurez-vous que le module mod_rewrite est activé.

Pointez la racine de votre hôte virtuel vers le dossier public/. Le fichier .htaccess inclus gérera la réécriture d'URL.

Accès :

Ouvrez votre navigateur et accédez à l'URL que vous avez configurée. Vous devriez voir la page d'accueil.
