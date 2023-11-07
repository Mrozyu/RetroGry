<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Połączenie z bazą danych (ustaw odpowiednie dane dostępowe)
    $conn = new mysqli("localhost", "db_username", "db_password", "db_name");

    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    // Pobranie hasła użytkownika z bazy danych
    $query = "SELECT password FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        // Sprawdzenie hasła
        if (password_verify($password, $stored_password)) {
            echo "Zalogowano pomyślnie.";
            header('Location: index.html');
        } else {
            echo "Błąd logowania: Nieprawidłowe hasło.";
        }
    } else {
        echo "Błąd logowania: Użytkownik o podanej nazwie nie istnieje.";
    }

    $conn->close();
}
?>
