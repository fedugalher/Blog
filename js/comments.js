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
   const userName = document.getElementById('username').textContent;  

   commentsContainer.innerHTML = '';
   for (const comment in resultado) {
      const date = new Date(resultado[comment].date); //para poder formatear la hora con la funcion formatDate()
      commentsContainer.innerHTML+= `
         <div class="col-lg-11 coment">
            <p class="coment-name" id="${resultado[comment].id}">${resultado[comment].username}</p>
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
      if(userName === commentName[comment].textContent){
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
   }

   if(saveBtn){
      const id = element.id.slice(5, element.id.length);
      updateComment(id);           
   }

   if(cancelBtn){
      const id = element.id.slice(7, element.id.length);
      const userActions = element.parentElement;
      const buttons = userActions.getElementsByTagName('BUTTON');
      const commentText = document.getElementById(`comment-${id}`);
     
      console.log(commentText)
      commentText.removeAttribute('contenteditable');
      commentText.classList.remove('comment-edit');     
      userActions.removeChild(buttons[0]);
      userActions.removeChild(buttons[0]);     
   }

  
});

let updateComment = async id => {
   const data = new FormData();
   const commentText = document.getElementById(`comment-${id}`);
   const method = 'update';
   data.append('id', id);
   data.append('comment', commentText.textContent);
   data.append('method', method);
   const peticion = await fetch('../php/comments_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   if(resultado['comment-msg'] === 'Comentario actualizado'){
      location.reload();
   }   
}