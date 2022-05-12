'use_strict';

const userImg = document.querySelector('.userImgLabel');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const passwordConfirm = document.getElementById('password-confirm');
const image = document.getElementById('userImg');
const method = 'update';
const saveBtn = document.getElementById('btn-user');

window.addEventListener('load', ()=>{
   showUser();   
});

let showUser = async () =>{
   const peticion = await fetch('../php/users_controller.php?method=show'); 
   const resultado = await peticion.json();
   console.log(resultado)

   username.value = resultado.username;
   email.value = resultado.email;
   userImg.style.backgroundImage = `url(../images/users/${resultado.image})`;
   userImg.style.borderStyle = 'solid';      
}

saveBtn.addEventListener('click', e =>{
   e.preventDefault();
   const data = new FormData();
   data.append('email', email);
   data.append('username', username);
   data.append('password', password);
   data.append('image', image.files[0]);
   data.append('method', method);
});

//Previsualizar imagen antes de subirla --Ya funciona
document.getElementById("userImg").onchange = function(e) {
   // Creamos el objeto de la clase FileReader
   let reader = new FileReader();
 
   // Leemos el archivo subido y se lo pasamos a nuestro fileReader
   reader.readAsDataURL(e.target.files[0]);
 
   // Le decimos que cuando este listo ejecute el código interno
   reader.onload = function(){
      console.log(reader.result)
      let image = document.createElement('img'); 
      image.classList.add('imgLabel');
 
     image.src = reader.result;
 
     userImg.innerHTML = '';
     userImg.append(image);
   };
 }