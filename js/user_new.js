'use_strict';

const btnUser = document.getElementById('btn-user');


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
   const userRole = currentURL === 'http://localhost/FedugalherBlog/public/users.php' ? document.getElementById('user-role').value : 'usuario';
   const image = document.getElementById('userImg');
   const method = 'new';
   const msgBox = document.querySelector('.msg-box');
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
   console.log(messages.length)
   if(messages.length === 0){
      data.append('email', userEmail);
      data.append('username', username);
      data.append('password', password);
      data.append('password-confirm', passwordConfirm);
      data.append('role', userRole);
      data.append('image', image.files[0]);
      data.append('method', method);
      sendUser(data); //llama a la funcion send article y le pasa los datos del formulario     
   }else{
      
      for (const msg in messages) {
         msgBox.innerHTML += `<p class="msg-error">* ${messages[msg]}</p>`;
      }
   }  
   
});

let sendUser = async (data) =>{   
   const peticion = await fetch('../php/users_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   console.log(resultado)
   if(resultado['user-msg'] == 'Usuario Registrado'){
      if(currentURL === 'http://localhost/FedugalherBlog/public/users.php'){
         location.href = 'users.php';
      }else{
         location.href = 'index.php';
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