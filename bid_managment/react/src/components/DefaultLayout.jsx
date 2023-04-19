import React from "react";
import { Navigate, Outlet } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import SideMenu from "../elements/SideMenu";

export default function DefaultLayout() {
    const { token } = useStateContext()

    if (token) {
        return <Navigate to={"/main"} />
    }

    return (<>
        <SideMenu position={"absolute"}/>
        <Outlet />
    </>);
}