<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Fiche_Frais;
use App\Models\Ligne_Frais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FicheFraisController extends Controller
{
    public function show(){

        $ficheFrais = new Fiche_Frais();
        $uneFiche = Fiche_Frais::where('Date','1999-08-30')->where('Identifiant','adtdyganed')->get();

        $desFiches = Fiche_Frais::where('Identifiant','opbgyupnrb')->get();

        if(count($uneFiche) == 1){
            $ficheFrais = $uneFiche[0];
        }
        

        $desLigneFrais = Ligne_Frais::where('Date','1999-08-30')->where('Identifiant','adtdyganed')->get();

        $desUsers = User::all('Identifiant');
        $desIdentifiant = [];
        foreach($desUsers as $user){
            array_push($desIdentifiant, $user->Identifiant);
        }

        return view('Fiche_Frais')
            ->with('ficheFrais', $ficheFrais)
            ->with('desLigneFrais', $desLigneFrais)
            ->with('desIdentifiant', $desIdentifiant)
            ->with('desFiches', $desFiches) ;
    }

    public function insert(){
        return view('User');
    }

    public function delete(){

        
    }

    public function update(){

        
    }
}
