'use_strict';

document.addEventListener('click', e => {
   //saber si el elemento al que se le hizo click y asignarlo a una constante
   const deleteIcon = e.target.parentElement.className === 'delete-icon' ? true : false;
  
   if(deleteIcon){
      console.log('delete User')      
      //Obtenr el id del usuraio cortando el contenido del tag id del elemento a
      let elementId = e.target.parentElement.id;
      let dash = elementId.indexOf('-');
      let userId = elementId.slice(dash+1,elementId.length);
      deleteUser(userId)
   }  
});

let deleteUser = async id =>{
   const peticion = await fetch(`../php/users_controller.php?method=delete&id=${id}`); 
   const resultado = await peticion.json();
   console.log(resultado)
   if(resultado[1].msg == 'Usuario eliminado'){
      location.reload();
   }
}