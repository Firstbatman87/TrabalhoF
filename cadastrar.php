<?php
// Conexão com o banco de dados
$hostname = "localhost";
$username = "root"; // Substitua pelo seu usuário do MySQL
$password = "";   // Substitua pela sua senha do MySQL
$database = "trabalho";    // Nome do banco de dados criado

$conn = mysqli_connect($hostname, $username, $password, $database);

// Verifica a conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Verifica se os dados foram enviados por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

    // Prepara a declaração SQL para prevenir injeção SQL
    $sql = "INSERT INTO usuario (login, senha) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, $login, $senha);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='cadastro.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário. Tente novamente!'); window.location.href='cadastro.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Erro na preparação do comando SQL!'); window.location.href='cadastro.php';</script>";
    }
}

mysqli_close($conn);
?>