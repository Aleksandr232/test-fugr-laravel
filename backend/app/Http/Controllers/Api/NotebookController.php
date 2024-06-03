<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotebookController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/v1/notebook",
 *     tags={"Notebooks"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="name", type="string", example="Aleks"),
 *                 @OA\Property(property="company", type="string",  example="Yandex"),
 *                 @OA\Property(property="phone", type="string",  example="8999992323"),
 *                 @OA\Property(property="email", type="string",  example="turbo232@mail.ru"),
 *                 @OA\Property(property="birth_date", type="date", example="02.02.2024"),
 *                 @OA\Property(property="photo", type="string", example="photo.jpg"),
 *                 @OA\Property(property="photo_file", type="string", example="http://localhost:8000/photos/photo.jpg")
 *              )
 *         )
 *     )
 * )
 */
    public function index()
    {
        $notebooks = Notebook::all();
        $data = [];
        foreach ($notebooks as $notebook) {
            $data[] = [
                "name" => $notebook->name,
                "company" => $notebook->company,
                "phone" => $notebook->phone,
                "email" => $notebook->email,
                "birth_date" => $notebook->birth_date,
                "photo" => $notebook->photo,
                "photo_file" => "http://localhost:8000/photos/" . $notebook->paths,

            ];
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

     /**
 * @OA\Post(
 *     path="/api/v1/notebook",
 *     tags={"Notebooks"},
 *     summary="create",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="company",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="phone",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="birth_date",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="photo",
 *                     type="file"
 *                 ),
 *
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Notebook create  successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="Notebook create  successfully", type="string")
 *         )
 *     )
 * )
 */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        $notebook = Notebook::create($validated);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $paths = Storage::disk('photos')->putFile('photo', $photo);
            $notebook->photo = $photo->getClientOriginalName();
            $notebook->paths = $paths;
            $notebook->save();
        }

        $birth_date = $request->input('birth_date');
        $company = $request->input('company');
        $notebook->birth_date = $birth_date;
        $notebook->company = $company;
        $notebook->save();

        return response()->json(['message' => 'Notebook create  successfully'], 201);
    }

      /**
 * @OA\Get(
 *     path="/api/v1/notebook/{id}",
 *     tags={"Notebooks"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="name", type="string", example="Aleks"),
 *                 @OA\Property(property="company", type="string",  example="Yandex"),
 *                 @OA\Property(property="phone", type="string",  example="8999992323"),
 *                 @OA\Property(property="email", type="string",  example="turbo232@mail.ru"),
 *                 @OA\Property(property="birth_date", type="date", example="02.02.2024"),
 *                 @OA\Property(property="photo", type="string", example="photo.jpg"),
 *                 @OA\Property(property="photo_file", type="string", example="http://localhost:8000/photos/photo.jpg")
 *              )
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        $notebook = Notebook::findOrFail($id);
        $data = [
            "name" => $notebook->name,
            "company" => $notebook->company,
            "phone" => $notebook->phone,
            "email" => $notebook->email,
            "birth_date" => $notebook->birth_date,
            "photo" => $notebook->photo,
            "photo_file" => "http://localhost:8000/photos/" . $notebook->paths,
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notebook $notebook)
    {
        //
    }

    /**
 * @OA\Post(
 *     path="/api/v1/notebook/{id}",
 *     tags={"Notebooks"},
 *     summary="update",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="company",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="phone",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="birth_date",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="photo",
 *                     type="file"
 *                 ),
 *
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Notebook update successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="Notebook update successfully", type="string")
 *         )
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        $notebook = Notebook::find($id);

        if (!$notebook) {
            return response()->json(['error' => 'The notebook was not found'], 404);
        }

        if ($request->has('name')) {
            $notebook->name = $request->name;
        }
        if ($request->has('phone')) {
            $notebook->phone = $request->phone;
        }
        if ($request->has('company')) {
            $notebook->company = $request->company;
        }
        if ($request->has('email')) {
            $notebook->email = $request->email;
        }
        if ($request->has('birth_date')) {
            $notebook->birth_date = $request->birth_date;
        }

        if ($request->hasFile('photo')) {
            if ($notebook->photo) {
                Storage::disk('photos')->delete($notebook->paths);
            }

            $photo = $request->file('photo');
            $paths = Storage::disk('photos')->putFile('photo', $photo);
            $notebook->photo = $photo->getClientOriginalName();
            $notebook->paths = $paths;
        }

        $notebook->save();

        return response()->json(['message' => 'Notebook update successfully'], 200);
    }

    /**
 * @OA\Delete(
 *     path="/api/v1/notebook/{id}",
 *     summary="delete",
 *     tags={"Notebooks"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Notebook deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="Notebook deleted successfully", type="string")
 *         )
 *     )
 * )
 */
    public function destroy($id)
    {
        $notebook = Notebook::findOrFail($id);

        if ($notebook->photo) {
            Storage::disk('photos')->delete($notebook->paths);
        }

        $notebook->delete();

        return response()->json(
            ['message' => 'Notebook deleted successfully'], 200);
    }
}
