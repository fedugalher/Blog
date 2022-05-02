'use_strict';

const commentBtn = document.getElementById('coment-btn');

window.addEventListener('load', ()=>{
   getComments();
});

commentBtn.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit

   const data = new FormData();
   const commentName = document.getElementById('name');
   const commentText = document.getElementById('comment');
   const method = 'new';

   data.append('name', commentName.value);
   data.append('comment', commentText.value);
   data.append('method', method);
   data.append('article_id', id);
   sendComment(data);
   commentName.value = '';
   commentText.value = '';
});

let sendComment = async (data) =>{   
   const peticion = await fetch('../php/comments_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();

   if(resultado['article-msg'] == 'Tu comentario ha sido enviado'){
    getComments();
     
   }
}

const getComments = async ()=>{
   const peticion = await fetch(`../php/comments_controller.php?method=selectAll&id=${id}`); 
   const resultado = await peticion.json();

   commentsContainer.innerHTML = '';
   for (const comment in resultado) {
      const date = new Date(resultado[comment].date); //para poder formatear la hora con la funcion formatDate()
      commentsContainer.innerHTML+= `
         <div class="col-lg-11 coment">
            <p class="coment-name">${resultado[comment].name}</p>
            <p>${resultado[comment].comment}</p>
            <span class="article-date">${formatDate(date)}</span>
         </div>
      `;
   }
}

