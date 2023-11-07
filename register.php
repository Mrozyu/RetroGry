<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Bezpieczne hashowanie hasła

    // Połączenie z bazą danych (ustaw odpowiednie dane dostępowe)
    $conn = new mysqli("localhost", "db_username", "db_password", "db_name");

    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    // Sprawdzenie, czy użytkownik o podanej nazwie już istnieje
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "Użytkownik o takiej nazwie już istnieje.";
    } else {
        // Dodanie użytkownika do bazy danych
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($query) === TRUE) {
            echo "Zarejestrowano pomyślnie.";
            header('Location: index.html');
        } else {
            echo "Błąd rejestracji: " . $conn->error;
        }
    }

    $conn->close();
}
?>
