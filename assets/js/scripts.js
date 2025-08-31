let slides = document.querySelectorAll('.slider img');
let index = 0;
if(slides.length > 0){
    slides.forEach((s,i)=>{ if(i!==0) s.style.display='none'; });
    setInterval(() => {
        slides[index].style.display='none';
        index = (index+1)%slides.length;
        slides[index].style.display='block';
    }, 3000);
}
