window.addEventListener("DOMContentLoaded", function (e) {
  const testimonialForm = document.querySelector("#itay-testimonial-form");

  testimonialForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // reset the form messages
    resetMessages();

    // collect all the data of the form
    let data = {
      name: testimonialForm.querySelector("#name").value.replaceAll(" ", ""),
      email: testimonialForm.querySelector("#email").value.replaceAll(" ", ""),
      message: testimonialForm.querySelector("#message").value,
    };
    // validate the fields
    if (!data.name) {
      testimonialForm
        .querySelector('[data-error="invalidName"]')
        .classList.add("show");
      return;
    }

    let params = new FormData(testimonialForm);

    const url = testimonialForm.dataset.url;
    console.log(url);
  });
});

function resetMessages() {
  document
    .querySelectorAll(".field-msg")
    .forEach((element) => element.classList.remove("show"));
}
