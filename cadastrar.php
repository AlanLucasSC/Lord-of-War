<?php 


  
    
    if(isset($_GET['email']) and isset($_GET['senha'])){
    $sql = "INSERT INTO usuario(nome,
                email,
                nick,
                senha) VALUES (
                :nome, 
                :email, 
                :nick, 
                :senha)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':nome', $_POST['nome'], PDO::PARAM_STR);       
    $stmt->bindParam(':filmDescription', $_POST['email'], PDO::PARAM_STR); 
    $stmt->bindParam(':nick', $_POST['nick'], PDO::PARAM_STR);
    // use PARAM_STR although a number  
    $stmt->bindParam(':senha', $_POST['senha'], PDO::PARAM_STR); 


    $stmt->execute(); 

        if($stmt == 1)
            {
                $_SESSION['tipoAlert'] = 'Cadastro feito com sucesso';
                header("location:../index.php");
            }
        else{
            $_SESSION['error'] = 1;
            $_SESSION['where'] = '\"login.php\"';
            $_SESSION['type'] = 'Erro ao cadastrar';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>

    <form method="GET" action="cadastrar.php"> 
            <div class="col-md-4">
            <table>
                <tr>
                <td>
                <h2 >Cadastrar</h2>
                </td></tr>
                <tr>
                    <td><label>Nome: </label></td>
                    <td><input type="text" name="nome" class="form-control" size="23"> </td>
                </tr>
                <tr>
                    <td><label>Email:</label></td>
                    <td><input type="text" name="email" class="form-control" size="23"></td>
                </tr>
                <tr>
                    <td><label>Nick: </label></td>
                    <td><input type="text" name="nick" class="form-control" size="23"></td>
                </tr>
                <tr>
                    <td><label>Senha: </label></td>
                    <td><input type="password" name="senha" class="form-control" size="23"></td>
                </tr>
                <tr>
                    <td><input type="submit" class="btn-success">Cadastrar</button></td>
                </tr>
                </table>
            </div>
    </form>
</body>
</html>
<!--
CREATE TABLE IF NOT EXISTS `moinho`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NULL,
  `nick` VARCHAR(45) NULL,
  `nome` VARCHAR(45) NULL,
  `senha` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `nick_UNIQUE` (`nick` ASC))
ENGINE = InnoDB
