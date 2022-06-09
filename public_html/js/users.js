'use_strict';

let usersTableBody = document.getElementById('usersTable-body');

window.addEventListener('load', ()=>{
   getUsers();
});

let getUsers = async () =>{
   
   const peticion = await fetch(`./php/users_controller.php?method=selectAll`); 
   const resultado = await peticion.json();
  
   let count = 1;
   for (const user in resultado.data) {

      const date = new Date(resultado.data[user].reg_date); //para poder formatear la hora con la funcion formatDate()
      const userId = resultado.data[user].id;
      const userEmail = resultado.data[user].email;
      const userImage = resultado.data[user].image
      const userName = resultado.data[user].username;
      const userRole = resultado.data[user].role;
      const userPass = resultado.data[user].password;        
      
      const imageSrc = userImage === 'no-image.png' ? 'images/users' : `images/users/${userId}`;

    
      usersTableBody.innerHTML += `
         <tr id="trUser-${userId}" class="disabled">
            <th scope="row">${count++}</th>
            <td>
               <img src="${imageSrc}/${userImage}" id="userImg-${userId}"  class="user-img">
               <label id="userImgLabel-${userId}" for="userImgInput-${userId}" class="userInputLabel unset"></label>               
               <input id="userImgInput-${userId}" class="unset" type="file" name="image">
            </td>            
            <td><input type="text" value="${userName}" id="userName-${userId}" name="userName" disabled placeholder="Nombre de usuario"></td>
            <td><input type="text" value="${userEmail}" id="userEmail-${userId}" name="userEmail" disabled placeholder="Correo Electrónico"></td>
            <td id="tdUserRole-${userId}"></td>
            <td id="tdUserPass-${userId}">
               <input type="password" value="${userPass}" id="userPass-${userId}" name="userPass" disabled placeholder="Password anterior">
               <input type="password" value="" id="userPass2-${userId}" name="userPass2" disabled placeholder="Confirmar password" class="unset">
            </td>
            <td>${formatDate(date)}</td>
            <td class="text-center">
               <button id="updateUserBtn-${userId}" class="btn-green unset">Actualizar</button><br>
               <a id="editUser-${userId}" href="" class="edit-icon"><i class="fa-solid fa-pen-to-square"></i></a> 
               <a id="deleteUser-${userId}" href="" class="delete-icon"><i class="fa-solid fa-trash-can"></i></a>
            </td>
         </tr>
      `;

      //Select del Rol de usuario
      const tdRole = document.getElementById(`tdUserRole-${userId}`);
      const userRoleSelect = document.createElement('select');
      
      userRoleSelect.setAttribute('name', 'user-role');
      userRoleSelect.setAttribute('id', `userRole-${userId}`);
      userRoleSelect.setAttribute('disabled', true);
      let roleOption1 = document.createElement('option');
      let roleOption2 = document.createElement('option');
      roleOption1.value = 'admin';
      roleOption1.text = 'Administrador';
      roleOption2.value = 'user';
      roleOption2.text = 'Usuario';
      userRoleSelect.add(roleOption1, null);
      userRoleSelect.add(roleOption2, null);        

      if(roleOption1.value === userRole){
         roleOption1.setAttribute('selected', true)
      }else{
         roleOption2.setAttribute('selected', true)
      }
      tdRole.appendChild(userRoleSelect);
   }   
}

let formatDate = date =>{
   let day = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let fullDate = `${day[date.getDay()]}, ${date.getDate()} de ${month[date.getMonth()]} de ${date.getFullYear()}`;
  
   return fullDate;
}
