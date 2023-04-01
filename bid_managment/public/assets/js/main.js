window.addEventListener("DOMContentLoaded", () => {
    document.querySelector('.link').addEventListener('click', async (e) => {
        const clientID = document.querySelector('.link').getAttribute('client_id')
        const clientSecret = document.querySelector('.link').getAttribute('client_secret')
        const response = await fetch(`/api/setCookies?client_id=${clientID}&client_secret=${clientSecret}`);
        if (!response.ok) {
            alert("Error");
        }
    })
})