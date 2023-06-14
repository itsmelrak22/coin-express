<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    private function generateInviationCode(){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $code = '';
    
        for ($i = 0; $i < 6; $i++) {
            $index = mt_rand(0, strlen($characters) - 1);
            $code .= $characters[$index];
        }
    
        return $code;
    }

    public function GetAgents(){
        return Admin::getAgents();
    }

    public function getAdminAgents(){
        return Admin::getAdminAgents();
    }

    public function store(Request $request){
        $exists = Admin::where('email', $request->email)->exists();
        if($exists) {
            return ["exists" => "Email Already Exists"];
        }

        $admin = new Admin;
        $admin->email = $request->email;
        $admin->name = $request->name;
        $admin->password = bcrypt( $request->email );
        $admin->phone = $request->phone;
        $admin->is_agent = 1;
        if( $request->role == 'admin' ){
            $admin->never_admin = 0;
        }else if ( $request->role == 'agent' ) {
            $admin->never_admin = 1;
        }
        $admin->invitation_code = $this->generateInviationCode();
        $admin->save();

        return ["success" => "Agent Has Been Added"];
    }

    public function update(Request $request, Admin $admin)
    {
        $exists = Admin::where('email', $request->email)
              ->whereNotIn('id', [$admin->id])
              ->exists();
        if($exists) {
            return ["exists" => "Email Already Exists"];
        }

        $admin->email = $request->email;
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        if( $request->role == 'admin' ){
            $admin->never_admin = 0;
        }else if ( $request->role == 'agent' ) {
            $admin->never_admin = 1;
        }

        if( !$admin->invitation_code ){
            $admin->invitation_code = $this->generateInviationCode();
        }
        $admin->updated_at = new \DateTime;
        $admin->save();

        return ["success" => "Agent Has Been Updated"];

    }

    public function delete(Admin $admin)
    {
        Admin::destroy($admin->id);
    }

   
}
