<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Topup extends BaseController
{
  public function index(): ResponseInterface
  {
    if (!session()->get('isLoggedIn')) {
      return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
    }

    $client = \Config\Services::curlrequest();

    $token = session('token');

    // Get Balance
    $responseBalance = $client->get('https://take-home-test-api.nutech-integrasi.com/balance', [
      'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
      ],
    ]);
    $dataBalance = json_decode($responseBalance->getBody(), true);
    $balance = $dataBalance['data']['balance'] ?? 0;

    return $this->response->setBody(view('topup', [
      'balance'  => $balance,
    ]));
  }
}
