<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to the Anime Weeb Forum</title>
  <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Include your common style.css here -->
</head>
<body>
  <header>
    <h1>Welcome to the Anime Weeb Forum!</h1>
    <button class="theme-toggle">Toggle Theme</button>
    <a href="help.php" class="help-link">Help</a>
    <?php
    session_start();
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
      echo '<a href="user_page.php" class="profile-link">Profile</a> ';
      echo '<a href="all_anime_questions.php" class="profile-link">View Wisdom</a> ';
      echo '<a href="ask_anime_questions.php" class="profile-link">Ask a Question</a> ';
      echo '<a href="answer_anime_questions.php" class="profile-link">Wisdom</a> ';
      echo '<form method="POST" style="display: inline;">
              <button type="submit" name="logout">Log out</button>
            </form>';
  } else {
        echo '<a href="register.php" class="ask-link">Register</a> ';
        echo '<a href="login.php" class="ask-link">Log in</a>';
    }
    
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
    ?>
  </header>
  <main>
    <section class="accordion">
      <h2>Purpose of the Anime Weeb Forum</h2>
      <div class="content">
        <p>Welcome to our Anime Weeb Forum, a place where you can immerse yourself in the world of anime! Whether you're a seasoned otaku or just getting started, our community is here to discuss, share, and celebrate all things anime. From classic series to the latest releases, dive into the vibrant world of anime with fellow fans!</p>
      </div>
    </section>

    <section class="accordion">
      <h2>How to Get Started</h2>
      <div class="content">
        <p>To start your anime journey with us, follow these simple steps:</p>
        <ol>
          <li><a href="register.php" class="ask-link">Register</a> for an account if you haven't already.</li>
          <li><a href="ask_anime_questions.php" class="ask-link">Ask a Question</a> to engage with the community.</li>
          <li><a href="all_anime_questions.php" class="ask-link">View Wisdom</a> to explore discussions.</li>
          <li><a href="user_page.php" class="ask-link">Profile</a> to manage your account.</li>
          <li>Enjoy the world of anime!</li>
        </ol>
      </div>
    </section>
  </main>

  <footer>
    <p>© <?php echo date('Y'); ?> - Anime Weeb Forum</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
