document.addEventListener("DOMContentLoaded", function() {
    var monElement = document.getElementById("image-container");
    var boutonAfficher = document.getElementById("scroll-button");
    
    boutonAfficher.addEventListener("click", function() {
      
if (monElement.style.display !== "none") {
            monElement.style.display = "none"; 
        } else {
            monElement.style.display = "block"; 

       }
       })
        
    })
     



    


