<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST["jautajums"];
    $answer1_text = $_POST["atbilde1"];
    $answer2_text = $_POST["atbilde2"];
    $correct_answer = $_POST["pareiza_atbilde"];

    // Insert question into the 'questions' table
    $sql_question = "INSERT INTO questions (text) VALUES ('$text')";
    $conn->query($sql_question);
    $question_id = $conn->insert_id;

    // Insert answers into the 'answers' table
    $sql_answer1 = "INSERT INTO answers (answers_text, question_id, is_correct) VALUES ('$answer1_text', $question_id, " . ($correct_answer == 1 ? '1' : '0') . ")";
    $sql_answer2 = "INSERT INTO answers (answers_text, question_id, is_correct) VALUES ('$answer2_text', $question_id, " . ($correct_answer == 2 ? '1' : '0') . ")";
    
    $conn->query($sql_answer1);
    $conn->query($sql_answer2);

    // Redirect to prevent form resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izveidot jautājumus</title>
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

        .questions {
            max-width: 800px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
        }

        input {
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="questions">
        <h1>Izveidot Jautājumus</h1>
        <form method="post" action="http://localhost/Izmeginajuma_eksamens/create.php?jautajums=test&atbilde1=test+1&atbilde2=test+2&pareiza_atbilde=2">
            <label for="jautajums">Jautājums:</label>
            <input type="text" id="jautajums" name="jautajums" required>

            <label for="atbilde1">Atbilde 1:</label>
            <input type="text" id="atbilde1" name="atbilde1" required>

            <label for="atbilde2">Atbilde 2:</label>
            <input type="text" id="atbilde2" name="atbilde2" required>

            <label for="pareiza_atbilde">Pareizais atbilžu variants (1 vai 2):</label>
            <input type="number" id="pareiza_atbilde" name="pareiza_atbilde" min="1" max="2" required>

            <input type="submit" value="Iesniegt">
        </form>
    </div>
</body>
</html>