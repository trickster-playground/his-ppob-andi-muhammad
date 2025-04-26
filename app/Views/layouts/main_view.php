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

<body>
  <!-- Header atau elemen yang sama di setiap halaman -->
  <header>
    <?= view('components/navbar') ?>

    <!-- Full width divider -->
    <div class="border-t border-primary w-screen"></div>
  </header>


  <!-- Konten dinamis dari halaman tertentu -->
  <?= $this->renderSection('content'); ?>

  <!-- Footer atau elemen yang sama di setiap halaman -->
  <footer>

  </footer>
</body>

</html>