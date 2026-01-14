// --- Bài 1: Đổi nền ---
const btnToggle = document.getElementById('btn-toggle');
btnToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark');
});

// --- Bài 2: Menu Highlight ---
const sections = document.querySelectorAll('section');
const navLinks = document.querySelectorAll('.menu-link');

window.addEventListener('scroll', () => {
    let current = "";
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (pageYOffset >= sectionTop - 100) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').includes(current)) {
            link.classList.add('active');
        }
    });
});

// --- Bài 3: Xuất hiện khi cuộn ---
const boxes = document.querySelectorAll('.box');
const checkBoxes = () => {
    const triggerBottom = window.innerHeight * 0.8;
    boxes.forEach(box => {
        const boxTop = box.getBoundingClientRect().top;
        if (boxTop < triggerBottom) {
            box.classList.add('show');
        } else {
            box.classList.remove('show'); // Có thể bỏ nếu chỉ muốn hiện 1 lần
        }
    });
};
window.addEventListener('scroll', checkBoxes);

// --- Bài 4: Nút nhảy ---
const jumpBtn = document.querySelector('.jump');
jumpBtn.addEventListener('mouseover', () => {
    jumpBtn.classList.add('animate');
    // Xóa class sau khi animation xong để có thể kích hoạt lại
    setTimeout(() => {
        jumpBtn.classList.remove('animate');
    }, 500);
});

// --- Bài 5: Theo dấu chuột ---
const circle = document.querySelector('.circle');
window.addEventListener('mousemove', (e) => {
    // Trừ đi 15px (nửa kích thước circle) để chuột nằm giữa hình tròn
    circle.style.left = e.clientX - 15 + 'px';
    circle.style.top = e.clientY - 15 + 'px';
});