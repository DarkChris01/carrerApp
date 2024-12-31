<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;


class EmployerService
{

    private function get_employer(){
        return Auth::guard("employer")->user();
    } 

    public function enterprise()
    {
        return $this->get_employer()->enterprise;
    }


    public function notifications()
    {
        return $this->get_employer()->notifications;
    }
    
    public function jobs()
    {
        return $this->get_employer()->jobs()->with(["competence"])->get();
    }
}
