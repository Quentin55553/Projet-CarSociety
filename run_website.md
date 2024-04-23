## Comment lancer le site internet sous Linux ?

> [!NOTE]
> ## Prérequis
> 1. Avoir Linux comme système d'exploitation (recommandé) [Installer une distribution Linux](https://www.linux.org/pages/download/)
> 2. Avoir les privilèges administrateur
> 3. [Installer PHP sur Linux](docs/install_php.md)
> 4. [Installer MySQL](docs/install_mysql.md) et [Configurer MySQL](docs/config_mysql.md)


## Étape 1 : Ouvrir le terminal Linux
Ouvrez l'explorateur de fichier et placez-vous à la racine du répertoire du site internet.
Faites un **CLIQUE DROIT** avec la souris et cliquez sur `Ouvrir dans un terminal`.

## Étape 2 : Démarrer un serveur PHP localement
Le site internet est prévu pour fonctionner sur le port 8080.
Pour s'assurer que ce port est libre assurez-vous de fermer les processus susceptibles d'utiliser ce port et entrez la commande suivante dans le terminal :

```bash
sudo fuser -k 8080/tcp
```

Ensuite démarrez un serveur PHP localement sur le port 8080 à l'aide de la commande suivante :
```bash
php -S localhost:8080
```

## Étape 3 : Se connecter au site internet sur le serveur local
Ouvrez votre navigateur internet, et dans la barre d'adresse entrez `http://localhost:8080/`.
Vous voilà sur le site internet !