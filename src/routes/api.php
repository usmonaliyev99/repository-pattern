<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/pattern/statement', function (Request $request) {
  return DB::statement($request->get('query', 'SELECT 1 + 1;'));
});

Route::get('/pattern/raw', function (Request $request) {
  $result = DB::raw($request->get('query', 'SELECT 1 + 1;'));

  dd($result);
});
