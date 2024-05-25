// Deixar a opção selecionada pelo click

var menu_item = document.querySelectorAll('.menu_item') // irá pegar todos que tiverem a class item menu e transformalas em um variavel
function selectItem () {
	menu_item.forEach((item) => 
item.classList.remove('ativo')); // irá remover a classe 'ativo'

this.classList.add('ativo'); // irá adcionar a classe ativo
}

menu_item.forEach ((item) => 
item.addEventListener('click', selectItem));


	//irá adicionar um nvo campo de imagem URL

	let numImagens = 0;

	// Função para adicionar um novo campo de imagem URL
	function adicionarImagem() {
			// Verifica se o número de imagens é menor que 3
			if (numImagens <= 4) {
					const containerImagens = document.getElementById('containerImagens');
					const novoDiv = document.createElement('div');
					novoDiv.className = 'imagem_container'; // Mantém a mesma classe
	
					const novoInputURL = document.createElement('input');
					novoInputURL.type = "text";
					novoInputURL.name = 'imagem_url[]';
					novoInputURL.placeholder = 'URL da Imagem';
					novoInputURL.required = true;
	
					const novoInputOrdem = document.createElement('input');
					novoInputOrdem.type = "number";
					novoInputOrdem.name = 'imagem_ordem[]';
					novoInputOrdem.placeholder = 'Ordem da Imagem';
					novoInputOrdem.min = "1";
					novoInputOrdem.required = true;
	
					novoDiv.appendChild(novoInputURL);
					novoDiv.appendChild(novoInputOrdem);
	
					containerImagens.appendChild(novoDiv);
	
					// Incrementa o contador de imagens
					numImagens++;
			} else {
					// Se o limite de 3 imagens já foi atingido, exibe uma mensagem de alerta
					alert("Você já adicionou o limite máximo de 4 imagens.");
			}
	}
	

		// voltar para a pagina de listagem quando clicar no cadastrar
		function onSubmit(event) {
			event.preventDefault(); // Evita o envio automático do formulário
	
			const form = document.querySelector("form");
			const formData = new FormData(form); // Obtem os dados do formulário
	
			// Envia uma requisição assíncrona para submeter o formulário
			fetch(form.action, {
					method: form.method,
					body: formData
				})
				.then(response => {
					if (response.ok) {
						// Redireciona para a página de listagem de administradores
						window.location.href = "./listar_produto.php";
					} else {
						// Se houver um erro na requisição, exibe uma mensagem de erro
						console.error('Erro ao enviar formulário:', response.statusText);
					}
				})
				.catch(error => {
					console.error('Erro inesperado:', error);
				});
		}

		// remover imagens adicionadas
function removerImagem(element) {
	element.parentNode.remove(); // Remove o pai do ícone (o container da imagem)
}