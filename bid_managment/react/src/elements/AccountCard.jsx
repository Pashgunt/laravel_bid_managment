import { Box, Button, Card, Grid, IconButton, Link, Step, StepLabel, Stepper, Typography } from "@mui/material";
import { useEffect, useState } from "react";
import { useStateContext } from "../contexts/ContextProvider";
import axiosClient from "../axios-client.js";
import RefreshIcon from '@mui/icons-material/Refresh';
import CheckIcon from '@mui/icons-material/Check';
import CloseIcon from '@mui/icons-material/Close';
import DeleteOutlineIcon from '@mui/icons-material/DeleteOutline';
import CircularProgressWithLabel from "./CircularProgressWithLabel";

export default function AccountCard({ account }) {

    const [stepFaild, setStepFaild] = useState(null);
    const [activeStep, setActiveStep] = useState(1);
    const [active, setActive] = useState(!!account['selected']);
    const [showModalForDelete, setShowModalForDelete] = useState(false);
    const [showCancelDelete, setShowCancelDelete] = useState(false);
    const [progress, setProgress] = useState(10);
    const [intervalID, setIntervalID] = useState(null);

    const hrefForGetAccessToken = `https://oauth.yandex.ru/authorize?response_type=code&client_id=${account['client_id']}`;

    const { clientID, code, setClientID, setCode, user, setAccounts } = useStateContext();

    const steps = ['Isset all need params', 'Params Is Correct', 'Access token has'];

    useEffect(() => {
        setActiveStep(account['code'] && account['access_token'] ? 3 : 1);
        let params = new URLSearchParams(document.location.search),
            code = params.get("code");

        setCode(code);

        if (code && clientID) {
            const payload = {
                client_id: clientID,
                code: code
            };
            axiosClient.post('/account/get_access_token', payload)
                .then(({ data }) => {
                    setCode('', -100);
                    setClientID('', -100);
                })
                .catch((error) => {
                    setStepFaild(1);
                })
        }

    }, []);

    const handlerForSetCookies = () => {
        setClientID(account['client_id']);
    }

    const handlerCancelDelete = (event) => {
        event.preventDefault();

        const payload = {
            'account_id': account['id']
        }

        axiosClient.post(`/account/delete_cancel`, payload)
            .then(({ data }) => {
                setShowCancelDelete(false);
                clearInterval(intervalID);
                axiosClient.get('/account/list')
                    .then(({ data }) => {
                        setAccounts(data?.accounts)
                    })
            }).catch((error) => { })
    }

    const hadleActiveAccount = (event) => {
        event.preventDefault();
        const payload = {
            'account_id': account['id'],
            'user_id': user['id']
        }
        const url = active ? 'make_inactive' : 'make_active';

        axiosClient.post(`/account/${url}`, payload)
            .then(({ data }) => {
                setActive(!active);
            }).catch((error) => {
            })
    }

    const accessSoftDeleteAccount = () => {
        const payload = {
            'account_id': account['id']
        }
        axiosClient.post(`/account/delete`, payload)
            .then(({ data }) => {
                setShowModalForDelete(false);
                setShowCancelDelete(true);
                const timer = setInterval(() => {
                    setProgress((prevProgress) => {
                        if (prevProgress >= 100) {
                            clearInterval(timer);
                            setShowCancelDelete(false);
                            return 0;
                        }
                        return prevProgress + 10
                    });
                    setIntervalID(timer);
                }, 500);

            }).catch((error) => {
                setShowModalForDelete(false)
            })
    }

    const handleSoftDeleteAccount = (event) => {
        setShowModalForDelete(true);
        event.preventDefault();
    }

    return (<>
        {showCancelDelete && <Grid item><Box mb={4} display={"flex"} alignItems={"center"} gap={2}>
            <CircularProgressWithLabel value={progress} />
            <Link underline={'none'} onClick={handlerCancelDelete}>
                Отменить удаление
            </Link>
        </Box></Grid>}
        <Grid item xs={12} display={showCancelDelete && 'none'}>
            <Card>
                <Box p={2} position="relative">
                    {active && <Box position={"absolute"} bgcolor={active ? 'success.main' : 'secondary.light'} bottom={0} left={0} height={7} width={'100%'}></Box>}
                    {showModalForDelete && <Box
                        position={"absolute"}
                        bgcolor={'rgba(255,255,255,.8)'}
                        zIndex={100}
                        bottom={0}
                        left={0}
                        height={'100%'}
                        width={'100%'}
                        display={"flex"}
                        justifyContent={"center"}
                        alignItems={"center"}
                        gap={3}
                    >
                        <IconButton onClick={accessSoftDeleteAccount}>
                            <CheckIcon color="primary.black" fontSize="large" />
                        </IconButton>
                        <IconButton onClick={() => setShowModalForDelete(false)}>
                            <CloseIcon color="primary.black" fontSize="large" />
                        </IconButton>
                    </Box>}
                    <Box mb={2} display={"flex"} justifyContent={"end"} gap={2}>
                        <Link underline="none" onClick={hadleActiveAccount} color={'initial'}>
                            {!active ? <CheckIcon color="primary.black" fontSize="medium" /> : <CloseIcon color="primary.black" fontSize="medium" />}
                        </Link>
                        <Link underline="none" onClick={handleSoftDeleteAccount} color={'initial'}>
                            <DeleteOutlineIcon fontSize="medium" />
                        </Link>
                    </Box>
                    <Stepper activeStep={activeStep} >
                        {steps.map((label, index) => {
                            const labelProps = {};
                            if (stepFaild == index) {
                                labelProps.optional = (
                                    <Typography variant="caption" color="error">
                                        Client ID or Client Secret is incorrect
                                    </Typography>
                                );

                                labelProps.error = true;
                            }

                            return (
                                <Step key={label}>
                                    <StepLabel {...labelProps}>{label}</StepLabel>
                                </Step>
                            );
                        })}
                    </Stepper>
                    <Typography variant="button" display="block" gutterBottom mt={2}>
                        #AAID {account['id']}
                    </Typography>
                    <Typography variant="body1" display="block" gutterBottom>
                        Client ID <span style={{
                            color: "#666"
                        }}>{account['client_id']}</span>
                    </Typography>
                    <Typography variant="body1" display="block" gutterBottom>
                        Client secret <span style={{
                            color: "#666"
                        }}>{account['client_secret']}</span>
                    </Typography>
                    <Typography variant="body1" display="block" gutterBottom>
                        Code <span style={{
                            color: "#666"
                        }}>{account['code'] ?? 'н/д'}</span>
                    </Typography>
                    <Typography variant="body1" display="block" gutterBottom>
                        Access token <span style={{
                            color: "#666"
                        }}>{account['access_token'] ?? 'н/д'}
                            <Link underline="none" href={hrefForGetAccessToken} onClick={handlerForSetCookies}>
                                <IconButton>
                                    <RefreshIcon />
                                </IconButton>
                            </Link></span>
                    </Typography>
                </Box>
            </Card>
        </Grid>
    </>);
}