'use_strict';

//Obtener parametros de la URL
const params = window.location.search;
const urlParams = new URLSearchParams(params);
const id = urlParams.get('id');

const articleImg = document.querySelector('.article-img');
const articleImage = document.createElement('img');
const title = document.getElementById('title');
const body = document.getElementById('body');
const category = document.getElementById('category');
const image = document.getElementById('img-file');
const articleStatus = document.getElementById('status');
const btnPublish = document.getElementById('btn-publish');
const data = new FormData();


window.onload = e =>{
   getArticle();   
}

sesionClose.addEventListener('click', e => {
   e.preventDefault();
   closeSession();
});

btnPublish.addEventListener('click', e =>{
   e.preventDefault();

   data.append('title', title.value);
   data.append('body', body.value);
   data.append('category', category.value);
   data.append('image', image.files[0]);
   data.append('status', articleStatus.checked);
   data.append('user_id', 1); //esto es temporal igual que en el metodo new
   data.append('method', 'update');
   data.append('id', id);

   sendArticle(data);
});

const getArticle = async () =>{   
   const peticion = await fetch(`../php/articles_controller.php?method=edit&id=${id}`); 
   const resultado = await peticion.json(); 
   
   articleImage.src = `../images/articles/${resultado.image}`;
   articleImage.id = 'article-image'; 
   articleImg.innerHTML = '';
   articleImg.append(articleImage);
   title.value = resultado.title;
   category.value = resultado.category;
   body.value = resultado.body;
   articleStatus.checked = resultado.status === 'published' ? true : false;
   console.log(resultado)
}

const sendArticle = async (data) =>{   
   const peticion = await fetch('../php/articles_controller.php', {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   if(resultado['article-msg'] == 'Articulo guardado'){
      location.href = 'index.php';
   }
}

//Previsualizar imagen antes de subirla --Ya funciona
document.getElementById("img-file").onchange = function(e) {
   // Creamos el objeto de la clase FileReader
   let reader = new FileReader();
 
   // Leemos el archivo subido y se lo pasamos a nuestro fileReader
   reader.readAsDataURL(e.target.files[0]);
 
   // Le decimos que cuando este listo ejecute el código interno
   reader.onload = function(){
     let preview = document.querySelector('.article-img')
            
   //   const articleImage = document.getElementById('article-image');
     articleImage.src = reader.result;
 
     preview.innerHTML = '';
     preview.append(articleImage);
   };
 }

