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
    
    // Méthodes spécifiques aux héros
    // public function Attaquer() {
    //     $attaques = ["Coup de poing","Kamehameha", "Genkidama"];
    //     $newAttaques = ["Kamehameha", "Genkidama"];

    //     echo "Que voulez-vous faire ? \n";
    //     $i = 1;
    //     foreach ($attaques as $attaque) {
    //         echo "$i." . $attaque . ".\n";
    //         $i++;
    //     }
    // }

    // public function Defense() {
        
    // }


}

class Vilain extends Personnage {
    public function __construct($nom, $niveauPuissance, $pointsDeVie, $atq, $def) {
        parent::__construct($nom, $niveauPuissance, $pointsDeVie, $atq, $def);
    }

    // Méthodes spécifiques aux méchants
}


$goku = new Hero("Goku", 1, 100, 20, 10);
$vegeta = new Hero("Vegeta", 1, 100, 20, 10);
$picollo = new Hero("Piccolo", 1, 100, 20, 10);

$listeHeros = [$goku, $vegeta, $picollo];

$freezer = new Vilain ("Freezer", 1, 100, 20, 10);
$cell = new Vilain ("Cell", 1, 100, 20, 10);
$buu = new Vilain ("Buu", 1, 100, 20, 10);

$listeVilains = [$freezer, $cell, $buu];



// function listerHeros($listeHeros) {
//     $heros = array_filter($listeHeros, function($personnage) {
//         return $personnage instanceof Hero;
//     });

//     foreach ($heros as $hero) {
//         echo "Nom : " . $hero->nom . ", Niveau de puissance : " . $hero->niveauPuissance . ", Points de vie : " . $hero->pointsDeVie . ", Points d'attaque :" . $hero->atq . ", Points de défense :" . $hero->def . "\n";
        
//     }
// }

// listerHeros($listeHeros);


?>