<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jautajumu saraksts</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

h1 {
    text-align: center;
    color: #333;
}

.question-container {
    max-width: 800px;
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.question-container p {
    margin-bottom: 16px;
}

.question-container ul {
    list-style-type: none;
    padding: 0;
}

.question-container li {
    padding: 8px;
    margin-bottom: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
}

.question-container li:hover {
    background-color: #f9f9f9;
}

.correct {
    color: #4caf50;
    font-weight: bold;
}

.incorrect {
    color: #f44336;
    font-weight: bold;
}
    </style>
</head>
<body>
<div class="question-container">
    <h1>Tests</h1>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "data";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch all questions and their answers from the database
        $sql = "SELECT q.id AS question_id, q.text AS question_text, a.id AS answer_id, a.answers_text AS answer_text, a.is_correct
                FROM questions q
                JOIN answers a ON q.id = a.question_id
                ORDER BY q.id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $currentQuestionId = null;

            while ($row = $result->fetch_assoc()) {
                $question_id = $row["question_id"];
                $question_text = $row["question_text"];
                $answer_id = $row["answer_id"];
                $answer_text = $row["answer_text"];
                $is_correct = $row["is_correct"];

                if ($question_id !== $currentQuestionId) {
                    // Start a new question
                    if ($currentQuestionId !== null) {
                        echo "</ul></div>";
                    }

                    echo "<div class='question'>";
                    echo "<p><strong>Jautājums:</strong> $question_text</p>";
                    echo "<ul class='answer-list'>";
                    $currentQuestionId = $question_id;
                }

                // Display each answer with an indication of whether it's correct or incorrect
                echo "<li class='answer-item'>$answer_text";
                if ($is_correct == 1) {
                    echo " (Pareizi)";
                } else {
                    echo " (Nepareizi)";
                }
                echo "</li>";
            }

            // Close the last question
            echo "</ul></div>";
        } else {
            echo "No questions found.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>