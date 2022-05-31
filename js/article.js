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
   const peticion = await fetch(`../php/articles_controller.php?method=show&id=${id}`); 
   const resultado = await peticion.json();
   const date = new Date(resultado['created_at']); //para poder formatear la hora con la funcion formatDate()
   console.log(resultado)
   articleImage.setAttribute('src', `../images/articles/${resultado.id}/${resultado.image}`);
   articleTitle.textContent = resultado.title;
   articleText.innerHTML = resultado.body;
   articleDate.textContent = `Publicado el ${formatDate(date)}`;
}

// Funcion para obtener todos los articulos y colocarlso en el aside
let getArticles = async () =>{   
   const peticion = await fetch('../php/articles_controller.php?method=selectLimit&limit=5'); 
   const resultado = await peticion.json();

   for (const article in resultado.data) {

      const date = new Date(resultado.data[article]['created_at']); //para poder formatear la hora con la funcion formatDate()
          
      asideContainer.innerHTML += `
         <div class="row aside-row article-card" id="article-${resultado.data[article].id}">            
            <div class="col-lg-12 col-md-3 aside-img-box" id="article-img-${resultado.data[article].id}"></div>           
            <div class="col-lg-12 col-md-9 aside-text-box">
               <div class="article-text">
                  <h5>${resultado.data[article].title}</h5>
                  ${resultado.data[article].body.substring(0,99)}                  
                  <span class="article-date">Publicado el ${formatDate(date)}</span>
               </div>
            </div>             
         </div>
      `;
      //Agregar imagen personalizada a cada articulo
      const articleImage = document.getElementById(`article-img-${resultado.data[article].id}`);
      articleImage.style.backgroundImage = `url('../images/articles/${resultado.data[article].id}/${resultado.data[article].image}')`;
   }   
}


//Formatear fecha
let formatDate = date =>{
   let day = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let fullDate = `${day[date.getDay()]}, ${date.getDate()} de ${month[date.getMonth()]} de ${date.getFullYear()}`;
   // console.log(fullDate);
   return fullDate;
}



