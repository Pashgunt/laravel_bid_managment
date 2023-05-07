import { createBrowserRouter } from "react-router-dom";
import Login from "./views/Login.jsx";
import Signup from "./views/Signup.jsx";
import Main from "./views/Main.jsx";
import DefaultLayout from "./components/DefaultLayout.jsx";
import GuestLayout from "./components/GuestLayout.jsx";
import AccountPageLayout from "./components/AccountPageLayout.jsx";
import AccountPage from "./views/AccountPage/AccountPage.jsx";
import CampaignsPage from "./views/AccountPage/CampaignsPage.jsx";
import AdGroupsPage from "./views/AccountPage/AdGroupsPage.jsx";
import KeywordsPage from "./views/AccountPage/KeywordsPage.jsx";
import ForgotPassword from "./views/ForgotPassword.jsx";
import NewPasword from "./views/NewPassword.jsx";
import Verify from "./views/Verify.jsx";
import AdditionaLayout from "./components/AdditionalLayout.jsx";
import QrCodeLogin from "./elements/QrCodeLogin.jsx";

const router = createBrowserRouter([
    {
        path: '/',
        element: <DefaultLayout />,
        children: [
            {
                path: '/login',
                element: <Login />
            },
            {
                path: '/signup',
                element: <Signup />
            },
            {
                path: '/forgot',
                element: <ForgotPassword />
            },
            {
                path: '/recovery/:token',
                element: <NewPasword />
            }
        ]
    },
    {
        path: '/',
        element: <AdditionaLayout />,
        children: [
            {
                path: '/verify',
                element: <Verify />
            },
            {
                path: '/qrcode/:id',
                element: <QrCodeLogin />
            }
        ]
    },
    {
        path: '/',
        element: <GuestLayout />,
        children: [
            {
                path: '/main',
                element: <Main />
            },
            {
                path: '/account',
                element: <AccountPageLayout />,
                children: [
                    {
                        path: ':id',
                        element: <AccountPage />
                    },
                    {
                        path: ':id/campaigns',
                        element: <CampaignsPage />
                    },
                    {
                        path: ':id/adgroups',
                        element: <AdGroupsPage />
                    },
                    {
                        path: ':id/keywords',
                        element: <KeywordsPage />
                    },
                ]
            },
        ]
    },
]);

export default router;