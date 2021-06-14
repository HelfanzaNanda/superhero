<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('superheroes.index');
});

Route::get('superheroes', 'SuperheroController@index')->name('superheroes.index');
Route::post('superheroes', 'SuperheroController@datatables')->name('superheroes.datatables');

Route::get('superheroes/detail/{id}', 'SuperheroController@detail')->name('superheroes.detail');
Route::put('superheroes/edit/{id}', 'SuperheroController@update')->name('superheroes.update');

Route::post('superheroes/superhero', 'SuperheroController@datatablesSuperheroSkill')->name('superheroes.skill.datatables');
Route::post('superheroes/attach', 'SuperheroController@attach')->name('superheroes.attach');

Route::delete('superheroes/delete/{id}', 'SuperheroController@delete')->name('superheroes.delete');

Route::get('skills', 'SkillController@index')->name('skills.index');
Route::post('skills', 'SkillController@datatables')->name('skills.datatables');
Route::get('skills/detail/{id}', 'SkillController@detail')->name('skills.detail');
Route::put('skills/edit/{id}', 'SkillController@update')->name('skills.update');

Route::post('skills/superhero', 'SkillController@datatablesSkillSuperhero')->name('skills.superhero.datatables');
Route::post('skills/attach', 'SkillController@attach')->name('skills.attach');

Route::delete('skills/delete/{id}', 'SkillController@delete')->name('skills.delete');


Route::get('married', 'MarriedController@index')->name('married.index');
Route::post('married/search/skills', 'MarriedController@searchSkills')->name('married.search.skills');
Route::post('married/pdf', 'MarriedController@pdf')->name('married.pdf');
Route::post('married/excell', 'MarriedController@excell')->name('married.excell');
