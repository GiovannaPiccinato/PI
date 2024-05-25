// Deixar a opção selecionada pelo click

var menu_item = document.querySelectorAll('.item_menu') // irá pegar todos que tiverem a class item menu e transformalas em um variavel
function selectItem () {
	menu_item.forEach((item) => 
item.classList.remove('ativo')); // irá remover a classe 'ativo'

this.classList.add('ativo'); // irá adcionar a classe ativo
}

menu_item.forEach ((item) => 
item.addEventListener('click', selectItem));

// Expandir Menu

var exp = document.querySelector('#btn-exp');
var menu_lateral = document.querySelector('.menu_lateral');

exp.addEventListener('click', function(){ // esse "function()" é a criação de uma função anonima
	menu_lateral.classList.toggle('expandir'); // isso irá de forma dinamica retirar e aplicar a função expandir sempre que clicar no icone BTN-EXP	
})

//expandir submenu

var dropItems = document.querySelectorAll('.drop_hover');

dropItems.forEach(drop => {
    drop.addEventListener('click', function() {
        var submenu = this.querySelector('.submenu');
        submenu.classList.toggle('expandir_submenu');
    });
});

