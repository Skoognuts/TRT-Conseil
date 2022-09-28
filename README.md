# EVALUATION :
## Développer la partie Back-End d'une Application Web

Evaluation réalisée par Julien LABATUT lors de la Formation "*Graduate Développeur Mobile Android*", promotion ATIYAH. 

### Livrables contenues dans ce dépôt (Dossier "LIVRABLES") :
- **Création de la base de données.sql :** Fichier SQL regroupant l'ensemble des commandes pour créer la base de données et ses tables, ainsi que les commandes permettant d'insérer dans ces tables des données factices et cohérentes.
- **Documentation technique.pdf :** Fichier PDF regroupant les diagrammes de classe, de cas d'utilisation...
- **Manuel d'utilisation.pdf :** Fichier PDF regroupant les directives nécessaire au fonctionnement et à l'administration de l'application.
- **README :** Fichier Markdown regroupant la description du contexte de l'évaluation ainsi que les techniques de mise en œuvre de déploiement en local ou en ligne.

### Contexte de l'évaluation :
TRT Conseil est une agence de recrutement spécialisée dans l’hôtellerie et la restauration. Fondée en 2014, la société s’est agrandie au fil des ans et possède dorénavant plus de 12 centres dispersés aux quatre coins de la France.

La crise du coronavirus ayant frappée de plein fouet ce secteur, la société souhaite progressivement mettre en place un outil permettant à un plus grand nombre de recruteurs et de candidats de trouver leur bonheur.

TRT Conseil désire avoir un produit minimum viable afin de tester si la demande est réellement présente. L’agence souhaite proposer pour l’instant une simple interface avec une authentification.

4 types d’utilisateur devront pouvoir se connecter :

 1. **Les recruteurs** : Une entreprise qui recherche un employé.
 2. **Les candidats** : Un serveur, responsable de la restauration, chef cuisinier etc.
 3. **Les consultants** : Missionnés par TRT Conseil pour gérer les liaisons sur le back-office entre
recruteurs et candidats.
 4. **L’administrateur** : La personne en charge de la maintenance de l’application.

### Déploiement en local :
Le déploiement en local de cette application suggère que vous disposez au minimum d'un serveur local (Apache), de PHP 8.1, de MySQL et de Symfony 5, les trois premiers étant fournis par Xampp par exemple.

 - Dans un premier temps, ouvrez un invite de commande, clonez le dépôt Git de l'application et naviguez jusqu'au dossier précédemment créé :
```
git clone https://github.com/Skoognuts/TRT-Conseil.git
cd TRT-Conseil
```
 - Installez les dépendances de l'application :
```
composer install
```
 - Modifiez le fichier environnement ( .env situé dans le dossier racine ) afin d'y lier votre propre base de données. L'URL de cette dernière doit être modifiée dans la ligne suivante :
 ```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name
```
 - Toujours dans ce même fichier .env, modifiez la variable d'environnement afin de la passer en développement, sinon, vos modifications ne seront pas prises en compte :
```
APP_ENV=dev
```
 - Remplacez "db_user" par votre nom d'utilisateur (en règle générale, "root" en local), "db_password" par votre mot de passe et "db_name" par le nom que vous souhaitez donner à votre base de données. Afin de valider cette manipulation, créez la base de données et effectuez la migration.
```
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
 - Enfin, lancez le serveur local :
```
symfony server:start
```
### Déploiement en ligne :
Le déploiement en ligne se fait via Heroku et suggère que vous y ayez un compte.
 - Dans un premier temps, connectez vous à votre compte Heroku depuis un invite de commande, puis créez un nouveau projet :
```
heroku login
heroku create
```
- Si le fichier Procfile ne se trouve pas à la racine de l'application, créez-le. Attention, il est impératif que ce fichier n'ait pas d'extension :
```
echo 'web: heroku-php-apache2 public/' > Procfile
```
- Modifiez le fichier d'environnement afin de passer en mode production :
```
heroku config:set APP_ENV=prod
heroku config:set APP_SECRET=$(php -r 'echo bin2hex(random_bytes(16));')
``` 
- Configurez votre projet Heroku en y ajoutant un gestionnaire de base de données (JawsDB):
```
heroku addons:create jawsdb-maria:kitefin
```
- Reportez l'adresse de votre base de données sur JawsDB dans votre fichier d'environnement :
```
heroku config:get JAWSDB_MARIA_URL
heroku config:set DATABASE_URL=your_db_url
```
- Enfin, lancez le déploiement en créant un commit et en réalisant un push sur votre projet Heroku :
```
git add .
git commit -m "Create heroku production configuration"
git push heroku main
```
---

**Julien Labatut :**
- **Mail :** j.labatut33127@gmail.com.
- **GitHub :** https://github.com/Skoognuts.