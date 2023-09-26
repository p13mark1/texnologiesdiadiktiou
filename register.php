<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Anime Weeb Forum</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Welcome to the Anime Weeb Forum!</h1>
    <button class="theme-toggle">Toggle Theme</button>
    <a href="Home.php" class="Home-link">Home</a>
    <a href="help.php" class="help-link">Help</a>
    <a href="login.php" class="ask-link">Login</a>
  </header>
  <main>
    <section class="register-form">
      <h2>Register</h2>
      <div class="content">
        <p>To become a part of our anime-loving community, please fill out the registration form below:</p>
        <form method="post" action="register_process.php">
          Namaewa: <input type="text" name="name"><br>
          Surname: <input type="text" name="surname"><br>
          Username: <input type="text" name="username"><br>
          Password: <input type="password" name="password"><br>
          Email: <input type="text" name="email"><br>
          Anime Weeb Key: <input type="text" name="anime_weeb_key"><br>
          <input type="submit" name="submit" value="Sign Up">
        </form>
      </div>
    </section>
  </main>
  <footer>
    <p>© <?php echo date("Y"); ?> - Anime Weeb Forum</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>
