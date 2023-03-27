se mettre dans le dossier public
pour lancer le server php : php -S localhost:8080
ouvrir la page: http://localhost:8080


Pour lancer la migration
php migration.php

Pour démarer un server mysql
sudo /Applications/XAMPP/xamppfiles/bin/mysql.server start

Pour stopper un server mysql
sudo killall mysqld

configuration:
sudo /Applications/XAMPP/xamppfiles/bin/manger_osx

Pour creer un package:
- init composer
- creer un dépot github
- dans packagist (https://packagist.org/) soumettre le dépot
- renomer les  namespace avec le même que le nom  du "vendor" dans composer pour éviter les conflits