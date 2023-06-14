<?php

namespace App\Http\Controllers;

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
        $users = User::where('status', '!=', 3)->where('firstname', 'LIKE', "%$search%")->orWhere('lastname', 'LIKE', "%$search%")->get();
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
}
