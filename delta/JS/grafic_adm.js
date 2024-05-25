document.addEventListener('DOMContentLoaded', function () {
	const ctx = document.getElementById('pieChart').getContext('2d');
	const pieChart = new Chart(ctx, {
			type: 'pie',
			data: {
					labels: ['Categoria', 'Produto', 'Administrador'],
					datasets: [{
							label:  ['Ativos', 'Inativos'],
							data: [dadosGrafico.administradores.ativos],
							backgroundColor: [
									'rgba(250, 103, 68, 1)',
									'rgba(255, 52, 71, 1)',
									'rgba(125, 20, 102, 1)'
							],
							borderColor: [
									'rgba (200, 82, 58, 1)',
									'rgba(204, 41, 47, 1)',
									'rgba(90, 16, 86, 1)'
							],
							borderWidth: 1,
					}]
			},
			options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
							legend: {
									position: 'top',
							},
							title: {
									display: true,
									text: 'Produtos, Administradores e Categorias Ativas',
									color: 'white'
							}
					}
			}
	});
});