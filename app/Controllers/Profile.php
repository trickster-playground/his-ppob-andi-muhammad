<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Profile extends BaseController
{
  public function index()
  {
    if (!session()->get('isLoggedIn')) {
      return redirect()->to('/')->with('error', 'Silahkan login dulu.');
    }

    $profile = [
      'email' => session()->get('email'),
      'first_name' => session()->get('first_name'),
      'last_name' => session()->get('last_name'),
      'profile_image' => session()->get('profile_image'),
    ];

    return view('profile/index', compact('profile'));
  }
}
