<?PHP
ECHO $dataHoje = date('d/m/y');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .login{
        border: 2px solid black;
        margin-top: 10vh;
        margin-left: 40%;
        width: 200px;
        padding: 10px;
    }
	</style>
</head>
<body>
<div class="login">
		<form action="login_ok.php" method="POST">
			<h3>Formulario de Login</h3>
			<label>CPF: </label> <input type="text" name="login" id="login">
			<br>
			<label>Senha: </label> <input type="text" name="senha" id="senha">
			<br>
			<input type="submit" value="Login">
		</form>
	</div>
</body>
</html>