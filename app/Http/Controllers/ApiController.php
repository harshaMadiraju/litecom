<?php

namespace App\Http\Controllers;

use App\Helpers\Response as ApiResponse;
use JWTAuth;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    public function register(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *  path="/api/login",
     *  summary="Login",
     *  tags={"Authentication"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="username", type="string", example="harsha3889@gmail.com"),
     *              @OA\Property(property="password", type="string", example="12345"),
     *          ),
     *      ),
     *  @OA\Response(response=200, description="Created successfully"),
     *  @OA\Response(response=422, description="Bad request"),
     *  @OA\Response(response=500, description="Internal server error"),
     * )
     */

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $validator = Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(ApiResponse::prepareResponse(false, [], '', ApiResponse::FORM_VALIDATION_ERROR, ['error' => $validator->messages()]), ApiResponse::FORM_VALIDATION_ERROR);
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(ApiResponse::prepareResponse(false, [], 'Invalid Credentials.Please try again', ApiResponse::FORM_VALIDATION_ERROR, ['error' => $validator->messages()]), ApiResponse::FORM_VALIDATION_ERROR);
            }
        } catch (JWTException $e) {
            return response()->json(ApiResponse::prepareResponse(false, [], 'Failed to create token', ApiResponse::FORM_VALIDATION_ERROR, ['error' => $e->getMessage()]));
        }

        return response()->json(
            ApiResponse::prepareResponse(true, ['token' => $token], 'Token Created Successfully', ApiResponse::SUCCESS, [])
        );
    }

    public function logout(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(ApiResponse::prepareResponse(false, [], 'Failed', ApiResponse::FORM_VALIDATION_ERROR, ['error' => $validator->messages()]), ApiResponse::FORM_VALIDATION_ERROR);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json(ApiResponse::prepareResponse(true, [], 'Logged Out Success', ApiResponse::SUCCESS, []), ApiResponse::SUCCESS);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                ['error' => $e->getMessage()]
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }
}
