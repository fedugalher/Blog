'use_strict';

let usersTableBody = document.getElementById('usersTable-body');


let getUsers = async () =>{
   
   const peticion = await fetch('./php/users_controller.php?method=selectAll'); 
   const resultado = await peticion.json();
  
   let count = 1;
   for (const user in resultado.data) {

      const date = new Date(resultado.data[user].reg_date); //para poder formatear la hora con la funcion formatDate()
    
      usersTableBody.innerHTML += `
         <tr>
            <th scope="row">${count++}</th>
            <td><img src="images/users/${resultado.data[user].image}" alt="" class="user-img"></td>
            <td>${resultado.data[user].username}</td>
            <td>${resultado.data[user].role}</td>
            <td>${formatDate(date)}</td>
            <td>
            <a href="" class="edit-icon"><i class="fa-solid fa-pen-to-square"></i></a> 
            <a href="" class="delete-icon"><i class="fa-solid fa-trash-can"></i></a>
            </td>
         </tr>
      `;
   }
   
}

getUsers();

let formatDate = date =>{
   let day = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let fullDate = `${day[date.getDay()]}, ${date.getDate()+1} de ${month[date.getMonth()]} de ${date.getFullYear()}`;
   // console.log(fullDate);
   return fullDate;
}
