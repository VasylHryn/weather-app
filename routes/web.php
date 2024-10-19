<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use GuzzleHttp\Client;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::get('/weather', function () {
    $client = new Client();
    $response = $client->get('https://api.openweathermap.org/data/2.5/weather', [
        'query' => [
            'lat' => 51.4982,
            'lon' => 31.2893,
            'appid' => env('WEATHER_API_KEY'), // Используем API-ключ из .env файла
        ],
        'verify' => false, // Отключаем проверку SSL-сертификата
    ]);

    $data = json_decode($response->getBody(), true);
    return response()->json($data);
});
