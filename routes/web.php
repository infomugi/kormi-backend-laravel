<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes Modular Loader
|--------------------------------------------------------------------------
| Memuat rute Frontend (Portal Publik) dan Backend (Admin & CMS).
*/

// 1. Frontend Routes (Portal Publik)
require __DIR__ . '/frontend.php';

// 2. Backend Routes (Admin CMS Panel & Auth)
require __DIR__ . '/backend.php';
