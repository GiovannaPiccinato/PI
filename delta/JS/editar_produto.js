//irá adicionar um nvo campo de imagem URL

let numImagens = 0;

// Função para adicionar um novo campo de imagem URL
function adicionarImagem() {
	// Verifica se o número total de imagens (incluindo as já existentes) é menor que 7
	if (document.querySelectorAll('.imagem_container').length < 7) {
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

			const novoIconeRemover = document.createElement('span');
			novoIconeRemover.className = 'remove-icon';
			novoIconeRemover.innerHTML = '<i class="bi bi-x-circle-fill"></i>';
			novoIconeRemover.onclick = function() {
					removerNovaImagem(novoDiv);
			};

			novoDiv.appendChild(novoInputURL);
			novoDiv.appendChild(novoInputOrdem);
			novoDiv.appendChild(novoIconeRemover);

			containerImagens.appendChild(novoDiv);

	} else {
			alert("Você já adicionou o limite máximo de imagens.");
	}
}

// remover imagens adicionadas
function removerImagem(element) {
	const containerImagem = element.parentElement;
	containerImagem.remove();
	
}
