<?php

use App\Http\Controllers\PageController;
use App\Models\Page;
use Illuminate\Support\Facades\Route;

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
    /** @var Page $homePage */
    $homePage = Page::where('is_homepage', true)->first();
    return redirect('/' . $homePage->slug);
});
Route::get('/{page}', [PageController::class, 'index'])->name('page_index');
