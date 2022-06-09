'use_strict';

let articleRow = document.querySelector('.article-row');

window.addEventListener('load', e =>{
   if(currentURL == `${host_dir}/index.php` || 
      currentURL == `${host_dir}`){
      getArticles();
   }else{
      //Obtener parametros de la URL para filtrar articulos segun la categoria seleccionada
      const params = window.location.search;
      const urlParams = new URLSearchParams(params);
      const category = urlParams.get('category');
      getArticlesByCategory(category);

      //añadir la clase active al link seleccionado en el navbar
      const navLinks = document.getElementsByClassName('nav-link');
      for (const link in navLinks) {        
         if (navLinks[link].textContent === category){
            navLinks[link].classList.add('active');
         }
      }
   }   
});


let getArticles = async () =>{
   
   const peticion = await fetch(`./php/articles_controller.php?method=selectAll`); 
   const resultado = await peticion.json();
   let currentCategory; //Para imprimir los titulos de la categoria
   let pastCategory = '';
   
   articleRow.innerHTML = '';
   for (const article in resultado.data) {

      const date = new Date(resultado.data[article]['created_at']); //para poder formatear la hora con la funcion formatDate()
      currentCategory = resultado.data[article].category;
      
      if(pastCategory != currentCategory){
         pastCategory = currentCategory;
         articleRow.innerHTML += `<h1 id="${resultado.data[article].category}-category">${currentCategory}</h1><hr>`; 
      }           
     
      articleRow.innerHTML += `
         <div class="col-lg-4 col-md-6 article-col">
            <div class="article-content article-card" id="article-${resultado.data[article].id}">
               <div class="article-img" id="article-img-${resultado.data[article].id}"></div>
               <div class="article-text">
                  <h5>${resultado.data[article].title}</h5>
                  ${resultado.data[article].preview}                                 
                  <span class="article-date">${formatDate(date)}</span>
               </div>
            </div>
         </div>
      `;
      //Agregar imagen personalizada a cada articulo
      const articleImage = document.getElementById(`article-img-${resultado.data[article].id}`);
      articleImage.style.backgroundImage = `url('./images/articles/${resultado.data[article].id}/${resultado.data[article].image}')`;
   }
   
}

let getArticlesByCategory = async category =>{
   
   const peticion = await fetch(`./php/articles_controller.php?method=selectCategory&category=${category}`); 
   const resultado = await peticion.json();
   let currentCategory; //Para imprimir los titulos de la categoria
   let pastCategory = '';
   
   articleRow.innerHTML = '';
   for (const article in resultado.data) {
      
      const date = new Date(resultado.data[article]['created_at']); //para poder formatear la hora con la funcion formatDate()
      currentCategory = resultado.data[article].category;
      
      if(pastCategory != currentCategory){
         pastCategory = currentCategory;
         articleRow.innerHTML += `<h1 id="${resultado.data[article].category}-category">${currentCategory}</h1><hr>`; 
      }           
     
      articleRow.innerHTML += `
         <div class="col-lg-4 col-md-6 article-col">
            <div class="article-content article-card" id="article-${resultado.data[article].id}">
               <div class="article-img" id="article-img-${resultado.data[article].id}"></div>
               <div class="article-text">
                  <h5>${resultado.data[article].title}</h5>
                  ${resultado.data[article].preview}                                
                  <span class="article-date">${formatDate(date)}</span>
               </div>
            </div>
         </div>
      `;
      //Agregar imagen personalizada a cada articulo
      const articleImage = document.getElementById(`article-img-${resultado.data[article].id}`);
      articleImage.style.backgroundImage = `url('./images/articles/${resultado.data[article].id}/${resultado.data[article].image}')`;
   }
   
}



//Formatear fecha
let formatDate = date =>{
   let calendarIcon = '<i class="fa-solid fa-calendar-days date-icons"></i>';
   let clockIcon = '<i class="fa-solid fa-clock date-icons"></i>';
   let day = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let hours = date.getHours().toString().length === 1 ? '0'+ date.getHours() : date.getHours();
   let minutes = date.getMinutes().toString().length === 1 ? '0'+ date.getMinutes() : date.getMinutes();   
   let fullDate = `${calendarIcon} ${day[date.getDay()]}, ${date.getDate()} de ${month[date.getMonth()]} de ${date.getFullYear()} ${clockIcon} ${hours}:${minutes}`;

   return fullDate;
}
