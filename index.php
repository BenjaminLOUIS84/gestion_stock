<?php
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //SESSION
    //Une session en PHP correspond à une façon de stocker des données différentes pour chaque utilisateur en utilisant un identifiant de session unique.
    //Les identifiants de session vont généralement être envoyés au navigateur via des cookies de session et vont être utilisés pour récupérer les données existantes de la session.
    //Un des grands intérêts des sessions est qu’on va pouvoir conserver des informations pour un utilisateur lorsqu’il navigue d’une page à une autre.
    //De plus, les informations de session ne vont cette fois-ci pas être stockées sur les ordinateurs de vos visiteurs
    //à la différence des cookies mais plutôt côté serveur ce qui fait que les sessions vont pouvoir être beaucoup plus sûres que les cookies.
    //Notez toutefois que le but des sessions n’est pas de conserver des informations indéfiniment mais simplement durant une « session ».
    //Une session démarre dès que la fonction session_start() est appelée et se termine en général dès que la fenêtre courante du navigateur est fermée
    //(à moins qu’on appelle une fonction pour terminer la session de manière anticipée ou qu’un cookie de session avec une durée de vie plus longues ait été défini).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    
    //REQUETE HTTP
    //Une requête HTTP est une demande effectuée par le navigateur web (Chrome, Internet Explorer, Firefox, Mozilla, Safari, etc.) au serveur HTTP lorsqu’il souhaite télécharger une page web.
    //C’est un ensemble de lignes envoyé au serveur par le navigateur. Le protocole HTTP est utilisé par le navigateur web pour consulter un site internet.
    //Le HTTP permet au navigateur de demander tous les types de médias utilisés sur les sites Internet modernes.
    //Les applications utilisent également le HTTP pour charger des fichiers et des mises à jour de serveurs distants.
    //Le HTTP intervient également dans les API REST, une solution permettant de contrôler les services Web
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    
    //DIFFERENCE ENTRE HTTP ET HTTPS
    //Quelle est la différence entre HTTP et HTTPS ?
    //HTTP et HTTPS sont les deux protocoles utilisés pour transmettre des données sur Internet et sites Web.
    //HTTP est synonyme de protocole de transfert hypertexte, tandis que l’ajout du «S» dans HTTPS signifie (HyperText Transfer Protocol Secure) qu’il s’agit d’une connexion sécurisée (chiffrée).
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    
    //SUPERGLOBALES
    //Les variables superglobales sont des variables internes au PHP, ce qui signifie que ce sont des variables créées automatiquement par le PHP.
    //Ces variables vont être accessibles n’importe où dans le script et quel que soit le contexte, qu’il soit local ou global.
    //C’est d’ailleurs la raison pour laquelle on appelle ces variables « superglobales ».
    //Il existe 9 superglobales en PHP. Ces variables vont toutes être des variables tableaux qui vont contenir des groupes de variables très différentes.
    //La plupart des scripts PHP vont utiliser les variables superglobales car ces dernières vont s’avérer très souvent très utiles .
    //Il est donc indispensable de bien les connaitre et de savoir les manipuler:

    //$GLOBALS ;$_SERVER ;$_REQUEST ;$_GET ;$_POST ;$_FILES ;$_ENV ;$_COOKIE ;$_SESSION.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    
    //$_SESSION: est un tableau associatif qui va contenir toutes les données de session une fois la session démarrée.

    //$_POST: Contient tous les couples variable / valeur transmis en POST, c'est à dire les informations qui ne proviennent ni de l'url, ni des cookies et ni des sessions.

    //$_GET: Contient tous les couples variable / valeur transmis dans l'url.

    //Deux méthodes peuvent être utilisées dans l'envoi de données via les formulaires, la méthode GET et POST.
    //Nous préconisons l'emploi de la méthode POST car elle cache les informations transmises (qui transiteraient par l'URL dans le cas de la méthode GET).
    //De plus, elle permet d'envoyer des données importantes en taille (la méthode GET se limite à 255 caractères) et assure la gestion de l'envoi de fichiers.
    //La méthode GET est utilisée par défaut lorsque l'on utilise l'URL pour faire passer des variables.
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //COOKIE
    //Un cookie est un petit fichier informatique type texte, un traceur, déposé et lu par exemple lors de la consultation d'un site internet, de la lecture d'un courrier électronique,
    //de l'installation ou de l'utilisation d'un logiciel ou d'une application mobile et ce, quel que soit le type de terminal utilisé
    //(ordinateur, smartphone, liseuse numérique, console de jeux vidéos connectée à Internet, etc.).
    //Les cookies sont de petits fichiers textes enregistrés automatiquement dans votre navigateur par un site web lors de votre visite.
    //D’autre part, les cookies recueillent des informations à votre sujet et sur votre activité en ligne d’une manière qui peut sembler malhonnête et peu transparente.

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    
    //Pour parcourir le tableau de session de la page de traitement on appel la fonction ici
    session_start();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, intitial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ajout produit</title>
</head>

<body>
    <div id="wrapper">
        <header>
            <nav>
                <label>Gestion de Stock</label>
                <h1>PHP</h1>
                <div class="menu">
                    <a href="recap.php">RESULTAT</a>
                </div>
            </nav>
        </header>

        <?php
            ///////////////////////////////////////////////////////////////////////////////
            //Pour afficher le nombre de produits en session (références en stock)
            //////////////////////////////////////////////////////////////////////////////

            if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {    
                        
                echo "<p>Nombre de produits en stock : 0 </p>";

            } else {

                echo "<p>Nombre de produits en stock: ".count($_SESSION['products'])."</p>";  

            }
            /////////////////////////////////////////////////////////////////////////////////
        ?>

        <!-- La balise form comporte 2 attributs action qui indique la cible du formulaire (fichier à atteindre quand l'user soumettra le formulaire)
        et method qui précise par quelle méthode les données seront transmises au serveur -->
        <!-- On privilégie Post pour ne pas polluer l'URL -->

        <div class= formulaire>
            <form action = "traitement.php" method = "post">

                <p>
                    <label>
                        Nom du produit<br>
                        <input type = "text" name = "name" required>
                    </label>
                </p>
                <p>
                    <label>
                        Prix du produit<br>
                        <input type = "number" step = "any" name = "price" required>
                    </label>
                </p>
                <p>
                    <label>
                        Quantité<br>
                        <input type = "number" name = "qtt" value = "" required>
                    </label>
                </p>
                <p>
                    <input type = "submit" name = "addProduct" value = "AJOUTER">
                </p>
            </form>
        </div>

        <?php
          
            ///////////////////////////////////////////////////////////////////////////////
            // Afficher un message à chaque ajout de produit
            ///////////////////////////////////////////////////////////////////////////////

            if(!isset($_SESSION['checkSuccess'])|| empty(['checkSuccess'])){

                $_SESSION['checkSuccess'] = "<p>Veuillez ajouter un produit</p>";
          
            }else{
            
                echo $_SESSION['checkSuccess'];
            }
           
            ///////////////////////////////////////////////////////////////////////////////   

        ?>

    </div>

    <script src="script.js"></script>

</body>
</html>
