<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    public function pusherAuth(Request $request)
    {
        $socketId = $request->input('socket_id');

        // Thực hiện xác thực người dùng ở đây
        // Sử dụng Laravel Sanctum để xác thực người dùng và tạo token

        if (Auth::check()) {
            $user = Auth::user();

            // Tạo dữ liệu người dùng đã xác thực để trả về
            $userData = [
                'id' => $user->id ."",
                'user_info' => [
                    'user_id' => $user->id . "",
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ];

            // Khởi tạo Pusher instance
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            // Tạo chuỗi xác thực để gán kênh với người dùng
            $auth = json_decode($pusher->authenticateUser($socketId, $userData));

            return response()->json($auth);
        }

        return response('Unauthorized', 401);
    }

    public function pusherAuthChanel(Request $request)
    {
        $socketId = $request->input('socket_id');

        // Thực hiện xác thực người dùng ở đây
        // Sử dụng Laravel Sanctum để xác thực người dùng và tạo token

        if (Auth::check()) {
            $user = Auth::user();

            // Tạo dữ liệu người dùng đã xác thực để trả về
            $userData = [
                'id' => $user->id ."",
                'user_info' => [
                    'user_id' => $user->id . "",
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ];

            // Khởi tạo Pusher instance
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            // Tạo chuỗi xác thực để gán kênh với người dùng
            $auth = json_decode($pusher->authorizePresenceChannel('presence-chat', $socketId, $user->id . "", $userData));

            return response()->json($auth);
        }

        return response('Unauthorized', 401);
    }
}
