document.addEventListener('DOMContentLoaded', function () {
    console.log("Form submitted", this);
    let questionIndex = 0;

    // Function to add a new question
    function addQuestion() {
        const container = document.getElementById('questions-container');
        const questionDiv = document.createElement('div');
        questionDiv.classList.add('question');

        questionDiv.innerHTML = `
            <div class="question-wrapper mt-4">
                <label>Question Type:</label>
                <select name="questions[${questionIndex}][type]" data-question-index="${questionIndex}" class="question-type">
                    <option value="open">Open Question</option>
                    <option value="multiple_choice">Multiple Choice</option>
                </select>

                <label>Question:</label>
                <input type="text" name="questions[${questionIndex}][text]" placeholder="Enter the question">

                <div id="open-answer-container-${questionIndex}" class="open-answer-container mt-3" style="display: block;">
                    <label>Expected Answer:</label>
                    <input type="text" name="questions[${questionIndex}][answer_text]" placeholder="Answer" required>
                </div>

                <div id="answers-container-${questionIndex}" class="answers-container mt-3" style="display: none;">
                    <label>Answers:</label>
                    <button type="button" class="add-answer btn btn-secondary" data-question-index="${questionIndex}">Add Answer</button>
                    <div class="answers"></div>
                </div>

                <button type="button" class="remove-question btn btn-danger mt-3">Remove Question</button>
            </div>
        `;

        container.appendChild(questionDiv);
        questionIndex++;
    }

    // Function to toggle between open question or multiple choice
    function toggleAnswers(event) {
        const questionIndex = event.target.getAttribute('data-question-index');
        const type = event.target.value;

        const openAnswerContainer = document.getElementById(`open-answer-container-${questionIndex}`);
        const multipleChoiceContainer = document.getElementById(`answers-container-${questionIndex}`);

        if (type === 'multiple_choice') {
            openAnswerContainer.style.display = 'none';  // Hide the open answer textarea
            multipleChoiceContainer.style.display = 'block';  // Show the "Add Answer" button for multiple choice
        } else {
            openAnswerContainer.style.display = 'block';  // Show the open answer textarea
            multipleChoiceContainer.style.display = 'none';  // Hide the multiple choice options
        }
    }

    // Function to add an answer for multiple-choice questions
    function addAnswer(questionIndex) {
        const answersContainer = document.querySelector(`#answers-container-${questionIndex} .answers`);

        const answerDiv = document.createElement('div');
        answerDiv.classList.add('answer');

        answerDiv.innerHTML = `
            <input type="text" name="questions[${questionIndex}][answers][][text]" placeholder="Answer">
            <label>Correct Answer</label>
            <input type="checkbox" name="questions[${questionIndex}][answers][][is_correct]">
            <button type="button" class="remove-answer btn btn-danger mt-3">Remove Answer</button>
        `;

        answersContainer.appendChild(answerDiv);
    }

    // Function to remove a question
    function removeQuestion(element) {
        element.closest('.question').remove();
    }

    // Function to remove an answer
    function removeAnswer(element) {
        element.closest('.answer').remove();
    }

    // Function to validate the form before submission
    function validateForm(event) {
        const questions = document.querySelectorAll('.question-container');
        let allAnswered = true;

        questions.forEach(question => {
            const questionType = question.querySelector('.question-type').value;
            let answered = false;

            if (questionType === 'open') {
                const openAnswer = question.querySelector('textarea[name^="questions"]');
                if (openAnswer && openAnswer.value.trim() !== '') {
                    answered = true;
                }
            } else {
                const selectedAnswer = question.querySelector('input[type="radio"]:checked');
                if (selectedAnswer) {
                    answered = true;
                }
            }

            if (!answered) {
                allAnswered = false;
                question.classList.add('border-danger'); // Add red border to indicate the question is unanswered
            } else {
                question.classList.remove('border-danger'); // Remove red border if answered
            }
        });

        if (!allAnswered) {
            event.preventDefault(); // Prevent form submission
            alert('Please answer all questions before submitting the quiz.'); // Inform the student
        }
    }

    // Event listener for adding questions
    document.querySelector('body').addEventListener('click', function (event) {
        if (event.target.matches('.add-question')) {
            addQuestion();
        }

        // Event listener for adding answers to multiple-choice questions
        if (event.target.matches('.add-answer')) {
            const questionIndex = event.target.getAttribute('data-question-index');
            addAnswer(questionIndex);
        }

        // Event listener for removing questions
        if (event.target.matches('.remove-question')) {
            removeQuestion(event.target);
        }

        // Event listener for removing answers
        if (event.target.matches('.remove-answer')) {
            removeAnswer(event.target);
        }
    });

    // Event listener for switching between question types (open or multiple choice)
    document.getElementById('questions-container').addEventListener('change', function (event) {
        if (event.target.matches('.question-type')) {
            toggleAnswers(event);
        }
    });

    // Add the event listener for form validation on submit
    const quizForm = document.getElementById('quizForm');
    if (quizForm) {
        quizForm.addEventListener('submit', validateForm);
    }
});
