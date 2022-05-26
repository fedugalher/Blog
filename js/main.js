'use strict';

const currentURL = window.location.href;



// ------------------------- Eventos -------------------------

// click con e.target
document.addEventListener('click', e =>{

   let element = e.target;
   //Para acceder a los Articulos
   if(element.parentElement !== null){
      //Articles
      if(element.parentElement !== 'undefined' && element.parentElement.classList.contains('article-card')){ 
         let elementId = element.parentElement.id;
         let dash = elementId.indexOf('-');
         let articleId = elementId.slice(dash+1,elementId.length);
         location.href=`article.php?id=${articleId}`;
      }   

      //Navbar
      const categoryLink = element.classList.contains('nav-link') ? element.textContent : false;
      const homeLink = element.classList.contains('navbar-brand') ? 'home' : false;
      const logoutLink = element.id === 'sesionClose' ? 'sesionClose' : false;
      const userProfile = element.id === 'userProfile' || element.parentElement.id === 'userProfile' ? true : false;
 
      if(categoryLink != false || homeLink != false){
         e.preventDefault();
         const category = categoryLink != false ? categoryLink : homeLink;
         category != 'home' ? location.href = `../public/index.php?category=${category}` : location.href = '../public/index.php';     
      }else if(logoutLink != false){
         e.preventDefault();
         closeSession();
      }else if(userProfile){
         e.preventDefault();
         location.href = '../public/user_show.php';
      }
   }
});

let closeSession = async () =>{
   const peticion = await fetch('../php/sesions_controller.php?method=closeSesion'); 
   const resultado = await peticion.json();
   
   if (resultado[0].msgType === 'succes') {
      location.reload();
   }
}



