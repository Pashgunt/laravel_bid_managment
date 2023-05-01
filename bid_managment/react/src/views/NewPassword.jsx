import { useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../axios-client.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import React, { useState } from "react";
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

export default function NewPasword() {
    const { token } = useParams();
    const navigate = useNavigate();
    const { recoveryToken, setRecoveryToken } = useStateContext();
    const [errors, setErrors] = useState(null);
    const [showLoader, setShowLoader] = useState(false);

    const cancelNewPassword = () => {
        setRecoveryToken(null);
        navigate('/login');
    }

    useEffect(() => {
        if (token !== recoveryToken || !recoveryToken) cancelNewPassword();

        axiosClient.get(`/recovery/${token}`)
            .then(({ data }) => {
                if (token !== data?.token?.recovery_token || !recoveryToken) {
                    cancelNewPassword();
                }
                setRecoveryToken(data?.token?.recovery_token);
            }).catch((error) => {
                cancelNewPassword();
            });
    }, []);

    const handleSubmit = (event) => {
        setShowLoader(true);
        event.preventDefault();
        const data = new FormData(event.currentTarget);
        const payload = {
            password: data.get("password"),
            re_password: data.get("re_password"),
        }
        axiosClient.post(`/recovery/new/${token}`, payload)
            .then(async ({ data }) => {
                setRecoveryToken(null);
                await new Promise(resolve => setTimeout(resolve, 1000));
                setShowLoader(false)
                navigate("/login")
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
                            Create new Password
                        </Typography>
                        {errors && <Errors errors={errors} title="При регистрации пользователя произошла ошибка" />}
                        <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 1 }}>
                            <TextField
                                margin="normal"
                                required
                                fullWidth
                                name="password"
                                label="Password"
                                type="password"
                                id="password"
                                autoComplete="current-password"
                                error={errors && Object.keys(errors)?.includes('password')}
                                helperText={errors && Object.keys(errors)?.includes('password') ? "Incorrect entity" : ''}
                            />
                            <TextField
                                margin="normal"
                                required
                                fullWidth
                                name="re_password"
                                label="Confirm password"
                                type="password"
                                id="re_password"
                                autoComplete="current-password"
                                error={errors && Object.keys(errors)?.includes('re_password')}
                                helperText={errors && Object.keys(errors)?.includes('re_password') ? "Incorrect entity" : ''}
                            />
                            <Button
                                type="submit"
                                fullWidth
                                variant="contained"
                                sx={{ mt: 3, mb: 2 }}
                            >
                                Change password
                            </Button>
                            <Copyright sx={{ mt: 5 }} />
                        </Box>
                    </Box>
                </Grid>
            </Grid>
        </ThemeProvider >
    </>);
}