'use_strict';

const btnCategory = document.getElementById('btn-category');
const msgBox = document.querySelector('.msg-box');


// Evento Click
btnCategory.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit

   // const articleForm = document.getElementById('article-form');
   // const data = new FormData(articleForm); //Guarda los datos del formulario creando un objeto form data
   //Crea un objeto de tipo FormData, se guardanlos valores de los inputs en variables y se agregan al formulario,
   //en este caso se agregan uno por uno y no todo el formulario como en la linea comentada, esto con el fin de agregar tambien el metodo new
   
   const data = new FormData();
   const categoryName = document.getElementById('name').value;
   const method = 'new';   
   const messages = [];


   if(categoryName === ''){
      messages.push('El nombre de la nueva categoría no puede estar en blanco');
   } 
   
   if(messages.length === 0){
      data.append('name', categoryName);
      data.append('method', method);
      sendCategory(data); //llama a la funcion send article y le pasa los datos del formulario     
   }else{
      
      for (const msg in messages) {
         msgBox.innerHTML += `<p class="msg-error">* ${messages[msg]}</p>`;
      }
   }  
   
});

let sendCategory = async (data) =>{   
   const peticion = await fetch(`${host_dir}/php/categories_controller.php`, {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();

   msgBox.innerHTML = '';
   
   if(resultado[resultado.length -1]['category-msg'] == 'Categoría registrada'){   
      location.href = 'categories.php';    
   }else{      
      for (const msg in resultado) {
         if(resultado[msg]['category-msg']){
            console.log(resultado[msg]['category-msg'])
            msgBox.innerHTML+=`
            <p class="msg-error">* ${resultado[msg]['category-msg']}</p>         
         `;
         }
      }
   }
}