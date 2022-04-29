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
   const username = document.getElementById('username').value;
   const password = document.getElementById('password').value;
   const passwordConfirm = document.getElementById('password-confirm').value;
   const userRole = document.getElementById('user-role').value;
   const image = document.getElementById('userImg');
   const method = 'new';

   if (password !== passwordConfirm) {
      alert('El password no coincide');
   }else{
      data.append('username', username);
      data.append('password', password);
      data.append('password-confirm', passwordConfirm);
      data.append('role', userRole);
      data.append('image', image.files[0]);
      data.append('method', method);
      sendUser(data); //llama a la funcion send article y le pasa los datos del formulario
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
      location.href = 'users.php';
   }
}