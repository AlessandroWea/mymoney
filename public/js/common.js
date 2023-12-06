function request(method, url, data, onload, onerror)
{
   let xhr = new XMLHttpRequest();

   xhr.open(method, url);

   xhr.send(data);

   xhr.onload = onload;

   xhr.onerror = onerror;
}