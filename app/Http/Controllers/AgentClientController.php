<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AgentClient;

class AgentClientController extends Controller
{
    //
    public function index(Admin $admin){
        $adminClients = AgentClient::select(
                                        'agent_clients.agent_id',
                                        'agent_clients.client_id',
                                        'users.name',
                                        'users.email',
                                        'users.asset',
                                        'users.country',
                                        'admins.invitation_code',
                                        'admins.email as inviter_email'
                                        )
                                        ->leftJoin('admins', 'agent_clients.agent_id', 'admins.id')
                                        ->leftJoin('users', 'users.id', 'agent_clients.client_id')
                                        ->where('agent_clients.agent_id', $admin->id)
                                        ->orderBy('agent_clients.created_at', 'DESC')
                                        ->get();
        return $adminClients;
    }
}
