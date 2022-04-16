'use_strict';

const articleTitle = document.getElementById('article-title');
const articleText = document.querySelector('.article-text');
const articleDate = document.querySelector('.article-date');
const articleImage = document.getElementById('article-img');
const asideContainer = document.querySelector('.aside-container');

//Obtener parametros de la URL
const params = window.location.search;
const urlParams = new URLSearchParams(params);
const id = urlParams.get('id');
console.log(id)

//Funcion asincrona para obtener el articulo, pasando como parametros el metodo shoe y el id que seran consultados en el articles_controller.php
let getArticle = async () =>{   
   const peticion = await fetch(`./php/articles_controller.php?method=show&id=${id}`); 
   const resultado = await peticion.json();
   const date = new Date(resultado.date); //para poder formatear la hora con la funcion formatDate()

   articleImage.setAttribute('src', `images/articles/${resultado.image}`);
   articleTitle.textContent = resultado.title;
   articleText.textContent = resultado.body;
   articleDate.textContent = `Publicado el ${formatDate(date)}`;

}

// Funcion para obtener todos los articulos y colocarlso en el aside
let getArticles = async () =>{   
   const peticion = await fetch('./php/articles_controller.php?method=selectLimit&limit=5'); 
   const resultado = await peticion.json();

   for (const article in resultado.data) {

      const date = new Date(resultado.data[article].date); //para poder formatear la hora con la funcion formatDate()
          
      asideContainer.innerHTML += `
         <div class="row aside-row" id="article-${resultado.data[article].id}">            
            <div class="col-lg-12 col-md-3 aside-img-box" id="article-img-${resultado.data[article].id}"></div>           
            <div class="col-lg-12 col-md-9 aside-text-box">
               <p>${resultado.data[article].body}</p>
               <span class="article-date">Publicado el ${formatDate(date)}</span>
            </div>             
         </div>
      `;
      //Agregar imagen personalizada a cada articulo
      const articleImage = document.getElementById(`article-img-${resultado.data[article].id}`);
      articleImage.style.backgroundImage = `url('./images/articles/${resultado.data[article].image}')`;
   }   
}

//Formatear fecha
let formatDate = date =>{
   let day = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let fullDate = `${day[date.getDay()]}, ${date.getDate()+1} de ${month[date.getMonth()]} de ${date.getFullYear()}`;
   // console.log(fullDate);
   return fullDate;
}

if(id){
   getArticle();
}


getArticles();
