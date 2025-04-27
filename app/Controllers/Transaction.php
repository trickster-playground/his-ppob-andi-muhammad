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

    // Ambil transaksi pertama kali (offset = 0, limit = 5)
    $limit = 5; // Jumlah transaksi yang ditampilkan per request
    $offset = 0; // Mulai dari transaksi pertama

    $responseTransaction = $client->get('https://take-home-test-api.nutech-integrasi.com/transaction/history', [
      'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
      ],
      'query' => [
        'limit' => $limit,
        'offset' => $offset,
      ]
    ]);

    $dataTransaction = json_decode($responseTransaction->getBody(), true);
    $transactions = $dataTransaction['data']['records'] ?? [];

    return $this->response->setBody(view('transaction/history', [
      'balance' => $balance,
      'transactions' => $transactions,
      'limit' => $limit,
      'offset' => $offset + $limit, // Update offset untuk request berikutnya
    ]));
  }

  public function loadMoreTransactions(): ResponseInterface
  {
    if (!session()->get('isLoggedIn')) {
      return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
    }

    $client = \Config\Services::curlrequest();
    $token = session('token');

    $limit = $this->request->getVar('limit') ?? 5;
    $offset = $this->request->getVar('offset') ?? 5;

    // Mengambil transaksi lebih lanjut berdasarkan offset
    $responseTransaction = $client->get('https://take-home-test-api.nutech-integrasi.com/transaction/history', [
      'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
      ],
      'query' => [
        'limit' => $limit,
        'offset' => $offset,
      ]
    ]);

    $dataTransaction = json_decode($responseTransaction->getBody(), true);
    $transactions = $dataTransaction['data']['records'] ?? [];

    return $this->response->setJSON([
      'transactions' => $transactions,
      'offset' => $offset + $limit, // Update offset
    ]);
  }

  public function payment($service_code)
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

    // Ambil data service detail dari API services
    $response = $client->get('https://take-home-test-api.nutech-integrasi.com/services', [
      'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
      ],
    ]);

    $data = json_decode($response->getBody(), true);

    $service = null;
    if (isset($data['data'])) {
      foreach ($data['data'] as $item) {
        if ($item['service_code'] == $service_code) {
          $service = $item;
          break;
        }
      }
    }

    if (!$service) {
      return redirect()->to('/homepage')->with('error', 'Service tidak ditemukan');
    }

    return view('transaction/payment', ['service' => $service, 'balance' => $balance]);
  }

  public function store()
  {
    if (!session()->get('isLoggedIn')) {
      return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
    }

    $serviceCode = $this->request->getPost('service_code');

    if (empty($serviceCode)) {
      return redirect()->back()->with('error', 'Service code tidak ditemukan.');
    }

    $client = \Config\Services::curlrequest();
    $token = session('token');

    try {
      $response = $client->post('https://take-home-test-api.nutech-integrasi.com/transaction', [
        'headers' => [
          'Authorization' => 'Bearer ' . $token,
          'Accept' => 'application/json',
          'Content-Type' => 'application/json',
        ],
        'body' => json_encode([
          'service_code' => $serviceCode,
        ]),
      ]);

      $result = json_decode($response->getBody(), true);

      if (($result['status'] ?? '') === 0) {
        return redirect()->back()
          ->with('success', 'berhasil!')
          ->with('service_name', $result['data']['service_name'] ?? '')
          ->with('total_amount', $result['data']['total_amount'] ?? 0);
      }

      return redirect()->back()
        ->with('error', $result['message'] ?? 'gagal')
        ->with('service_name', $result['data']['service_name'] ?? '')
        ->with('total_amount', $result['data']['total_amount'] ?? 0);
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }
}
