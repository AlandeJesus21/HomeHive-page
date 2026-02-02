<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\PropRent;

class PropiedadController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
        // Asegura que todas las rutas de creación/actualización/eliminación requieran autenticación
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    /** Listar propiedades públicas */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Propiedad::query();

            // Búsqueda
            if ($request->has("search")) {
                $search = $request->input("search");
                $query->where(function ($q) use ($search) {
                    $q->where("tipo", "like", "%{$search}%")
                      ->orWhere("descripcion", "like", "%{$search}%")
                      ->orWhere("barrio", "like", "%{$search}%");
                });
            }

            // // Orden
            // $sortBy = $request->input("sort_by", "created_at");
            // $sortDirection = $request->input("sort_direction", "desc");
            // $query->orderBy($sortBy, $sortDirection);

            // Paginación
            // $perPage = min($request->input("per_page", 15), 100);
            $props = $query->get();

            return response()->json([
                "success" => true,
                "data" => $props,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Error al obtener propiedades",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    /** Crear propiedad */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validación
            $validated = $request->validate([
                "titulo"       => "required|string|max:255",
                "tipo"         => "nullable|string|max:50",
                "barrio"       => "required|string|max:50",
                "calle"        => "required|string|max:50",
                "precio"       => "required|numeric|min:1",
                "forma_pago"   => "required|string|max:20",
                "servicio"     => "required|string|max:100",
                "reglas"       => "required|string|max:100",
                "cercanias"    => "required|string|max:100",
                "descripcion"  => "nullable|string",
                "imagen"       => "nullable|image|max:5000"
            ]);

            // Asignar automáticamente el usuario autenticado
            if (!$request->user()) {
                return response()->json([
                    "success" => false,
                    "message" => "No estás autenticado",
                ], 401);
            }

            $validated['user_id'] = $request->user()->id;

            // Crear propiedad
            $prop = Propiedad::create($validated);

            // Subida de imagen (opcional)
            if ($request->hasFile("imagen")) {
                $upload = $this->fileService->upload($request->file("imagen"), "propiedades");
                if ($upload["success"]) {
                    $prop->imagen = $upload["path"];
                    $prop->save();
                }
            }

            return response()->json([
                "success" => true,
                "message" => "Propiedad creada correctamente",
                "data" => $prop
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                "success" => false,
                "message" => "Error de validación",
                // "errors" => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Error al crear la propiedad",
                // "error" => $e->getMessage()
            ], 500);
        }
    }

    /** Ver propiedad */
    public function show(Propiedad $propiedad): JsonResponse
    {
        return response()->json([
            "success" => true,
            "data" => $propiedad
        ]);
    }

    /** Actualizar propiedad */
    public function update(Request $request, Propiedad $propiedad): JsonResponse
    {
        try {
            $validated = $request->validate([
                "titulo"       => "required|string|max:255",
                "tipo"         => "nullable|string|max:50",
                "barrio"       => "required|string|max:50",
                "calle"        => "required|string|max:50",
                "precio"       => "required|numeric|min:1",
                "forma_pago"   => "required|string|max:20",
                "servicio"     => "required|string|max:100",
                "reglas"       => "required|string|max:100",
                "cercanias"    => "required|string|max:100",
                "descripcion"  => "nullable|string",
                "imagen"       => "nullable|image|max:5000",
                "remove_image" => "sometimes|boolean",
            ]);

            $propiedad->update($validated);

            // Eliminar imagen
            if ($request->remove_image && $propiedad->imagen) {
                $this->fileService->delete($propiedad->imagen);
                $propiedad->imagen = null;
                $propiedad->save();
            }

            // Nueva imagen
            if ($request->hasFile("imagen")) {
                $old = $propiedad->imagen;
                $upload = $this->fileService->upload($request->file("imagen"), "propiedades");
                if ($upload["success"]) {
                    $propiedad->imagen = $upload["path"];
                    $propiedad->save();
                    if ($old) $this->fileService->delete($old);
                }
            }

            return response()->json([
                "success" => true,
                "message" => "Propiedad actualizada",
                "data" => $propiedad
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                "success" => false,
                "message" => "Error de validación",
                "errors" => $e->errors()
            ], 422);
        }
    }

    /** Eliminar propiedad */
    public function destroy(Propiedad $propiedad): JsonResponse
    {
        if ($propiedad->imagen) {
            $this->fileService->delete($propiedad->imagen);
        }

        $propiedad->delete();

        return response()->json([
            "success" => true,
            "message" => "Propiedad eliminada"
        ]);
    }


    public function viewrent(Request $fecha)
    {
     $f1 = $fecha->input("f1");
     $f2 = $fecha->input("f2");   

        $rentals = PropRent::whereBetween('fecha_rentada', [$f1, $f2])->get();

        return response()->json([
            "success" => true,
            "data" => $rentals,
        ], 200);
    }

}