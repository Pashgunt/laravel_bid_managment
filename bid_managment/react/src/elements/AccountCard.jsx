import { Box, Button, Card, Grid, Link, Step, StepLabel, Stepper, Typography } from "@mui/material";
import { useEffect, useState } from "react";
import { useStateContext } from "../contexts/ContextProvider";
import axiosClient from "../axios-client.js";

export default function AccountCard({ account }) {

    const [stepFaild, setStepFaild] = useState(null);
    const [activeStep, setActiveStep] = useState(1);

    const hrefForGetAccessToken = `https://oauth.yandex.ru/authorize?response_type=code&client_id=${account['client_id']}`;

    const { clientID, code, setClientID, setCode } = useStateContext();

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

    return (<Grid item>
        <Card>
            <Box p={2}>
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
                    }}>{account['access_token'] ?? 'н/д'}</span>
                </Typography>
                <Box mt={2}>
                    <Button size="small" variant="outlined" color="primary" style={{
                        marginRight: '10px'
                    }}>
                        Active
                    </Button>
                    <Link underline="none" href={hrefForGetAccessToken} onClick={handlerForSetCookies}>
                        Get access token
                    </Link>
                </Box>
            </Box>
        </Card>
    </Grid>);
}