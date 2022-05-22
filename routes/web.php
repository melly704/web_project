<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\RegisterController; 
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\CoursController; 
use App\Http\Controllers\EtudiantController; 
use App\Http\Controllers\SeanceController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| php artisan db:seed (pour peupler la base de données).
| Vous trouverez des commentaires indiquant le numéro de la question traitée.
| 
|
*/

//page principale
Route::get('/', function () {
    return view('welcome');
})-> name('welcome'); 

//les routes de connexion/deconnexion et enregistrement

Route::get('/login', [AuthController::class,'showForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::get('/logout', [AuthController::class,'logout']) ->name('logout')->middleware('auth');

//Partie 1: Création utilisatuers:
    //3.1.1 création du compte
    Route::get('/register', [RegisterController::class,'showForm']) ->name('register');
    Route::post('/register', [RegisterController::class,'store']); 

    //3.1.2 et 3.1.3 changement du mot de passe ou de nom/prénom pour gestionnaire/enseignant

    Route::get('/profile/edit', [ProfileController::class, 'edit'])-> middleware('auth') ->name('profile.edit'); 
    Route::post('/profile/edit', [ProfileController::class, 'update'])-> middleware('auth') -> name('profile.update'); 

    //4.1.2 
        //Récupèrer la liste des users pour MAJ type
        Route::get('users/index', [UserController::class, 'index'])-> middleware('is_admin')-> name('user.index'); 
        //acceptation d'un utilisateur auto-créé
        Route::get('user/edit/{id}', [UserController::class, 'edit_type'])-> middleware('is_admin')-> name('user.edit'); 
        Route::post('user/edit/{id}', [UserController::class, 'update_type']) -> middleware('is_admin') -> name('user.update'); 
        //Refus d'un utilisateur auto-créé
        Route::get('user/deny/{id}', [UserController::class, 'deny']) -> middleware('is_admin') -> name('user.deny'); 
    //4.1.3 Création d'un utilisateur
    Route::get('user/create', [UserController::class, 'create'])-> middleware('is_admin') -> name('user.create'); 
    Route::post('user/create', [UserController::class, 'store'])-> middleware('is_admin') -> name('user.store'); 
//Partie 2: Ajouts
    //4.2.1 Création d'un cours
    Route::get('cours/create', [CoursController::class, 'create'])-> middleware('is_admin') -> name('cours.create'); 
    Route::post('cours/create', [CoursController::class, 'store'])-> middleware('is_admin') -> name('cours.store'); 
    //4.2.2 liste des cours
    Route::get('cours/index', [CoursController::class, 'index']) -> name('cours.index')-> middleware('auth'); 
    //2.1.1 Ajout d'un étudiant
    Route::get('etudiant/create', [EtudiantController::class, 'create'])-> middleware('is_gestionnaire') -> name('etudiant.create'); 
    Route::post('etudiant/create', [EtudiantController::class, 'store'])-> middleware('is_gestionnaire') -> name('etudiant.store'); 
    //Création d'une nouvelle séance de cours
    Route::get('seance/create/{cours_id}', [SeanceController::class, 'create'])-> middleware('is_gestionnaire') -> name('seance.create'); 
    Route::post('seance/create/{cours_id}', [SeanceController::class, 'store'])-> middleware('is_gestionnaire') -> name('seance.store'); 
//Partie 3: inscriptions
    //2.3.1 associer des étudiants au cours
    Route::get('etudiant/inscription/{cours_id}',[EtudiantController::class, 'inscription'])->middleware('is_gestionnaire') -> name('etudiant.inscription'); 
    Route::get('etudiant/inscription/{etudiant_id}/{cours_id}',[EtudiantController::class, 'etudiant_cours']) -> middleware('is_gestionnaire') -> name('etudiant.cours');
    //2.3.2 Supprimer l'association d'un étudiant du cours
    Route::get('etudiant/detach/{etudiant_id}/{cours_id}', [EtudiantController::class, 'etudiant_detach']) -> middleware('is_gestionnaire')-> name('etudiant.detach'); 
    //2.3.3 Liste des étudiants associés à un cours
    Route::get('etudiants/cours/{cours_id}', [EtudiantController::class, 'index'])-> middleware('auth') -> middleware('is_gestionnaire_or_teacher') -> name('etudiant.index');
    //2.4.1 Associer des enseignants au cours.
    Route::get('enseignant/cours/{cours_id}', [UserController::class, 'enseignant_inscription'])-> middleware('is_gestionnaire')-> name('enseignant.inscription'); 
    Route::get('enseignant/cours/{enseignant_id}/{cours_id}',[UserController::class, 'enseignant_cours']) -> middleware('is_gestionnaire') -> name('enseignant.cours');
    //2.4.2  Supprimer l’association d'un enseignant du cours
    Route::get('enseignant/detach/{enseignant_id}/{cours_id}', [UserController::class, 'enseignant_dettach'])-> middleware('is_gestionnaire')-> name('enseignant.dettach');
    //2.4.3  Liste des enseignants associés à un cours
    Route::get('enseigants/cours/{cours_id}', [UserController::class, 'index_enseignant']) -> middleware('is_gestionnaire') -> name('enseignant.index');

//Partie 4: pointage
    //1.1 Voir la liste des cours associée pour un enseignant
    Route::get('cours/enseignant', [CoursController::class, 'cours_enseignant'])-> middleware('is_teacher')->name('cours.enseignant');
    //1.2.1 Liste des inscrits dans un cours
    Route::get('etudiants/cours/{cours_id}', [EtudiantController::class, 'index']) -> name('etudiant.index');
     //1.2.2 Pointage d'un étudiant pour la séance
    Route::get('etudiant/present/{etudiant_id}/{cours_id}', [EtudiantController::class, 'presence'])-> middleware('is_teacher')-> name('etudiant.present');
    Route::post('etudiant/present/{etudiant_id}/{cours_id}', [EtudiantController::class, 'presence'])-> middleware('is_teacher')-> name('etudiant.present');
    Route::get('etudiant/present/{etudiant_id}/{cours_id}/{seance_id}', [SeanceController::class, 'presence'])-> middleware('is_teacher')-> name('etudiant.present.seance');
    
  

    
    //1.2.3. Pointage de plusieurs étudiants d’un coup pour la séance.
    Route::post('pointage/groupe/{cours_id}', [SeanceController::class, 'presences_group']) -> middleware('is_teacher')-> name('presences.group');
    Route::get('pointage/groupe/{cours_id}/{seance_id}', [SeanceController::class, 'presences_group_seance'])-> middleware('is_teacher')-> name('presences.group.seance'); 
    //1.2.4 Liste des Présents/absents par séance
    Route::get('seances/index/{cours_id}', [SeanceController::class, 'index']) ->name('seances.index');
    Route::get('presences/list/{seance_id}', [SeanceController::class, 'presences_index'])-> name('presences.index');


//Partie 5: statistiques
    //2.5.1 liste des étudiants
    Route::get('etudiants/list',[EtudiantController::class, 'index_all'])->middleware('is_gestionnaire')-> name('etudiants.index_all');
    //2.5.2 Recherche des étudiants
    Route::post('etudiants/search',[EtudiantController::class, 'search'])->middleware('is_gestionnaire')-> name('etudiants.search'); 
    //2.5.3 Liste des cours
    Route::get('cours/index', [CoursController::class, 'index']) -> name('cours.index'); 
    //2.5.4 Liste des séances pour un cours
    Route::get('seances/index/{cours_id}', [SeanceController::class, 'index']) ->name('seances.index');
    //2.6.1 Liste de présences détaillée (par étudiant).
    Route::get('presences/etudiant/{etudiant_id}', [EtudiantController::class, 'presences_etudiant'])->middleware('is_gestionnaire')-> name('presences.etudiant');
    //2.6.3 Liste des présences (des étudiants) par séance
    Route::get('presences/list/{seance_id}', [SeanceController::class, 'presences_index'])-> name('presences.index');
    //2.6.3 Liste des présences (des étudiants) par cours
    Route::get('presences/cours/{cours_id}', [EtudiantController::class, 'presences_cours'])->middleware('is_gestionnaire')-> name('presences.cours');
    

//Partie 5: MAJ/Supp
    //2.1.2 Mise à jour de l’étudiant
    Route::get('etudiant/edit/{etudiant_id}', [EtudiantController::class, 'edit'])-> middleware('is_gestionnaire')-> name('etudiant.edit'); 
    Route::post('etudiant/edit/{etudiant_id}', [EtudiantController::class, 'update'])-> middleware('is_gestionnaire')-> name('etudiant.update');

    //2.1.3. Suppression de l’étudiant
    Route::get('etudiant/delete/{id}',[EtudiantController::class, 'delete'])-> middleware('is_gestionnaire')-> name('etudiant.delete');
    //2.2.2. Mise à jour d’une séance de cours
    Route::get('seance/edit/{seance_id}/{cours_id}', [SeanceController::class, 'edit'])-> middleware('is_gestionnaire')-> name('seance.edit');
    Route::post('seance/edit/{seance_id}/{cours_id}', [SeanceController::class, 'update'])-> middleware('is_gestionnaire')-> name('seance.update');
    //2.2.3. Suppression d’une séance de cours.
    Route::get('seance/delete/{seance_id}/{cours_id}', [SeanceController::class, 'delete'])-> middleware('is_gestionnaire')-> name('seance.delete');
    //2.3.4. Copier toutes les associations d’un cours vers un autre cours
    Route::get('copie/associations/{cours1_id}', [CoursController::class, 'copy'])-> middleware('is_gestionnaire') -> name("copy.associations"); 
    Route::get('coller/associations/{cours2_id}', [CoursController::class, 'paste'])->  middleware('is_gestionnaire') -> name("paste.associations"); 
    //2.3.5. Associer des étudiants au cours (plusieurs d’un coup).
    Route::post('inscription/group/{cours_id}', [EtudiantController::class, 'inscription_group'])-> middleware('is_gestionnaire')-> name('inscription.group');
    //Supprimer l’association (plusieurs d’un coup).
    Route::post('dessociations/group/{cours_id}', [EtudiantController::class, 'dessociations_group']) -> middleware('is_gestionnaire') -> name('dessociations.group'); 

//Les routes ayant besoin de deux middleware




//Partie 5: admin
    //4.1.1.1. Liste users intégrale
    Route::get('users/index', [UserController::class, 'index'])-> middleware('is_admin')-> name('user.index'); 
    //4.1.1.2. Filtre par type (enseignant/gestionnaire)
    Route::get('liste/enseignants/filter',[UserController::class, 'enseignants_index_type'])-> middleware('is_admin') -> name('enseignants.index_type'); 
    Route::get('liste/gestionnaires/filter', [UserController::class, 'gestionnaires_index_type'])-> middleware('is_admin') -> name('gestionnaires.index_type'); 
    //4.1.1.3. Rechercher par nom/prénom/login.
    Route::post('users/search', [UserController::class, 'search'])-> middleware('is_admin')-> name('users.search'); 
    //4.1.4. Modification d’un utilisateur (y compris le type)
    Route::get('edit/user/{user_id}', [UserController::class, 'edit']) -> middleware('is_admin')-> name('user.edit'); 
    Route::post('edit/user/{user_id}', [UserController::class , 'update']) -> middleware('is_admin') -> name('user.update'); 
    //4.1.5. Suppression d’un utilisateur.
    Route::get('user/delete/{user_id}',[UserController::class, 'delete'])-> middleware('is_admin') -> name('user.delete'); 

    //4.2.3. Recherche des cours par intitulé
    Route::post('cours/search', [CoursController::class, 'search'])-> middleware('is_admin') -> name('cours.search'); 
    //4.2.4 Modification d'un cours
    Route::get('edit/cours/{id}', [CoursController::class, 'edit']) -> middleware('is_admin')-> name('cours.edit'); 
    Route::post('edit/cours/{id}', [CoursController::class , 'update']) -> middleware('is_admin') -> name('cours.update'); 
    //4.2.5 Suppression d'u cours
    Route::get('cours/delete/{cours_id}', [CoursController::class, 'delete'])-> middleware('is_admin') -> name('cours.delete'); 