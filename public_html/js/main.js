'use strict';

//Local
const host_dir = 'http://localhost/FedugalherBlog/public_html';

//Production
// const host_dir = 'https://fedugalher.com';

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
        
         category != 'home' && category != 'Inicio' ? location.href = `./index.php?category=${category}` : location.href = `./index.php`;     
      }else if(logoutLink != false){
         e.preventDefault();
         closeSession();
      }else if(userProfile){
         e.preventDefault();
         location.href = `user_show.php`;
      }
   }
});

window.addEventListener('load', ()=>{
   navbarCategories();  
});

let navbarCategories = async () =>{   
   const peticion = await fetch(`./php/categories_controller.php?method=selectAll`); 
   const resultado = await peticion.json();   

   const categories = resultado.data;
   const ulNav = document.querySelector('.navbar-nav'); 
   
   
   for (const category in categories) {      
     ulNav.innerHTML+=`
         <li class="nav-item">
            <a id="${categories[category].name}" class="nav-link" href="">${categories[category].name}</a>
         </li>
     `;
   }

   //Agregar clase active al enlace seleccionado
   const params = window.location.search;
   const urlParams = new URLSearchParams(params);
   const category = urlParams.get('category');
   const categorySelected = document.getElementById(`${category}`);
   const home = document.getElementById('Inicio');

   if(categorySelected !== null){
      categorySelected.classList.add('active')
   }else if(home !== null){
      home.classList.add('active');
   }
}

let closeSession = async () =>{
   const peticion = await fetch(`./php/sesions_controller.php?method=closeSesion`); 
   const resultado = await peticion.json();
   
   if (resultado[0].msgType === 'succes') {
      location.reload();
   }
}
