<?php

namespace App\Observers;

use App\Models\note;
use App\Models\Moyenne;
use App\Models\Eleve;
use App\Models\Filiere;

use Illuminate\Support\Arr;

class noteObserver
{
    
    public function created(note $note)
    {
        $poidsTotal = 0 ;
        $noteTotal = 0;
        $notes = note::where('eleve_id' , $note->eleve_id)->get();
        $filiereAP = Filiere::where('designation' , "AP")->first();
        foreach ($notes as $n){
           $poidsTotal =  $n->Element_module['poids'] +  $poidsTotal;
        } 
        if($poidsTotal == 2){
            foreach ($notes as $n){
                $noteTotal =  $n->Element_module['poids'] * $n->note +  $noteTotal;
             } 
            $moyenne = new Moyenne; 
            $moyenne->filiere_id = $note->Eleve['filiere_id'];
            $moyenne->eleve_id = $note->Eleve['id'];
            $moyenne->niveau =  $note->Eleve['niveau'];
            $moyenne->moyenne = $noteTotal/2 ;;
            $eleve = Eleve::where('id' , $note->eleve_id)->first();
            if($eleve &&  $moyenne->moyenne > 12){
                if($eleve->filiere_id ==  $filiereAP->id && $eleve->niveau == '1') $eleve->niveau = '2';
                elseif ($eleve->filiere_id == $filiereAP->id && $eleve->niveau == '2') {
                    /*ici on va definir une fonction qui affecter d'une maniere aleatoire une filiere pour chaque etudiant 
                    qui a bien passee la 2eme annee du  cyle prepa ; biesure on va redefinir cette fonction plus tard ;)  */
                    $Filieres = [1, 2 , 3, 4, 5];
                    $randomFiliere = Arr::random($Filieres);
                    $eleve->filiere_id = $randomFiliere ;
                    $eleve->niveau = '1';
                }
                elseif ($eleve->filiere_id != $filiereAP->id && $eleve->niveau < 3 ) {
                    $eleve->niveau++;
                }
            }
            $eleve->save();
            $moyenne->save();
        }
    
    }
    public function updated(note $note)
    {

        $moyenne = Moyenne::where('eleve_id' , $note->eleve_id)->first();
        $filiereAP = Filiere::where('designation' , "AP")->first();
        if($moyenne){
            $noteTotal = 0;
            $notes = note::where('eleve_id' , $note->eleve_id)->get();
            $filiereAP = Filiere::where('designation' , 'AP')->first();

                foreach ($notes as $n){
                    $noteTotal =  $n->Element_module['poids'] * $n->note +  $noteTotal;
                 } 
                $moyenne->filiere_id = $note->Eleve['filiere_id'];
                $moyenne->eleve_id = $note->Eleve['id'];
                $moyenne->niveau =  $note->Eleve['niveau'];
                $oldMoyenne = $moyenne->moyenne  ; 

                //on va garder l'ancien valeur de la moyenne pour teste ts les possinlitees entre l 'antien valeur et la nouvelle valeur
                $moyenne->moyenne = $noteTotal/2 ;
                $moyenne->update();
                $eleve = Eleve::where('id' , $note->eleve_id)->first();

                //si l'eleve a reussi apres la modification
                if( $eleve && $moyenne->moyenne >= 12 && $oldMoyenne < 12){
                    if($eleve->filiere_id ==  $filiereAP->id && $eleve->niveau == '1') $eleve->niveau == '2';
                    elseif ($eleve->filiere_id ==  $filiereAP->id && $eleve->niveau == '2') {
                        /*ici on va definir une fonction qui affecter d'une maniere aleatoire une filiere pour chaque etudiant 
                        qui a bien passee la 2eme annee du  cyle prepa ; biesure on va redefinir cette fonction plus tard ;)  */
                        $Filieres = [1, 2 , 3, 4, 5];
                        $randomFiliere = Arr::random($Filieres);
                        $eleve->filiere_id = $randomFiliere ;
                        $eleve->niveau = '1';
                    }
                    elseif ($eleve->filiere_id !=  $filiereAP->id  || $eleve->niveau < 3 ) {
                        $eleve->niveau++;
                    }
                    $eleve->save();
                }

                //si l'eleve va redoubler apres la modification 
                if( $eleve && $moyenne->moyenne < 12 && $oldMoyenne >= 12){
                    if($eleve->niveau > 1) $eleve->niveau--;
                    else{
                        
                        $eleve->niveau = '2';
                        $eleve->filiere_id = $filiereAP->id ;
                    }
                    $eleve->save();

                }
            }
    }


    public function deleted(note $note)
    {
        $moyenne = Moyenne::where('eleve_id' , $note->eleve_id)->first();
        $filiereAP = Filiere::where('designation' , 'AP')->first();

        //si une personne a passee a l'annee suivante alors il doit revenir a l'annee d'origine;
        if($moyenne){
            $eleve = Eleve::where('id' , $note->eleve_id)->first();
            if( $eleve && $moyenne->moyenne >= 12){
                if($eleve->niveau > 1) $eleve->niveau--;
                else{
                    
                    $eleve->niveau = '2';
                    $eleve->filiere_id = $filiereAP->id ;
                }
                $eleve->save();

            }
            $moyenne->delete();
        }
    }
 
    public function restored(note $note)
    {
        //
    }
}
