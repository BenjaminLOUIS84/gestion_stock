<?php

    // Ouvrir une session sur le serveur avec la fonction session_start()

    session_start();

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Effacer toute les références du tableau avec le bouton "Vider le Stock"
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    if (isset($_POST['reset'])){

        //unset($_SESSION['products']); //Pour détruire le tableau

        $_SESSION['products'] = []; //Pour vider le tableau
        $_SESSION['checkSuccess'] = "<p>Veuillez ajouter un produit</p>"; //Pour reset le message  
        
        header("Location:recap.php"); 
        exit;   
    }
   
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Effacer une référence du tableau avec le bouton "Supprimer"
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    // Pour effacer une référence en appelant la fonction dans l'action (en référencent le paramêtre avec la superglobale PHP $_GET)

    if (isset($_POST['delete'])){

        // if($_GET['id'] && $_SESSION['products'][$_GET['id']]){

        //     unset($_SESSION['products'][$_GET['id']]);
        // }

        //Pour vérifier si la route est bonne (en cliquant sur le bouton "Supprimer" on atterri sur une autre page avec le mot "Hello")
        // die('hello');

        // Pour effacer une référence en réindexant les clés automatiquement

        array_splice($_SESSION['products'], array_search(68, $_SESSION['products']),1);

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Afficher une message à chaque suppression de produit.
        ///////////////////////////////////////////////////////////////////////////////

        $_SESSION['checkRemove'] = "<div id = messAdd><p>Produit supprimé avec succès !</p></div>";
           
        ///////////////////////////////////////////////////////////////////////////////
        
        header("Location:recap.php"); 
        exit;          
    }
    
    //header("Location:recap.php"); 
    //exit; 

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Augmenter la quantité d'une référence avec le bouton "+"
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    if (isset($_GET['add'])){

        //die('hello');

        if($_GET['id'] && $_SESSION['products'][$_GET['id']]){

            //die('hi');//PB pour accéder ici
            
            $_SESSION['products'][$_GET['id']]['qtt'] ++;
            $_SESSION['products'][$_GET['id']]['total']=($_SESSION['products'][$_GET['id']]['qtt']) * ($_SESSION['products'][$_GET['id']]['price']);
        }
        
        header("Location:recap.php");
        exit;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Réduire la quantité d'une référence avec le bouton "-"
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    if (isset($_GET['del'])){

        if($_GET['id'] && $_SESSION['products'][$_GET['id']]){
          
            $_SESSION['products'][$_GET['id']]['qtt'] --;
            $_SESSION['products'][$_GET['id']]['total']=($_SESSION['products'][$_GET['id']]['qtt']) * ($_SESSION['products'][$_GET['id']]['price']);
        }
        
        header("Location:recap.php");
        exit;
    }
   
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Reset le message en retournant sur la page du formulaire
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    if (isset($_POST['return'])){

        $_SESSION['checkSuccess'] = "<p>Veuillez ajouter un produit</p>"; //Pour reset le message

        header("Location:index.php");
        exit;
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       
    // Vérifier l'éxistence d'une requête POST (vérifier l'existence de la clé "submit dans le tableau POST)
    // Créer une condition pour limiter l'accès à cette page par les seules requêtes HTTP provenant de la soumission de notre formulaire.

    if(isset($_POST['addProduct'])){
        
        // Vérifier l'intégrité des valeurs transmises dans le tableau $_POST
        // en fonction de celles que nous attendons réellement avec des filtres
        // pour éviter les failles par injection de code (XXS ou SQL Injection)

        ///////////////////////////////////////////////////////////////////////////////
        //XSS
        //Le cross-site scripting (abrégé XSS) est un type de faille de sécurité des sites web permettant d'injecter du contenu dans une page,
        //provoquant ainsi des actions sur les navigateurs web visitant la page.
        //Les possibilités des XSS sont très larges puisque l'attaquant peut utiliser tous les langages pris en charge par le navigateur (JavaScript, Java...)
        //et de nouvelles possibilités sont régulièrement découvertes notamment avec l'arrivée de nouvelles technologies comme HTML5.
        //Il est par exemple possible de rediriger vers un autre site pour de l'hameçonnage ou encore de voler la session en récupérant les cookies.
        

        //PRINCIPE
        //Le principe est d'injecter des données arbitraires dans un site web, si ces données arrivent dans la page web
        //sans avoir été vérifiées on peut s'en servir pour faire exécuter du code malveillant en langage de script par le navigateur web qui consulte cette page

        //CONTROLE
        //La détection de la présence d'une faille XSS peut se faire par exemple en entrant un script Javascript dans un champ de formulaire ou dans une URL :

            //<script>alert('bonjour')</script>​
            
        //Si une boîte de dialogue apparaît, on peut en conclure que l'application Web est sensible aux attaques de type XSS.

        //RISQUES:
        //Redirection vers d'autres site
        //Vol d'informations
        //Action sur le site faillible envoi de message, suppression de données,...
        //Rendre la lecture difficile (boucle infinie d'alertes)

        
        //PROTECTION
        //utiliser la fonction htmlspecialchars()​ qui filtre les '<' et '>' 
        //utiliser la fonction htmlentities()​ qui est identique à htmlspecialchars()​ sauf qu'elle filtre tous les caractères équivalents au codage HTML ou JavaScript.
        
        //OU utiliser les filtres CI DESSOUS
        ///////////////////////////////////////////////////////////////////////////////

        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);//Supprime toute présence de caractères spéciaux et de toute balise HTML (Pas d'injection de code HTML possible)
        $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);//Validera le prix que si celui ci est décimal - Pour permettre l'utilisation du caractère "." ou ","
        $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);//Validera la quantité que si celle ci est un nombre entier

        // filter_input renvoie la valeur assainie correspondant au champs traité en cas de succès sinon false ou null (pas de risque que l'utilisateur transmette des champs supplémentaires) 

        // Vérifier si les filtres ont tous fonctionnés grâce à la condition ci dessous

        if($name && $price && $qtt){

            // Organiser les données pour conserver chaque produit renseigné
            // Stcoker nos données en session en ajoutant celles-ci au tableau $_SESSION fournis par PHP
            // Construire un tableau associatif $ product pour conserver chaque produit renseigné
            
            $product = [
        
                "name" => $name,
                "price" => $price,
                "qtt" => $qtt,
                "total" => $price*$qtt
            ];

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Enregistrer le tableau de produits créer en session (tableau contenant des références enregistrer dans le stock)
            ///////////////////////////////////////////////////////////////////////////////

            $_SESSION['products'][] = $product;

            ///////////////////////////////////////////////////////////////////////////////


            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Afficher une message à chaque ajout de produit.
            ///////////////////////////////////////////////////////////////////////////////

            $_SESSION['checkSuccess'] = "<div id = messAdd><p>Produit ajouté avec succès !</p></div>";
           
            ///////////////////////////////////////////////////////////////////////////////
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Si la requête POST transmet bien une clé "submit" au serveur on accède à la page recap automatiquement  
        // Si ce n'est pas le cas la fonction header() effectuera une redirection vers un nouvel entête HTTP on reste sur la page actuelle
      
        header("Location:index.php");
        exit;  
    }
          
?>