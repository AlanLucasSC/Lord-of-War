<?php 
public function exec($query, $type, $param){
        //echo $param['nome'];
        //echo $param['senha'];
        //echo $type;
        //echo $query;
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param($type, ...$param);
        //echo "string";
        $stmt->execute();
        if($stmt->field_count>0)
            $result = $stmt->get_result();
        else
            $result=TRUE;
        if ($this->conn->errno) {
            die('Invalid query: '.$this->conn->error());
        }
        return $result;
    }
    
    if(isset($_GET['email']) and isset($_GET['senha'])){

        $param = array();
        array_push($param, $_GET['email']);
        array_push($param, $_GET['nick']);
        array_push($param, $_GET['nome']);
        array_push($param, $_GET['senha']);
        $sql="INSERT INTO `usuario` (`email`, `nick`, `nome`, `senha`) VALUES (?, ?, ?, ?);";
        
        $result = $objBd->exec($sql, 'ssss', $param);
        if($result == 1)
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