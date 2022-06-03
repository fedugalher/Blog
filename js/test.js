const bodyText = document.getElementById('bodyText');
const body = document.getElementById('body');
const paragraph = document.getElementById('paragraph');
const bold = document.getElementById('bold');



bold.addEventListener('click', e =>{
   // e.preventDefault();
   var selection;
   if(window.getSelection){
      selection = window.getSelection();
   }
   console.log(selection)
   console.log(selection.anchorOffset)
   console.log(selection.focusOffset)

  
})





