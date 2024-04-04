const slides= document.querySelectorAll(".slide")
var counter = 0;
// console.log(slides)
slides.forEach(
    (slide,index) =>{
        slide.computedStyleMap.left ='${index*100}%'
    }
)
 
const slideImage =() => {
    slides.forEach(
        (slide) => {
            slide.style.transform = 'translateX(-${counter*100}%)'
        }
    )
}