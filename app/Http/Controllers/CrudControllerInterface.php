<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface CrudControllerInterface
{
    public function index(Request $request): JsonResponse;
    public function show(int $id): JsonResponse;
    public function create(Request $request): JsonResponse;
    public function update(Request $request, int $id): JsonResponse;
    public function delete(int $id): JsonResponse;
}
