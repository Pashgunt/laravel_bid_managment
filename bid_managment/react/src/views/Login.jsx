import React, { useEffect, useRef } from "react";
import axiosClient from "../axios-client.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
export default function Login() {
    const emailRef = useRef();
    const passwordRef = useRef();

    const { user } = useStateContext();
    console.log(user);
    const onSubmit = (e) => {
        e.preventDefault();
        const payload = {
            email: emailRef.current.value,
            password: passwordRef.current.value
        }
        axiosClient.post('/login', payload)
            .then(({ data }) => {
                console.log(data);
            })
            .catch(({ error }) => {
                console.log(error);
            })
    }

    return (<>
        <form onSubmit={onSubmit}>
            <label htmlFor="email">Email</label>
            <input ref={emailRef} type="text" id="email" name="email" required placeholder="email" />
            <label htmlFor="password">Password</label>
            <input ref={passwordRef} type="text" id="password" name="password" required placeholder="password" />
            <button>Send</button>
        </form>
    </>);
}