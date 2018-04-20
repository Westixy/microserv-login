# microserv-login

## run 

1. clone the repo
2. Run `composer install`
3. start a php serv with `php -S localhost:8000`

## Routes
### GET /login
utilisée pour obtenir les infos grace a un uid en parametre
#### params
- uuid : l'uid de l'utilisateur
#### return 
- 404: pas trouvé
- 200: les infos de l'user

### POST /login
utilisé pour obtenir l'uid en fonction de l'email et du password
#### params
- email: l'email de l'utilisateur
- password: le mdp de l'user
#### return
- 404: pas d'user trouve avec ce mail
- 401: user / password not match
- 200: infos de l'user 

### POST /register
utiliser pour creer un nouvel utilisateur
#### params
- email: l'email de l'utilisateur
- password: le mdp de l'user
#### return
- 409: email exist déja
- 401: erreur a la creation (inconnue)
- 200: infos utilisateur

### POST /reset-password
#### params
- email :  l'email de l'utilisateur
#### return
- 404: user not found
- 200: infos user + password dans le payload

### POST /update-password
#### params
- uuid : l'uid de l'utilisateur
- password : le nouveau mdp
#### return
- 404: user not found
- 200: infos user

### GET /update-uid
#### params
- uuid :  l'uid de l'utilisateur
#### return
- 404: user not found
- 200: infos user

### DELETE /delete
#### params
- uuid :  l'uid de l'utilisateur
#### return
- 404: user not found
- 200: user deleted
