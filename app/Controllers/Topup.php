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

  public function store()
  {
    if (!session()->get('isLoggedIn')) {
      return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
    }

    $nominal = $this->request->getPost('nominal');

    if (!is_numeric($nominal)) {
      return redirect()->back()->with('error', 'Paramter amount hanya boleh angka dan tidak boleh lebih kecil dari 0.');
    }

    $nominal = (int) $nominal;

    if ($nominal < 10000 || $nominal > 1000000) {
      return redirect()->back()->with('error', 'Nominal harus antara Rp10.000 dan Rp1.000.000.');
    }

    $client = \Config\Services::curlrequest();
    $token = session('token');

    try {
      $responseTopup = $client->post('https://take-home-test-api.nutech-integrasi.com/topup', [
        'headers' => [
          'Authorization' => 'Bearer ' . $token,
          'Accept' => 'application/json',
          'Content-Type' => 'application/json',
        ],
        'body' => json_encode([
          'top_up_amount' => $nominal,
        ]),
      ]);

      $result = json_decode($responseTopup->getBody(), true);

      if (($result['status'] ?? '') === 0) {
        return redirect()->to('/topup')
          ->with('success', 'berhasil!')
          ->with('nominal', $nominal);
      }

      return redirect()->back()
        ->with('error', $result['message'] ?? 'gagal')
        ->with('nominal', $nominal);
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }
}
