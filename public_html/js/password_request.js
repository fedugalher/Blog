'use_strict';

const btnSubmit = document.getElementById('login-btn');
const loginMsg = document.querySelector('.login-msg');
const loader = document.querySelector('.loader');

btnSubmit.addEventListener('click', e =>{
   e.preventDefault();
   const data = new FormData();
   const username = document.getElementById('username').value;
   const email = document.getElementById('email').value;
   const method = 'passwordRequest';

   if(email === '' || username === ''){
     alert('Algunos campos están vacios, favor de llenarlos')
   }else if(!emailValidate(email)){
      alert('Favor de escribir un correo valido');
   }else{
      data.append('username', username);
      data.append('email', email);
      data.append('method', method);

      btnSubmit.setAttribute('disabled', '')
      loginMsg.textContent = '';
      loader.innerHTML = `
         <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
         </div>	
      `;

      passwordRequest(data);
   }
   
});

let passwordRequest = async (data) =>{   
   const peticion = await fetch(`./php/users_controller.php`, {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   console.log(resultado)

   if(resultado[2].msg === 'El mensaje ha sido enviado'){
      loader.innerHTML = '';
      loginMsg.textContent = 'Listo, por favor revisa tu correo y sigue las indicaciones.'
      loginMsg.classList.add('msg-succes');
   }else{
      loader.innerHTML = '';
      btnSubmit.removeAttribute('disabled');
      loginMsg.textContent = 'Los datos que ingresaste son incorrectos, favor de verificarlos.';
      loginMsg.classList.add('msg-error');
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