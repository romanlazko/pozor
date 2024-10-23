// function setWindowHeight() {
//     const windowHeight = window.innerHeight;
//     document.documentElement.style.setProperty('--vh', `${windowHeight * 0.01}px`);
// }

// window.addEventListener('resize', setWindowHeight);
// window.addEventListener('orientationchange', setWindowHeight);
// setWindowHeight();

function resizeElement() {
    const windowHeight = window.innerHeight;
    const windowWidth = window.innerWidth;
    
    const element = document.getElementById('resizable-element');
    
    // Применение размеров окна к элементу
    element.style.height = `${windowHeight}px`;
    element.style.width = `${windowWidth}px`;

    alert('ok');
  }

  function setListeners()
  {
     
  }