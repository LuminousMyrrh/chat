<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *  title="user-crud api",
 *  version="1.0.0",
 *  description="User-crud doc"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/users",
     *  summary="Get all users",
     *  tags={"Users"},
     *  @OA\Response(response=200, description="List of users")
     * )
     */
    public function index()
    {
        return User::all();
    }

    /**
     * @OA\Post(
     *  path="/api/users",
     *  summary="Create user",
     *  tags={"Users"},
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         required={"name", "email", "password"},
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="password", type="string", format="password")
     *     )
     *  ),
     *  @OA\Response(response=201, description="User created")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return User::create($data);
    }

    /**
     * @OA\Get(
     *  path="/api/users/{id}",
     *  summary="Get a single user",
     *  tags={"Users"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(response=200, description="User found")
     * )
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @OA\Put(
     *  path="/api/users/{id}",
     *  summary="Update user",
     *  tags={"Users"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="email", type="string"),
     *         @OA\Property(property="password", type="string")
     *     )
     *  ),
     *  @OA\Response(response=200, description="Updated user")
     * )
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *  path="/api/users/{id}",
     *  summary="Delete user",
     *  tags={"Users"},
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(response=200, description="User deleted")
     * )
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
