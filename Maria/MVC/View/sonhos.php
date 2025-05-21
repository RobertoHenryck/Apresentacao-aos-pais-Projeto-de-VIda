<?php
session_start();
require_once 'C:\Turma2\xampp\htdocs\projeto de vida\MVC\config\config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_nome'])) {
  header('Location: login.php');
  exit;
}

// Obter os dados do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nome, foto_perfil, data_nascimento FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Projeto de Vida</title>
  <link href="https://fonts.googleapis.com/css2?family=Platypi&display=swap" rel="stylesheet">
  <style>
    * {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: 'Platypi', serif;
  background-color: #FF7E7E;
}

header {
  background-color: #5B0A29;
  color: #FFB3B3;
  padding: 10px 20px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}

.left-header {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.logo {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
  color: #FFA3A3;
}

.user-profile {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user-profile img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: 2px solid white;
  background-color: #C4C4C4;
}

.user-info {
  display: flex;
  flex-direction: column;
  color: #FFA3A3;
  font-size: 14px;
}

.user-info a {
  color: #FFA3A3;
  text-decoration: none;
  font-size: 14px;
}

.user-info a:hover {
  text-decoration: underline;
}

nav a {
  margin-left: 20px;
  text-decoration: none;
  color: #FFA3A3;
  font-size: 18px;
}

.container {
  display: flex;
  justify-content: center;
  padding: 40px;
}

.painel-formulario {
  background-color: #FFB3B3;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 900px;
}

form {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px 50px;
}

.form-group {
  color: #5B0A29;
  display: flex;
  flex-direction: column;
}

label {
  font-weight: bold;
  margin-bottom: 5px;
  font-size: 16px;
}

input[type="text"] {
  border: none;
  border-bottom: 2px solid #5B0A29;
  background: transparent;
  padding: 5px 0;
  font-size: 16px;
}

select {
  border: 2px solid #5B0A29;
  border-radius: 25px;
  padding: 8px 12px;
  font-size: 16px;
  background: transparent;
  width: 100%;
}

.full-width {
  grid-column: span 2;
  display: flex;
  justify-content: center;
  color: #7a103f;
}


button[type="submit"] {
  display: block;
  margin: 30px auto 0;
  background-color: #5B0A29;
  color: #FFA3A3;
  border: none;
  padding: 12px 30px;
  border-radius: 12px;
  font-size: 18px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #7E0E3B;
}

.footer {
  background-color: #5B0A29;
  color: #FFB3B3;
  text-align: center;
  padding: 15px;
  font-size: 14px;
  margin-top: 300px;
}

  </style>
</head>
<body>

  <header>
    <div class="left-header">
      <div class="logo">Projeto de vida</div>
      <div class="user-profile">
      <img src="<?= htmlspecialchars($usuario['foto_perfil'] ?? 'download.png') ?>" alt="Foto de perfil">
        <div class="user-info">
        <?php echo htmlspecialchars($usuario['nome']); ?>
          <a href="perfil.php">editar perfil</a>
        </div>
      </div>
    </div>
    <nav>
      <a href="inicio.php">Home</a>
      <a href="formulario.php">Teste de personalidade</a>
      <a href="plano.php">Teste de inteligencia</a>
    </nav>
  </header>

 <div class="container">
  <div class="painel-formulario">
     <form action="salvar_quem_sou.php" method="post">
  <!-- ... todos os campos ... -->
    
    

  <div class="form-group">
    <label for="aspiracoes">Minhas aspirações</label>
    <input type="text" id="aspiracoes" name="aspiracoes" />
  </div>
  <div class="form-group">
    <label for="sonhos_hoje">O que ainda vou fazer</label>
    <input type="text" id="sonhos_hoje" name="sonhos_hoje" />
  </div>

  <div class="form-group">
    <label for="infancia">Meus sonhos de infância</label>
    <input type="text" id="infancia" name="infancia" />
  </div>
  <div class="form-group">
    <label for="faco_agora">O que já estou fazendo</label>
    <input type="text" id="faco_agora" name="faco_agora" />
  </div>

  <div class="form-group">
    <label for="vou_fazer">Meus sonhos hoje</label>
    <input type="text" id="vou_fazer" name="vou_fazer" />
  </div>

  <div class="form-group">
    <label for="profissao">Profissão dos sonhos</label>
    <select id="profissao" name="profissao">
      <option value="">Profissão</option>
          <option>Médico</option>
          <option>Engenheiro civil</option>
          <option>Advogado</option>
          <option>Professor</option>
          <option>Enfermeiro</option>
          <option>Psicólogo</option>
          <option>Arquiteto</option>
          <option>Administrador</option>
          <option>Contador</option>
          <option>Fisioterapeuta</option>
          <option>Nutricionista</option>
          <option>Farmacêutico</option>
          <option>Dentista</option>
          <option>Jornalista</option>
          <option>Publicitário</option>
          <option>Designer gráfico</option>
          <option>Desenvolvedor de software</option>
          <option>Analista de sistemas</option>
          <option>Cientista de dados</option>
          <option>Engenheiro de software</option>
          <option>Engenheiro elétrico</option>
          <option>Engenheiro mecânico</option>
          <option>Engenheiro de produção</option>
          <option>Biólogo</option>
          <option>Químico</option>
          <option>Físico</option>
          <option>Pedagogo</option>
          <option>Professor universitário</option>
          <option>Técnico em informática</option>
          <option>Técnico em enfermagem</option>
          <option>Técnico em segurança do trabalho</option>
          <option>Eletricista</option>
          <option>Encanador</option>
          <option>Pintor</option>
          <option>Pedreiro</option>
          <option>Mestre de obras</option>
          <option>Carpinteiro</option>
          <option>Serralheiro</option>
          <option>Vendedor</option>
          <option>Caixa</option>
          <option>Garçom</option>
          <option>Cozinheiro</option>
          <option>Chef de cozinha</option>
          <option>Confeiteiro</option>
          <option>Atendente</option>
          <option>Recepcionista</option>
          <option>Secretário</option>
          <option>Assistente administrativo</option>
          <option>Gerente de loja</option>
          <option>Supervisor</option>
          <option>Motorista</option>
          <option>Caminhoneiro</option>
          <option>Motoboy</option>
          <option>Operador de empilhadeira</option>
          <option>Agente de viagens</option>
          <option>Guia de turismo</option>
          <option>Policial</option>
          <option>Bombeiro</option>
          <option>Militar</option>
          <option>Guarda municipal</option>
          <option>Juiz</option>
          <option>Promotor</option>
          <option>Delegado</option>
          <option>Investigador</option>
          <option>Corretor de imóveis</option>
          <option>Economista</option>
          <option>Bibliotecário</option>
          <option>Historiador</option>
          <option>Sociólogo</option>
          <option>Antropólogo</option>
          <option>Geógrafo</option>
          <option>Tradutor</option>
          <option>Intérprete</option>
          <option>Cantor</option>
          <option>Músico</option>
          <option>Ator</option>
          <option>Dançarino</option>
          <option>Fotógrafo</option>
          <option>Cineasta</option>
          <option>Roteirista</option>
          <option>Editor de vídeo</option>
          <option>Ilustrador</option>
          <option>Artista plástico</option>
          <option>Tatuador</option>
          <option>Barbeiro</option>
          <option>Cabeleireiro</option>
          <option>Maquiador</option>
          <option>Esteticista</option>
          <option>Personal trainer</option>
          <option>Treinador</option>
          <option>Técnico esportivo</option>
          <option>Árbitro</option>
          <option>Agricultor</option>
          <option>Zootecnista</option>
          <option>Veterinário</option>
          <option>Agrônomo</option>
          <option>Engenheiro ambiental</option>
          <option>Engenheiro florestal</option>
          <option>Silvicultor</option>
          <option>Técnico agropecuário</option>
          <option>Influenciador digital</option>
          <option>Streamer</option>
          <option>Youtuber</option>
          <option>Astronauta</option>
          <option>Comissário de bordo</option>
          <option>Piloto de avião</option>
          <option>Mecânico de aeronaves</option>
          <option>Analista de logística</option>
          <option>Técnico em edificações</option>
          <option>Operador de telemarketing</option>
          <option>Analista de marketing</option>
          <option>Gerente de projetos</option>
          <option>Engenheiro de dados</option>
          <option>Especialista em segurança da informação</option>
          <option>UX designer</option>
          <option>UI designer</option>
          <option>Redator publicitário</option>
          <option>Copywriter</option>
          <option>Consultor</option>
          <option>Empreendedor</option>
          <option>CEO</option>
          <option>CTO</option>
          <option>COO</option>
        </select>
     
  </div>

  <div class="full-width">
    <button type="submit">Avançar</button>
  </div>

</form>

  </div>

 </form>
  </div>
</div>
  <footer class="footer">
    <p>&copy; 2025 Projeto de Vida. Todos os direitos reservados.</p>
  </footer>
  
</body>
</html>

     