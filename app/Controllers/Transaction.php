<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Transaction extends BaseController
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

    $responseTransaction = $client->get('https://take-home-test-api.nutech-integrasi.com/transaction/history', [
      'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
      ],
    ]);
    $dataTransaction = json_decode($responseTransaction->getBody(), true);
    $transactions = $dataTransaction['data']['records'] ?? [];

    return $this->response->setBody(view('transaction', [
      'balance'  => $balance,
      'transactions' => $transactions,
    ]));
  }
}
