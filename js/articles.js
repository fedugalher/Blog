'use_strict';

let articleRow = document.querySelector('.article-row');


let getArticles = async () =>{
   
   const peticion = await fetch('./php/articles_controller.php?method=selectAll'); 
   const resultado = await peticion.json();
   // console.log(resultado.data);
   // console.log(resultado.messages);   
   let currentCategory; //Para imprimir los titulos de la categoria
   let pastCategory = '';
   
   for (const article in resultado.data) {

      const date = new Date(resultado.data[article].date); //para poder formatear la hora con la funcion formatDate()
      currentCategory = resultado.data[article].category;
      
      if(pastCategory != currentCategory){
         pastCategory = currentCategory;
         articleRow.innerHTML += `<h1 id="${resultado.data[article].category}-category">${currentCategory}</h1><hr>`; 
      }           
     
      articleRow.innerHTML += `
         <div class="col-lg-4 col-md-6 article-col">
            <div class="article-content" id="article-${resultado.data[article].id}">
               <div class="article-img" id="article-img-${resultado.data[article].id}"></div>
               <div class="article-text">
                  <h5>${resultado.data[article].title}</h5>
                  <p>${resultado.data[article].body.substring(0,99)}...</p>
                  <a href="article.html?id=${resultado.data[article].id}" class="btn btn-primary">Ver más</a>                  
                  <span class="article-date">${formatDate(date)}</span>
               </div>
            </div>
         </div>
      `;
      //Agregar imagen personalizada a cada articulo
      const articleImage = document.getElementById(`article-img-${resultado.data[article].id}`);
      articleImage.style.backgroundImage = `url('./images/articles/${resultado.data[article].image}')`;
   }
   
}

getArticles();

let formatDate = date =>{
   let day = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let fullDate = `${day[date.getDay()]}, ${date.getDate()+1} de ${month[date.getMonth()]} de ${date.getFullYear()}`;
   // console.log(fullDate);
   return fullDate;
}
