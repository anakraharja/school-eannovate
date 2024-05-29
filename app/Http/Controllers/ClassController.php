<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function index()
    {
        $client = new Client();
        $base_uri = 'http://school-eannovate.test/api/mobile/class';
        $response = $client->request('GET', $base_uri);
        return view('class.index',[
            'title' => 'Class',
            'icon' => 'fa-door-closed',
            'class' => json_decode($response->getBody(),true)['data']
        ]);
    }

    public function create()
    {
        return view('class.create',[
            'title' => 'Class',
            'icon' => 'fa-door-closed'
        ]);
    }

    public function edit($id)
    {
        $client = new Client();
        $base_uri = 'http://school-eannovate.test/api/mobile/class/'.$id;
        $response = $client->request('GET', $base_uri);
        return view('class.edit',[
            'title' => 'Class',
            'icon' => 'fa-door-closed',
            'class' => json_decode($response->getBody(),true)['data']
        ]);
    }
}
