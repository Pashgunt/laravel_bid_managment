import React from "react";
import { Outlet } from "react-router-dom";
import SideMenu from "../elements/SideMenu";

export default function DefaultLayout() {
    return (<>
        <SideMenu />
        <Outlet />
    </>);
}