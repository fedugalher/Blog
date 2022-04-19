'use_strict';

//Esta parte ya esta especificada en article.js y ya no es necesario ponerla aqui
//Obtener parametros de la URL
// const params = window.location.search;
// const urlParams = new URLSearchParams(params);
// const id = urlParams.get('id');
console.log(id);
const commentBtn = document.getElementById('comment-btn');


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

let sendComment = async (data) =>{   
   const peticion = await fetch('./php/comments_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   console.log(resultado)
   // if(resultado['article-msg'] == 'Articulo guardado'){
   //    location.href = 'index.html';
   // }
}
