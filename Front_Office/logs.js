function getLogs() {
    const logs = localStorage.getItem('siteLogs');
    return logs ? JSON.parse(logs) : [];
}

function saveLogs(logs) {
    localStorage.setItem('siteLogs', JSON.stringify(logs));
}

function displayLogs() {
    const logs = getLogs();
    console.log("Logs: ", logs);
}

function logRequest(pageUrl) {
    const logs = getLogs();
    const timestamp = new Date().toLocaleString();
    const logMessage = `${timestamp} - Page visited: ${pageUrl}`;
    logs.push(logMessage);
    saveLogs(logs);
}

function logError(errorMessage) {
    const logs = getLogs();
    const timestamp = new Date().toLocaleString();
    const logMessage = `${timestamp} - Error: ${errorMessage}`;
    logs.push(logMessage);
    saveLogs(logs);
}

function clearLogs() {
    localStorage.removeItem('siteLogs');
}

function detectPageVisit() {
    const currentPageUrl = window.location.pathname;
    logRequest(currentPageUrl);
}

window.onload = detectPageVisit;


let slideIndex = 0;
showSlides();

function changeSlide(n) {
    slideIndex += n;
    showSlides();
}

function showSlides() {
    const slides = document.querySelectorAll('.slide');
    if (slideIndex >= slides.length) { slideIndex = 0; }
    if (slideIndex < 0) { slideIndex = slides.length - 1; }
    
    slides.forEach((slide, index) => {
        slide.style.display = (index === slideIndex) ? 'block' : 'none';
    });
}