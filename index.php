<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>I am an Anime Weeb Forum</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Welcome to the "I am an Anime Weeb Forum"!</h1>
    <button class="theme-toggle">Toggle Theme</button>
    <a href="help.php" class="help-link">Help</a>
    
    <?php
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
      echo '<a href="user_profile.php" class="profile-link">My Profile</a> ';
      echo '<a href="view_questions.php" class="profile-link">View Questions</a> ';
      echo '<a href="ask_question.php" class="profile-link">Ask a Question</a> ';
      echo '<a href="answer_question.php" class="profile-link">Answer Questions</a> ';
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
    <section class="forum-description">
      <h2>Explore the World of Anime with Us</h2>
      <div class="content">
        <p>Welcome to the "I am an Anime Weeb Forum"! This is the place where anime enthusiasts like you can come together to ask questions, share knowledge, and discuss your favorite anime series and characters.</p>
        <p>Feel free to ask any anime-related questions you have in mind or help others by answering their questions. Let's build a vibrant anime community together!</p>
      </div>
    </section>

    <section class="how-to-join">
      <h2>How to Join the Forum</h2>
      <div class="content">
        <p>To become a part of our anime-loving community, follow these steps:</p>
        <a href="register.php" class="ask-link">Register</a> if you're new to the forum.
        <a href="login.php" class="ask-link">Log in</a> if you're already a member.
      </div>
    </section>
  </main>

  <footer>
    <p>© <?php echo date("Y"); ?> - I am an Anime Weeb Forum</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>

