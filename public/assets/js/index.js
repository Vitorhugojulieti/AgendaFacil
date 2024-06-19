// acordions
function toggleAcordion(element){
    element.classList.toggle("active");
    console.log(element);

    var panel = element.nextElementSibling;
    if (panel.style.display === "block") {
        panel.style.display = "none";
    } else {
        panel.style.display = "block";
    }

    let icons = element.querySelectorAll("i");

    if(icons[1].style.display === "none"){
        icons[0].style.display = "none";
        icons[1].style.display = "block";
    }else{
        icons[1].style.display = "none";
        icons[0].style.display = "block";
    }
}