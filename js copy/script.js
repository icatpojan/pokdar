document.addEventListener('DOMContentLoaded', () => {
    // --- Three.js Hero Background ---
    const initThree = () => {
        const canvas = document.getElementById('three-canvas');
        if (!canvas) return;

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });

        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

        // Create particles
        const particlesGeometry = new THREE.BufferGeometry();
        const count = 1500;
        const positions = new Float32Array(count * 3);

        for (let i = 0; i < count * 3; i++) {
            positions[i] = (Math.random() - 0.5) * 15;
        }

        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.02,
            color: window.particleColor || '#ffd700',
            transparent: true,
            opacity: 0.5
        });

        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);

        camera.position.z = 5;

        const animate = () => {
            requestAnimationFrame(animate);
            particlesMesh.rotation.y += 0.001;
            particlesMesh.rotation.x += 0.0005;
            renderer.render(scene, camera);
        };

        animate();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    };

    initThree();

    // --- Navbar Scroll Effect ---
    const navbar = document.querySelector('.custom-navbar');
    const handleScroll = () => {
        if (window.scrollY > 10) {
            navbar.classList.add('navbar-scrolled');
            navbar.classList.remove('navbar-transparent', 'navbar-dark');
            // Change logo text color if needed via CSS classes
        } else {
            navbar.classList.remove('navbar-scrolled');
            navbar.classList.add('navbar-transparent');
        }
    };

    window.addEventListener('scroll', handleScroll);
    handleScroll();

    // --- Intersection Observer for Animations ---
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

    // --- Smooth Scrolling ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Close mobile menu
                const toggler = document.querySelector('.navbar-toggler');
                const collapse = document.querySelector('.navbar-collapse');
                if (collapse.classList.contains('show')) {
                    toggler.click();
                }
            }
        });
    });

    // --- Contact Form Handling ---
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = contactForm.querySelector('button');
            const originalText = btn.innerText;

            btn.disabled = true;
            btn.innerText = 'Mengirim...';

            // Simulate sending (you can connect this to submit.php later)
            setTimeout(() => {
                alert('Pesan anda telah terkirim. Terima kasih!');
                contactForm.reset();
                btn.disabled = false;
                btn.innerText = originalText;
            }, 1500);
        });
    }

    // --- Pendaftaran Form Handling ---
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileElem');
    const fileNameDisplay = document.getElementById('file-name-display');
    const regForm = document.getElementById('reg-web-form');

    if (dropArea && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('dragover'), false);
        });

        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            if (files.length > 0) {
                fileNameDisplay.innerText = `File terpilih: ${files[0].name}`;
                fileNameDisplay.classList.add('text-primary', 'fw-bold');
            }
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                fileNameDisplay.innerText = `File terpilih: ${fileInput.files[0].name}`;
                fileNameDisplay.classList.add('text-primary', 'fw-bold');
            }
        });
    }

    if (regForm) {
        regForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = regForm.querySelector('button');
            const originalText = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';

            const formData = new FormData(regForm);
            // Append a specific identifier if needed, but submit.php handles standard fields
            // reg_number is usually auto-generated on server or daftar.html, 
            // but for this simple form we'll just let submit.php handle it or generate a temp one.
            formData.append('reg_number', 'WEB-' + Date.now());

            try {
                const resp = await fetch('submit.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await resp.json();

                if (result.status === 'success') {
                    alert('Terima kasih! Pendaftaran anda telah kami terima.');
                    regForm.reset();
                    fileNameDisplay.innerText = 'Upload formulir yang sudah diisi & KTP (Maks 5MB)';
                    fileNameDisplay.classList.remove('text-primary', 'fw-bold');
                } else {
                    alert('Maaf, terjadi kesalahan: ' + result.message);
                }
            } catch (error) {
                alert('Gagal menghubungi server. Silakan coba lagi nanti.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    }
});
