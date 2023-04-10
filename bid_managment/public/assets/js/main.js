window.addEventListener("DOMContentLoaded", () => {

    const buttonForInnactiveAccount = document.querySelectorAll('.make_account_innactive');
    const buttonForActiveAccount = document.querySelectorAll('.make_account_active');
    const buttonForGetAccessToken = document.querySelectorAll('.get_access_token');
    const buttonForSaveActiveAccount = document.querySelector('.save_active_account');

    const makeAccountInnactive = async (elem) => {
        const accountID = elem.getAttribute('account_id');
        const userID = elem.getAttribute('user_id');
        const response = await fetch(`/api/makeInnactiveAccount`, {
            method: 'POST',
            mode: "cors",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
            },
            redirect: "follow",
            referrerPolicy: "no-referrer",
            body: JSON.stringify({
                'account_id': accountID,
                'user_id': userID
            })
        })
        if (!response.ok) {
            alert("Error");
        }
    }

    const makeAccountActive = async (elem) => {
        const accountID = elem.getAttribute('account_id');
        const userID = elem.getAttribute('user_id');
        const response = await fetch(`/api/makeActiveAccount`, {
            method: 'POST',
            mode: "cors",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
            },
            redirect: "follow",
            referrerPolicy: "no-referrer",
            body: JSON.stringify({
                'account_id': accountID,
                'user_id': userID
            })
        })
        if (!response.ok) {
            alert("Error");
        }
    }

    const saveCookiesForGetAccessToken = async (elem) => {
        const clientID = elem.getAttribute('client_id')
        const clientSecret = elem.getAttribute('client_secret')
        const response = await fetch(`/api/setCookies`, {
            method: 'POST',
            mode: "cors",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
            },
            redirect: "follow",
            referrerPolicy: "no-referrer",
            body: JSON.stringify({
                'client_id': clientID,
                'client_secret': clientSecret
            })
        });
        if (!response.ok) {
            alert("Error");
        }
    }

    buttonForGetAccessToken?.forEach(item => {
        item.addEventListener('click', async function () {
            await saveCookiesForGetAccessToken(item);
        })
    })

    buttonForInnactiveAccount?.forEach(item => {
        item.addEventListener('click', async function (e) {
            e.preventDefault();
            await makeAccountInnactive(item)
        })
    })

    buttonForActiveAccount?.forEach(item => {
        item.addEventListener('click', async function (e) {
            e.preventDefault();
            await makeAccountActive(item)
        })
    })

    buttonForSaveActiveAccount?.addEventListener('click', async function (e) {
        e.preventDefault();
        const select = document.querySelector("#direct_account");
        const option = select.querySelector(`option[value="${select.value}"]`)
        await makeAccountActive(option);
    })
})