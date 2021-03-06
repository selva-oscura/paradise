<?php $noAuth = true; $redirectAuth = ".."; require "../php/security.php"; ?>
<!doctype html>
<!-- - - - - - - - - - - - - - - - - - - - - - - - -->
<!-- Paradise ~ centerkey.com/paradise             -->
<!-- GPLv3 - Copyright (c) individual contributors -->
<!-- - - - - - - - - - - - - - - - - - - - - - - - -->
<html lang=en>
<head>
<meta charset=utf-8>
<meta name=viewport                   content="width=device-width, initial-scale=1">
<meta name=apple-mobile-web-app-title content="Console">
<title>Paradise &bull; Administrator Console</title>
<link rel=icon             href=http://centerkey.com/paradise/graphics/bookmark.png>
<link rel=apple-touch-icon href=http://centerkey.com/paradise/graphics/mobile-home-screen.png>
<link rel=stylesheet       href=https://cdn.jsdelivr.net/fontawesome/4.7/css/font-awesome.min.css>
<link rel=stylesheet       href=https://cdn.jsdelivr.net/dna.js/1.2/dna.css>
<link rel=stylesheet       href=http://centerkey.com/css/reset.css>
<link rel=stylesheet       href=http://centerkey.com/css/layout-color-blocks.css>
<link rel=stylesheet       href=../css/style.css>
</head>
<body>

<header>
   <aside>
      <button data-href=../..>Visit Gallery</button>
   </aside>
   <h1>Paradise PHP Photo Gallery</h1>
   <h2>Administrator Console</h2>
</header>

<main>
   <div>
      <section class=component-security data-on-load=app.login.setup>
         <h2>
            Sign in
            <i data-icon=info-circle class=external-site
               data-href=https://github.com/center-key/paradise/wiki/faq#4-is-my-password-send-over-the-internet-in-clear-text></i>
         </h2>
         <form>
            <h3 class=for-create>Create account</h3>
            <p class=for-create>No user accounts exist yet.&nbsp; Create your account to continue the setup.</p>
            <p class=error-message></p>
            <label class=invite-code>
               <span>Invite code:</span>
               <input placeholder="Enter invite code">
            </label>
            <label>
               <span>Email:</span>
               <input type=email data-enter-key=app.login.submit placeholder="Enter your email address" required>
            </label>
            <label>
               <span>Password:</span>
               <input type=password data-enter-key=app.login.submit placeholder="Enter your password" required>
            </label>
            <label class=for-create>
               <span>Confirm:</span>
               <input type=password data-enter-key=app.login.submit placeholder="Re-enter your password">
            </label>
            <p>
               <button data-click=app.login.submit>Sign in</button>
            </p>
         </form>
      </section>
      <?php include "../../~data~/login-message.html"; ?>
   </div>
</main>

<footer>
   <div>
      FAQ:
      <a href=https://github.com/center-key/paradise/wiki/faq class=external-site>
         github.com/center-key/paradise/wiki/faq
      </a>
   </div>
</footer>

<script src=https://cdn.jsdelivr.net/jquery/3.2/jquery.min.js></script>
<script src=https://cdn.jsdelivr.net/crypto-js/3.1/rollups/sha256.js></script>
<script src=https://cdn.jsdelivr.net/dna.js/1.2/dna.min.js></script>
<script>var app = {}; app.clientData = <?= appClientData(false) ?>;</script>
<script src=../js/library.js></script>
<script src=../js/login.js></script>
</body>
</html>
