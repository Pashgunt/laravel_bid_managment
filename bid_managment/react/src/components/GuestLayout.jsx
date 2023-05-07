import React, { useEffect } from "react";
import { Navigate, Outlet, useNavigate } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import SideMenu from "../elements/SideMenu.jsx";
import axiosClient from "../axios-client.js";
import Profile from "../elements/Profile.jsx";
import { Box } from "@mui/system";
import QRCode from "react-qr-code";

export default function GuestLayout() {
    const { user, setAccounts, setUser, token } = useStateContext()
    const navigate = useNavigate();

    if (!token) {
        return <Navigate to={"/login"} />
    } else {
        axiosClient.get('/verify/check')
            .then(() => {
            })
            .catch((error) => {
                alert("Hi");
                navigate('/verify');
            })
    }


    useEffect(() => {
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
    }, []);

    return (<>
        <Box style={{ height: "auto", margin: "0 auto", maxWidth: 64, width: "100%" }}>
            <QRCode
                size={256}
                style={{ height: "auto", maxWidth: "100%", width: "100%" }}
                value={`http://localhost:3000/qrcode/${user?.id}`}
                viewBox={`0 0 256 256`}
            />
        </Box>
        <Box>
            <SideMenu position={'relative'} />
            <Profile />
        </Box>
        <Outlet />
    </>);
}