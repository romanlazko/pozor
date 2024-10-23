// function setWindowHeight() {
//     const windowHeight = window.innerHeight;
//     document.documentElement.style.setProperty('--vh', `${windowHeight * 0.01}px`);
// }

// window.addEventListener('resize', setWindowHeight);
// window.addEventListener('orientationchange', setWindowHeight);
// setWindowHeight();

window.addEventListener('resize', () => {
    document.body.style.height = `${window.innerHeight}px`;
});