<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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

    $profileImage = $profile['profile_image'] ?? '';

    // Kalau kosong atau URL mengandung "null", set default
    if (!$profileImage || str_contains($profileImage, '/null')) {
      $profileImage = base_url('assets/images/Profile Photo.png');
    }


    return view('profile/index', [
      'profile' => $profile,
      'profileImage' => $profileImage,
    ]);
  }

  public function profileUpdate()
  {
    if (!session()->get('isLoggedIn')) {
      return redirect()->to('/')->with('error', 'Silahkan login dulu.');
    }

    $validation = \Config\Services::validation();

    // Aturan validasi
    $rules = [
      'email' => 'required|valid_email',
      'first_name' => 'required',
      'last_name' => 'required',
    ];

    // Pesan kustom
    $messages = [
      'email' => [
        'required' => 'The Email field is required.',
        'valid_email' => 'Please enter a valid Email address.',

      ],
      'first_name' => [
        'required' => 'The First Name field is required.',
      ],
      'last_name' => [
        'required' => 'The Last Name field is required.',
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

    // Membuat client cURL untuk mengirim permintaan POST ke API
    $client = \Config\Services::curlrequest();
    $token = session('token');

    // Mengirimkan data update
    try {
      $response = $client->put('https://take-home-test-api.nutech-integrasi.com/profile/update', [
        'headers' => [
          'Authorization' => 'Bearer ' . $token,
          'Accept' => 'application/json',
          'Content-Type' => 'application/json',
        ],
        'body' => json_encode([
          'email' => $email,
          'first_name' => $first_name,
          'last_name' => $last_name,
        ]),
      ]);

      $statusCode = $response->getStatusCode();
      $result = json_decode($response->getBody(), true);

      // cek HTTP status code
      if ($statusCode == 200) {
        if (($result['status'] ?? -1) === 0) {
          // Update berhasil
          $profileData = $result['data'];

          session()->set([
            'email' => $profileData['email'] ?? session('email'),
            'first_name' => $profileData['first_name'] ?? session('first_name'),
            'last_name' => $profileData['last_name'] ?? session('last_name'),
          ]);

          return redirect()->to('/profile')->with('success', $result['message'] ?? 'Profil berhasil diperbarui!');
        } else {
          // gagal update
          return redirect()->back()->with('error', $result['message'] ?? 'Gagal memperbarui profil.');
        }
      } elseif ($statusCode == 401) {
        // Token salah atau kadaluwarsa
        session()->destroy();
        return redirect()->to('/')->with('error', 'Sesi anda telah berakhir, silakan login kembali.');
      } else {
        // Ada HTTP error lain
        return redirect()->back()->with('error', 'Terjadi kesalahan server.');
      }
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function profileImage()
  {
    // Mendapatkan file yang diupload
    $file = $this->request->getFile('file');

    // Mendapatkan token JWT dari session
    $token = session('token');
    $client = \Config\Services::curlrequest();
    
    // Memastikan file ada
    if ($file && $file->isValid()) {
      try {
        $response = $client->put('https://take-home-test-api.nutech-integrasi.com/profile/image', [
          'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
          ],
          'multipart' => [
            [
              'name'     => 'file',
              'contents' => fopen($file->getTempName(), 'r'),
              'filename' => $file->getName(),
            ],
          ],
        ]);

        $result = json_decode($response->getBody(), true);

        if ($response->getStatusCode() == 200) {
          return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
        } else {
          return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $result['message']);
        }
      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
      }
    } else {
      return redirect()->back()->with('error', 'File tidak valid atau tidak ada.');
    }
  }
}
