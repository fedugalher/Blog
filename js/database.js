'use_strict';

const btnDb = document.getElementById('btn-db');
const btnUsers = document.getElementById('btn-users');
const btnArticles = document.getElementById('btn-articles');


// Evento Click
btnDb.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   createDb(); 
});

btnUsers.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   usersTable(); 
});

btnArticles.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   articlesTable(); 
});

let createDb = async () =>{   
   const peticion = await fetch('./php/database_controller.php?method=createDB'); 
   const resultado = await peticion.json();
   console.log(resultado);
}

let usersTable = async () =>{   
   const peticion = await fetch('./php/users_controller.php?method=usersTable'); 
   const resultado = await peticion.json();
   console.log(resultado);
}

let articlesTable = async () =>{   
   const peticion = await fetch('./php/articles_controller.php?method=articlesTable'); 
   const resultado = await peticion.json();
   console.log(resultado);
}

