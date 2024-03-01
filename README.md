# Guide d'Utilisation et Sécurité du Projet

## Téléchargement du Projet

Pour télécharger et utiliser ce projet, veuillez suivre les étapes suivantes :

1. Clonez le dépôt Git :
    ```
    git clone <URL_DU_DEPOT>
    ```

2. Accédez au répertoire du projet :
    ```
    cd <NOM_DU_REPERTOIRE>
    ```

3. Installez les dépendances :
    ```
    composer install
    ```

4. Configurez votre base de données :

    Ouvrez le fichier `.env` et configurez l'URL de votre base de données :
    ```dotenv
    DATABASE_URL=mysql://user:password@127.0.0.1:3306/db
    ```

5. Créez la base de données :
    ```
    php bin/console doctrine:database:create
    ```

6. Appliquez les migrations :
    ```
    php bin/console doctrine:migrations:migrate
    ```

7. Lancez le serveur Symfony :
    ```
    symfony serve
    ```

8. Accédez à l'URL fournie par Symfony pour visualiser votre application dans le navigateur.

## Sécurité du Site

Pour assurer la sécurité de votre site, veuillez suivre les bonnes pratiques suivantes :

- **Validation des Entrées** : Utilisez les contraintes de validation Symfony comme Length pour limiter la longueur des champs.
  ```php
  use Symfony\Component\Validator\Constraints as Assert;

  class User
  {
      /**
       * @Assert\Length(
       *      min = 2,
       *      max = 10,
       *      minMessage = "Votre prénom doit comporter au moins {{ limit }} caractères",
       *      maxMessage = "Votre prénom ne peut pas dépasser {{ limit }} caractères"
       * )
       */
      private $firstName;
  }
  
- **Contrôle d'Accès** : Utilisez access_control dans votre fichier security.yaml pour définir les règles d'accès basées sur les rôles des utilisateurs.


security:
    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/profile, roles: ROLE_USER }
        
- **CUtilisation de Slug** : Pour éviter d'exposer des identifiants dans les URL, utilisez des slugs générés à partir des titres des entités.

- **Échappement des Données** : Utilisez htmlspecialchars pour échapper les données provenant des utilisateurs avant de les afficher dans les vues pour prévenir les attaques XSS.


public function setTitle($title)
{
    $this->title = htmlspecialchars($title);
    return $this;
}

En suivant ces mesures de sécurité, vous pouvez renforcer la robustesse et la fiabilité de votre application Symfony.
