<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemSkillController;
use App\Http\Controllers\SkillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// header("Access-Control-Allow-Headers: Content-Type, Authorization");

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/levels', [LevelController::class, "show"]);
Route::post('/levels', [LevelController::class, "create"]);
Route::get('/levels/{id}', [LevelController::class, "levelDetail"]);
Route::post('/levels/{id}', [LevelController::class, "update"]);
Route::delete('/levels/{id}', [LevelController::class, "delete"]);


Route::get('/skills', [SkillController::class, "show"]);
Route::post('/skills', [SkillController::class, "create"]);
Route::post('/updateSkillPosition', [SkillController::class, "updatePosition"]);


Route::get('/members', [MemberController::class, "show"]);
Route::post('/members', [MemberController::class, "create"]);


Route::get('/memskills', [MemSkillController::class, "show"]);
Route::get('/memskillsSortBylevelNumberOfSkill/{skillId}', [MemSkillController::class, "showMemCodesortBylevelNumberOfSkill"]);

Route::post('/memskills', [MemSkillController::class, "store"]);

// Route::get('login/{provider}', function ($provider) {
//     return Socialite::driver($provider)->stateless()->redirect();
// });

// Route::get('login/{provider}/callback', function ($provider) {
//     $providerUser = Socialite::driver($provider)->stateless()->user();
//     $user = User::firstOrCreate(
//         ['provider_id' => $providerUser->getId()],
//         ['email' => $providerUser->getEmail(), 'name' => $providerUser->getName()]
//     );

//     // create a token for the user and return it
//     $token = $user->createToken('Token Name')->accessToken;
//     return response()->json(['token' => $token]);
// });