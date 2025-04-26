<?php

namespace App\Controllers;

class Auth extends BaseController
{
  public function login()
  {
    return view('auth/login');
  }

  public function register()
  {
    return view('auth/register');
  }

  public function registration()
  {
    $validation = \Config\Services::validation();

    // Aturan validasi
    $rules = [
      'email' => 'required|valid_email',
      'first_name' => 'required',
      'last_name' => 'required',
      'password' => 'required|min_length[8]',
      'confirm_password' => 'required|matches[password]',
    ];

    // Pesan kustom
    $messages = [
      'first_name' => [
        'required' => 'The First Name field is required.',
      ],
      'last_name' => [
        'required' => 'The Last Name field is required.',
      ],
      'email' => [
        'required' => 'The Email field is required.',
        'valid_email' => 'Please enter a valid Email address.',
      ],
      'password' => [
        'required' => 'The Password field is required.',
        'min_length' => 'The Password must be at least 8 characters.',
      ],
      'confirm_password' => [
        'required' => 'The Confirm Password field is required.',
        'matches' => 'Confirm Password must match the Password.',
      ],
    ];

    // Validasi form
    if (!$this->validate($rules, $messages)) {
      return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Ambil data dari form
    $email = $this->request->getPost('email');
    $first_name = $this->request->getPost('first_name');
    $last_name = $this->request->getPost('last_name');
    $password = $this->request->getPost('password');

    // Membuat client cURL untuk mengirim permintaan POST ke API
    $client = \Config\Services::curlrequest();

    // Mengirimkan data registrasi
    try {
      $response = $client->post('https://take-home-test-api.nutech-integrasi.com/registration', [
        'json' => [
          'email' => $email,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'password' => $password,
        ]
      ]);

      // Mengambil respons dan mendekodekan JSON
      $body = json_decode($response->getBody(), true);

      // Jika status adalah 0, registrasi berhasil
      if (isset($body['status']) && $body['status'] === 0) {
        return redirect()->to('/')->with('success', 'Registrasi berhasil. Silakan login.');
      }

      // Jika gagal, kirim pesan error dari API
      return redirect()->back()->withInput()->with('api_error', $body['message'] ?? 'Registrasi gagal.');
    } catch (\Exception $e) {
      // Tangani jika cURL gagal (misalnya, masalah koneksi)
      return redirect()->back()->withInput()->with('api_error', 'Terjadi kesalahan saat menghubungi server API: ' . $e->getMessage());
    }
  }
}
