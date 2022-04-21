'use_strict';

const btnSesion = document.getElementById('login-btn');

btnSesion.addEventListener('click', e =>{
   e.preventDefault();

   const data = new FormData();
   const username = document.getElementById('username').value;
   const password = document.getElementById('password').value;
   const method = 'startSesion';

   data.append('username', username);
   data.append('password', password);
   data.append('method', method);
   startSesion(data);
});

let startSesion = async (data) =>{   
   const peticion = await fetch('./php/sesions_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   console.log(resultado['messages'][1].msgType)
   
}