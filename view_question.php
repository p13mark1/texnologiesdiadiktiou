<?php
session_start();
require_once('config.php'); // Your database connection configuration

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $question_id = $_GET['id'];

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $question_query = "SELECT id, title, main_text, created_at FROM questions WHERE id = ?";
    $stmt = $conn->prepare($question_query);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $question_result = $stmt->get_result();

    if ($question_result->num_rows === 1) {
        $question = $question_result->fetch_assoc();

        $answers_query = "SELECT main_text, created_at FROM answers WHERE question_id = ? ORDER BY created_at ASC";
        $stmt = $conn->prepare($answers_query);
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $answers_result = $stmt->get_result();
    } else {
        header("Location: all_anime_questions.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: all_anime_questions.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Question View - Anime Forum</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Add your custom CSS styles here */
    body {
      font-family: "Your Anime Font", Arial, sans-serif;
      background-color: #f7dbd1;
      color: #ff00ff;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #ff6600;
      color: #ffffff;
      text-align: center;
      padding: 1rem 0;
    }

    main {
      padding: 2rem;
    }

    footer {
      background-color: #ff9933;
      color: #333;
      text-align: center;
      padding: 1rem 0;
    }

    /* Question View Styling */
    .question-view {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .question-view h2 {
      background-color: #ffcc00;
      color: #663399;
      padding: 1rem;
    }

    .question-view p {
      margin-top: 1rem;
    }

    /* Answers List Styling */
    .answers-list h2 {
      background-color: #ffcc00;
      color: #663399;
      padding: 1rem;
    }

    .answers-list ul {
      list-style-type: none;
      padding: 0;
    }

    .answers-list li {
      margin-top: 1rem;
      padding: 1rem;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .answers-list li p {
      margin: 0;
    }

    /* Theme Toggle Button */
    .theme-toggle {
      position: absolute;
      top: 1rem;
      right: 1rem;
      padding: 0.5rem 1rem;
      background-color: #ff99cc;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header>
    <h1>Welcome to the Anime Forum!</h1>
    <button class="theme-toggle">Toggle Theme</button>
    <a href="Home.php" class="Home-link">Home</a>
    <a href="help.php" class="help-link">Help</a>
    <a href="ask_anime_questions.php" class="ask-link">Ask a Question</a>
    <a href="answer_anime_questions.php" class="Wisdom">Wisdom</a>
    <?php
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        echo '<a href="user_page.php" class="profile-link">Profile</a>';
        echo '<form method="POST" style="display: inline;">
                <button type="submit" name="logout">Log out</button>
              </form>';
    } else {
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
    <section class="question-view">
      <h2><?php echo $question['title']; ?></h2>
      <p><?php echo $question['main_text']; ?></p>
      <p><strong>Posted on:</strong> <?php echo $question['created_at']; ?></p>
    </section>

    <section class="answers-list">
      <h2>Answers</h2>
      <ul>
        <?php
        if ($answers_result->num_rows > 0) {
            while ($answer = $answers_result->fetch_assoc()) {
                echo '<li><p>' . $answer['main_text'] . '</p><p><em>Posted on: ' . $answer['created_at'] . '</em></p></li>';
            }
        } else {
            echo '<li>No answers available.</li>';
        }
        ?>
      </ul>
    </section>
  </main>
  <footer>
    <p>© <?php echo date('Y'); ?> - Anime Forum</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>
