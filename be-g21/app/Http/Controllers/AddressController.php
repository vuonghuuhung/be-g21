<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Urban;
use Illuminate\Http\Request;

class AddressController extends BaseController
{
    public function getCities()
    {
        $cities = City::all();
        return $this->sendResponse($cities, 'Cities retrieved successfully.');
    }

    public function getDistricts($idCity)
    {
        $districts = District::where('parent_code', $idCity)->get();
        return $this->sendResponse($districts, 'Districts retrieved successfully.');
    }

    public function getUrbans($idDistrict)
    {
        $urbans = Urban::where('parent_code', $idDistrict)->get();
        return $this->sendResponse($urbans, 'Urbans retrieved successfully.');
    }
}
