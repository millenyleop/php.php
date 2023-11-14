<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$obj_mysqli = new mysqli("127.0.0.1", "phpmyadmin", "aluno", "TutoCrudPhp");

if ($obj_mysqli->connect_errno) {
echo "Ocorreu um erro na conexão com o banco de dados.";
exit;
}

mysqli_set_charset($obj_mysqli, 'utf8');

$erro = $sucesso = "";

// Validando a existência dos dados
if (isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"])) {
if (empty($_POST["nome"])) {
$erro = "Campo nome obrigatório";
} elseif (empty($_POST["email"])) {
$erro = "Campo e-mail obrigatório";
} elseif (empty($_POST["senha"])) {
$erro = "Campo senha obrigatório";
} else {
// Vamos realizar o cadastro ou alteração dos dados enviados.
$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];

$stmt = $obj_mysqli->prepare("INSERT INTO `Cliente` (`Nome`,`Email`,`Senha`) VALUES (?,?,?)");
$stmt->bind_param('sss', $nome, $email, $senha);

if (!$stmt->execute()) {
$erro = "Erro no SQL: " . $stmt->error;
} else {
$sucesso = "Dados cadastrados com sucesso!";
}
}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Cadastro</title>
</head>
<body>
<form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
Nome:<br/>
<input type="text" name="nome" placeholder="Qual seu nome?"><br/><br/>
E-mail:<br/>
<input type="email" name="email" placeholder="Qual seu e-mail?"><br/><br/>
Senha:<br/>
<input type="password" name="senha" placeholder="Qual sua senha?"><br/><br/>

<?php if(isset($erro)) { echo "<p style='color:red'>$erro</p>"; } ?>
<?php if(isset($sucesso)) { echo "<p style='color:green'>$sucesso</p>"; } ?>

<br/><br/>
<input type="hidden" value="-1" name="id">
<button type="submit">Cadastrar</button>
</form>
</body>
</html>