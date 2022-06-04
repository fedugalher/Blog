'use_strict';

const btnDb = document.getElementById('btn-db');
const btnDropDb = document.getElementById('btn-dropDb');
const btnUsers = document.getElementById('btn-users');
const btnArticles = document.getElementById('btn-articles');
const btnComments = document.getElementById('btn-comments');
const btnCategories = document.getElementById('btn-categories');

// Evento Click
btnDb.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   createDb(); 
});

btnDropDb.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   dropDb(); 
});

btnUsers.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   usersTable(); 
});

btnArticles.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   articlesTable(); 
});

btnComments.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   commentsTable(); 
});

btnCategories.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit
   categoriesTable(); 
});

let createDb = async () =>{   
   const peticion = await fetch(`${host_dir}/php/database_controller.php?method=createDB`); 
   const resultado = await peticion.json();
   console.log(resultado);
}

let dropDb = async () =>{   
   const peticion = await fetch(`${host_dir}/php/database_controller.php?method=dropDB`); 
   const resultado = await peticion.json();
   console.log(resultado);
}

let usersTable = async () =>{   
   const peticion = await fetch(`${host_dir}/php/users_controller.php?method=usersTable`); 
   const resultado = await peticion.json();
   console.log(resultado);
}

let articlesTable = async () =>{   
   const peticion = await fetch(`${host_dir}/php/articles_controller.php?method=articlesTable`); 
   const resultado = await peticion.json();
   console.log(resultado);
}

let commentsTable = async () =>{   
   const peticion = await fetch(`${host_dir}/php/comments_controller.php?method=commentsTable`); 
   const resultado = await peticion.json();
   console.log(resultado);
}

let categoriesTable = async () =>{   
   const peticion = await fetch(`${host_dir}/php/categories_controller.php?method=categoriesTable`); 
   const resultado = await peticion.json();
   console.log(resultado);
}

