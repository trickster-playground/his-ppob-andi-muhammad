<?php include('icons/eye.php'); ?>

<?php $inputId = esc($id ?? ('input_' . ($name ?? uniqid()))); ?>
<?php $extraAttributes = $attributes ?? ''; ?>

<div class="relative w-full">
  <?php if (!empty($icon)): ?>
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
      <?= $icon ?>
    </div>
  <?php endif; ?>

  <input
    id="<?= $inputId ?>"
    type="<?= esc($type ?? 'text') ?>"
    name="<?= esc($name ?? '') ?>"
    placeholder="<?= esc($placeholder ?? '') ?>"
    value="<?= esc($value ?? '') ?>"
    <?= $extraAttributes ?>
    class="w-full border border-gray-300 rounded-md p-3 <?= (!empty($icon) ? 'pl-12' : 'pl-4') ?> focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300" />

  <?php if (($type ?? '') === 'password'): ?>
    <button
      type="button"
      onclick="togglePassword('<?= $inputId ?>', this)"
      class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
      <span class="toggle-eye">
        <?= $eyeIcon ?>
      </span>
    </button>
  <?php elseif (!empty($kbd)): ?>
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center space-x-1">
      <?php foreach ($kbd as $key): ?>
        <kbd class="kbd kbd-xl"><?= esc($key) ?></kbd>
      <?php endforeach; ?>
    </div>
  <?php elseif (!empty($badge)): ?>
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
      <span class="badge badge-neutral badge-xl"><?= esc($badge) ?></span>
    </div>
  <?php endif; ?>
</div>

<script>
  function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeWrapper = btn.querySelector('.toggle-eye');

    const eyeSVG = `<?= addslashes($eyeIcon) ?>`;
    const eyeOffSVG = `<?= addslashes($eyeOffIcon) ?>`;

    if (input.type === 'password') {
      input.type = 'text';
      eyeWrapper.innerHTML = eyeOffSVG;
    } else {
      input.type = 'password';
      eyeWrapper.innerHTML = eyeSVG;
    }
  }
</script>