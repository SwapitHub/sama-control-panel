<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request to send a password reset email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email|unique:users',
        // ]);

        // if ($validator->fails()) {
        //     $output['res'] = 'error';
        //     $output['msg'] = $validator->errors()->all();
        //     $output['data'] = [];
        //     return response()->json($output, 400);
        // }
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );
        // if ($status === Password::RESET_LINK_SENT) {
        //     return response()->json(['res'=>'success','msg' => __($status)], 200);
        // }
        // throw ValidationException::withMessages([
        //     'email' => [trans($status)],
        // ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email', // Check that the email exists in the users table
        ], [
            'email.exists' => 'We can\'t find a user with that email address.', // Custom error message
        ]);

        // If validation fails, return error messages
        if ($validator->fails()) {
            return response()->json([
                'res' => 'error',
                'msg' => $validator->errors()->first(), // Return the first error message
                'data' => []
            ], 400);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'res' => 'success',
                'msg' => __($status) // Retrieve message from the status
            ], 200);
        }

        return response()->json([
            'res' => 'error',
            'msg' => __($status), // Retrieve the error message from status
            'data' => []
        ], 400);
    }
}
