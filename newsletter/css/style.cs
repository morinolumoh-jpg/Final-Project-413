/*
Theme Name: CrimeStories Newsletter
Author: Omorinsola Olumoh
Version: 3.0
*/

*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: #c7b5b5;
    color: #1a0a0a;
    font-family: 'Times New Roman', Times, serif;
    line-height: 1.7;
}

a {
    text-decoration: none;
    color: inherit;
}

img {
    display: block;
    width: 100%;
    height: auto;
    object-fit: cover;
}

h1, h2, h3, h4 {
    margin: 0;
    font-family: 'Georgia', serif;
    line-height: 1.2;
}

p {
    margin: 0;
}

/* ------ Header -------- */

header {
    width: 100%;
    background-color: #c7a6a6;
    border-bottom: 2px solid #e6baba;
    padding: 0 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

h1.header {
    margin: 0;
    padding: 16px 0 4px;
    display: flex;
    font-size: 50px;
    font-weight: 900;
    color: #8a0309;
    text-transform: uppercase;
    font-family: 'Times New Roman', Times, serif;
    letter-spacing: -0.02em;
    line-height: 1;
}

.site-nav {
    display: flex;
    gap: 23px;
    color: #270101;
    font-size: 15px;
    font-family: monospace;
    font-weight: 600;
    padding: 8px 0 14px;
}

.site-nav a {
    color: #7e0505;
    transition: transform 0.3s ease, color 0.3s ease;
    opacity: 0.85;
}

.site-nav a:hover {
    transform: translateX(3px);
    opacity: 1;
    color: #270101;
}

/* ------ Trending Posts Section -------- */
.newsletter-trending-post-grid {
    display: flex;
    flex-direction: column;
    gap: 24px;
    padding: 24px 20px;
}

.newsletter-trending-title {
    font-family: 'Times New Roman', Times, serif;
    font-size: 38px;
    font-weight: 800;
    color: #500e0e;
    text-transform: uppercase;
    text-decoration: underline;
    text-underline-offset: 4px;
    margin: 10px 20px 0;
}

.newsletter-trending-card {
    background-color: #d4bfbf;
    border-radius: 8px;
    width: 100%;
    border: 0.5px solid #c7b5b5;
    box-shadow: 1px 1px 6px rgba(0,0,0,0.12);
    overflow: hidden;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.newsletter-trending-card:hover {
    transform: translateY(-4px);
    box-shadow: 2px 4px 14px rgba(0,0,0,0.18);
}

.newsletter-trending-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.newsletter-trending-card-post {
    padding: 14px 18px;
    color: #0e0d0d;
    line-height: 1.5;
}

.newsletter-trending-card-post-h3 {
    font-family: 'Georgia', serif;
    font-size: 26px;
    font-weight: 800;
    font-style: italic;
    color: #0e0d0d;
    letter-spacing: -0.01rem;
    margin-bottom: 6px;
}

.newsletter-trending-card-post-p {
    font-size: 12px;
    font-style: italic;
    color: #555;
    display: flex;
    gap: 12px;
    margin-bottom: 10px;
}

.newsletter-trending-card-post-excerpt {
    font-family: 'Georgia', serif;
    font-size: 15px;
    font-style: italic;
    color: #2a1a1a;
    line-height: 1.65;
    opacity: 0.9;
    margin-bottom: 14px;
}

.newsletter-trending-card-readmore {
    display: inline-block;
    padding: 9px 22px;
    border-radius: 8px;
    background-color: antiquewhite;
    color: #270101;
    font-family: monospace;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    border: 1px solid #c7a6a6;
    transition: transform 0.25s ease, background-color 0.25s ease;
    cursor: pointer;
}

.newsletter-trending-card-readmore:hover {
    transform: translateX(4px);
    background-color: #e8d5c0;
}

/*------ Post Grid-------- */

.site-post-grid {
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}

.site-post-card {
    background: #d4bfbf;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.site-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.14);
}

.site-post-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}

.site-post-card h3 {
    font-family: 'Georgia', serif;
    font-size: 16px;
    font-weight: 700;
    padding: 12px 14px 6px;
    color: #1a0808;
}

.site-post-card p {
    font-size: 13px;
    padding: 0 14px 16px;
    color: #4a3030;
    line-height: 1.55;
}

/* ------ Poll -------- */

.poll-wrapper {
    margin: 40px auto;
    max-width: 600px;
    background: #d4bfbf;
    padding: 28px;
    border-radius: 12px;
    border: 0.5px solid #c7b5b5;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.poll-wrapper.show {
    opacity: 1;
    transform: translateY(0);
}

.poll-wrapper h3 {
    font-family: 'Georgia', serif;
    font-size: 18px;
    font-style: italic;
    color: #1a0808;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #c7b5b5;
}

.poll-wrapper-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.poll-wrapper-form label {
    font-size: 14px;
    font-family: monospace;
    color: #2a1414;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid transparent;
    transition: background 0.2s ease, border-color 0.2s ease;
}

.poll-wrapper-form label:hover {
    background: rgba(200,160,160,0.3);
    border-color: #c7a6a6;
}

.poll-wrapper-form input[type="radio"] {
    accent-color: #8a0309;
    width: 15px;
    height: 15px;
}

.poll-wrapper-form button[type="submit"] {
    margin-top: 8px;
    width: fit-content;
    padding: 10px 24px;
    background: #8a0309;
    color: antiquewhite;
    border: none;
    border-radius: 6px;
    font-family: monospace;
    font-size: 12px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.25s ease, transform 0.2s ease;
}

.poll-wrapper-form button[type="submit"]:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

.poll-results {
    margin-top: 20px;
    padding-top: 14px;
    border-top: 1px solid #c7b5b5;
}

.poll-results h4 {
    font-family: 'Georgia', serif;
    font-size: 14px;
    font-style: italic;
    color: #1a0808;
    margin-bottom: 10px;
}

.poll-results p {
    background: #b89898;
    color: #1a0808;
    padding: 8px 12px;
    border-radius: 6px;
    margin: 5px 0;
    font-size: 13px;
    font-family: monospace;
}


/* ------ Email Signup Footer -------- */

.newsletter-footer {
    background: #3d1a1a;
    color: #dac9c9;
    padding: 60px 8%;
    margin-top: 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.newsletter-footer::before {
    content: 'SUBSCRIBE';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: 'Georgia', serif;
    font-size: clamp(3rem, 12vw, 8rem);
    font-weight: 900;
    color: rgba(255,255,255,0.04);
    white-space: nowrap;
    pointer-events: none;
    user-select: none;
    line-height: 1;
}

.newsletter-signup-footer-copy {
    position: relative;
    z-index: 1;
    max-width: 520px;
    margin: 0 auto 28px;
}

.newsletter-signup-footer-copy h2 {
    font-family: 'Georgia', serif;
    font-size: 26px;
    font-weight: 700;
    font-style: italic;
    color: #f0e0e0;
    margin-bottom: 10px;
}

.newsletter-signup-footer-copy p {
    font-size: 14px;
    color: #b89898;
    font-style: italic;
    opacity: 0.9;
}

.newsletter-footer-form {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    max-width: 400px;
    margin: 0 auto;
    border: 1px solid #5a2a2a;
}

.newsletter-footer-form input[type="email"] {
    flex: 1;
    padding: 12px 16px;
    background: #2a0f0f;
    border: none;
    color: #f0e0e0;
    font-family: monospace;
    font-size: 13px;
    outline: none;
}

.newsletter-footer-form input[type="email"]::placeholder {
    color: #7a5a5a;
}

.newsletter-footer-form button[type="submit"] {
    padding: 12px 20px;
    background: #8a0309;
    border: none;
    color: antiquewhite;
    font-family: monospace;
    font-size: 11px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.25s ease;
}

.newsletter-footer-form button[type="submit"]:hover {
    background: #c0392b;
}

.success {
    color: #7ec88a;
    font-family: monospace;
    font-size: 13px;
    margin-top: 14px;
    letter-spacing: 0.06em;
}

.error {
    color: #ff8a8a;
    font-family: monospace;
    font-size: 13px;
    margin-top: 14px;
    letter-spacing: 0.06em;
}
