<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Urban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends BaseController
{
    public function getListUser(Request $request)
    {
        $page = $request->input('page') ?? 1;
        $perPage = $request->input('perPage') ?? 10;
        $search = $request->input('search') ?? '';
        $users = User::where('status', '!=', 3)->where('firstname', 'LIKE', "%$search%")->orWhere('lastname', 'LIKE', "%$search%")->with('city')->get();
        $users = new LengthAwarePaginator($users->forPage($page, $perPage), $users->count(), $perPage, $page);
        return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    public function updateUser($id, Request $request)
    {
        $data = $request->all();
        $user = User::where('id', $id)->update($data);
        if ($user) {
            return $this->sendResponse('OK', 'User update successful.');
        } else {
            return $this->sendResponse('Error', 'User update failed.');
        }
    }

    public function getUserById($id)
    {
        $user = User::where('id', $id)->where('status', '!=', 3)->get()->first();
        $user->address = Urban::where('id', $user->urban_id)->get()->first();
        $user->order = Order::where('user_id', $id)->count();
        $user->sum_order = Order::where('user_id', $id)->sum('total_price');
        return $this->sendResponse($user, 'User retrieved successfully.');
    }
}
