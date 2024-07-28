function request(method, url, data, onload, onerror)
{
   let xhr = new XMLHttpRequest();

   xhr.open(method, url);
   xhr.setRequestHeader("Content-Type", "application/json");

   xhr.send(data);
   xhr.onload = () => {
      if (xhr.status != 200) { 
          console.log(`Ошибка ${xhr.status}: ${xhr.statusText}`);
      }
      else
      {
         data = JSON.parse(xhr.responseText);
         onload(xhr, data);
      }
   };

   if(onerror == undefined)
   {
      xhr.onerror = function(){
         alert("Запрос не удался");
      }
   }
   else
   {
      xhr.onerror = onerror;
   }
}