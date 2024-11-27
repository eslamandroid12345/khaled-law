<?php

use Illuminate\Support\Facades\Route;
use App\Models\Scopes\ActiveUserScope;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/binary-search', function () {
    $users = \App\Models\User::orderBy('id')->get();
    $targetId = 70;
    $low = 0;
    $high = count($users) - 1;
    while ($low <= $high)
    {
        $mid = floor(($low + $high) / 2);
        $midId = $users[$mid]->id;
        if ($midId == $targetId)
        {
            return $users[$mid];
        }
        elseif ($midId < $targetId)
        {
            $low = $mid + 1;
        }
        else
        {
            $high = $mid - 1;
        }
    }
    return null;
});

Route::get('/test',function(){
    $arr = ["php", "laravel", "mysql", "key" => "val", "html", "css"];
    return $arr;
});

Route::get('/test-scope',function(){
    $users = \App\Models\User::withoutGlobalScope(ActiveUserScope::class)->get();
    return $users;
});

Route::get('/test-arr',function() {
    $arr1 = [1,1,5,2,3,2,3];
    $uniqueArray = array_unique($arr1);
    return count($uniqueArray);
});

