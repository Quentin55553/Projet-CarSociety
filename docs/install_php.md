# Comment installer PHP sous Linux ?

> [!NOTE]
> ## Prérequis
> - Avoir les privilèges administrateur
> - Avoir un compilateur ANSI C
> - Avoir les composants spécifiques aux modules comme les bibliothèques graphiques GD ou les bibliothèques PDF
> - **Facultatif :** Avoir Autoconf 2.59+ (pour les versions PHP < 7.0), Autoconf 2.64+ (pour les versions PHP > 7.2), Automake 1.4+, Libtool 1.4+, re2c 0.13.4+ et Bison

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

## Étape 4 : Installer PHP
Vous pouvez désormais installer PHP sur votre système à l'aide de la commande suivante :

```bash
sudo apt-get install php
```

Après avoir entré la commande ci-dessus, une confirmation vous sera demandée afin de poursuivre l'installation, entrez **Y** et appuyez sur **ENTRÉE**.

## Étape 5 : Vérifier l'installation

Pour vérifier que PHP a bien été installé, vous pouvez vérifier la version installée sur votre système à l'aide de la commande suivante :

```bash
php --version
```