<?php

namespace App\Http\Controllers;

use App\Student;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $client = new Client();
        $base_uri = 'http://school-eannovate.mochamadmaulana.my.id/api/mobile/class';
        $class = $client->request('GET', $base_uri);
        $student = Student::all();
        return view('dashboard',[
            'title' => 'Dashboard',
            'icon' => 'fa-home',
            'class' => json_decode($class->getBody(),true)['data'],
            'student' => $student
        ]);
    }
}
