<?php

//creation of the class Personnage
class Personnage {  
    protected $nom;     //protected for the child class, private for the other. variable for the name of the character
    protected $niveauPuissance; //variable for the level of power
    protected $pointsDeVie;     //variable for the life points
    protected $atq;        //variable for the attack points

    //constructor of the class Personnage with the parameters
    public function __construct($nom, $niveauPuissance, $pointsDeVie, $atq) {
        $this->nom = $nom;
        $this->niveauPuissance = $niveauPuissance;
        $this->pointsDeVie = $pointsDeVie;
        $this->atq = $atq;

    }

    // GETTERS
    public function getNom() {
        return $this->nom;
    }

    public function getNiveauPuissance() {
        return $this->niveauPuissance;
    }

    public function getPointsDeVie() {
        return $this->pointsDeVie;
    }

    public function getAtq() {
        return $this->atq;
    }


    //SETTERS
    public function setNiveauPuissance($niveauPuissance) {
        $this->niveauPuissance = $niveauPuissance;
        return $this;
    }
    public function setAtq($atq) {
        $this->atq = $atq;
        return $this;
    }

    public function setPointsDeVie($pointsDeVie) {
        $this->pointsDeVie = $pointsDeVie;
        return $this;
    }


    //method to attack
    public function attaquer($ennemi) {         
        $degats = $this->atq;           //variable for the damage
        echo $this->nom . " attaque " . $ennemi->nom . " pour " . $degats . " points de dégâts.\n";     //display of the attack
        $ennemi->recevoirDegats($degats);       //call of the method recevoirDegats
    }

    //method to receive damage
    public function recevoirDegats($degats) {
        $this->pointsDeVie -= $degats;    //variable for the life points, the life points decrease with the damage

        if ($this->pointsDeVie <= 0) {  //condition if the life points are less than or equal to 0,  we display the character's name and his status "has been defeated"
            echo $this->nom . " a été vaincu !\n";
            echo "--------------------------------------------------\n";
        } else {                //else the life points are displayed
            echo $this->nom . " a " . $this->pointsDeVie . " points de vie restants.\n";
            echo "--------------------------------------------------\n";
        }
    }

    //method to say if the character is dead or not
    public function estMort() {
        return $this->pointsDeVie <= 0;     //return true if the life points are less than or equal to 0, else return false
    }

    //method to display the stats of the character
    public function afficherStats() {
        echo "Nom : " . $this->nom . ", Niveau de puissance : " . $this->niveauPuissance . ", Points de vie : " . $this->pointsDeVie . ", Points d'attaque : " . $this->atq . ".\n";
        echo "--------------------------------------------------\n";
    }

    //method to get the max life points of the character
    public function getPointsDeVieMax() {
        return 100;
    }

    //method to heal the character
    public function heal() {
        $this->pointsDeVie = $this->getPointsDeVieMax();

    }

    //method to increase the level of power
    public function augmenterNiveauPuissance() {

        $this->niveauPuissance++;       //increase the level of power
        //call the method heal because the character is healed when he increases his level of power
        $this->heal();
        $this->pointsDeVie += $this->pointsDeVie * 0.5;     //increase the life points
        $this->atq += $this->atq * 0.5;         //increase the attack points
        echo "Vous êtes monter au niveau " . $this->niveauPuissance . " de puissance.\n";
    }

}


//creation of the class Hero which extends the class Personnage
class Hero extends Personnage {

    //method to attack with the choice of the attack
    public function attaquer($ennemi) {
        $attaquesDispo = ["Coup de poing"];     //variable for the attack available

        //condition to display the attack available according to the level of power
        if ($this->getNiveauPuissance() == 2 || $this->getNiveauPuissance() == 3 || $this->getNiveauPuissance() == 4) {
            $attaquesDispo = ["Coup de poing", "Kamehameha"];
        } elseif ($this->getNiveauPuissance() == 5) {
            $attaquesDispo = ["Coup de poing", "Kamehameha", "Genkidama"];
        }

        //display of the attack available
        foreach ($attaquesDispo as $key => $attaque) {
            echo ($key + 1) . ". " . $attaque . "\n";
        }

        //choice of the attack
        $choixAttaque = readline("Votre choix (1/2/3): ");
        echo "--------------------------------------------------\n";

        //condition to display the attack chosen
        switch ($choixAttaque) {
            case 1:
                echo "Vous avez choisi " . $attaquesDispo[0] . "\n";
                $this->setAtq($this->getAtq() * 1);
                break;
            case 2:
                if ($attaquesDispo[1] != null) {
                    echo "Vous avez choisi " . $attaquesDispo[1] . "\n";
                    $this->setAtq($this->getAtq() * 2);
                }
                break;
            case 3:
                if ($attaquesDispo[2] != null) {
                    echo "Vous avez choisi " . $attaquesDispo[2] . "\n";
                    $this->setAtq($this->getAtq() * 3);
                }
                break;
        }
        //call of the method attaquer of the class Personnage
        parent::attaquer($ennemi);
    }
}

//creation of the class Vilain which extends the class Personnage
class Vilain extends Personnage {

    //method to attack
    public function attaquer($ennemi) {
        parent::attaquer($ennemi);
    }

    //method to increase the level of power
    public function augmenterNiveauPuissance() {
        $this->niveauPuissance++;       //increase the level of power
        $this->heal();          //call the method heal because the character is healed when he increases his level of power
        $this->pointsDeVie += $this->pointsDeVie * 0.2;     //increase the life points
        $this->atq += $this->atq * 0.2;     //increase the attack points

    }
}

//creation of the class Game
class Game {
    private $heros;     //variable for the hero, private for the other because we don't want to change the hero
    private $vilains;   //variable for the vilain, private for the other because we don't want to change the vilain

    private $nbrVictoires = 0; // Variable for the number of victories

    public function __construct($heros, $vilains) {     //constructor of the class Game with the parameters
        $this->heros = $heros;
        $this->vilains = $vilains;
    }

    //method to fight
    public function combattre($hero, $vilain) {
        

        echo "Un combat commence entre " . $hero->getNom() . " et " . $vilain->getNom() . "!\n";
        echo "--------------------------------------------------\n";

        //while loop to fight until one of the characters is dead
        while (!$hero->estMort() && !$vilain->estMort()) {      
            $hero->attaquer($vilain);
            if (!$vilain->estMort()) {
                $vilain->attaquer($hero);
            } 
        }
        
        echo "Le combat est terminé!\n";
        echo "--------------------------------------------------\n";
        //condition to increase the level of power if the vilain is dead
        if ($vilain->estMort()) {   
            $hero->augmenterNiveauPuissance();

        }

        $hero->afficherStats();     //display the stats of the hero
        $vilain->afficherStats();   //display the stats of the vilain
    }

    //method to choose the character
    public function choisirPersonnage($liste) {
        echo "Choisissez un personnage : \n";
        for ($i = 0; $i < count($liste); $i++) {        //for loop to display the character available 
            echo ($i + 1) . ". " . $liste[$i]->getNom() . "\n";     
        }

        $choix = readline("Votre choix (1/2/3): ");         //choice of the character
        echo "--------------------------------------------------\n";
        switch ($choix) {       //condition to display the character chosen
            case 1:
                echo "Vous avez choisi " . $liste[$choix - 1]->getNom() . "\n";
                echo "--------------------------------------------------\n";
                return $liste[$choix - 1];
            case 2:
                echo "Vous avez choisi " . $liste[$choix - 1]->getNom() . "\n";
                echo "--------------------------------------------------\n";
                return $liste[$choix - 1];
            case 3:
                echo "Vous avez choisi " . $liste[$choix - 1]->getNom() . "\n";
                echo "--------------------------------------------------\n";
                return $liste[$choix - 1];
        }
    }

    //method to save the game
    public function sauvegarder() {
        $saveHero = serialize($this->heros);
        $saveVillain = serialize($this->vilains);

        file_put_contents('saveH.txt', $saveHero);
        file_put_contents('saveV.txt', $saveVillain);

        echo "Partie sauvegardée\n";
        echo "Au revoir\n";

        exit;
    }

    //method to load the game
    public function chargerSauvegarde() {
        
        $saveHero = file_get_contents('saveH.txt');
        $saveVilain = file_get_contents('saveV.txt');

        $this->heros = unserialize($saveHero);
        $this->vilains = unserialize($saveVilain);

        echo "Partie chargée\n";
        $this->jouer();
    }

    //method to start the game
    public function startGame() {
        echo "--------------------------------------------------\n";
        echo "Bienvenue dans le jeu de combat DBZ !\n";
        echo "--------------------------------------------------\n";

        //choose to start a new game or load a game
        echo "1. Nouvelle partie\n";
        echo "2. Charger partie\n";
        echo "--------------------------------------------------\n";
        $choixGame = readline("Votre choix (1/2): ");
        echo "--------------------------------------------------\n";
        switch ($choixGame) {       //condition to start a new game or load a game
                case 1:
                    echo "Vous avez choisi de commencer une nouvelle partie.\n";
                    echo "--------------------------------------------------\n";
                    $this->jouer();     //call of the method jouer
                    break;
                    
                case 2:
                    echo "Vous avez choisi de charger une partie.\n";
                    echo "--------------------------------------------------\n";
                    $this->chargerSauvegarde();     //call of the method chargerSauvegarde
                    break;

        }

    } 

    //method to play
    public function jouer() {

        $hero = $this->choisirPersonnage($this->heros);     //call of the method choisirPersonnage
            
                    //function to choose a random vilain
                    $vilain = $this->vilains[array_rand($this->vilains)];       
    
                    $this->nbrVictoires = 0;    //set the number of victories to 0
                    while ($this->nbrVictoires < 10) {      //while loop to fight until the hero has 10 victories
                        echo "Que voulez-vous faire ?\n";
                        echo "--------------------------------------------------\n";
                        echo "1. Combattre\n";
                        echo "2. Voir ses stats\n";
                        echo "3. Sauvegarder et quitter\n";
                        echo "--------------------------------------------------\n";
    
                        $choixJoueur = readline("Votre choix (1/2/3): ");
                        echo "--------------------------------------------------\n";


                switch ($choixJoueur) {     //condition to fight, see the stats or save and quit
                    case 1:     //fight
                        echo "Vous avez choisi de combattre.\n";
                        $this->combattre($hero, $vilain);    //call of the method combattre

                        if ($vilain->estMort()) {       //condition if the vilain is dead
                            $this->nbrVictoires++;    //increase the number of victories
                            echo "Nombre de victoires : " . $this->nbrVictoires . "\n";     
                            echo "--------------------------------------------------\n";
                            $vilain->heal(); // Heal the vilain

                            if ($this->nbrVictoires < 10) {     //condition if the number of victories is less than 10
                                $choix = readline("Voulez-vous combattre à nouveau ? (o/n) : ");    //choice of the user
                                echo "--------------------------------------------------\n";

                                if ($choix == "n") {    //condition if the user doesn't want to fight again
                                    echo "Vous avez choisi de quitter.\n";
                                    echo "--------------------------------------------------\n";
                                    break; //exit the fight loop
                                } else if ($choix == "o"){  //condition if the user wants to fight again
                                    echo "Vous avez choisi de continuer.\n";
                                    echo "--------------------------------------------------\n";
                                    //we check if the number of victories is less than 10
                                    if ($this->nbrVictoires !== 10) {       //si il est bien inférieur on demande si l'utilisateur veut changer de héros
                                    $choix = readline("Voulez-vous changer de héros ? (o/n) : ");

                                        if ($choix == "o") {    //condition if the user wants to change the hero
                                            echo "Vous avez choisi de changer de héros.\n";
                                            echo "--------------------------------------------------\n";
                                            $hero = $this->choisirPersonnage($this->heros); //we call the method choisirPersonnage to choose a new hero
                                        } else {    //condition if the user doesn't want to change the hero
                                            echo "Vous avez choisi de garder le même héros.\n";
                                            echo "--------------------------------------------------\n";
                                        }
                                    }
                                }
                            $vilain = $this->vilains[array_rand($this->vilains)]; //we choose a new random vilain

                            } elseif ($hero->estMort()) {       //condition if the hero is dead
                                echo "Votre héros " . $hero->getNom() . " est mort !\n";
                                echo "Vous avez perdu !\n";
                                echo "--------------------------------------------------\n";
                                break; //exit the fight loop
                        }
                    }
                        break;
                    case 2:     //see the stats
                        echo "Vous avez choisi de voir les stats.\n";
                        echo "--------------------------------------------------\n";
                        foreach ($this->heros as $hero) {       //for loop to display the stats of each hero
                            $hero->afficherStats();
                        } 
                        break;
                    case 3:    //save and quit
                        echo "Vous avez choisi de sauvegarder et quitter.\n";
                        echo "--------------------------------------------------\n";
                        $this->sauvegarder();   //call of the method sauvegarder
                        $this->startGame();    //call of the method startGame
                        break;
                }
            }    
            
            echo "Bravo vous avez fini le jeu !\n";
            echo "--------------------------------------------------\n";
        
    }
}      

//creation of the heros
$goku = new Hero("Goku", 1, 100, 20);
$vegeta = new Hero("Vegeta", 1, 100, 20);
$picollo = new Hero("Picollo", 1, 100, 20);

//creation of the list of the characters
$listeHeros = [$goku, $vegeta, $picollo];

//creation of the vilains
$freezer = new Vilain("Freezer", 1, 100, 20);
$cell = new Vilain("Cell", 1, 100, 20);
$buu = new Vilain("Buu", 1, 100, 20);

//creation of the list of the vilains
$listeVilains = [$freezer, $cell, $buu];

//creation of the game
$game = new Game($listeHeros, $listeVilains);
//call of the method startGame
$game->startGame();
?>