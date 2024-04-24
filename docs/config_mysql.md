# Comment configurer un compte MySQL 'root' sans mot de passe sous Linux ?

> [!NOTE]
> ## Prérequis
> - Avoir [installé MySQL](install_mysql.md)
> - Avoir les privilèges administrateur

## Étape 1 : Se connecter au serveur local MySQL en tant que root
Sur votre ordinateur Linux, ouvrez le terminal (**Ctrl+Alt+T**).<br>
Connectez-vous au serveur local MySQL en tant que root à l'aide la commande suivante :

```bash
sudo mysql -u root
```

## Étape 2 : Créer un compte 'root' sans mot de passe
### Supprimer le compte 'root' existant
Si un compte 'root' existe déjà, nous allons le supprimer pour s'assurer que le nouveau soit correctement créé.<br>
Pour ce faire, entrez la commande suivante :

```sql
DROP USER IF EXISTS 'root'@'localhost';
```

### Créer un nouveau compte 'root' sans mot de passe
Créez un compte 'root' sans mot de passe à l'aide de la commande suivante :

```sql
CREATE USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password;
```

### Accorder tous les privilèges au nouveau compte 'root'
Pour accorder tous les privilèges au nouveau compte 'root', utilisez la commande suivante :

```sql
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;
```

### Recharger les privilèges
Afin de recharger la table des informations relatives aux privilèges, utilisez la commande suivante :

```sql
FLUSH PRIVILEGES;
```

## Étape 3 : Se déconnecter du serveur local MySQL
Après les modifications effectuées, déconnectez-vous du serveur local MySQL à l'aide de la commande suivante :

```sql
exit;
```

## Etape 4 : Redémarrer MySQL
Pour s'assurer que tous les changements soient bien pris en compte, redémarrez MySQL en utilisant la commande associée à votre distribution Linux :

### | <img height="30" src="https://user-images.githubusercontent.com/25181517/186884153-99edc188-e4aa-4c84-91b0-e2df260ebc33.png"> Ubuntu / Debian
```bash
sudo service mysql restart
```

### CentOS / RHEL (Red Hat Enterprise Linux)
```bash
sudo systemctl restart mysqld
```

### Fedora
```bash
sudo systemctl restart mariadb
```
