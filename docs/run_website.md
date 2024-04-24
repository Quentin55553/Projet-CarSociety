# Comment lancer le site internet sous Linux ?

> [!NOTE]
> ## Prérequis
> - Avoir Linux comme système d'exploitation (recommandé) [Installer une distribution Linux](https://www.linux.org/pages/download/)
> - Avoir les privilèges administrateur
> 1. [Installer PHP sur Linux](install_php.md)
> 2. [Installer MySQL](install_mysql.md)
> 3. [Configurer MySQL](config_mysql.md)

## Étape 1 : Ouvrir le terminal Linux
Ouvrez l'explorateur de fichier et placez-vous à la racine du répertoire du site internet.<br>
Faites un **CLIQUE DROIT** avec la souris et cliquez sur `Ouvrir dans un terminal`.

## Étape 2 : Démarrer un serveur PHP localement
### Arrêter l'activité sur le port 8080
Le site internet est prévu pour fonctionner sur le port 8080.<br>
> [!CAUTION]
> Pour s'assurer que ce port est libre assurez-vous de fermer les processus susceptibles d'utiliser ce port et entrez la commande suivante dans le terminal :

```bash
sudo fuser -k 8080/tcp
```

### Démarrer un serveur local PHP sur le port 8080
Ensuite démarrez un serveur PHP localement sur le port 8080 à l'aide de la commande suivante :

```bash
php -S localhost:8080
```

## Étape 3 : Se connecter au site internet sur le serveur local
Ouvrez votre navigateur internet, et entrez dans la barre d'adresse : `http://localhost:8080/`.<br><br>
### `#ffffff` Vous voilà sur le site internet ! 🎉
