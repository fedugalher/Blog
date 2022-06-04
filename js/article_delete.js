'use_strict';

document.addEventListener('click', e =>{
   let element = e.target;   
   
   if(element.id.indexOf('delete') != -1){
      let dash = element.id.indexOf('-');
      let id = element.id.slice(dash+1,element.id.length);
      let articleDelete = confirm('¿Deseas eleminar el artículo?');
      if(articleDelete == true){
         deleteArticle(id);
      }
   }  
});

const deleteArticle = async (id) => {
   const peticion = await fetch(`${host_dir}/php/articles_controller.php?method=delete&id=${id}`); 
   const resultado = await peticion.json();
   console.log(resultado[1].msg);
   if(resultado[1]['db-msg'] == 'Articulo eliminado'){
         location.reload();
   }else{
      console.log('No se pudo eliminar el articulo')
   }

}

