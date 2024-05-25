

<?php
session_start();
require_once('../conexao.php');

if (!isset($_SESSION['admin_logado'])) {
	header('Location:login.php');
	exit(); // se nao houver a permissão do usuario, irá parar o programa e nao aparecerá as demais informações.
}

try {
	$stmt = $pdo->prepare("SELECT PRODUTO.PRODUTO_ID, PRODUTO.PRODUTO_NOME, PRODUTO.PRODUTO_DESC, 
			PRODUTO.PRODUTO_PRECO, CATEGORIA.CATEGORIA_NOME, PRODUTO.PRODUTO_ATIVO, 
			PRODUTO.PRODUTO_DESCONTO, PRODUTO_ESTOQUE.PRODUTO_QTD, 
			GROUP_CONCAT(PRODUTO_IMAGEM.IMAGEM_URL SEPARATOR ',') AS IMAGENS
			FROM PRODUTO
			JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
			LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
			LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID
			GROUP BY PRODUTO.PRODUTO_ID");
	$stmt->execute();
	$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "<p style='color: red;'> Erro ao listar produtos: " . $e->getMessage() . "</p>"; // getMessage irá deixar a msg de erro mais resumida.
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../CSS/listar_produto.css" />
	<link rel="stylesheet" href="../CSS/modal.css">
	<script src="../JS/listar_produto.js"></script>
	<title>Lista de Produtos</title>
</head>

<body>
	<main>
		<nav class="lateral_menu">
			<div class="items">
				<ul>
					<li class="menu_item">
						<a href="../painel_admin.php">
							<span class="icon"><i class="bi bi-house"></i></span>
							<span class="text">HOME</span>
						</a>
					</li>

					<li class="menu_item ativo">
						<a href="../PRODUTO/listar_produto.php">
							<span class="icon"><i class="bi bi-tags"></i></span>
							<span class="text">PRODUTOS</span>
						</a>
					</li>

					<li class="menu_item">
						<a href="../CATEGORIA/listar_categoria.php">
							<span class="icon"><i class="bi bi-controller"></i></span>
							<span class="text">CATEGORIA</span>
						</a>
					</li>

					<li class="menu_item">
						<a href="../ADMINISTRADOR/listar_administrador.php">
							<span class="icon"><i class="bi bi-person-gear"></i></span>
							<span class="text">ADMINISTRADOR</span>
						</a>
					</li>

					<li class="menu_item">
						<a href="#">
							<span class="icon"><i class="bi bi-person"></i></span>
							<span class="text">PERFIL</span>
						</a>
					</li>
				</ul>
			</div>

			<div class="close">
				<a href="../login.php">
					<span class="icon"><i class="bi bi-door-closed"></i></span>
					<span class="text">SAIR</span>
				</a>
			</div>
		</nav>

		<section class="painel">
			<header>
				<div class="search-container">
					<button type="button" id="searchButton">
						<i class="bi bi-search"></i>
						<input type="text" id="searchInput" placeholder="Pesquisar...">
					</button>
					<img src="../fotos/usuario.png" alt="Barra de Carregamento do usuario" />
				</div>
			</header>

			<div class="cadastro">
				<button id="button_register" onclick="window.location.href = '../PRODUTO/cadastrar_produto.php'">
					<i class="bi bi-person-add"></i>
					Cadastrar Produto
				</button>
			</div>

			<section class="list">
				<table border="1" class="table_container">
					<thead class="table_head">
						<tr class="table_title">
							<td> ID </td>
							<td> Nome </td>
							<td> Descrição </td>
							<td> Preço </td>
							<td> Categoria </td>
							<td> Ativo </td>
							<td> Desconto </td>
							<td> Estoque </td>
							<td> Imagem </td>
							<td>Ações</td>
						</tr>
					</thead>
					<tbody class="table_body" id="table_body">
						<?php foreach ($produtos as $produto) : // jogando de produtos para produto.
						?>
							<tr>
								<td><?php echo $produto['PRODUTO_ID']; ?></td>
								<td><?php echo $produto['PRODUTO_NOME']; ?></td>
								<td>
									<?php
									$descricao = $produto['PRODUTO_DESC'];
									$max_length = 20; // Define o comprimento máximo da descrição a ser exibida inicialmente
									if (strlen($descricao) > $max_length) {
										// Se a descrição for mais longa que o comprimento máximo, exibe a versão truncada
										echo '<span class="describe">' . substr($descricao, 0, $max_length) . '...<span class="describe-text">' . $descricao . '</span></span>';
									} else {
										// Caso contrário, exibe a descrição completa
										echo $descricao;
									}
									?>
								</td>
								<td>R$<?php echo $produto['PRODUTO_PRECO']; ?></td>
								<td><?php echo $produto['CATEGORIA_NOME']; ?></td>
								<td id="ativo"><?php echo ($produto['PRODUTO_ATIVO'] == '0' ? "<p class='inactive''> <i class='bi bi-circle-fill'></i> </p> " : "<p class='active'> <i class='bi bi-circle-fill'></i> </p>") ?></td>

								<td>R$<?php echo $produto['PRODUTO_DESCONTO']; ?></td>

								<td><?php echo $produto['PRODUTO_QTD']; ?></td>
								<td id="table_img" width="150vh">
									<?php
									// Verifica se há imagens do produto e exibe o carrossel de imagens
									$imagens = explode(',', $produto['IMAGENS']);
									if (!empty($imagens)) {
										echo '<div id="carouselExampleControls_' . $produto['PRODUTO_ID'] . '" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">';
										foreach ($imagens as $index => $imagem) {
											echo '<div class="carousel-item ' . ($index === 0 ? 'active' : '') . '">
                            <img src="' . $imagem . '" class="d-block w-100" alt="Imagem do Produto">
                        </div>';
										}
										echo '</div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls_' . $produto['PRODUTO_ID'] . '" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls_' . $produto['PRODUTO_ID'] . '" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>';
									} else {
										echo 'Sem imagem';
									}
									?>
								</td>
								<td class="acoes">
									<a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>"> <i class="bi bi-pencil-square active"></i> </a>
									<button id="button_delet" onclick="confirm()"> <i class="bi bi-trash3-fill delet_color"></i> </button>
									<!-- <button id="button_delet" >
										<i class="bi bi-trash3-fill delet_color"></i>
									</button> -->
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</section>
		</section>
	</main>

	<div id="modal_close" class="modal">
		<div class="modal-content">
			<div class="close_x">
				<span onclick="fechar()">&times;</span>
			</div>
			<h3 class="modal_title">Deseja excluir este produto?</h3>
			<a id="yes" href="excluir_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>">Sim</a>
			<button id="no" onclick="fechar()">Não</button>
		</div>
	</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</html>