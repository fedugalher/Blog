'use strict';


// ------------------------- Eventos -------------------------

// click con e.target
document.addEventListener('click', e =>{
   let element = e.target;

   //Para acceder a los Articulos
   if(element.parentElement.classList.contains('article-content')){ 
      let elementId = element.parentElement.id;
      let dash = elementId.indexOf('-');
      let articleId = elementId.slice(dash+1,elementId.length);
      console.log(location.href=`article.html?id=${articleId}`);
   }
});




