'use_strict';

document.addEventListener('click', e => {
   //saber si el elemento al que se le hizo click y asignarlo a una constante
   if(e.target.parentElement !== null){
      const deleteIcon = e.target.parentElement.className === 'delete-icon' ? true : false;
     
      if(deleteIcon){
         e.preventDefault();  
         //Obtenr el id del usuraio cortando el contenido del tag id del elemento a
         let elementId = e.target.parentElement.id;
         let dash = elementId.indexOf('-');
         let categoryId = elementId.slice(dash+1,elementId.length);
         const deleteConfirm = confirm('¿Estas seguro que deseas eliminar la categoría?');
         if(deleteConfirm){
            deleteCategory(categoryId);
         }         
      }  
   }
});

let deleteCategory = async id =>{
   const peticion = await fetch(`./php/categories_controller.php?method=delete&id=${id}`); 
   const resultado = await peticion.json();
   
   if(resultado[1]['db-msg'] == 'Categoría eliminada'){
      location.reload();
   }
}