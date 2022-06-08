'use_strict';

const btnUser = document.getElementById('btn-user');
const msgBox = document.querySelector('.msg-box');
const userImg = document.querySelector('.userImgLabel');
const loader = document.querySelector('.loader');


// Evento Click
btnUser.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit

   // const articleForm = document.getElementById('article-form');
   // const data = new FormData(articleForm); //Guarda los datos del formulario creando un objeto form data
   //Crea un objeto de tipo FormData, se guardanlos valores de los inputs en variables y se agregan al formulario,
   //en este caso se agregan uno por uno y no todo el formulario como en la linea comentada, esto con el fin de agregar tambien el metodo new
   
   const data = new FormData();
   const userEmail = document.getElementById('email').value;
   const username = document.getElementById('username').value;
   const password = document.getElementById('password').value;
   const passwordConfirm = document.getElementById('password-confirm').value;
   const userRole = currentURL === `${host_dir}/public/users.php` ? document.getElementById('user-role').value : 'usuario';
   const image = document.getElementById('userImg');
   const method = 'new';   
   const messages = [];


   if(userEmail === '' || username === '' || password === ''|| passwordConfirm === ''){
      messages.push('Algunos campos están en blanco');
   }   
   if(userEmail !== '' && !emailValidate(userEmail)){      
     messages.push('El correo electrónico no es correcto');
   }   
   if (password !== passwordConfirm) {
      messages.push('El password no coincide');
   }
   if(password.length < 8){
      messages.push('El password debe ser de al menos 8 caracteres');
   }
   
   if(messages.length === 0){
      data.append('email', userEmail);
      data.append('username', username);
      data.append('password', password);
      data.append('password-confirm', passwordConfirm);
      data.append('role', userRole);
      data.append('image', image.files[0]);
      data.append('method', method);

      btnUser.setAttribute('disabled', true);
      msgBox.innerHTML = '';
      loader.innerHTML = `
         <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
         </div>	
      `;
      sendUser(data); //llama a la funcion send article y le pasa los datos del formulario     
   }else{      
      for (const msg in messages) {
         msgBox.innerHTML += `<p class="msg-error">* ${messages[msg]}</p>`;
      }
   }  
   
});

let sendUser = async (data) =>{   
   const peticion = await fetch(`./php/users_controller.php`, {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();   
   console.log(resultado)
   if(resultado[resultado.length - 1]['user-msg'] == 'Usuario registrado'){      
      if(currentURL === `${host_dir}/users.php`){
         location.href = 'users.php';
      }else{
         msgBox.innerHTML += `
         <p class="msg-succes">
            * Tu usuario ha sido registrado, por favor revisa tu correo electrónico
            y sigue las instrucciones para activar tu cuenta. 
         </p>`;
         loader.innerHTML = '';
         setTimeout("location.href = 'index.php'", 10000);
      }
   }else{  
      btnUser.removeAttribute('disabled');
      msgBox.innerHTML = '';
      loader.innerHTML = '';
      for (const msg in resultado) {
         if(resultado[msg]['user-msg']){
            console.log(resultado[msg]['user-msg'])
            msgBox.innerHTML+=`
            <p class="msg-error">* ${resultado[msg]['user-msg']}</p>         
         `;
         }
      }
   }
}

let emailValidate = email => {
   expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
       return false
    }else{
       return true
    }       
}

//Previsualizar imagen antes de subirla --Ya funciona
document.getElementById("userImg").onchange = function(e) {
   // Creamos el objeto de la clase FileReader
   let reader = new FileReader();
 
   // Leemos el archivo subido y se lo pasamos a nuestro fileReader
   if(e.target.files[0]){
      reader.readAsDataURL(e.target.files[0]);
   }
  
 
   // Le decimos que cuando este listo ejecute el código interno
   reader.onload = function(){
      let image = document.createElement('img'); 
      image.classList.add('imgLabel');
 
     image.src = reader.result;
 
     userImg.innerHTML = '';
     userImg.append(image);
   };
 }