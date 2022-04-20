'use_strict';

//Esta parte ya esta especificada en article.js y ya no es necesario ponerla aqui
//Obtener parametros de la URL
// const params = window.location.search;
// const urlParams = new URLSearchParams(params);
// const id = urlParams.get('id');


const commentsContainer = document.querySelector('.form-coment-col');
const commentBtn = document.getElementById('coment-btn');
console.log(commentBtn)


let articleComments = async () =>{   
   const peticion = await fetch(`./php/comments_controller.php?method=selectAll&id=${id}`); 
   const resultado = await peticion.json();
   // console.log(resultado);
   for (const comment in resultado.data) {
      const date = new Date(resultado.data[comment].date);
      commentsContainer.innerHTML+= `
         <div class="col-lg-11 coment">
            <p class="coment-name">${resultado.data[comment].name}</p>
            <p>${resultado.data[comment].comment}</p>
            <span class="article-date">${formatDate(date)}</span>
         </div>
      `;
   }
}

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
   console.log(resultado);
   if(resultado['article-msg'] == 'Tu comentario ha sido enviado'){
      // location.reload;
      console.log('bien')
      // articleComments();
   }
}



