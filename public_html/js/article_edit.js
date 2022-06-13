'use_strict';

//Obtener parametros de la URL
const params = window.location.search;
const urlParams = new URLSearchParams(params);
const id = urlParams.get('id');

const articleImg = document.querySelector('.article-img');
const articleImage = document.createElement('img');
const title = document.getElementById('title');
const body = document.getElementById('body');
const preview = document.getElementById('preview');
const categorySelect = document.getElementById('category');
const image = document.getElementById('img-file');
const articleStatus = document.getElementById('status');
const btnPublish = document.getElementById('btn-publish');
const articleBody = document.getElementById('body');
const articlePreview = document.getElementById('preview');
const charCount = document.getElementById('counter1');
const charCountPreview = document.getElementById('counter2');
const articleText = document.querySelector('.article-text');
const articleTitle = document.getElementById('article-title');
const data = new FormData();


window.onload = e =>{   
   getCategories();     
}

articleBody.addEventListener('keyup', () =>{
   if(articleBody.value.length <= 3000){
      charCount.textContent = articleBody.value.length + '/' + 3000;
      if(articleBody.value.length >= 2950){
         charCount.style.color = '#720d0d';
      }else{
         charCount.style.color = '#9b9b9b';
      }
      articleText.innerHTML = articleBody.value;
   }else{
      articleBody.value = articleBody.value.slice(0, 3000);            
   }
});

articlePreview.addEventListener('keyup', () =>{
   if(articlePreview.value.length <= 100){
      charCountPreview.textContent = articlePreview.value.length + '/' + 100;
      if(articlePreview.value.length >= 90){
         charCountPreview.style.color = '#720d0d';
      }else{
         charCountPreview.style.color = '#9b9b9b';
      }
   }else{
      articlePreview.value = articlePreview.value.slice(0, 100);            
   }
});

sesionClose.addEventListener('click', e => {
   e.preventDefault();
   closeSession();
});

btnPublish.addEventListener('click', e =>{
   e.preventDefault();

   data.append('title', title.value);
   data.append('body', body.value);
   data.append('preview', preview.value);
   data.append('category', categorySelect.value);
   data.append('image', image.files[0]);
   data.append('status', articleStatus.checked);
   data.append('method', 'update');
   data.append('id', id);

   sendArticle(data);
});

const getArticle = async () =>{   
   
   const peticion = await fetch(`./php/articles_controller.php?method=edit&id=${id}`); 
   const resultado = await peticion.json();

   const imgSrc = resultado.image === 'no-image.png' ? './images/articles/' : `./images/articles/${resultado.id}/`;   
   articleImage.src = `${imgSrc + resultado.image}`;
   articleImage.id = 'article-image'; 
   articleImg.innerHTML = '';
   articleImg.append(articleImage);
   articleText.innerHTML = resultado.body;
   articleTitle.textContent = resultado.title;
   title.value = resultado.title;  
   
   categorySelect.value = resultado.category;
   body.value = resultado.body;
   preview.value = resultado.preview;
   articleStatus.checked = resultado.status === 'published' ? true : false;
}

const sendArticle = async (data) =>{   
   const peticion = await fetch(`./php/articles_controller.php`, {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
   if(resultado[resultado.length - 1]['article-msg'] == 'Artículo actualizado'){
      location.href = 'admin.php';
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

 //Obtener categorias para llenar el select

const getCategories = async () =>{   
   const peticion = await fetch(`./php/categories_controller.php?method=selectAll`); 
   const resultado = await peticion.json();
   const categories = resultado.data;   

   for (const category in categories) {
     let option = document.createElement('option');
     option.value = categories[category].name;
     option.text = categories[category].name;
     categorySelect.add(option);
   } 
   getArticle();
}

