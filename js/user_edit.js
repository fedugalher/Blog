'use_strict';



document.addEventListener('click', e => {
   //saber si el elemento al que se le hizo click y asignarlo a una constante
   const editIcon = e.target.parentElement.className === 'edit-icon' ? true : false;
   const deleteIcon = e.target.parentElement.className === 'delete-icon' ? true : false;
   const updateBtn = e.target.textContent === 'Actualizar' ? true : false;
  
   if(editIcon){
      console.log('edit user')      
      //Obtenr el id del usuraio cortando el contenido del tag id del elemento a
      let elementId = e.target.parentElement.id;
      let dash = elementId.indexOf('-');
      let userId = elementId.slice(dash+1,elementId.length);
      editUser(userId);
   }
   
   if(updateBtn){
      console.log('vas a actualizar')
      //Obtenr el id del usuraio cortando el contenido del tag id del elemento a
      let elementId = e.target.id;
      let dash = elementId.indexOf('-');
      let userId = elementId.slice(dash+1,elementId.length);
      updateUser(userId);
   }
});


let editUser = id => {
   //Agregar o quitar clases y atributos para poder editar los campos de usuario
   const userImgLabel = document.getElementById(`userImgLabel-${id}`);
   const userNameInput = document.getElementById(`userName-${id}`);
   const userRoleSelect = document.getElementById(`userRole-${id}`);
   const userPassInput = document.getElementById(`userPass-${id}`);
   const userPass2Input = document.getElementById(`userPass2-${id}`);
   const updateBtn = document.getElementById(`updateUserBtn-${id}`);
   const userImg = document.getElementById(`userImg-${id}`);
   const trUser = document.getElementById(`trUser-${id}`);

   userPassInput.value = '';
   userPass2Input.value = '';
   trUser.classList.replace('disabled', 'enabled');
   userNameInput.removeAttribute('disabled');
   userRoleSelect.removeAttribute('disabled');
   userPassInput.removeAttribute('disabled');
   userPass2Input.removeAttribute('disabled');
   userPass2Input.classList.remove('unset');
   updateBtn.classList.remove('unset');
   userImgLabel.classList.remove('unset');
   userImg.classList.add('unset');    
   
}

let updateUser = async id =>{
   const userName = document.getElementById(`userName-${id}`).value;
   const userRole = document.getElementById(`userRole-${id}`).value;
   const userPass = document.getElementById(`userPass-${id}`).value;
   const userPass2 = document.getElementById(`userPass2-${id}`).value;
   const userImg = document.getElementById(`userImgInput-${id}`);
   const method = 'update'; 
   const data = new FormData(); 
   
   if (userPass !== userPass2) {
      alert('El password no coincide');
   }else{
     
      data.append('id', id);
      data.append('username', userName);
      data.append('password', userPass);
      data.append('password-confirm', userPass2);
      data.append('role', userRole);
      data.append('image', userImg.files[0]);
      data.append('method', method);
      
      // sendUser(data); //llama a la funcion send article y le pasa los datos del formulario

      const peticion = await fetch(`../php/users_controller.php`, {
         method: 'POST',
         body: data
      }); 
      const resultado = await peticion.json();
      if(resultado['user-msg'] == 'Usuario actualizado'){
         location.reload();
      }
   }


   
}

// const btnUser = document.getElementById('btn-user');


// // Evento Click
// btnUser.addEventListener('click', e =>{
//    e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit

//    // const articleForm = document.getElementById('article-form');
//    // const data = new FormData(articleForm); //Guarda los datos del formulario creando un objeto form data
//    //Crea un objeto de tipo FormData, se guardanlos valores de los inputs en variables y se agregan al formulario,
//    //en este caso se agregan uno por uno y no todo el formulario como en la linea comentada, esto con el fin de agregar tambien el metodo new

//    const data = new FormData();
//    const username = document.getElementById('username').value;
//    const password = document.getElementById('password').value;
//    const passwordConfirm = document.getElementById('password-confirm').value;
//    const userRole = document.getElementById('user-role').value;
//    const image = document.getElementById('userImg');
//    const method = 'new';

//    if (password !== passwordConfirm) {
//       alert('El password no coincide');
//    }else{
//       data.append('username', username);
//       data.append('password', password);
//       data.append('password-confirm', passwordConfirm);
//       data.append('user-role', userRole);
//       data.append('image', image.files[0]);
//       data.append('method', method);
//       sendUser(data); //llama a la funcion send article y le pasa los datos del formulario
//    }
   
// });

// let sendUser = async (data) =>{   
//    const peticion = await fetch('../php/users_controller.php', {
//       method: 'POST',
//       body: data
//    }); 
//    const resultado = await peticion.json();
//    console.log(resultado)
//    if(resultado['user-msg'] == 'Usuario Registrado'){
//       location.href = 'users.php';
//    }
// }

