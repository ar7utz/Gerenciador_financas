<?php
session_start();
include ('../../assets/bd/conexao.php');

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'data-desc';
$usuario_id = $_SESSION['user_id'];
$order_by = 'data DESC';

$filter = isset($_GET['filtro']) ? $_GET['filtro'] : '';




switch ($filtro) {
  case 'data-asc':
      $order_by = 'data ASC';
      break;
  case 'data-desc':
      $order_by = 'data DESC';
      break;
  case 'valor-asc':
      $order_by = 'valor ASC';
      break;
  case 'valor-desc':
      $order_by = 'valor DESC';
      break;
  case 'descricao-asc':
      $order_by = 'descricao ASC';
      break;
  case 'descricao-desc':
      $order_by = 'descricao DESC';
      break;
}

$sql = "SELECT * FROM transacoes WHERE usuario_id = ? ORDER BY $order_by";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="pt-BR" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/css/scrollbar.css" />
    <link rel="shortcut icon" href="../../dinheiro.ico"/>

    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,400;0,700;1,100;1,400;1,700&display=swap"
      rel="stylesheet"
    />
    <title>Dashboard</title>
  </head>
  <body>
    <header>
      <div class="container">
        <h1>Gerenciamento de Finanças</h1>
        <a class="btn_sair" href="../login/logout.php">Sair</a>
        <a class="btn_voltar" href="../dashboard/hplogin.php">Voltar</a>
        <a class="btn_perfil" href="../usuario/perfil.php">Meu Perfil</a>
        <button id="toggleModal">+ Nova Transação</button>
      </div>
    </header>
    <main>
      <?php
        // Consultar o banco de dados para obter todas as transações
        $sql = "SELECT SUM(valor) AS total FROM transacoes WHERE usuario_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        $saldo = $row['total'];

        // Consultar o banco de dados para obter o total de entradas
        $sql = "SELECT SUM(valor) AS total FROM transacoes WHERE usuario_id = ? AND valor > 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        $entradas = $row['total'];

        // Consultar o banco de dados para obter o total de saídas
        $sql = "SELECT SUM(valor) AS total FROM transacoes WHERE usuario_id = ? AND valor < 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        $saidas = abs($row['total']); // Valor absoluto para garantir que seja positivo
        ?>

      <div class="container">
        <div class="total">
        <h2>SALDO</h2>
        <p id="saldo"><?php echo number_format($saldo, 2); ?></p>
        </div>
        <div class="entradas-saidas">
          <div class="card entradas">
            <h3>Entradas</h3>
            <p id="entradas"><?php echo number_format($entradas, 2); ?></p>
          </div>
          <div class="card saidas">
            <h3>Saídas</h3>
            <p id="saidas"><?php echo number_format($saidas, 2); ?></p>
          </div>
      </div>
        <div class="historico">
          <h2>Histórico</h2>


        <nav class="filtro-nav">
          <label for="filtro">Filtrar por:</label>
          <select id="filtro" onchange="aplicarFiltro()">
            <option value="data-asc" <?php echo ($filtro == 'data-asc') ? 'selected' : ''; ?>>Data (Mais antigos)</option>
            <option value="data-desc" <?php echo ($filtro == 'data-desc') ? 'selected' : ''; ?>>Data (Mais recentes)</option>
            <option value="valor-asc" <?php echo ($filtro == 'valor-asc') ? 'selected' : ''; ?>>Valor (Menor para maior)</option>
            <option value="valor-desc" <?php echo ($filtro == 'valor-desc') ? 'selected' : ''; ?>>Valor (Maior para menor)</option>
            <option value="descricao-asc" <?php echo ($filtro == 'descricao-asc') ? 'selected' : ''; ?>>Descrição (A-Z)</option>
            <option value="descricao-desc" <?php echo ($filtro == 'descricao-desc') ? 'selected' : ''; ?>>Descrição (Z-A)</option>
          </select>
        </nav>

        <nav class="filtro-nav">
          <label for="filtroSearch">Procurar</label>
          <input type="text">
        </nav>

          <ul id="historico-list">
          <?php
            include ('../../assets/bd/conexao.php');

            if (isset($_SESSION['user_id'])) {
              $usuario_id = $_SESSION['user_id'];
          
              $sql = "SELECT * FROM transacoes WHERE usuario_id = ? ORDER BY data DESC";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param('i', $usuario_id);
              $stmt->execute();
              $resultado = $stmt->get_result();
              
              // Verificar se há transações
              if ($resultado->num_rows > 0) {
                // Exibir as transações no histórico
                while ($row = $resultado->fetch_assoc()) {
                  echo '<li>';
                  echo '<span id="descricao" class="descricao">' . $row['descricao'] . '</span>';
                  echo '<span id="data" class="data">' . $row['data'] . '</span>';
                  echo '<span id="valor" class="valor">' . $row['valor'] . '</span>';
                  echo '<div>';
                  echo '<button id="" class="editar"><a href="../../modulos/transacoes/editar_transacao.php?id=' . $row['id'] . '">Editar</a></button>';
                  echo '<button id="" class="excluir" data-id="' . $row['id'] . '">Excluir</button>';
                  echo '</div>';
                  echo '</li>';
                }
              } else {
                echo '<li>Nenhuma transação encontrada.</li>';
              }
            }
            ?>
          </ul>
        </div>
      </div>
    </main>
    <form action="../transacoes/add_transacao.php" method="POST" >
        <div class="modal-overlay" id="modal" >
            <div class="modal">
                <h2>Nova Transação</h2>
                <div class="tipoTransacao">
                    <select name="tipo" required>
                        <option value="positivo">Transação Positiva</option>
                        <option value="negativo">Transação Negativa</option>
                    </select>
                </div>
                <form id="novaTransacaoForm" method="POST" action="adicionarTransacao.php">
                    <input type="text" name="descricao" placeholder="Descrição" required>
                    <input type="text" name="valor" placeholder="Valor" required>
                    <input type="date" name="data" required>
                    <div class="botoes">
                        <button type="button" class="cancelar" id="fecharModal">Cancelar</button>
                        <button type="submit" class="confirmar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </form>

    <div id="modalConfirmarExclusao" class="modal">
      <div class="modal-content">
        <p>Tem certeza de que deseja excluir esta nota?</p>
        <button id="confirmarExcluirNota">Confirmar</button>
        <button id="cancelarExcluirNota">Cancelar</button>
      </div>
    </div>

  <script src="../../assets/js/main.js"></script>
  <script>
      function aplicarFiltro() {
        const filtro = document.getElementById('filtro').value;
        window.location.href = `?filtro=${filtro}`;
      }

      function filtrarTransacoes() {
        const filtro = document.getElementById('filtroSearch').value.toLowerCase();
        const transacoes = document.querySelectorAll('#historico-list li');
        transacoes.forEach(transacao => {
            const descricao = transacao.querySelector('.descricao').innerText.toLowerCase();
            if (descricao.includes(filtro)) {
                transacao.style.display = '';
            } else {
                transacao.style.display = 'none';
            }
        });
      }
    </script>
  </body>
</html>
