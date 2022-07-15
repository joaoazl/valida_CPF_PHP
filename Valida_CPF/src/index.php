<?php
$erro = "";
$cpfValido = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $arrayCpf = clearPost($_POST['cpf']);

    // if(empty($cpf)){
    //     $erro = "Campo não pode ser vazio";
    // }
    
    function validFirstDigit($arrayCpf){
        
        $cpf = preg_replace( '/[^0-9]/is', '', $arrayCpf);
        
        $sum = 0;
        for($index = 0; $index < 9; $index++){
            $cpf = intval($arrayCpf[$index] ?? 0);
            $sum += $cpf * (10 - $index);
            $rest = ($sum * 10)%11;
        }
        if($rest < 10){
            echo "<script>console.log('$rest')</script>";
            return $arrayCpf[9] == $rest;
        }
        echo "<script>console.log('$rest')</script>";
        return $arrayCpf[9] == 0;

    }

    function validSecondDigit($arrayCpf){
        
        $cpf = preg_replace( '/[^0-9]/is', '', $arrayCpf);
        
        $sum = 0;
        for($index = 0; $index < 10; $index++){
            $cpf = intval($arrayCpf[$index] ?? 0);
            $sum += $cpf * (11 - $index);
            $rest = ($sum * 10)%11;
        }
        if($rest < 10){
            echo "<script>console.log('$rest')</script>";
            return $arrayCpf[9] == $rest;
        }
        echo "<script>console.log('$rest')</script>";
        return $arrayCpf[9] == 0;

    }

    function validNumRepet($arrayCpf) {
        $primeiro = $arrayCpf[0];
        $diferente = false;
        for($index = 1; $index < strlen($arrayCpf); $index++) {
          if($arrayCpf[$index] != $primeiro) {
            $diferente = true;
          }
        }
        return $diferente;
        echo "<script>console.log('$diferente')</script>";
    }

    
    function validCpf($arrayCpf, &$erro){
        if(strlen($arrayCpf) != 11){
            $erro = "Campo precisa ter 11 digitos!";
            echo "<script>console.log('$erro')</script>";
            return $erro;
        }

        if(!validNumRepet($arrayCpf)){
            $erro = "Os números são repetidos";
            echo "<script>console.log('$erro')</script>";
            return $erro;
        }
        
        if(!validFirstDigit($arrayCpf)){
            $erro = "CPF Inválido - 1";
            echo "<script>console.log('$erro')</script>";
            return $erro;
        }
        
        if(!validSecondDigit($arrayCpf)){
            $erro = "CPF Inválido";
            echo "<script>console.log('$erro')</script>";
            return $erro;
        }
        return true;
    }
    var_dump($erro);
    $valid = validCpf($arrayCpf, $erro);
}

function clearPost($value){
    $value = trim($value);
    $value = stripcslashes($value);
    $value = htmlspecialchars($value);

    return $value;
}

?>
<!DOCTYPE html>
<html lang="pt-br" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Validador de CPF</title>
</head>

<body style="height: 100%;">
    <div class="container" style="height: 100%;">
        <main>
            <form class="form" method="POST">
                <label>CPF</label>
                <input type="text" name="cpf" autocomplete="off" placeholder="Digite seu Cpf..." />
                <span class="erro"> <?php echo $erro ?? '' ?> </span>
                <div class="btn">
                    <button type="submit">Validar</button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>