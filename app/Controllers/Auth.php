<?php

namespace App\Controllers;

class Auth extends BaseController
{
  public function login()
  {
    if (session()->get('isLoggedIn')) {
      return redirect()->to('/homepage');
    }

    return view('auth/login');
  }


  public function loginProcess()
  {
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // Validasi sederhana
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
      return redirect()->back()->withInput()->with('error', 'Email atau password tidak valid.');
    }

    $client = \Config\Services::curlrequest();

    try {
      // Request login
      $loginResponse = $client->post('https://take-home-test-api.nutech-integrasi.com/login', [
        'headers' => [
          'Accept' => 'application/json',
          'Content-Type' => 'application/json',
        ],
        'body' => json_encode([
          'email' => $email,
          'password' => $password,
        ]),
      ]);

      $loginData = json_decode($loginResponse->getBody(), true);

      if (isset($loginData['data']['token'])) {
        $token = $loginData['data']['token'];

        // Setelah login sukses, ambil data profile
        $profileResponse = $client->get('https://take-home-test-api.nutech-integrasi.com/profile', [
          'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
          ],
        ]);

        $profileData = json_decode($profileResponse->getBody(), true);

        if (isset($profileData['data'])) {
          // Simpan token dan data profil ke session
          session()->set([
            'token' => $token,
            'email' => $profileData['data']['email'],
            'first_name' => $profileData['data']['first_name'],
            'last_name' => $profileData['data']['last_name'],
            'profile_image' => $profileData['data']['profile_image'],
            'isLoggedIn' => true,
          ]);

          session()->setFlashdata('success', 'Login berhasil!');
          return redirect()->to('/homepage');
        } else {
          return redirect()->back()->withInput()->with('error', 'Gagal mengambil data profil.');
        }
      } else {
        return redirect()->back()->withInput()->with('error', $loginData['message'] ?? 'Login gagal.');
      }
    } catch (\Exception $e) {
      return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menghubungi server.');
    }
  }




  public function register()
  {
    if (session()->get('isLoggedIn')) {
      return redirect()->to('/homepage');
    }

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

  public function logout()
  {
    // Menghapus semua session yang terkait dengan login
    session()->remove(['token', 'email', 'first_name', 'last_name', 'profile_image', 'isLoggedIn']);

    // Mengarahkan pengguna ke halaman login
    return redirect()->to('/')->with('success', 'Logout berhasil!');
  }
}
