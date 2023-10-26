<?php


class Personnage {
    public $nom;
    public $niveauPuissance;
    public $pointsDeVie;
    public $atq;
    public $def;
    public function __construct($nom, $niveauPuissance, $pointsDeVie, $atq, $def) {
        $this->nom = $nom;
        $this->niveauPuissance = $niveauPuissance;
        $this->pointsDeVie = $pointsDeVie;
        $this->atq = $atq;
        $this->def = $def;
    }

}

class Hero extends Personnage {
    public function __construct($nom, $niveauPuissance, $pointsDeVie, $atq, $def) {
        parent::__construct($nom, $niveauPuissance, $pointsDeVie, $atq, $def);
    }


    //GETTERS

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

    public function setPointsDeVie($pointsDeVie) { 
        $this->pointsDeVie = $pointsDeVie;
        return $this;
    }

    public function setAtq($atq) {
        $this->atq = $atq;
        return $this;
    }

    public function setDef($def) {
        $this->def = $def;
        return $this;
    }


    public function Attaquer() {

        echo "Vous avez choisi d'attaquer.\n";
        echo "Que voulez-vous faire ?\n";

        $attaquesDispo = ["Coup de poing"];
        

        if ($this->getNiveauPuissance() == 2) {
            $attaquesDispo = ["Coup de poing", "Kamehameha"];
        } else if ($this->getNiveauPuissance() == 5) {
            $attaquesDispo = ["Coup de poing", "Kamehameha", "Genkidama"];
        }

        foreach ($attaquesDispo as $key => $attaque) {
            echo ($key + 1) . ". " . $attaque . "\n";
        }

        $choixAttaque = readline("Votre choix (1/2/3): ");
        switch ($choixAttaque) {
            case 1:
                echo "Vous avez choisi " . $attaquesDispo[0] . "\n";
                $degats = $this->getAtq() * 1;
                echo "Vous avez infligé " . $degats . " points de dégats.\n";
                break;
            case 2:
                echo "Vous avez choisi " . $attaquesDispo[1] . "\n";
                $degats = $this->getAtq() * 2;
                echo "Vous avez infligé " . $degats . " points de dégats.\n";
                break;
            case 3:
                echo "Vous avez choisi " . $attaquesDispo[2] . "\n";
                $degats = $this->getAtq() * 3;
                echo "Vous avez infligé " . $degats . " points de dégats.\n";
                break;
            default:
                echo "Vous n'avez pas choisi d'attaque.\n";
                return $this->Attaquer();
        }
    }
 
    


}

class Vilain extends Personnage {
    public function __construct($nom, $niveauPuissance, $pointsDeVie, $atq, $def) {
        parent::__construct($nom, $niveauPuissance, $pointsDeVie, $atq, $def);
    }

    //GETTERS
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

    // Méthodes spécifiques aux méchants
    public function attaqueEnnemie() {
        $attaquesDispo = ["Coup de poing"];
        

        if ($this->getNiveauPuissance() == 2) {
            $attaquesDispo = ["Coup de poing", "Kienzan"];
        } else if ($this->getNiveauPuissance() == 5) {
            $attaquesDispo = ["Coup de poing", "Kienzan", "Death Beam"];
        }


        $attaqueE = rand(1,3);

        switch ($attaqueE) {
            case 1:
                echo $this->getNom() . " a lancé " . $attaquesDispo[0] . "\n";
                $degats = $this->getAtq() * 1;
                echo $this->getNom() . " a infligé " . $degats . " points de dégats.\n";
                break;
            case 2:
                echo $this->getNom() . " a lancé " . $attaquesDispo[1] . "\n";
                $degats = $this->getAtq() * 2;
                echo $this->getNom() . " a infligé " . $degats . " points de dégats.\n";
                break;
            case 3:
                echo $this->getNom() . " a lancé " . $attaquesDispo[2] . "\n";
                $degats = $this->getAtq() * 3;
                echo $this->getNom() . " a infligé " . $degats . " points de dégats.\n";
                break;
            
        }
    }
}


class Game {

    private $perso;

    private $ennemi;
    private $listeHeros;

    private $listeVilains;

    public function __construct($listeHeros, $listeVilains) {
        $this->listeHeros = $listeHeros;
        $this->listeVilains = $listeVilains;
        $this->perso = null;

    }

    public function choixPerso() {
        echo "Choisissez votre personnage : \n";
        $i = 1;
        foreach ($this->listeHeros as $hero) {
            echo "$i." . $hero->nom . "\n";
            $i++;
        }

        $choixPerso = readline("Votre choix (1/2/3): ");
        switch ($choixPerso) {
            case 1:
                echo "Vous avez choisi " . $this->listeHeros[0]->nom . "\n";
                $this->perso = $this->listeHeros[0];
                // echo $this->perso->nom;
                break;
            case 2:
                echo "Vous avez choisi " . $this->listeHeros[1]->nom . "\n";
                $this->perso = $this->listeHeros[1];
                break;
            case 3:
                echo "Vous avez choisi " . $this->listeHeros[2]->nom . "\n";
                $this->perso = $this->listeHeros[2];
                break;
            default:
                echo "Vous n'avez pas choisi de personnage.\n";
                return $this->choixPerso();
        }
    }


    public function Combat() {

        $ennemi = $this->listeVilains[rand(0,2)];

        echo "Le combat commence !\n";
        echo "C'est au tour de " . $this->perso->nom . " d'agir.\n";
        $this->perso->Attaquer();
            // Vous pouvez ajouter ici la logique pour gérer les attaques des héros contre les vilains

        


        // Logique pour gérer les attaques des vilains contre les héros si nécessaire
        echo "C'est au tour de " . $ennemi->nom . " d'agir.\n";
        $ennemi->attaqueEnnemie();


        echo "Le combat est terminé !\n";
    }
    public function showStats($listeHeros) {
        $heros = array_filter($listeHeros, function($personnage) {
            return $personnage instanceof Hero;
        });
    
        foreach ($heros as $hero) {
            echo "Nom : " . $hero->nom . ", Niveau de puissance : " . $hero->niveauPuissance . ", Points de vie : " . $hero->pointsDeVie . ", Points d'attaque :" . $hero->atq . ", Points de défense :" . $hero->def . "\n";
            
        }
    }

    public function Save() {

    }

    public function Win() {
        
    }

    
}

$goku = new Hero("Goku", 1, 100, 20, 10);
$vegeta = new Hero("Vegeta", 1, 100, 20, 10);
$picollo = new Hero("Piccolo", 1, 100, 20, 10);

$listeHeros = [$goku, $vegeta, $picollo];

$freezer = new Vilain ("Freezer", 1, 100, 20, 10);
$cell = new Vilain ("Cell", 1, 100, 20, 10);
$buu = new Vilain ("Buu", 1, 100, 20, 10);

$listeVilains = [$freezer, $cell, $buu];

$game = new Game($listeHeros, $listeVilains);
$game->choixPerso();
$game->Combat();

// $game->showStats($listeHeros);




// listerHeros($listeHeros);


?>