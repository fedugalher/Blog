'use_strict';



document.addEventListener('click', e => {
   //saber si el elemento al que se le hizo click y asignarlo a una constante
   if(e.target.parentElement !== null){
      const editIcon = e.target.parentElement.className === 'edit-icon' ? true : false;
      const deleteIcon = e.target.parentElement.className === 'delete-icon' ? true : false;
      const updateBtn = e.target.textContent === 'Actualizar' ? true : false;
      
      if(editIcon){
         e.preventDefault();
               
         //Obtenr el id del usuraio cortando el contenido del tag id del elemento a
         let elementId = e.target.parentElement.id;
         let dash = elementId.indexOf('-');
         let userId = elementId.slice(dash+1,elementId.length);
         editUser(userId);
      }
      
      if(updateBtn){
         
         //Obtenr el id del usuraio cortando el contenido del tag id del elemento a
         let elementId = e.target.id;
         let dash = elementId.indexOf('-');
         let userId = elementId.slice(dash+1,elementId.length);
         updateUser(userId);
      }
   }
  
});


let editUser = id => {
   //Agregar o quitar clases y atributos para poder editar los campos de usuario
   const userImgLabel = document.getElementById(`userImgLabel-${id}`);
   const userEmailInput = document.getElementById(`userEmail-${id}`);
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
   userEmailInput.removeAttribute('disabled');
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
   const userEmail = document.getElementById(`userEmail-${id}`).value;
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
      data.append('email', userEmail);
      data.append('username', userName);
      data.append('password', userPass);
      data.append('password-confirm', userPass2);
      data.append('role', userRole);
      data.append('image', userImg.files[0]);
      data.append('method', method);
      
      // sendUser(data); //llama a la funcion send article y le pasa los datos del formulario

      const peticion = await fetch(`./php/users_controller.php`, {
         method: 'POST',
         body: data
      }); 
      const resultado = await peticion.json();
      
      if(resultado[resultado.length - 1]['user-msg'] == 'Usuario actualizado'){
         location.reload();
      }
   }


   
}


