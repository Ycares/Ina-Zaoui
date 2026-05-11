# Guide de contribution

Ce document decrit les conventions de contribution du projet Ina Zaoui.

## Branches

Utiliser un prefixe standard :

- `feat/<description-courte>`
- `fix/<description-courte>`
- `chore/<description-courte>`

Exemples :
- `feat/guest-management-admin`
- `fix/media-upload-validation`
- `chore/update-readme`

## Commits (Conventional Commits)

Format attendu :

- `feat: ...`
- `fix: ...`
- `chore: ...`
- `docs: ...`
- `test: ...`
- `refactor: ...`

Exemples :
- `feat: add admin guest blocking endpoints`
- `fix: exclude blocked users from portfolio album view`
- `docs: complete architecture and changelog`


## Politique de validation avant PR

Executer au minimum :

- `php bin/console lint:container`
- `php bin/phpunit`
- `php bin/phpunit --coverage-html var/coverage`

Attendus :

- suite de tests verte
- couverture maintenue (objectif projet : > 70%)
- pas de secret committe (`.env.local`, tokens, credentials)

## Qualite de code

- Proteger les actions sensibles en POST avec CSRF.
- Valider les entrees utilisateur cote serveur (Validator, contraintes Assert).
- Limiter le N+1 via repository/requetes optimisees lorsque necessaire.


Quelques commandes utiles :

Tests:
- `php bin/phpunit`

PHPStan:
- `./vendor/bin/phpstan analyse`

Coverage en texte:
- `XDEBUG_MODE=coverage php bin/phpunit --coverage-text`

Coverage en HTML (résultat dans var/coverage/index.html)
- `XDEBUG_MODE=coverage php bin/phpunit --coverage-html var/coverage`
