// Animasi Welcome Overview
function showOverview() {
    let homeContainer = document.getElementById("home-container");
    let overview = document.getElementById("overview");

    homeContainer.classList.add("hidden");

    setTimeout(() => {
        overview.classList.add("show");
    }, 500);
}

// Navbar Scroll Effect
let lastScrollY = 0;
let scrollTimeout;

function updateNavbar() {
    let navbar = document.querySelector(".nav");
    let scrollY = window.scrollY;

    if (scrollY > 50) {
        navbar.classList.add("scroll");
        navbar.classList.remove("default");
    } else {
        navbar.classList.remove("scroll");
        navbar.classList.add("default");
    }

    clearTimeout(scrollTimeout);

    scrollTimeout = setTimeout(() => {
        navbar.classList.remove("scroll");
        navbar.classList.add("default"); 
    }, 1000); 
}

window.addEventListener("scroll", updateNavbar);

// Skill Bar Animation
document.addEventListener("DOMContentLoaded", function () {
    let skills = document.querySelectorAll(".skill-fill");

    let observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let percent = entry.target.getAttribute("data-percent");
                entry.target.style.width = percent + "%";
            }
        });
    }, { threshold: 0.5 });

    skills.forEach(skill => {
        observer.observe(skill);
    });
});

//send_email
document.getElementById("contactForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Mencegah halaman reload
  
    let formData = new FormData(this);
  
    fetch("http://localhost/UTS/src/send_email.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        let formMessage = document.getElementById("formMessage");
        formMessage.textContent = data.message;
        formMessage.style.color = (data.status === "success") ? "green" : "red";
  
        if (data.status === "success") {
            document.getElementById("contactForm").reset();
        }
    })
    .catch(error => {
        console.error("Error:", error);
        document.getElementById("formMessage").textContent = "Terjadi kesalahan, coba lagi nanti.";
        document.getElementById("formMessage").style.color = "red";
    });
  });
  