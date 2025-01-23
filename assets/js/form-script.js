const form = document.getElementById("contactForm");
const loading = document.querySelector(".loading");
const errorMessage = document.querySelector(".error-message");
const sentMessage = document.querySelector(".sent-message");

form.addEventListener("submit", async (event) => {
  event.preventDefault();
  loading.style.display = "block";
  errorMessage.textContent = "";
  sentMessage.style.display = "none";

  const formData = new FormData(form);

  try {
    const response = await fetch(form.action, {
      method: "POST",
      body: formData,
    });

    const result = await response.text();

    loading.style.display = "none";

    if (result.trim() === "OK") {
      sentMessage.style.display = "block";
      form.reset(); // Clear the form fields
    } else {
      errorMessage.textContent =
        result || "An error occurred while sending your message.";
    }
  } catch (error) {
    loading.style.display = "none";
    errorMessage.textContent = "An error occurred. Please try again later.";
  }
});
