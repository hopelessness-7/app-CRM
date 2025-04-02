<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginatedResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseController extends MainController implements CrudControllerInterface
{

    protected $service;
    protected $resourceClass;
    protected $createRequestClass;
    protected $updateRequestClass;

    /**
     * BaseController constructor.
     *
     * @param object $service Экземпляр сервиса
     */
    public function __construct(object $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->executeRequest(function () use ($request) {
            $paginate = $request->input('paginate', 10);
            $paginatedData = $this->service->index($paginate);
            return (new PaginatedResource($this->resourceClass::collection($paginatedData)));
        });
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return $this->executeRequest(function () use ($id) {
            return call_user_func([$this->resourceClass, 'make'], $this->service->show($id))->resolve();
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return $this->executeRequest(function () use ($request) {
            // Создаем экземпляр пользовательского класса запроса
            $validatedRequest = app($this->createRequestClass);
            $data = $validatedRequest->validated();

            return call_user_func([$this->resourceClass, 'make'], $this->service->create($data))->resolve();
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        return $this->executeRequest(function () use ($request, $id) {
            // Создаем экземпляр пользовательского класса запроса
            $validatedRequest = app($this->updateRequestClass);
            $data = $validatedRequest->validated();

            return call_user_func([$this->resourceClass, 'make'], $this->service->update((int)$id, $data))->resolve();
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->executeRequest(function () use ($id) {
            $this->service->delete((int)$id);
            return [];
        });
    }
}
