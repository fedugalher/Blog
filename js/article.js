'use_strict';

const articleContent = document.querySelector('.article-content')
const articleTitle = document.getElementById('article-title');
const articleText = document.querySelector('.article-text');
const articleDate = document.querySelector('.article-date');
const articleImage = document.getElementById('article-img');
const asideContainer = document.querySelector('.aside-container');
const commentsContainer = document.getElementById('comments');
const commentBtn = document.getElementById('coment-btn');
console.log(commentBtn)

//Obtener parametros de la URL
const params = window.location.search;
const urlParams = new URLSearchParams(params);
const id = urlParams.get('id');

window.addEventListener('load', ()=>{
   getArticles();
   getArticle();
});

commentBtn.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit

   const data = new FormData();
   const commentName = document.getElementById('name').value;
   const commentText = document.getElementById('comment').value;
   const method = 'new';

   data.append('name', commentName);
   data.append('comment', commentText);
   data.append('method', method);
   data.append('article_id', id);
   sendComment(data);
});


//Funcion asincrona para obtener el articulo, pasando como parametros el metodo shoe y el id que seran consultados en el articles_controller.php
let getArticle = async () =>{   
   const peticion = await fetch(`./php/articles_controller.php?method=show&id=${id}`); 
   const resultado = await peticion.json();
   console.log(resultado)
   const date = new Date(resultado.date); //para poder formatear la hora con la funcion formatDate()

   articleImage.setAttribute('src', `images/articles/${resultado.image}`);
   articleTitle.textContent = resultado.title;
   articleText.textContent = resultado.body;
   articleDate.textContent = `Publicado el ${formatDate(date)}`;
   commentsContainer.innerHTML = '';
   for (const comment in resultado.comments) {
      commentsContainer.innerHTML+= `
         <div class="col-lg-11 coment">
            <p class="coment-name">${resultado.comments[comment].name}</p>
            <p>${resultado.comments[comment].comment}</p>
            <span class="article-date">${formatDate(date)}</span>
         </div>
      `;
   }

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
               <p>${resultado.data[article].body.substring(0,99)}...</p>
               <span class="article-date">Publicado el ${formatDate(date)}</span>
            </div>             
         </div>
      `;
      //Agregar imagen personalizada a cada articulo
      const articleImage = document.getElementById(`article-img-${resultado.data[article].id}`);
      articleImage.style.backgroundImage = `url('./images/articles/${resultado.data[article].image}')`;
   }   
}

let sendComment = async (data) =>{   
   const peticion = await fetch('./php/comments_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   console.log(resultado);
   if(resultado['article-msg'] == 'Tu comentario ha sido enviado'){
     getArticle();
     
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



