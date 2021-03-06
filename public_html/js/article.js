'use_strict';

const articleContent = document.querySelector('.article-content')
const articleTitle = document.getElementById('article-title');
const articleText = document.querySelector('.article-text');
const articleDate = document.querySelector('.article-date');
const articleImage = document.getElementById('article-img');
const asideContainer = document.querySelector('.aside-container');
const commentsContainer = document.getElementById('comments');

//Obtener parametros de la URL
const params = window.location.search;
const urlParams = new URLSearchParams(params);
const id = urlParams.get('id');

window.addEventListener('load', ()=>{
   getArticles();
   getArticle();
});

//Funcion asincrona para obtener el articulo, pasando como parametros el metodo shoe y el id que seran consultados en el articles_controller.php
let getArticle = async () =>{   
   const peticion = await fetch(`./php/articles_controller.php?method=show&id=${id}`); 
   const resultado = await peticion.json();
   const date = new Date(resultado['created_at']); //para poder formatear la hora con la funcion formatDate()
   const imgSrc = resultado.image === 'no-image.png' ? './images/articles/' : `./images/articles/${resultado.id}/`;
   
   articleImage.setAttribute('src', `${imgSrc + resultado.image}`);
   articleTitle.textContent = resultado.title;
   articleText.innerHTML = resultado.body;
   articleDate.innerHTML = `${formatDate(date)}`;
}

// Funcion para obtener todos los articulos y colocarlso en el aside
let getArticles = async () =>{   
   const peticion = await fetch(`./php/articles_controller.php?method=selectLimit&limit=5`); 
   const resultado = await peticion.json();

   for (const article in resultado.data) {

      const date = new Date(resultado.data[article]['created_at']); //para poder formatear la hora con la funcion formatDate()
          
      asideContainer.innerHTML += `
         <div class="row aside-row article-card" id="article-${resultado.data[article].id}">            
            <div class="col-lg-12 col-md-3 aside-img-box" id="article-img-${resultado.data[article].id}"></div>           
            <div class="col-lg-12 col-md-9 aside-text-box">
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
      const imgSrc = resultado.data[article].image === 'no-image.png' ? './images/articles/' : `./images/articles/${resultado.data[article].id}/`;
      articleImage.style.backgroundImage = `url('${imgSrc + resultado.data[article].image}')`;
      
   }   
}


//Formatear fecha
let formatDate = date =>{
   let calendarIcon = '<i class="fa-solid fa-calendar-days date-icons"></i>';
   let clockIcon = '<i class="fa-solid fa-clock date-icons"></i>';
   let day = ['Domingo', 'Lunes', 'Martes', 'Mi??rcoles', 'Jueves', 'Viernes', 'S??bado'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let hours = date.getHours().toString().length === 1 ? '0'+ date.getHours() : date.getHours();
   let minutes = date.getMinutes().toString().length === 1 ? '0'+ date.getMinutes() : date.getMinutes();   
   let fullDate = `${calendarIcon} ${day[date.getDay()]}, ${date.getDate()} de ${month[date.getMonth()]} de ${date.getFullYear()} ${clockIcon} ${hours}:${minutes}`;

   return fullDate;
}



