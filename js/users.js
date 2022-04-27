'use_strict';

window.addEventListener('load', ()=>{
   getUsers();
});



let usersTableBody = document.getElementById('usersTable-body');


let getUsers = async () =>{
   
   const peticion = await fetch('../php/users_controller.php?method=selectAll'); 
   const resultado = await peticion.json();
  
   let count = 1;
   for (const user in resultado.data) {

      const date = new Date(resultado.data[user].reg_date); //para poder formatear la hora con la funcion formatDate()
      //asignar datos obtenidos a constantes
      const userId = resultado.data[user].id;
      const userImage = resultado.data[user].image
      const userName = resultado.data[user].username;
      const userRole = resultado.data[user].role;
      const userPass = resultado.data[user].password;      

      // //Crear elementos
      // //Tabla
      // const userRow = document.createElement('tr');
      // const thCount = document.createElement('th');
      // const tdImg = document.createElement('td');
      // const tdUsername = document.createElement('td');
      // const tdRole = document.createElement('td');
      // const tdPassword = document.createElement('td');
      // const tdDate = document.createElement('td');
      // const tdActions = document.createElement('td');
      // //inputs
      // const userImg = document.createElement('img');
      // const userNameText = document.createElement('input');
      // const userRoleSelect = document.createElement('select');
      // const userPassText = document.createElement('input');
      // //Links
      // const userEditLink = document.createElement('A');
      // const userDeleteLink = document.createElement('A');
      // //Iconos
      // const userEditIcon = document.createElement('i');
      // const userDeleteIcon = document.createElement('i');


      
      // //Asignar atributos a elementos

      // //Img
      // userImg.setAttribute('src', `../images/users/${userImage}`);
      // userImg.classList.add('user-img');
      // //userNameText
      // userNameText.setAttribute('type', 'text');
      // userNameText.setAttribute('name', 'username');
      // userNameText.value = userName;
      // //userPassText
      // userPassText.setAttribute('type', 'password');
      // userPassText.setAttribute('name', 'password');
      // userPassText.value = userPass;
      // //Links
      // userEditLink.setAttribute('id', `userEdit-${userId}`);
      // userEditLink.classList.add('edit-icon');
      // userEditLink.setAttribute('id', `userDelete-${userId}`);
      // userDeleteLink.classList.add('edit-icon');
    
      usersTableBody.innerHTML += `
         <tr id="user-${userId}" class="disabled">
            <th scope="row">${count++}</th>
            <td><img src="../images/users/${userImage}" alt="" class="user-img"></td>
            <td><input type="text" value="${userName}" disabled></td>
            <td id="tdUserRole-${userId}"></td>
            <td><input type="password" value="${userPass}" id="userPass-${userId}" name="userPass" disabled></td>
            <td>${formatDate(date)}</td>
            <td>
            <a id="editUser-${userId}" href="#" class="edit-icon"><i class="fa-solid fa-pen-to-square"></i></a> 
            <a id="deleteUser-${userId}" href="#" class="delete-icon"><i class="fa-solid fa-trash-can"></i></a>
            </td>
         </tr>
      `;

      //Select del Rol de usuario
      const tdRole = document.getElementById(`tdUserRole-${userId}`);
      const userRoleSelect = document.createElement('select');
      
      userRoleSelect.setAttribute('name', 'user-role');
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
         console.log('igual')
         roleOption1.setAttribute('selected', true)
      }else{
         console.log('otro rol')
         roleOption2.setAttribute('selected', true)
      }
      tdRole.appendChild(userRoleSelect);
   }   
}

let formatDate = date =>{
   let day = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let fullDate = `${day[date.getDay()]}, ${date.getDate()} de ${month[date.getMonth()]} de ${date.getFullYear()}`;
   // console.log(fullDate);
   return fullDate;
}
