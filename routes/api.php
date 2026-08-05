<?php

use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

Route::apiResource('v1/contacts', ContactController::class)->only(['index']);
