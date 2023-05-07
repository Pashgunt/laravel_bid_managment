import React, { useEffect } from "react";
import { Navigate, Outlet, useNavigate } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import SideMenu from "../elements/SideMenu.jsx";
import axiosClient from "../axios-client.js";
import Profile from "../elements/Profile.jsx";
import { Box } from "@mui/system";

export default function GuestLayout() {
    const { user, setAccounts, setUser, token } = useStateContext()
    const navigate = useNavigate();

    useEffect(() => {
        try {
            axiosClient.get('/user')
                .then(({ data }) => {
                    setUser(data?.user)
                }).catch((error) => {
                    try {
                        console.log(error);
                    } catch (e) { }
                })
            axiosClient.get('/account')
                .then(({ data }) => {
                    setAccounts(data?.accounts)
                }).catch((error) => {
                    try {
                        console.log(error);
                    } catch (e) { }
                })
            axiosClient.get('/verify/check')
                .then(() => {
                })
                .catch((error) => {
                    navigate('/verify');
                })
        } catch (e) { }
    }, []);

    if (!token) {
        return <Navigate to={"/login"} />
    }
    
    return (<>
        <Box>
            <SideMenu position={'relative'} />
            <Profile />
        </Box>
        <Outlet />
    </>);
}