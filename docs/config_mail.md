# Comment configurer XAMPP pour envoyer des mails depuis Localhost en PHP ?

## Prérequis
La configuration de la messagerie nécessite d'[installer](https://www.apachefriends.org/) et de [configurer](config_xampp.md) le logiciel XAMPP au préalable.

## Étape 1
Accédez au répertoire `\xampp\php` et ouvrez le fichier de paramètres de configuration PHP `php.ini`, puis recherchez `[mail function]` en faisant défiler vers le bas ou appuyez simplement sur **CTRL + F** pour le rechercher directement.
Recherchez ensuite les lignes suivantes et affectez ces valeurs. N'oubliez pas qu'il faut supprimer les points-virgules qui peuvent potentiellement se trouver au début de chacune de ces lignes.

```ini
[mail function]

SMTP=smtp.gmail.com
smtp_port=587
sendmail_from=carsociety758@gmail.com
sendmail_path="\"C:\xampp\sendmail\sendmail.exe\" -t"
```
Après cela, appuyez sur **CTRL + S** pour enregistrer les modifications, puis fermez le fichier.

## Étape 2
Maintenant, allez dans `\xampp\sendmail` et ouvrez le fichier de paramètres de configuration de *sendmail* `sendmail.ini`, puis recherchez `[sendmail]` en faisant défiler vers le bas ou appuyez sur **CTRL + F** pour le rechercher directement.
Recherchez ensuite les lignes suivantes et affectez ces valeurs. N'oubliez pas qu'il faut supprimer les points-virgules qui peuvent potentiellement se trouver au début de chacune de ces lignes.

```ini
[sendmail]

smtp_server=smtp.gmail.com
smtp_port=587
error_logfile=error.log
debug_logfile=debug.log
auth_username=carsociety758@gmail.com
auth_password=nwxidkhvtxiwbnkq
force_sender=carsociety758@gmail.com
```
Après cela, appuyez sur **CTRL + S** pour enregistrer les modifications, puis fermez le fichier.

## Étape 3
Après les modifications effectuées, redémarrez votre serveur Apache.
