document.addEventListener("DOMContentLoaded", function () {
    const poll = document.querySelector(".poll-wrapper");
    if (!poll) return;

    poll.style.opacity = "0";
    poll.style.maxHeight = "0";
    poll.style.overflow = "hidden";
    poll.style.transition = "opacity 0.4s ease, max-height 0.5s ease";

    const trigger = document.createElement("div");
    trigger.className = "poll-scroll-trigger";
    trigger.style.width = "1px";
    trigger.style.height = "1px";
    trigger.style.opacity = "0";
    if (poll.parentNode) {
        poll.parentNode.insertBefore(trigger, poll.nextSibling);
    } else {
        document.body.appendChild(trigger);
    }

    const revealPoll = function () {
        if (poll.style.opacity === "1") {
            return;
        }
        poll.style.display = "block";
        poll.style.opacity = "1";
        poll.style.maxHeight = "2000px";
        poll.style.overflow = "visible";
    };

    const showPollOnScroll = function () {
        if (window.innerHeight + window.scrollY >= document.body.scrollHeight - 120) {
            revealPoll();
            window.removeEventListener('scroll', showPollOnScroll);
        }
    };

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        revealPoll();
                    }
                });
            },
            {
                rootMargin: '0px 0px -120px 0px',
                threshold: 0.1,
            }
        );
        observer.observe(trigger);
    } else {
        window.addEventListener('scroll', showPollOnScroll, { passive: true });
    }

    setTimeout(function () {
        if (poll.style.opacity === "0") {
            revealPoll();
        }
    }, 5000);

    const pollForm = poll.querySelector(".poll-form");
    if (pollForm) {
        pollForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const selectedVote = pollForm.querySelector('input[name="vote"]:checked');
            if (!selectedVote) {
                alert("Please select an option");
                return;
            }
            const voteValue = selectedVote.value;
            const pollVotes = JSON.parse(localStorage.getItem('pollVotes') || '{}');
            pollVotes[voteValue] = (pollVotes[voteValue] || 0) + 1;
            localStorage.setItem('pollVotes', JSON.stringify(pollVotes));

            const resultsDiv = poll.querySelector(".poll-results");
            const total = Object.values(pollVotes).reduce((a, b) => a + b, 0);
            let resultsHTML = "<strong>Poll Results:</strong><br>";
            for (const [vote, count] of Object.entries(pollVotes)) {
                const percentage = ((count / total) * 100).toFixed(1);
                resultsHTML += `${vote.charAt(0).toUpperCase() + vote.slice(1)}: ${count} votes (${percentage}%)<br>`;
            }
            resultsDiv.innerHTML = resultsHTML;
            pollForm.style.opacity = "0.6";
            pollForm.style.pointerEvents = "none";
        });
    }

    const pollVotes = JSON.parse(localStorage.getItem('pollVotes') || '{}');
    if (Object.keys(pollVotes).length > 0) {
        const resultsDiv = poll.querySelector(".poll-results");
        const total = Object.values(pollVotes).reduce((a, b) => a + b, 0);
        let resultsHTML = "<strong>Poll Results:</strong><br>";
        for (const [vote, count] of Object.entries(pollVotes)) {
            const percentage = ((count / total) * 100).toFixed(1);
            resultsHTML += `${vote.charAt(0).toUpperCase() + vote.slice(1)}: ${count} votes (${percentage}%)<br>`;
        }
        resultsDiv.innerHTML = resultsHTML;
    }
});
