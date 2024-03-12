const btn=document.querySelector("btn")
const cambiarTemaClaro = () => {
    // Cambiar el tema a light
    document.documentElement.setAttribute('data-bs-theme', 'light');

    // Cambiar la clase de fa-regular a fa-solid
    const iconoLuna = document.querySelector('.fa-regular.fa-moon');
    iconoLuna.classList.remove('fa-regular');
    iconoLuna.classList.add('fa-solid');
};
