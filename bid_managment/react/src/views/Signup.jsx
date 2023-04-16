import React, { useRef, useState } from "react";
import { useNavigate } from "react-router-dom";
import axiosClient from "../axios-client.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
export default function Signup() {
    const nameRef = useRef();
    const emailRef = useRef();
    const passwordRef = useRef();
    const confirmPasswordRef = useRef();
    const [errors, setErrors] = useState(null);
    const navigate = useNavigate();
    const { setUser } = useStateContext();

    const onSubmit = (e) => {
        e.preventDefault();
        const payload = {
            email: emailRef.current.value,
            name: nameRef.current.value,
            password: passwordRef.current.value,
            re_password: confirmPasswordRef.current.value,
        }
        axiosClient.post('/signup', payload)
            .then(({ data }) => {
                setUser(data.user);
                setShwoLoginPage(true);
                return navigate("/login")
            })
            .catch((error) => {
                setErrors(error.data.errors)
            })
    }

    return (<>
        <form onSubmit={onSubmit}>
            {errors && Object.keys(errors).map(errorKey => {
                return <div key={errorKey}>{errors[errorKey][0]}</div>
            })}
            <label htmlFor="name">
                Name
                <input type="text" placeholder="Name" name="name" id="name" ref={nameRef} />
            </label>
            <label htmlFor="email">
                Email
                <input type="text" placeholder="Email" name="email" id="email" ref={emailRef} />
            </label>
            <label htmlFor="password">
                Password
                <input type="text" placeholder="Password" name="password" id="password" ref={passwordRef} />
            </label>
            <label htmlFor="re_password">
                Re-password
                <input type="text" placeholder="Confirm password" name="re_password" id="re_password" ref={confirmPasswordRef} />
            </label>

            <button>Send</button>
        </form>
    </>);
}