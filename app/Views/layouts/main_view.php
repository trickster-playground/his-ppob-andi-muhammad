<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HIS PPOB</title>
  <!-- Load Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Load DaisyUI -->
  <script src="https://cdn.jsdelivr.net/npm/daisyui@1.15.0/dist/full.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

  </header>

  <!-- Konten dinamis dari halaman tertentu -->
  <?= $this->renderSection('content'); ?>

  <!-- Footer atau elemen yang sama di setiap halaman -->
  <footer>
    <p>&copy; 2025 HIS PPOB</p>
  </footer>
</body>

</html>