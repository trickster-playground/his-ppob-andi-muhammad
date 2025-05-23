<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
  public function index(): ResponseInterface
  {
    if (!session()->get('isLoggedIn')) {
      return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
    }

    $client = \Config\Services::curlrequest();

    // Get Banner
    $responseBanner = $client->get('https://take-home-test-api.nutech-integrasi.com/banner');
    $dataBanner = json_decode($responseBanner->getBody(), true);
    $banners = $dataBanner['data'] ?? [];

    $token = session('token');

    // Get Services 
    $responseServices = $client->get('https://take-home-test-api.nutech-integrasi.com/services', [
      'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
      ],
    ]);
    $dataServices = json_decode($responseServices->getBody(), true);
    $services = $dataServices['data'] ?? [];

    // Get Balance
    $responseBalance = $client->get('https://take-home-test-api.nutech-integrasi.com/balance', [
      'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
      ],
    ]);
    $dataBalance = json_decode($responseBalance->getBody(), true);
    $balance = $dataBalance['data']['balance'] ?? 0;

    return $this->response->setBody(view('homepage', [
      'banners' => $banners,
      'services' => $services,
      'balance'  => $balance,
    ]));
  }
}
