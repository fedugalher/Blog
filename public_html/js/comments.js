'use_strict';

const commentBtn = document.getElementById('coment-btn');

window.addEventListener('load', ()=>{
   getComments();
});

if(commentBtn !== null){
   commentBtn.addEventListener('click', e =>{
      e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit

      const data = new FormData();
      // const commentName = document.getElementById('name');
      // const userId = document.getElementById('user-id');
      const commentText = document.getElementById('comment');
      const method = 'new';

      // data.append('name', commentName.value);
      // data.append('user_id', parseInt(userId.value));
      data.append('comment', commentText.value);
      data.append('method', method);
      data.append('article_id', id);
      sendComment(data);
      // commentName.value = '';
      commentText.value = '';
   });
}

let sendComment = async (data) =>{   
   const peticion = await fetch(`./php/comments_controller.php`, {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();

   if(resultado['article-msg'] == 'Tu comentario ha sido enviado'){
    getComments();     
   }
}

const getComments = async ()=>{
   const peticion = await fetch(`./php/comments_controller.php?method=selectAll&id=${id}`); 
   const resultado = await peticion.json();
   const userName = document.getElementById('username'); 
   
   commentsContainer.innerHTML = '';
   for (const comment in resultado) {
      const date = new Date(resultado[comment].date); //para poder formatear la hora con la funcion formatDate()
      commentsContainer.innerHTML+= `
         <div class="col-lg-11 coment">
            <p class="coment-name" id="${resultado[comment].id}">
               <img src="./images/users/${resultado[comment].user_id}/${resultado[comment].image}" class="userImg">               
               ${resultado[comment].username}
            </p>
            <hr>
            <p id="comment-${resultado[comment].id}">${resultado[comment].comment}</p>            
            <span class="article-date">
               <span class="userActions"></span>               
               ${formatDate(date)}
            </span>
         </div>
      `;
   }

   let userActions = document.getElementsByClassName('userActions');
   let commentName = document.getElementsByClassName('coment-name');

   for (const comment in userActions) {
      if(userName !== null && commentName[comment].textContent !== undefined){
         if(commentName[comment].textContent.includes(userName.textContent)){
            userActions[comment].innerHTML = `
                   <a href="#" class="edit-icon">
                     <i class="fa-solid fa-pen-to-square" id="edit-${parseInt(commentName[comment].id)}"></i>
                  </a>
                   <a href="#" class="delete-icon">
                     <i class="fa-solid fa-trash-can" id="delete-${parseInt(commentName[comment].id)}"></i>
                  </a>
                  <br>`;
         }
      }      
   }   
}

//Comment Edit
document.addEventListener('click', e =>{
   let element = e.target;
   const editIcon = element.id.includes('edit');
   const deleteIcon = element.id.includes('delete');
   const saveBtn = element.id.includes('save');
   const cancelBtn = element.id.includes('cancel');
   
   if(editIcon){
      e.preventDefault();
      const id = element.id.slice(5, element.id.length);
      const userActions = element.parentElement.parentElement;
      const saveBtn = document.createElement('button');
      const cancelBtn = document.createElement('button');
      const commentText = document.getElementById(`comment-${id}`);
     
      if(userActions.childNodes[0].nodeName !== 'BUTTON' || userActions.childNodes[1].nodeName !== 'BUTTON'){
         saveBtn.classList.add('btn-green');
         saveBtn.setAttribute('id', `save-${id}`);
         saveBtn.textContent = 'Guardar';
         cancelBtn.classList.add('btn-red');
         cancelBtn.setAttribute('id', `cancel-${id}`);
         cancelBtn.textContent = 'Cancelar';
         userActions.insertBefore(saveBtn, userActions.firstChild); 
         userActions.insertBefore(cancelBtn, userActions.firstChild);      
         commentText.setAttribute('contenteditable', true);
         commentText.classList.add('comment-edit');
      }      
      
   }

   if(deleteIcon){
      e.preventDefault();
      const id = element.id.slice(7, element.id.length);
      const deleteConfirm = confirm('¿Estas seguro de que deseas eliminar tu comentario?');
      if(deleteConfirm){
         deleteComment(id);
      }
   }

   if(saveBtn){
      const id = element.id.slice(5, element.id.length);
      updateComment(id);           
   }

   if(cancelBtn){
      location.reload();      
   }  
});

let updateComment = async id => {
   const data = new FormData();
   const commentText = document.getElementById(`comment-${id}`);
   const method = 'update';
   data.append('id', id);
   data.append('comment', commentText.textContent);
   data.append('method', method);
   const peticion = await fetch('./php/comments_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   if(resultado['comment-msg'] === 'Comentario actualizado'){
      location.reload();
   }   
}

let deleteComment = async id => {
   const data = new FormData();
   const method = 'delete';

   data.append('id', id);
   data.append('method', method);

   const peticion = await fetch('./php/comments_controller.php', {
      method: 'POST',
      body: data
   }); 

   const resultado = await peticion.json();
   console.log(resultado)
   if(resultado[1]['db-msg'] === 'Comentario eliminado'){
      location.reload();
   }else{
      console.log('Error al eliminar el comentario');
   }   
}