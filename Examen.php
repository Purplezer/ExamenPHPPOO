<?php

class Personnage {
    protected $nom;
    protected $niveauPuissance;
    protected $pointsDeVie;
    protected $atq;
    protected $def;

    protected $nbrWin = 0;

    public function __construct($nom, $niveauPuissance, $pointsDeVie, $atq, $def) {
        $this->nom = $nom;
        $this->niveauPuissance = $niveauPuissance;
        // TODO methode pour niveau de puissance ?
        $this->pointsDeVie = $pointsDeVie;
        $this->atq = $atq;
        $this->def = $def;
        // $this->nbrWin = 0;
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
        echo "Nom : " . $this->nom . ", Niveau de puissance : " . $this->niveauPuissance . ", Points de vie : " . $this->pointsDeVie . ", Points d'attaque : " . $this->atq . ", Points de défense : " . $this->def . "\n";
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
        // $this->def += 5;
    }

    //Methode pour compter le nbr de victoire
    public function nbrWin() {
        $this->nbrWin++;
        echo "Vous avez gagné " . $this->nbrWin . " fois.\n";
        return $this->nbrWin;
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

    public function getDef() {
        return $this->def;
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
}

class Hero extends Personnage {
    public function attaquer($ennemi) {
        $attaquesDispo = ["Coup de poing"];

        if ($this->getNiveauPuissance() >= 2) {
            $attaquesDispo = ["Coup de poing", "Kamehameha"];
        } elseif ($this->getNiveauPuissance() == 5) {
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

        // if ($this->getNiveauPuissance() == 2) {
        //     $attaquesDispo = ["Coup de poing", "Kamehameha"];
        // } elseif ($this->getNiveauPuissance() == 5) {
        //     $attaquesDispo = ["Coup de poing", "Kamehameha"];
        // }

        // vraiment besoin de l'attaque pour les vilains?
    }

    public function augmenterNiveauPuissance() {
        $this->niveauPuissance++;
        $this->heal();
        $this->pointsDeVie += $this->pointsDeVie * 0.5;
        $this->atq += $this->atq * 0.5;
        // echo "Le vilain est monté au niveau " . $this->niveauPuissance . " de puissance.\n";
        // $this->def += 5;
    }
}

class Game {
    private $heros;
    private $vilains;

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

    public function jouer() {

        $hero = $this->choisirPersonnage($this->heros);
        // $vilain = $this->choisirPersonnage($this->vilains);
        $vilain = $this->vilains[array_rand($this->vilains)];
        // fonction aleatoir pour enemie ?

        // $this->combattre($hero, $vilain);
        // TODO petite boucle pour faire un autre combat tant que le nombre de victoire est inferieur a 10
        $nbrVictoires = 0; // Variable pour suivre le nombre de victoires

    while ($nbrVictoires < 10) {
        $this->combattre($hero, $vilain);
        if ($vilain->estMort()) {
            $nbrVictoires++;
            echo "Nombre de victoires : " . $nbrVictoires . "\n";
            $vilain->augmenterNiveauPuissance(); // On soigne le vilain
            $vilain = $this->vilains[array_rand($this->vilains)]; // On change de vilain
            // $vilain->setNiveauPuissance(1); // Remettez le niveau du vilain à 1 après chaque victoire
            }
        }
        echo "Bravo vous avez fini le jeu !\n";
    } 
    
        
}

$goku = new Hero("Goku", 1, 100, 20, 10);
$vegeta = new Hero("Vegeta", 1, 100, 20, 10);
$picollo = new Hero("Picollo", 1, 100, 20, 10);

$listeHeros = [$goku, $vegeta, $picollo];

$freezer = new Vilain("Freezer", 1, 100, 20, 10);
$cell = new Vilain("Cell", 1, 100, 20, 10);
$buu = new Vilain("Buu", 1, 100, 20, 10);

$listeVilains = [$freezer, $cell, $buu];

$game = new Game($listeHeros, $listeVilains);
$game->jouer();
?>