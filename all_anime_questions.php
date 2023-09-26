<?php
session_start();
require_once('config.php'); // Your database connection configuration

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Create a database connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$animeQuestions = array();

// Check if a search query is submitted
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = $conn->real_escape_string($_GET['search_query']);
    $search_criteria = $_GET['search_criteria'] ?? 'all';

    // Construct the SQL query based on the chosen criteria
    if ($search_criteria === 'all') {
        $search_sql = "SELECT q.* FROM anime_questions q
                       LEFT JOIN users u ON q.user_id = u.id
                       WHERE q.title LIKE '%$search_query%' OR q.main_text LIKE '%$search_query%'
                       OR u.username LIKE '%$search_query%' OR q.created_at LIKE '%$search_query%'";
    } elseif ($search_criteria === 'username') {
        $search_sql = "SELECT q.* FROM anime_questions q
                       JOIN users u ON q.user_id = u.id
                       WHERE u.username LIKE '%$search_query%'";
    } elseif ($search_criteria === 'title') {
        $search_sql = "SELECT q.* FROM anime_questions q
                       WHERE q.title LIKE '%$search_query%'";
    } elseif ($search_criteria === 'main_text') {
        $search_sql = "SELECT q.* FROM anime_questions q
                       WHERE q.main_text LIKE '%$search_query%'";
    } elseif ($search_criteria === 'created_at') {
        $search_sql = "SELECT q.* FROM anime_questions q
                       WHERE q.created_at LIKE '%$search_query%'";
    }

    $search_result = $conn->query($search_sql);

    if ($search_result->num_rows > 0) {
        while ($row = $search_result->fetch_assoc()) {
            $animeQuestions[] = $row;
        }
    }
} else {
    // Fetch all anime-related questions from the database
    $question_query = "SELECT id, title, main_text, created_at FROM anime_questions ORDER BY created_at DESC";
    $question_result = $conn->query($question_query);

    if ($question_result->num_rows > 0) {
        while ($row = $question_result->fetch_assoc()) {
            $animeQuestions[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Anime Weeb Forum - All Questions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to the Anime Weeb Forum!</h1>
        <button class="theme-toggle">Toggle Theme</button>
        <a href="Home.php" class="Home-link">Home</a>
        <a href="help.php" class="help-link">Help</a>
        <a href="ask" class="ask-link">Ask a Question</a>
        <a href="answer_anime_questions.php" class="ask-link">Answer Questions</a>
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
        <form method="GET" action="all_anime_questions.php" class="search-form">
            <input type="text" name="search_query" placeholder="Search...">
            <select name="search_criteria">
                <option value="all">All</option>
                <option value="username">Username</option>
                <option value="title">Title</option>
                <option value="main_text">Question/Answer Text</option>
                <option value="created_at">Date Posted</option>
            </select>
            <button type="submit">Search</button>
        </form>
        <button id="export-xml" onclick="exportToXML()">Export to XML</button>
    </header>
    <main>
        <section class="content">
            <?php if (empty($animeQuestions)) : ?>
                <p>No results found.</p>
            <?php else : ?>
                <h2><?php echo isset($_GET['search_query']) ? 'Search Results' : 'All Anime Questions'; ?></h2>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Main Text</th>
                        <th>Date Posted</th>
                    </tr>
                    <?php foreach ($animeQuestions as $question) : ?>
                        <tr>
                            <td><a href="view_question.php?id=<?php echo $question['id']; ?>"><?php echo $question['title']; ?></a></td>
                            <td><?php echo $question['main_text']; ?></td>
                            <td><?php echo $question['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>© <?php echo date("Y"); ?> - Anime Weeb Forum</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
<script>
    function exportToXML() {
        // Create a new XML document
        var xmlDocument = document.implementation.createDocument(null, 'anime_questions');

        // Loop through the anime questions and answers to create XML elements
        <?php foreach ($animeQuestions as $question) : ?>
            var questionElement = xmlDocument.createElement('question');
            questionElement.setAttribute('id', '<?php echo $question['id']; ?>');
            questionElement.setAttribute('title', '<?php echo htmlentities($question['title']); ?>');
            questionElement.setAttribute('main_text', '<?php echo htmlentities($question['main_text']); ?>');
            questionElement.setAttribute('created_at', '<?php echo $question['created_at']; ?>');
            xmlDocument.documentElement.appendChild(questionElement);
        <?php endforeach; ?>

        // Convert the XML document to a string
        var serializer = new XMLSerializer();
        var xmlString = serializer.serializeToString(xmlDocument);

        // Create a downloadable link for the XML content
        var downloadLink = document.createElement('a');
        downloadLink.href = 'data:text/xml;charset=utf-8,' + encodeURIComponent(xmlString);
        downloadLink.download = 'anime_questions.xml';
        downloadLink.innerHTML = 'Download Anime Questions XML';

        // Append the link to the body and click it to trigger the download
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
