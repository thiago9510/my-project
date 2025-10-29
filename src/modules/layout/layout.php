<!-- src/views/layout.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'App' ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/styles/tokens.css">
  <link rel="stylesheet" href="/styles/base.css">
  <script type="module" src="../components/button/dt-button.js" defer></script>
  <script type="module" src="../components/layout/dt-layout.js" defer></script> 
  <script type="module" src="../components/sidebar/dt-sidebar.js" defer></script>
  <script type="module" src="../components/navbar/dt-navbar.js" defer></script>
</head>
<body>
  <dt-layout>
    <div slot="content">
      <?php include $content; ?>
    </div>
  </dt-layout>
</body>
</html>
