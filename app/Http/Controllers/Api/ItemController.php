<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

/**
 * @OA\Tag(
 *     name="Items",
 *     description="API Endpoints untuk Items/Barang"
 * )
 */
class ItemController extends Controller
{
    /**
     * @OA\Get(
     *     path="/items",
     *     tags={"Items"},
     *     summary="Lihat semua barang",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Cari barang berdasarkan nama"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="stock", type="integer"),
     *             @OA\Property(property="photo", type="string"),
     *             @OA\Property(property="category", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string")
     *             )
     *         ))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $items = Item::with('category')
            ->when($request->search, function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->get();

        return response()->json($items);
    }

    /**
     * @OA\Post(
     *     path="/items",
     *     tags={"Items"},
     *     summary="Tambah barang baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "category_id", "stock"},
     *                 @OA\Property(property="name", type="string", example="Laptop ASUS"),
     *                 @OA\Property(property="category_id", type="integer", example=1),
     *                 @OA\Property(property="stock", type="integer", example=10),
     *                 @OA\Property(property="photo", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Barang berhasil ditambahkan",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="stock", type="integer"),
     *             @OA\Property(property="photo", type="string")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('items', 'public');
        }

        $item = Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'photo' => $photo
        ]);

        return response()->json($item, 201);
    }

    /**
     * @OA\Get(
     *     path="/items/{id}",
     *     tags={"Items"},
     *     summary="Lihat detail barang",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID barang"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="stock", type="integer"),
     *             @OA\Property(property="photo", type="string"),
     *             @OA\Property(property="category", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string")
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        return Item::with('category')->find($id);
    }

    /**
     * @OA\Put(
     *     path="/items/{id}",
     *     tags={"Items"},
     *     summary="Update barang",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Laptop ASUS Update"),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="stock", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="stock", type="integer"),
     *             @OA\Property(property="photo", type="string")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        $item->update($request->all());
        return response()->json($item);
    }

    /**
     * @OA\Delete(
     *     path="/items/{id}",
     *     tags={"Items"},
     *     summary="Hapus barang",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="deleted")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        Item::destroy($id);
        return response()->json(['message' => 'deleted']);
    }
}