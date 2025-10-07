// Get the menu button, navigation links, and the icon inside the menu button
const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

// Add a click event listener to the menu button
menuBtn.addEventListener("click", (e) => {
  // Toggle the 'open' class on the navigation links
  navLinks.classList.toggle("open");

  // Check if the navigation links are open and update the menu button icon accordingly
  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

// Add a click event listener to the navigation links
navLinks.addEventListener("click", (e) => {
  // Remove the 'open' class from the navigation links when a link is clicked
  navLinks.classList.remove("open");
  // Reset the menu button icon to the menu icon
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

// Define options for ScrollReveal animations
const scrollRevealOption = {
  distance: "50px", // Distance the element will move
  origin: "bottom", // Direction from which the element will appear
  duration: 1000, // Duration of the animation in milliseconds
};

// Reveal the section header in the about container with ScrollReveal
ScrollReveal().reveal(".about__container .section__header", {
  ...scrollRevealOption, // Spread the options defined above
});

// Reveal the section description in the about container with a delay
ScrollReveal().reveal(".about__container .section__description", {
  ...scrollRevealOption,
  delay: 500, // Delay before the animation starts
  interval: 500, // Interval between animations for multiple elements
});

// Reveal the image in the about container with a longer delay
ScrollReveal().reveal(".about__container img", {
  ...scrollRevealOption,
  delay: 1500, // Longer delay for the image
});

// Reveal the section header in the service container
ScrollReveal().reveal(".service__container .section__header", {
  ...scrollRevealOption,
});

// Reveal the section description in the service container with a delay
ScrollReveal().reveal(".service__container .section__description", {
  ...scrollRevealOption,
  delay: 500, // Delay before the animation starts
});

// Reveal each service card with a delay and interval
ScrollReveal().reveal(".service__card", {
  duration: 1000, // Duration of the animation
  delay: 1000, // Delay before the animation starts
  interval: 500, // Interval between animations for multiple elements
});

// Initialize Swiper for the testimonials slider
const swiper = new Swiper(".swiper", {
  loop: true, // Enable looping of slides
  pagination: {
    el: ".swiper-pagination", // Selector for pagination element
  },
});

// Reveal the section header in the blog content
ScrollReveal().reveal(".blog__content .section__header", {
  ...scrollRevealOption,
});

// Reveal the blog content header with a delay
ScrollReveal().reveal(".blog__content h4", {
  ...scrollRevealOption,
  delay: 500, // Delay before the animation starts
});

// Reveal the blog content paragraph with a delay
ScrollReveal().reveal(".blog__content p", {
  ...scrollRevealOption,
  delay: 1000, // Delay before the animation starts
});

// Reveal the blog button with a delay
ScrollReveal().reveal(".blog__content .blog__btn", {
  ...scrollRevealOption,
  delay: 1500, // Delay before the animation starts
});

// Select the Instagram flex container
const instagram = document.querySelector(".instagram__flex");

// Duplicate each child element in the Instagram flex container
Array.from(instagram.children).forEach((item) => {
  const duplicateNode = item.cloneNode(true); // Clone the item
  duplicateNode.setAttribute("aria-hidden", true); // Set aria-hidden attribute for accessibility
  instagram.appendChild(duplicateNode); // Append the duplicate to the Instagram flex container
});




        