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

    Configurez les variables d'environnement en copiant `.env`  vers `.env.local` et en ajustant les détails de connexion à la base de données 
    ```dotenv
    DATABASE_URL="mysql://root:@127.0.0.1:3306/db_name?serverVersion=8.0.32&charset=utf8mb4"
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

8. Accédez à l'URL fournie par Symfony pour visualiser votre application dans le navigateur. ```http://localhost:8000 ```
9. Pour vous connecter en tant qu'utilisateur normal :
    - **e-mail :**test@gmail.com
    - **Password :**password
10. Pour vous connecter en tant qu'administrateur :
    - **e-mail :**admin@gmail.com
    - **Password :**admin1

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

 ```
    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/profile, roles: ROLE_USER }
        - { path: /register, roles: PUBLIC_ACCESS }
   ```
        
- **CUtilisation de Slug** : Pour éviter d'exposer des identifiants dans les URL, utilisez des slugs générés à partir des titres des entités.

- **Échappement des Données** : Utilisez htmlspecialchars pour échapper les données provenant des utilisateurs avant de les afficher dans les vues pour prévenir les attaques XSS.
 ```
    public function setTitle($title)
        {
            $this->title = htmlspecialchars($title);
            return $this;
        }
 ```

En suivant ces mesures de sécurité, vous pouvez renforcer la robustesse et la fiabilité de votre application Symfony.
