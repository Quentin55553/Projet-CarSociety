# Comment installer MySQL sous Linux ?

> [!NOTE]
> ## Prérequis
> - Avoir les privilèges administrateur

## Étape 1 : Ouvrir le terminal Linux
Sur votre ordinateur Linux, ouvrez le terminal (**Ctrl+Alt+T**).

## Étape 2 : Mettre à jour la liste des packages disponibles
Sur votre terminal, mettez à jour vos packages à l'aide de la commande suivante :

```bash
sudo apt-get update
```

## Étape 3 : Mettre à jour les packages installés sur votre système
Installez maintenant les mises à niveau disponibles de tous les packages actuellement installés sur le système à l'aide de la commande suivante :

```bash
sudo apt-get upgrade
```

## Étape 4 : Installer MySQL
Vous pouvez désormais installer MySQL sur votre système à l'aide de la commande suivante :

```bash
sudo apt install mysql-server
```

Après avoir entré la commande ci-dessus, une confirmation vous sera demandée afin de poursuivre l'installation, entrez **Y** et appuyez sur **ENTRÉE**.

## Étape 5 : Vérifier l'installation

Pour vérifier que MySQL a bien été installé, vous pouvez vérifier la version installée sur votre système à l'aide de la commande suivante :

```bash
mysql --version
```