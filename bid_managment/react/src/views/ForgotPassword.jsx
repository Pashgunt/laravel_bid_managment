import React, { useEffect, useState } from "react";
import axiosClient from "../axios-client.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import Typography from '@mui/material/Typography';
import Paper from '@mui/material/Paper';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import Copyright from "../elements/Copyright.jsx";
import Errors from "../elements/Errors.jsx";
import Spinner from "../elements/Spinner.jsx";
import { useNavigate } from "react-router-dom";
import RefreshIcon from '@mui/icons-material/Refresh';
import { IconButton, Skeleton } from "@mui/material";

export default function ForgotPassword() {
    const [errors, setErrors] = useState(null);
    const { recoveryToken, setRecoveryToken } = useStateContext();
    const [showLoader, setShowLoader] = useState(false);
    const [captcha, setCaptcha] = useState(null);
    const navigate = useNavigate();

    const getCaptcha = function () {
        axiosClient.get('/captcha')
            .then(({ data }) => {
                setCaptcha(data.captcha);
            });
    }

    useEffect(() => {
        getCaptcha();
        if (recoveryToken) {
            setRecoveryToken(null);
        }
        axiosClient.patch(`/recovery/${recoveryToken}`)
            .catch((error) => { });
    }, []);

    const handleSubmit = (event) => {
        setShowLoader(true);
        event.preventDefault();
        const data = new FormData(event.currentTarget);
        const payload = {
            email: data.get("email"),
            captcha: data.get("captcha"),
        }
        axiosClient.post('/recovery', payload)
            .then(async ({ data }) => {
                setRecoveryToken(data.recoveryToken)
                await new Promise(resolve => setTimeout(resolve, 1000));
                setShowLoader(false);
                navigate('/login');
            })
            .catch((error) => {
                setShowLoader(false)
                setErrors(error?.data?.errors)
            })
    }

    const theme = createTheme();

    return (<>
        <ThemeProvider theme={theme}>
            <Grid container component="main" sx={{ height: '100vh' }}>
                <CssBaseline />
                <Grid
                    item
                    xs={false}
                    sm={4}
                    md={7}
                    sx={{
                        backgroundImage: 'url(https://source.unsplash.com/random)',
                        backgroundRepeat: 'no-repeat',
                        backgroundColor: (t) =>
                            t.palette.mode === 'light' ? t.palette.grey[50] : t.palette.grey[900],
                        backgroundSize: 'cover',
                        backgroundPosition: 'center',
                    }}
                />
                <Grid item xs={12} sm={8} md={5} component={Paper} elevation={6} square style={{
                    position: "relative"
                }}>
                    {showLoader && <Spinner />}
                    <Box
                        sx={{
                            my: 8,
                            mx: 4,
                            display: 'flex',
                            flexDirection: 'column',
                            alignItems: 'center',
                        }}
                    >
                        <Typography component="h1" variant="h5">
                            Forgot password
                        </Typography>
                        {errors && <Errors errors={errors} title="При регистрации пользователя произошла ошибка" />}
                        <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 1 }}>
                            <TextField
                                margin="normal"
                                required
                                fullWidth
                                id="email"
                                label="Email Address"
                                name="email"
                                autoComplete="email"
                                autoFocus
                                error={errors && Object.keys(errors)?.includes('email')}
                                helperText={errors && Object.keys(errors)?.includes('email') ? "Incorrect entity" : ''}
                            />
                            <Box sx={{ mt: 2 }} display={"flex"} gap={1}>
                                {captcha ? <div dangerouslySetInnerHTML={{ __html: captcha }}></div> : <Skeleton variant="rounded" width={160} height={40} />}
                                <IconButton onClick={getCaptcha}>
                                    <RefreshIcon />
                                </IconButton>
                            </Box>
                            <TextField
                                margin="normal"
                                required
                                fullWidth
                                id="captcha"
                                label="Captcha"
                                name="captcha"
                                autoComplete="captcha"
                                autoFocus
                                error={errors && Object.keys(errors)?.includes('captcha')}
                                helperText={errors && Object.keys(errors)?.includes('captcha') ? "Incorrect entity" : ''}
                            />
                            <Button
                                type="submit"
                                fullWidth
                                variant="contained"
                                sx={{ mt: 3, mb: 2 }}
                            >
                                Get Link
                            </Button>
                            <Copyright sx={{ mt: 5 }} />
                        </Box>
                    </Box>
                </Grid>
            </Grid>
        </ThemeProvider>
    </>);
}