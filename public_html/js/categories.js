'use_strict';

let categoriesTableBody = document.getElementById('categoriesTable-body');

window.addEventListener('load', ()=>{
   getCategories();
});

let getCategories = async () =>{
   
   const peticion = await fetch(`./php/categories_controller.php?method=selectAll`); 
   const resultado = await peticion.json();
  
   let count = 1;
   for (const category in resultado.data) {

      const date = new Date(resultado.data[category].created_at); //para poder formatear la hora con la funcion formatDate()
      const categoryId = resultado.data[category].id;
      const categoryName = resultado.data[category].name; 

    
      categoriesTableBody.innerHTML += `
         <tr id="trCategory-${categoryId}" class="text-center">
            <th scope="row">${count++}</th>                 
            <td>${categoryName}</td>
            <td>${formatDate(date)}</td>    
            <td class="text-center">               
               <a id="deleteCategory-${categoryId}" href="" class="delete-icon"><i class="fa-solid fa-trash-can"></i></a>
            </td>
         </tr>
      `;

     
   }   
}

//Formatear fecha
let formatDate = date =>{
   let calendarIcon = '<i class="fa-solid fa-calendar-days date-icons"></i>';
   let clockIcon = '<i class="fa-solid fa-clock date-icons"></i>';
   let day = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
   let month = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
   let hours = date.getHours().toString().length === 1 ? '0'+ date.getHours() : date.getHours();
   let minutes = date.getMinutes().toString().length === 1 ? '0'+ date.getMinutes() : date.getMinutes();   
   let fullDate = `${calendarIcon} ${day[date.getDay()]}, ${date.getDate()} de ${month[date.getMonth()]} de ${date.getFullYear()} ${clockIcon} ${hours}:${minutes}`;

   return fullDate;
}
