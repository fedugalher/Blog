'use_strict';

window.addEventListener('load', ()=>{
   //Obtener parametros de la URL
   const params = window.location.search;
   const urlParams = new URLSearchParams(params);
   const email = urlParams.get('email');
   const token = urlParams.get('token');
   if(email && token){
      activate(email, token);
   }
});


let activate = async (email, token) =>{   
   const peticion = await fetch(`./php/users_controller.php?method=activate&email=${email}&token=${token}`); 
   const resultado = await peticion.json();
   const msg = document.getElementById('msg');
   console.log(resultado)
   if(resultado[1]['db-msg'] === 'Cuenta activada'){      
      msg.innerHTML = `<h4 class="text-center">Listo... Ahora puedes <a href="login.php">iniciar sesión</a></h4>`;
   }else{
      msg.innerHTML = `<h4 class="text-center">El enlace no es valido, por favor registrate nuevamente</h4>`;
      setTimeout("location.href = 'login.php'", 5000);
   }
}