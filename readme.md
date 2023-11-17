# Projet symfony

## Auteur
Thomas L.  
EFREI  
B3 développement web & applications

## Lancer le projet
Pour faciliter l'éxecution du projet sur toutes les machines, il est préférable de posséder docker ainsi que yarn.  
Pour lancer le projet, se placer dans la root directory du projet puis :
- docker-compose up (dockerise une base de données pour le projet)
- yarn run dependencies
- yarn run truncate-database
- yarn run server-start  
(Les trois commandes ci-dessus sont des commandes custom ajoutées dans le package.json)  

Le projet sera accessible sur http://localhost:8001  

## Utilisateurs
Des utilisateurs de test par défaut sont disponibles grâce aux fixtures : 
- Admin : (username : admin / password : admin)
- User classique : (username : technicien / password : technicien)

## Droits
Les admins peuvent ajouter et modifier des contacts  
Les users ne peuvent que consulter