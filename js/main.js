'use strict';

const currentURL = window.location.href;



// ------------------------- Eventos -------------------------

// click con e.target
document.addEventListener('click', e =>{
  
   let element = e.target;
   //Para acceder a los Articulos
   if(element.parenteElement !== 'undefined' && element.parentElement.classList.contains('article-card')){ 
      let elementId = element.parentElement.id;
      let dash = elementId.indexOf('-');
      let articleId = elementId.slice(dash+1,elementId.length);
      console.log(location.href=`article.php?id=${articleId}`);
   }

   //Navbar
   const categoryLink = element.classList.contains('nav-link') ? element.textContent : false;
   const homeLink = element.classList.contains('navbar-brand') ? 'home' : false;

   if(categoryLink != false || homeLink != false){
      e.preventDefault();
      const category = categoryLink != false ? categoryLink : homeLink;
      category != 'home' ? location.href = `../public/index.php?category=${category}` : location.href = '../public/index.php';     
   }
});





