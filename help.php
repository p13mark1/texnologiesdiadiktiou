<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Help - Anime Weeb Forum</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Anime Weeb Forum - Help</h1>
    <button class="theme-toggle">Toggle Theme</button>
    <a href="Home.php" class="Home-link">Home</a>
    <?php
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
      echo '<a href="user_page.php" class="profile-link">Profile</a> ';
      echo '<a href="all_anime_questions.php" class="profile-link">View Anime Wisdom</a> ';
      echo '<a href="ask_anime_question.php" class="profile-link">Ask an Anime Question</a> ';
      echo '<a href="answer_anime_question.php" class="profile-link">Anime Wisdom</a> ';
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
      <h2>How to Use the Anime Weeb Forum</h2>
      <div class="content">
        <p>Welcome to the Anime Weeb Forum! Here's how you can make the most of our anime-loving community:</p>
        <ul>
          <li><strong>Ask an Anime Question:</strong> Dive into the world of anime by clicking on "Ask an Anime Question." Share your burning questions about anime, characters, or plots, and let fellow weebs provide their insights.</li>
          <li><strong>Register:</strong> If you haven't already, become an official anime weeb forum member by clicking on "Register." Answer our special anime-related question to prove your passion for the world of anime.</li>
          <li><strong>Help:</strong> If you ever find yourself lost in the world of anime, our "Help" section is here to guide you. Get tips and tricks on how to navigate our forum with ease.</li>
        </ul>
      </div>
    </section>
  </main>

  <footer>
    <p>© 2023 - Anime Weeb Forum</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
