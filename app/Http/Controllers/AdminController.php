<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function GetAgents(){
        return Admin::getAgents();
    }

    public function getAdminAgents(){
        return Admin::getAdminAgents();
    }
   
}
