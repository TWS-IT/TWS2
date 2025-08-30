<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicn.png">

  <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    :root {
      background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
      --card-bg: #f0f0f3;
      --text-color: #333;
      --highlight-color: #e5b800;
      --input-bg: #ecf0f3;
      --shadow-light: #ffffff;
      --shadow-dark: #c8d0e7;
    }
    body {
  position: relative;
}


    body.dark {
      --background-color: #121212;
      --card-bg: #1e1e1e;
      --text-color: #ffffff;
      --highlight-color: #f4c430;
      --input-bg: #2a2a2a;
      --shadow-light: #2c2c2c;
      --shadow-dark: #f4c430;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body, html {
      width: 100%;
  height: 100%;
  margin: 0;
  background-color: var(--background-color);
  color: var(--text-color);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease, color 0.3s ease;
    }

    .content {
      width: 400px;
      padding: 40px 30px;
      background-color: var(--card-bg);
      border-radius: 10px;
      box-shadow: 5px 5px 15px var(--shadow-dark), -5px -5px 15px var(--shadow-light);
    }

    .header-text {
      font-size: 36px;
      font-weight: 700;
      color: var(--highlight-color);
      margin-bottom: 10px;
      text-align: center;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.2), -1px -1px 3px rgba(255,255,255,0.3);
    }

    .login-title {
      font-size: 28px;
      font-weight: 700;
      text-align: center;
      margin-bottom: 30px;
      color: var(--text-color);
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
      letter-spacing: 1px;
    }

    .field {
      position: relative;
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .field input {
      width: 100%;
      padding: 12px 15px 12px 45px;
      border-radius: 25px;
      border: none;
      font-size: 16px;
      background-color: var(--input-bg);
      color: var(--text-color);
      box-shadow: inset 2px 2px 5px #BABECC, inset -5px -5px 10px #ffffff73;
    }

    .field span {
      position: absolute;
      left: 15px;
      font-size: 16px;
      color: #595959;
    }

    .field input:focus {
      outline: none;
      box-shadow: inset 1px 1px 2px #BABECC, inset -1px -1px 2px #ffffff73;
    }

    .forgot-pass {
      margin: 10px 0;
      text-align: left;
    }

    .forgot-pass a {
      font-size: 14px;
      color: #3498db;
      text-decoration: none;
    }

    .forgot-pass a:hover {
      text-decoration: underline;
    }

    .form-check {
      margin-bottom: 20px;
      font-size: 14px;
      text-align: left;
    }

    .form-check-input {
      margin-right: 5px;
    }

    button {
      width: 100%;
      height: 45px;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 25px;
      background-color: var(--card-bg);
      color: var(--text-color);
      cursor: pointer;
      box-shadow: 2px 2px 5px #BABECC, -5px -5px 10px #ffffff73;
      transition: all 0.3s ease;
    }

    button:hover {
      box-shadow: inset 2px 2px 5px #BABECC, inset -5px -5px 10px #ffffff73;
    }

    .theme-switch {
      position: fixed;
  top: 15px;
  right: 15px;
  background: none;
  border: none;
  cursor: pointer;
  z-index: 1000;

  width: 40px;
  height: 40px;
  padding: 5px;
  border-radius: 50%;
  background-color: var(--card-bg);
  box-shadow: 2px 2px 5px var(--shadow-dark), -2px -2px 5px var(--shadow-light);
  display: flex;
  align-items: center;
  justify-content: center;
    }

    .message {
      margin-bottom: 15px;
      color: red;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>
<body
>
 
  <button class="theme-switch" id="theme-switch" title="Toggle light & dark">
    <svg class="sun-and-moon" aria-hidden="true" width="24" height="24" viewBox="0 0 24 24">
      <mask class="moon" id="moon-mask">
        <rect x="0" y="0" width="100%" height="100%" fill="white" />
        <circle cx="24" cy="10" r="6" fill="black" />
      </mask>
      <circle class="sun" cx="12" cy="12" r="6" mask="url(#moon-mask)" fill="currentColor" />
      <g class="sun-beams" stroke="currentColor">
        <line x1="12" y1="1" x2="12" y2="3" />
        <line x1="12" y1="21" x2="12" y2="23" />
        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
        <line x1="1" y1="12" x2="3" y2="12" />
        <line x1="21" y1="12" x2="23" y2="12" />
        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
      </g>
    </svg>
  </button>


  <div class="content">
    <div class="header-text">Together We Success</div>
    <div class="login-title">Login</div>

 
    <?php if(!empty($this->session->flashdata('feedback'))): ?>
      <div class="message"><?php echo $this->session->flashdata('feedback'); ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo base_url('Login/Login_Auth'); ?>">
      <div class="field">
        <span class="fas fa-user"></span>
        <input type="text" name="email" required placeholder="Email or Phone" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>">
      </div>

      <div class="field">
  <span class="fas fa-lock"></span>
  <input type="password" name="password" id="password" required placeholder="Password" 
         value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>">
</div>

<div class="form-check">
  <input type="checkbox" id="show-password" class="form-check-input">
  <label for="show-password">Show Password</label>
</div>

<script>
document.getElementById('show-password').addEventListener('change', function() {
    var passwordInput = document.getElementById('password');
    if (this.checked) {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
});
</script>

<style>
  .field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}

.container{
  padding-top:50px;
  margin: auto;
}
</style>


  

      <div class="form-check">
        <input type="checkbox" name="remember" class="form-check-input" id="remember-me">
        <label class="form-check-label" for="remember-me">Remember Me</label>
      </div>

      <button type="submit">Sign in</button>
    </form>
  </div>

  <script>
    const themeSwitch = document.getElementById('theme-switch');
    themeSwitch.addEventListener('click', () => {
      document.body.classList.toggle('dark');
    });
  </script>
  
</body>
</html>
