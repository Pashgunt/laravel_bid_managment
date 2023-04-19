import { createContext, useContext, useState } from "react";

const StateContext = createContext({
    user: null,
    token: null,
    accounts: null,
    clientID: null,
    code: null,
    setUser: () => { },
    setToken: () => { },
    setAccounts: () => { },
    setCode: () => { },
    setClientID: () => { }
});

window.getCookie = function (name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
}

export const ContextProvider = ({ children }) => {
    const [user, setUser] = useState(null);
    const [token, _setToken] = useState(localStorage.getItem('ACCESS_TOKEN'));
    const [accounts, setAccounts] = useState(null);
    const [clientID, _setClientID] = useState(getCookie('client_id'));
    const [code, _setCode] = useState(getCookie('code'));

    const setClientID = (clientID, expireTime = 600) => {
        _setClientID(clientID);
        document.cookie = `client_id=${clientID}; expires=${expireTime}`;
    }

    const setCode = (code, expireTime = 600) => {
        _setCode(code);
        document.cookie = `code=${code}; expires=${expireTime}`;
    }

    const setToken = (token) => {
        _setToken(token);
        if (token) {
            localStorage.setItem('ACCESS_TOKEN', token);
            return;
        }
        localStorage.removeItem('ACCESS_TOKEN');
    }

    return (
        <StateContext.Provider value={{
            user, token, accounts, clientID, code, setUser, setToken, setAccounts, setCode, setClientID
        }}>
            {children}
        </StateContext.Provider>
    );
}

export const useStateContext = () => useContext(StateContext);