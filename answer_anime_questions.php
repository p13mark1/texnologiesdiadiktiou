<?php
session_start();
require_once('config.php'); // Your database connection configuration

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $question_id = $_POST["question_id"];
    $main_text = $_POST["main_text"];

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $insert_query = "INSERT INTO anime_answers (user_id, question_id, main_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iis", $user_id, $question_id, $main_text);

    if ($stmt->execute()) {
        $success_message = "Answer submitted successfully.";
    } else {
        $error_message = "Error submitting answer: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to the Anime Weeb Forum - Answer Questions</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <h1>Welcome to the Anime Weeb Forum!</h1>
    <button class="theme-toggle">Toggle Theme</button>
    <a href="Home.php" class="Home-link">Home</a>
    <a href="help.php" class="help-link">Help</a>
    <a href="ask" class="ask-link">Ask a Question</a>
    <a href="all_anime_questions.php" class="ask-link">View Wisdom</a>
    <?php
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        echo '<a href="user_page.php" class="profile-link">My Profile</a>';
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
    <section class="answer-form">
      <h2>Answer an Anime Question</h2>
      <form action="answer_anime_question.php" method="post">
        <label for="question_id">Select Question:</label>
        <select id="question_id" name="question_id" required>
          <?php
          $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

          if ($conn->connect_error) {
              die("Database connection failed: " . $conn->connect_error);
          }

          $question_query = "SELECT id, title FROM anime_questions ORDER BY created_at DESC";
          $question_result = $conn->query($question_query);

          if ($question_result->num_rows > 0) {
              while ($row = $question_result->fetch_assoc()) {
                  echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
              }
          }

          $conn->close();
          ?>
        </select>
        <label for="main_text">Your Answer:</label>
        <textarea id="main_text" name="main_text" rows="4" required></textarea>
        <button type="submit">Submit Answer</button>
      </form>
      <?php
      if (isset($success_message)) {
          echo '<p class="success">' . $success_message . '</p>';
      } elseif (isset($error_message)) {
          echo '<p class="error">' . $error_message . '</p>';
      }
      ?>
    </section>
  </main>
  <footer>
    <p>© <?php echo date("Y"); ?> - Anime Weeb Forum</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>
