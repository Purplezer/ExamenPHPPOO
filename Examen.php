<?php

class Personnage {
    protected $nom;
    protected $niveauPuissance;
    protected $pointsDeVie;
    protected $atq;

    public function __construct($nom, $niveauPuissance, $pointsDeVie, $atq) {
        $this->nom = $nom;
        $this->niveauPuissance = $niveauPuissance;
        $this->pointsDeVie = $pointsDeVie;
        $this->atq = $atq;

    }

    public function attaquer($ennemi) {
        $degats = $this->atq;
        echo $this->nom . " attaque " . $ennemi->nom . " pour " . $degats . " points de dégâts.\n";
        $ennemi->recevoirDegats($degats);
    }

    public function recevoirDegats($degats) {
        // TODO petit calul pour la defense
        $this->pointsDeVie -= $degats;

        if ($this->pointsDeVie <= 0) {
            echo $this->nom . " a été vaincu !\n";
        } else {
            echo $this->nom . " a " . $this->pointsDeVie . " points de vie restants.\n";
        }
    }

    // isDie?
    public function estMort() {
        return $this->pointsDeVie <= 0;
    }

    public function afficherStats() {
        echo "Nom : " . $this->nom . ", Niveau de puissance : " . $this->niveauPuissance . ", Points de vie : " . $this->pointsDeVie . ", Points d'attaque : " . $this->atq . ".\n";
    }

    // Methode Heal a la fin du combat
    public function getPointsDeVieMax() {
        return 100;
    }

    public function heal() {
        $this->pointsDeVie = $this->getPointsDeVieMax();

    }

    


    // Methode niveau de puissance

    public function augmenterNiveauPuissance() {

        $this->niveauPuissance++;
        //appel de la function heal
        $this->heal();
        $this->pointsDeVie += $this->pointsDeVie * 0.5;
        $this->atq += $this->atq * 0.5;
        echo "Vous êtes monter au niveau " . $this->niveauPuissance . " de puissance.\n";

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


}

class Hero extends Personnage {
    public function attaquer($ennemi) {
        $attaquesDispo = ["Coup de poing"];

        if ($this->getNiveauPuissance() >= 2) {
            $attaquesDispo = ["Coup de poing", "Kamehameha"];
        } elseif ($this->getNiveauPuissance() >= 5) {
            $attaquesDispo = ["Coup de poing", "Kamehameha", "Genkidama"];
        }

        foreach ($attaquesDispo as $key => $attaque) {
            echo ($key + 1) . ". " . $attaque . "\n";
        }

        $choixAttaque = readline("Votre choix (1/2/3): ");

        // change l'attaque de facon dynamique en fonction du choix du tour
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
        parent::attaquer($ennemi);
    }
}

class Vilain extends Personnage {
    public function attaquer($ennemi) {
        parent::attaquer($ennemi);

    }

    public function augmenterNiveauPuissance() {
        $this->niveauPuissance++;
        $this->heal();
        $this->pointsDeVie += $this->pointsDeVie * 0.2;
        $this->atq += $this->atq * 0.2;

    }
}

class Game {
    private $heros;
    private $vilains;

    private $nbrVictoires = 0; // Variable pour suivre le nombre de victoires

    public function __construct($heros, $vilains) {
        $this->heros = $heros;
        $this->vilains = $vilains;
    }

    public function combattre($hero, $vilain) {
        

        echo "Un combat commence entre " . $hero->getNom() . " et " . $vilain->getNom() . "!\n";

        // la demande de l'attaque se fait dans la classe Hero pour que l'attaque soit commune au deux, l'attaque est change avant l'action d'attaque sur l'adversaire
        while (!$hero->estMort() && !$vilain->estMort()) {
            $hero->attaquer($vilain);
            if (!$vilain->estMort()) {
                $vilain->attaquer($hero);
            } 
        }
        
        echo "Le combat est terminé!\n";
        // Condition pour augmenter le niveau de puissance et le nbr de victoire
        if ($vilain->estMort()) {   
            $hero->augmenterNiveauPuissance();
            

            // $hero->nbrWin();
        }

        $hero->afficherStats();
        $vilain->afficherStats();
    }

    public function choisirPersonnage($liste) {
        echo "Choisissez un personnage : \n";
        for ($i = 0; $i < count($liste); $i++) {
            echo ($i + 1) . ". " . $liste[$i]->getNom() . "\n";
        }

        $choix = readline("Votre choix (1/2/3): ");
        switch ($choix) {
            case 1:
                echo "Vous avez choisi " . $liste[$choix - 1]->getNom() . "\n";
                return $liste[$choix - 1];
            case 2:
                echo "Vous avez choisi " . $liste[$choix - 1]->getNom() . "\n";
                return $liste[$choix - 1];
            case 3:
                echo "Vous avez choisi " . $liste[$choix - 1]->getNom() . "\n";
                return $liste[$choix - 1];
        }
    }

    public function sauvegarder() {

    }

    public function chargerSauvegarde() {
    }

    public function startGame() {
        echo "-------------------------------------\n";
        echo "Bienvenue dans le jeu de combat DBZ !\n";
        echo "-------------------------------------\n";

        //Choisir nouvelle partie ou charger la partie
        echo "1. Nouvelle partie\n";
        echo "2. Charger partie\n";
        $choixGame = readline("Votre choix (1/2): ");
        switch ($choixGame) {
                case 1:
                    echo "Vous avez choisi de commencer une nouvelle partie.\n";
                    $this->jouer();
                    break;
                    
                case 2:
                    echo "Vous avez choisi de charger une partie.\n";
                    $this->chargerSauvegarde();
                    break;

        }

    } 

    public function jouer() {

        $hero = $this->choisirPersonnage($this->heros);
            
                    //fonction aléatoire pour choisir un ennemie
                    $vilain = $this->vilains[array_rand($this->vilains)];
    
                    $this->nbrVictoires = 0;
                    while ($this->nbrVictoires < 10) {
                        echo "Que voulez-vous faire ?\n";
                        echo "1. Combattre\n";
                        echo "2. Voir ses stats\n";
                        echo "3. Sauvegarder et quitter\n";
    
                        $choixJoueur = readline("Votre choix (1/2/3): ");


                switch ($choixJoueur) {
                    case 1: 
                        echo "Vous avez choisi de combattre.\n";
                        $this->combattre($hero, $vilain);

                        if ($vilain->estMort()) {
                            $this->nbrVictoires++;
                            echo "Nombre de victoires : " . $this->nbrVictoires . "\n";
                            $vilain->heal(); // On soigne le vilain

                            if ($this->nbrVictoires < 10) {
                                $choix = readline("Voulez-vous combattre à nouveau ? (o/n) : ");

                                if ($choix == "n") {
                                    echo "Vous avez choisi de quitter.\n";
                                    break; // Quitte la boucle de combats
                                } else if ($choix == "o"){
                                    echo "Vous avez choisi de continuer.\n";
                                    //On vérifie si le nbr de victoire est inférieur a 10
                                    if ($this->nbrVictoires !== 10) {       //si il est bien inférieur on demande si l'utilisateur veut changer de héros
                                    $choix = readline("Voulez-vous changer de héros ? (o/n) : ");

                                        if ($choix == "o") {
                                            echo "Vous avez choisi de changer de héros.\n";
                                            $hero = $this->choisirPersonnage($this->heros); // On change de héros
                                        } else {
                                            echo "Vous avez choisi de garder le même héros.\n";
                                        }
                                    }
                                }
                            $vilain = $this->vilains[array_rand($this->vilains)]; // On change de vilain

                            } elseif ($hero->estMort()) {
                                echo "Votre héros " . $hero->getNom() . " est mort !\n";
                                echo "Vous avez perdu !\n";
                                break; // Quitte la boucle de combats
                        }
                    }
                        break;
                    case 2:
                        echo "Vous avez choisi de voir les stats.\n";
                        $hero->afficherStats();
                        break;
                    case 3:
                        echo "Vous avez choisi de sauvegarder et quitter.\n";
                        $this->sauvegarder();
                        return; // Sort de la fonction jouer
                }
            }    
            
            echo "Bravo vous avez fini le jeu !\n";
        
    }
}      


$goku = new Hero("Goku", 1, 100, 20);
$vegeta = new Hero("Vegeta", 1, 100, 20);
$picollo = new Hero("Picollo", 1, 100, 20);

$listeHeros = [$goku, $vegeta, $picollo];

$freezer = new Vilain("Freezer", 1, 100, 20);
$cell = new Vilain("Cell", 1, 100, 20);
$buu = new Vilain("Buu", 1, 100, 20);

$listeVilains = [$freezer, $cell, $buu];

$game = new Game($listeHeros, $listeVilains);
$game->startGame();
?>