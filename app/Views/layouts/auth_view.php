<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HIS PPOB</title>
  <!-- Load Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Load DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />


  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }
  </style>
</head>

<body class="flex w-screen h-screen overflow-hidden">
  <!-- Kolom Kiri: Form-->
  <div class="flex flex-1 justify-center items-center bg-white">
    <div class="w-full max-w-2xl px-6 -mt-14">
      <!-- Konten dinamis dari halaman tertentu -->
      <?= $this->renderSection('content'); ?>
    </div>
  </div>

  <!-- Kolom Kanan: Gambar Full -->
  <div class="hidden md:block w-1/2 h-full bg-cover bg-center" style="background-image: url('<?= base_url('assets/images/Illustrasi Login.png'); ?>');"></div>
</body>

</html>