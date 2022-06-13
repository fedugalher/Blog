'use_strict';

const btnPublish = document.getElementById('btn-publish');
const articleBody = document.getElementById('body');
const articlePreview = document.getElementById('preview');
const charCount = document.getElementById('counter1');
const charCountPreview = document.getElementById('counter2');
const articleText = document.querySelector('.article-text');


// Evento Click
btnPublish.addEventListener('click', e =>{
   e.preventDefault(); //Evita que se recargue la pagina al dar click en el boton submit

   // const articleForm = document.getElementById('article-form');
   // const data = new FormData(articleForm); //Guarda los datos del formulario creando un objeto form data
   //Crea un objeto de tipo FormData, se guardanlos valores de los inputs en variables y se agregan al formulario,
   //en este caso se agregan uno por uno y no todo el formulario como en la linea comentada, esto con el fin de agregar tambien el metodo new

   const data = new FormData();
   const title = document.getElementById('title').value;
   const body = document.getElementById('body').value;
   const preview = document.getElementById('preview').value;
   const category = document.getElementById('category').value;
   const image = document.getElementById('img-file');
   const status = document.getElementById('status').checked;
   const method = 'new';

   data.append('title', title);
   data.append('body', body);
   data.append('preview', preview);
   data.append('category', category);
   data.append('image', image.files[0]);
   data.append('status', status);
   data.append('method', method);
   sendArticle(data); //llama a la funcion send article y le pasa los datos del formulario
   
});



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

let sendArticle = async (data) =>{   
   const peticion = await fetch(`./php/articles_controller.php`, {
      method: 'POST',
      body: data
   }); 
   const resultado = await peticion.json();
  
   if(resultado[6]['article-msg'] == 'Artículo guardado'){
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
     let preview = document.querySelector('.article-img'),
             image = document.createElement('img');
 
     image.src = reader.result;
 
     preview.innerHTML = '';
     preview.append(image);
   };
 }

//Obtener categorias para llenar el select

 window.addEventListener('load', ()=>{
      getCategories();
 });

let getCategories = async () =>{   
   const peticion = await fetch(`./php/categories_controller.php?method=selectAll`); 
   const resultado = await peticion.json();
   const categories = resultado.data;
   const categorySelect = document.getElementById('category');

   for (const category in categories) {
     let option = document.createElement('option');
     option.value = categories[category].name;
     option.text = categories[category].name;
     categorySelect.add(option);
   }   
}