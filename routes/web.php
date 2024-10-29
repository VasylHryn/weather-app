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
    $lat = request('lat'); // Получаем значение широты из запроса
    $lon = request('lon'); // Получаем значение долготы из запроса


    if (!$lat || !$lon) {
        return response()->json(['error' => 'Latitude and longitude are required.'], 400);
    }

    $client = new Client();
    $response = $client->get('https://api.openweathermap.org/data/2.5/weather', [
        'query' => [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => env('WEATHER_API_KEY'),
        ],
        'verify' => false,
    ]);

    $data = json_decode($response->getBody(), true);
    return response()->json($data);
});
