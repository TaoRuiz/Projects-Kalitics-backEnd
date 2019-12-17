Installation du projet :
Dans le dossier, ouvrir la CLI : composer install

Modifier les informations de connexion à la base de données dans le fichier .env :
DATABASE_URL=mysql://db_username:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

Créer la base de données :
php .\bin\console d:d:c

Lancer les migrations :
php .\bin\console d:m:m -n

Appliquer les fixtures :
php .\bin\console d:f:l -n

Lancer le serveur Php (si le choix se porte sur un autre port, il faudra le spécifier dans la partie FrontEnd):
php -S localhost:3000 -t public
