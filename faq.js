document.addEventListener("DOMContentLoaded", function() {
    fetch("faq.php")
    .then(response => response.json())
    .then(data => {
        const faqList = document.getElementById("faq-list");
        data.forEach(faq => {
            const faqItem = document.createElement("div");
            faqItem.classList.add("faq-item");

            const question = document.createElement("div");
            question.classList.add("faq-question");
            question.textContent = faq.question;

            const answer = document.createElement("div");
            answer.classList.add("faq-answer");
            answer.textContent = faq.answer;

            question.addEventListener("click", () => {
                answer.style.display = answer.style.display === "block" ? "none" : "block";
            });

            faqItem.appendChild(question);
            faqItem.appendChild(answer);
            faqList.appendChild(faqItem);
        });
    });
});
