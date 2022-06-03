'use_strict';

const userForm = document.getElementById('userForm');
const userImg = document.querySelector('.userImgLabel');
const username = document.getElementById('username');
const email = document.getElementById('email');
const newPassword = document.getElementById('password-new');
const passwordConfirm = document.getElementById('password-confirm');
const password = document.getElementById('password');
const image = document.getElementById('userImg');
const msgBox = document.querySelector('.msg-box');
const saveBtn = document.getElementById('btn-user');
const loader = document.querySelector('.loader');

window.addEventListener('load', ()=>{
   showUser();   
});

let showUser = async () =>{
   const peticion = await fetch('../php/users_controller.php?method=show'); 
   const resultado = await peticion.json();
   console.log(resultado)

   username.value = resultado.username;
   email.value = resultado.email;
   userImg.style.backgroundImage = `url(../images/users/${resultado.id}/${resultado.image})`;
   userImg.style.borderStyle = 'solid';      
}

saveBtn.addEventListener('click', e =>{
   e.preventDefault();
   let errorsCount = 0;
   msgBox.innerHTML = '';
   username.classList.remove('input-error');
   email.classList.remove('input-error');
   newPassword.classList.remove('input-error');
   passwordConfirm.classList.remove('input-error');
   password.classList.remove('input-error');
   
   if(username.value === '' || email.value === '' || password.value === ''){
      let params = {'Nombre de usuario': username.value, 'Correo electrónico':email.value, 'Contraseña actual':password.value};
      
      for (const param in params) {
         if (params[param] === '') {
            msgBox.innerHTML+= `<p class="msg-error">* El campo <b>${param}</b> está vacio.</p>`;
            switch (param) {
               case 'Nombre de usuario':
                  username.classList.add('input-error');
                  break;
               case 'Correo electrónico':
                  email.classList.add('input-error');
                  break;
               case 'Contraseña actual':
                  password.classList.add('input-error');
                  break;            
               default:
                  break;
            }
            errorsCount++;
         }
      }     
   }

   if(newPassword.value !== passwordConfirm.value){
      msgBox.innerHTML+= `<p class="msg-error">* La contraseña no coincide</p>`;
      passwordConfirm.classList.add('input-error');      
      errorsCount++;
   }
   
   if(newPassword.value.length < 8 && !newPassword.value === ''){
      msgBox.innerHTML+= `<p class="msg-error">* La contraseña debe contener al menos 8 caracteres</p>`;
      newPassword.classList.add('input-error');
      errorsCount++;
   }

   if(errorsCount === 0){
      const data = new FormData();
      data.append('email', email.value);
      data.append('username', username.value);
      data.append('password-new', newPassword.value);
      data.append('password', password.value);
      data.append('image', image.files[0]);
      data.append('method', 'update');

      saveBtn.setAttribute('disabled', '');
      msgBox.innerHTML = '';
      loader.innerHTML = `
         <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
         </div>	
      `;
      sendUser(data);
   }
  
});

let sendUser = async (data) =>{   
   const peticion = await fetch('../php/users_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   
   msgBox.innerHTML = '';

   if(resultado[resultado.length-1]['user-msg'] == 'Usuario actualizado'){
      if(currentURL === 'http://localhost/FedugalherBlog/public/users.php'){
         location.href = 'users.php';
      }else{  
         loader.innerHTML = ''; 
         msgBox.innerHTML+=`<p class="msg-succes">
            * Tus datos han sido actualizados, por favor inicia sesión nuevamente para ver los cambios.
         </p>`;                   
         for (const message in resultado) {
           if(resultado[message]['msg'] == 'El mensaje ha sido enviado'){
            msgBox.innerHTML+= `
               <p class="msg-succes">
                  * Se ha enviado un enlace para activar tu nueva cuenta de correo electrónico, 
                  por favor accede e inicia sesión nuevamente. 
               </p>`;            
           }
         }
         setTimeout('closeSession()', 10000);    
      }
   }else{ 
      saveBtn.removeAttribute('disabled');
      loader.innerHTML = '';     
      for (const msg in resultado) {
         if(resultado[msg]['user-msg'] && resultado[msg]['msgType'] === 'error'){
            msgBox.innerHTML+=`<p class="msg-error">* ${resultado[msg]['user-msg']}</p>`;
         }
      }
   }
}

//Previsualizar imagen antes de subirla --Ya funciona
document.getElementById("userImg").onchange = function(e) {
   // Creamos el objeto de la clase FileReader
   let reader = new FileReader();
 
   // Leemos el archivo subido y se lo pasamos a nuestro fileReader
   reader.readAsDataURL(e.target.files[0]);
 
   // Le decimos que cuando este listo ejecute el código interno
   reader.onload = function(){
      console.log(reader.result)
      let image = document.createElement('img'); 
      image.classList.add('imgLabel');
 
     image.src = reader.result;
 
     userImg.innerHTML = '';
     userImg.append(image);
   };
 }