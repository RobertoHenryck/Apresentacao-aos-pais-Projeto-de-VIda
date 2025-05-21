<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Projeto de Vida</title>
    <link rel="stylesheet" href="inicio.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
        }

        .principal {
            background-color: #004080;
            color: white;
            padding: 20px 0;
            
        }

        .cabecalho {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .img2 {
            height: 80px;
        }

        .imgs {
            width: 80px;
            height: 80px;
            transition: transform 0.2s;
        }

        .imgs:hover {
            transform: scale(1.05);
        }

        h1 {
            font-size: 28px;
        }

        .assunto {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 800px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        .assunto h3 {
            font-size: 22px;
            color: #333;
        }

        .assunto img {
            height: 70px;
        }

        .assunto2 {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px auto;
            padding: 20px 40px;
            border-radius: 30px;
            background-color: #0056b3;
            width: fit-content;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }

        .assunto2 a {
            text-decoration: none;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .assunto2:hover {
            background-color: #003d80;
        }
    </style>
</head>

<body>

<?php include 'topo.php'; ?>

  <style>
    body {
      background-color: #bfbfbf;
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .quiz {
      background-color: #618c78;
      color: #fff;
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border-radius: 15px;
    }

    h1, h2 {
      text-align: center;
    }

    .pergunta {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    .botao {
      display: block;
      margin: 20px auto;
      padding: 10px 25px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      background-color: #28a745;
      color: white;
      cursor: pointer;
    }

    .resultado {
      margin-top: 20px;
      background-color: #ffffff;
      color: #333;
      padding: 20px;
      border-radius: 10px;
      display: none;
      text-align: center;
    }

    .quiz{
      background-color: #0056b3;
    }
  </style>
</head>

<br>
<br>

<body>
  <div class="quiz">
    <h1>Teste de Personalidade</h1>
    <h2>Descubra mais sobre você!</h2>

    <form id="quizForm">
  <p>1 - O que é mais importante para você no momento?</p>
    <label><input type="radio" name="q1" value="A"> Me conhecer Melhor</label><br>
    <label><input type="radio" name="q1" value="B"> Construir uma carreira sólida</label><br>
    <label><input type="radio" name="q1" value="C"> Ter equilíbrio entre trabalho e vida pessoal</label><br>

    <p>2 - Qual dessas frases mais combina com você?</p>
    <label><input type="radio" name="q2" value="A"> “Quero viver com propósito.”</label><br>
    <label><input type="radio" name="q2" value="B"> “Quero alcançar grandes conquistas.”</label><br>
    <label><input type="radio" name="q2" value="C"> “Quero viver com leveza e tranquilidade.”</label><br>

    <p>3 - Como você lida com desafios?</p>
    <label><input type="radio" name="q3" value="A"> Vejo como oportunidades de crescimento</label><br>
    <label><input type="radio" name="q3" value="B"> Faço um plano e sigo até resolver</label><br>
    <label><input type="radio" name="q3" value="C"> Tento manter a calma e não me cobrar tanto</label><br>

    <p>4 - O que te inspira a seguir em frente?</p>
    <label><input type="radio" name="q4" value="A"> Meus sonhos e objetivos</label><br>
    <label><input type="radio" name="q4" value="B"> O apoio das pessoas ao meu redor</label><br>
    <label><input type="radio" name="q4" value="C"> A possibilidade de aprender algo novo</label><br>

    <p>5 - Onde você quer estar daqui a 10 anos?</p>
    <label><input type="radio" name="q5" value="A"> Realizado pessoalmente e profissionalmente</label><br>
    <label><input type="radio" name="q5" value="B"> Trabalhando com algo que me faz feliz</label><br>
    <label><input type="radio" name="q5" value="C"> Vivendo de forma simples e com qualidade de vida</label><br>

    <br> 
  <button type="submit" style="font-size: 25px; border-radius: 40px; padding: 10px 30px; display: block; margin: 20px auto;">
    Ver resultado
  </button>
</form>

<script>
document.getElementById('quizForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const respostas = ['q1', 'q2', 'q3', 'q4', 'q5'];
    const contagem = { A: 0, B: 0, C: 0 };

    for (const r of respostas) {
        const valor = document.querySelector(`input[name="${r}"]:checked`);
        if (!valor) {
            alert("Por favor, responda todas as perguntas.");
            return;
        }
        contagem[valor.value]++;
    }

    let resultadoFinal = 'A';
    if (contagem.B > contagem.A && contagem.B > contagem.C) resultadoFinal = 'B';
    else if (contagem.C > contagem.A && contagem.C > contagem.B) resultadoFinal = 'C';

    const form = new FormData();
    form.append('resultado', resultadoFinal);

    fetch('salvar_resultado.php', {
        method: 'POST',
        body: form
    })
    .then(response => {
        if (!response.ok) throw new Error('Erro ao salvar o resultado.');
        return response.text();
    })
    .then(() => {
        alert('Seu perfil é: ' + resultadoFinal);
        window.location.href = 'pagina_final.php';
    })
    .catch(error => {
        alert('Erro: ' + error.message);
    });
});
</script>



<script>
document.getElementById('quizForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const respostas = ['q1', 'q2', 'q3', 'q4', 'q5'];
    const contagem = { A: 0, B: 0, C: 0 };


    for (const r of respostas) {
        const valor = document.querySelector(`input[name="${r}"]:checked`);
        if (valor) contagem[valor.value]++;
    }

    let resultadoFinal = 'A';
    if (contagem.B > contagem.A && contagem.B > contagem.C) resultadoFinal = 'B';
    else if (contagem.C > contagem.A && contagem.C > contagem.B) resultadoFinal = 'C';

    // Enviar resultado final para o PHP
    const form = new FormData();
    form.append('resultado', resultadoFinal);

    fetch('salvar_resultado.php', {
        method: 'POST',
        body: form
    }).then(() => {
        alert('Seu perfil é: ' + resultadoFinal);
        window.location.href = 'pagina_final.php'; // Redireciona após salvar
    });
});
</script>
</body>

</html>
