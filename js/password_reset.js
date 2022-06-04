'use_strict';

const btnSubmit = document.getElementById('login-btn');
const loginMsg = document.querySelector('.login-msg');

 //Obtener parametros de la URL
 const params = window.location.search;
 const urlParams = new URLSearchParams(params);
 const email = urlParams.get('email');
 const token = urlParams.get('token');


btnSubmit.addEventListener('click', e =>{
   e.preventDefault();

   if(email && token){
      const data = new FormData();
      const password = document.getElementById('password').value;
      const password2 = document.getElementById('password2').value;
      const method = 'passwordReset';

      if(password === password2 && password !== ""){
         data.append('email', email);
         data.append('token', token);
         data.append('password', password);
         data.append('method', method);
         passwordReset(data);
      }else{
         alert('La contraseña no coincide o está en blanco, favor de ingresarla correctamente');
      }
   }else{
      alert('Algo salio mal, por favor ingresa nuevamente al enlace que se te envió por correo o solicitalo nuevamente');
   }
   
});

let passwordReset = async (data) =>{   
   const peticion = await fetch(`${host_dir}/php/users_controller.php`, {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   console.log(resultado)

   if(resultado[1]['db-msg'] === 'El password ha sido cambiado correctamente'){
      loginMsg.textContent = 'Tu password ha sido cambiado, ya puedes iniciar sesión.'
      loginMsg.classList.add('msg-succes');
   }else{
      loginMsg.textContent = resultado[1]['db-msg'];
      loginMsg.classList.add('msg-error');
   }
}