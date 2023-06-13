# P6_SnowTricks

Développez de A à Z le site communautaire SnowTricks

![Capture](https://insight.symfony.com/projects/3d78783a-627a-4df2-9f5f-75663c6b59f5/big.svg)

![Capture](https://user-images.githubusercontent.com/82519929/231784652-a02d0840-8fba-4341-be8f-84dc1379b650.PNG)

# Contexte
Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaître ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.

Pour ce projet, nous allons nous concentrer sur la création technique du site pour Jimmy.

# Description du besoin
Vous êtes chargé de développer le site répondant aux besoins de Jimmy. Vous devez ainsi implémenter les fonctionnalités suivantes : 

un annuaire des figures de snowboard. Vous pouvez vous inspirer de la liste des figures sur Wikipédia. 
Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes.
la gestion des figures (création, modification, consultation).
un espace de discussion commun à toutes les figures.
Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :

la page d’accueil où figurera la liste des figures;

la page de création d'une nouvelle figure;

la page de modification d'une figure ;

la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).

# Installation
1- Copier le projet via git clone

2- Créer votre fichier .env.local (à la racine du projet) décommenter (DATABASE_URL="mysql") et ajouter les infos de votre bdd 

3- Un petit Composer install sera de la partie pour les bibliotèques tierce installé  

4- faite un "symfony console doctrine:database:create" apres avoir rentré les infos de votre BDD (consigne 3)

5- faite ensuite un "symfony console doctrine:migration:migrate" pour creer les tables 

6- et pour finir toujours dans votre terminal un "symfony console doctrine:fixtures:load --no-interaction" pour générer un jeux de donnée

7- Profiter du site snowtricks
