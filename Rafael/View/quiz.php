<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Quiz Projeto de Vida</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #004080;
      color: white;
      padding: 20px;
      margin: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .pergunta,
    #resultado {
      max-width: 600px;
      width: 100%;
      margin: auto;
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 10px;
      display: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .pergunta.active {
      display: block;
    }

    button {
      margin-top: 15px;
      padding: 10px 20px;
      background: #ffffff;
      color: #004080;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #004080;
      color: white;
    }

    canvas {
      background: white;
      border-radius: 10px;
      margin-top: 20px;
    }

    #resultado {
      text-align: center;
      display: none;
    }

    .container-button {
      text-align: center;
    }

    @media (max-width: 768px) {

      .pergunta,
      #resultado {
        max-width: 90%;
        padding: 15px;
      }

      button {
        padding: 8px 16px;
      }

      canvas {
        width: 100%;
        height: auto;
      }
    }
  </style>
</head>

<body>
  <h2>Quiz: Descubra seu estilo de Projeto de Vida</h2>

  <form id="quizForm">
    <div class="pergunta active" data-index="0">
      <p>1. Quando pensa no seu futuro, você:</p>
      <label><input type="radio" name="q1" value="visionario"> Grandes conquistas e realizações</label><br>
      <label><input type="radio" name="q1" value="planejador"> Metas e planos detalhados</label><br>
      <label><input type="radio" name="q1" value="pratico"> Foca no que pode fazer hoje</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="1">
      <p>2. Como organiza seu tempo?</p>
      <label><input type="radio" name="q2" value="planejador"> Usa agenda e planejamento</label><br>
      <label><input type="radio" name="q2" value="visionario"> Muitas ideias mas se perde</label><br>
      <label><input type="radio" name="q2" value="pratico"> Resolve conforme as tarefas aparecem</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="2">
      <p>3. O que mais representa você?</p>
      <label><input type="radio" name="q3" value="visionario"> Criativo e cheio de ideias</label><br>
      <label><input type="radio" name="q3" value="planejador"> Organizado e focado</label><br>
      <label><input type="radio" name="q3" value="pratico"> Realista e objetivo</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="3">
      <p>4. Qual frase combina com você?</p>
      <label><input type="radio" name="q4" value="visionario"> "O futuro pertence a quem sonha"</label><br>
      <label><input type="radio" name="q4" value="planejador"> "Plano bem feito é meio caminho andado"</label><br>
      <label><input type="radio" name="q4" value="pratico"> "O importante é fazer acontecer"</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="4">
      <p>5. Diante de um desafio, você:</p>
      <label><input type="radio" name="q5" value="visionario"> Imagina novas possibilidades</label><br>
      <label><input type="radio" name="q5" value="planejador"> Analisa os passos antes de agir</label><br>
      <label><input type="radio" name="q5" value="pratico"> Age com o que tem em mãos</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="5">
      <p>6. Seu lema de vida seria:</p>
      <label><input type="radio" name="q6" value="visionario"> "O céu é o limite"</label><br>
      <label><input type="radio" name="q6" value="planejador"> "Cada coisa em seu tempo"</label><br>
      <label><input type="radio" name="q6" value="pratico"> "Mãos à obra!"</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="6">
      <p>7. Como você reage ao imprevisto?</p>
      <label><input type="radio" name="q7" value="visionario"> Enxerga como uma nova oportunidade</label><br>
      <label><input type="radio" name="q7" value="planejador"> Recalcula o plano</label><br>
      <label><input type="radio" name="q7" value="pratico"> Resolve rapidamente</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="7">
      <p>8. Quando você começa um projeto, você:</p>
      <label><input type="radio" name="q8" value="visionario"> Foca na criatividade e inovação</label><br>
      <label><input type="radio" name="q8" value="planejador"> Planeja cada etapa antes de começar</label><br>
      <label><input type="radio" name="q8" value="pratico"> Começa logo e ajusta ao longo do caminho</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="8">
      <p>9. Como você se sente em relação aos riscos?</p>
      <label><input type="radio" name="q9" value="visionario"> Enfrento os riscos com confiança</label><br>
      <label><input type="radio" name="q9" value="planejador"> Prefiro avaliar bem os riscos antes de agir</label><br>
      <label><input type="radio" name="q9" value="pratico"> Tento minimizar os riscos ao máximo</label><br>
      <button type="button" onclick="proximaPergunta()">Próxima</button>
    </div>

    <div class="pergunta" data-index="9">
      <p>10. Se você tivesse que escolher um projeto para o futuro, qual seria?</p>
      <label><input type="radio" name="q10" value="visionario"> Criar algo revolucionário</label><br>
      <label><input type="radio" name="q10" value="planejador"> Montar um plano para algo grandioso</label><br>
      <label><input type="radio" name="q10" value="pratico"> Colocar uma ideia prática em ação</label><br>
      <button type="button" onclick="proximaPergunta()">Ver Resultado</button>
    </div>
  </form>

  <div id="resultado">
    <h2>Resultado do Quiz</h2>
    <p id="perfilTexto"></p>
    <canvas id="grafico" width="400" height="300"></canvas>
    <div class="container-button">
      <button onclick="voltarParaInicio()">Voltar para o início</button>
    </div>
  </div>

  <script>
    let perguntas = document.querySelectorAll('.pergunta');
    let indice = 0;

    function proximaPergunta() {
      let atual = perguntas[indice];
      let radioSelecionado = atual.querySelector('input[type="radio"]:checked');

      if (!radioSelecionado) {
        alert('Por favor, selecione uma resposta.');
        return;
      }

      atual.classList.remove('active');
      indice++;

      if (indice < perguntas.length) {
        perguntas[indice].classList.add('active');
      } else {
        enviarQuiz();
      }
    }

    function enviarQuiz() {
      const formData = new FormData(document.getElementById('quizForm'));
      const respostas = {};
      formData.forEach((val, key) => respostas[key] = val);

      fetch('processar_respostas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(respostas)
      })
        .then(resp => resp.json())
        .then(data => {
          console.log(data);  // Verifique os dados recebidos no console

          document.getElementById('quizForm').style.display = 'none';
          document.getElementById('resultado').style.display = 'block';
          document.getElementById('perfilTexto').textContent = `Seu perfil é: ${data.perfil}`;

          // Criar o gráfico com os dados recebidos
          const ctx = document.getElementById('grafico').getContext('2d');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['Visionário', 'Planejador', 'Prático'],
              datasets: [{
                label: 'Pontuação',
                data: [
                  data.pontuacoes.visionario || 0,
                  data.pontuacoes.planejador || 0,
                  data.pontuacoes.pratico || 0
                ],
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e']
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        })
        .catch(error => {
          console.error('Erro ao enviar o quiz:', error);
        });
    }




    function voltarParaInicio() {
      window.location.href = 'inicio.php';
    }
  </script>


  </script>
</body>

</html>