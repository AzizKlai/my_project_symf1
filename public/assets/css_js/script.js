const add = document.querySelectorAll("td");

add.forEach(el=>el.addEventListener("click", function(e) {
   el.classList.toggle('highlight')}));