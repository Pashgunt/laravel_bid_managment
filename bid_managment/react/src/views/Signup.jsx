import React, { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
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
import { IconButton, Skeleton } from "@mui/material";
import RefreshIcon from '@mui/icons-material/Refresh';

export default function Signup() {
    const [errors, setErrors] = useState(null);
    const navigate = useNavigate();
    const { setUser } = useStateContext();
    const [showLoader, setShowLoader] = useState(false);
    const [captcha, setCaptcha] = useState(null);

    const getCaptcha = function () {
        axiosClient.get('/captcha')
            .then(({ data }) => {
                setCaptcha(data.captcha);
            });
    }

    useEffect(() => {
        getCaptcha();
    }, [])

    const handleSubmit = (event) => {
        setShowLoader(true);
        event.preventDefault();
        const data = new FormData(event.currentTarget);
        const payload = {
            name: data.get("name"),
            email: data.get("email"),
            password: data.get("password"),
            re_password: data.get("re_password"),
            captcha: data.get("captcha"),
        }
        axiosClient.post('/signup', payload)
            .then(async ({ data }) => {
                setUser(data.user);
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
                            Sign up
                        </Typography>
                        {errors && <Errors errors={errors} title="При регистрации пользователя произошла ошибка" />}
                        <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 1 }}>
                            <TextField
                                margin="normal"
                                required
                                fullWidth
                                id="name"
                                label="Name"
                                name="name"
                                autoComplete="name"
                                autoFocus
                                error={errors && Object.keys(errors)?.includes('name')}
                                helperText={errors && Object.keys(errors)?.includes('name') ? "Incorrect entity" : ''}
                            />
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
                            <Grid container spacing={1}>
                                <Grid item xs={12} md={6}>
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
                                </Grid>
                                <Grid item xs={12} md={6}>
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
                                </Grid>
                            </Grid>
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
                                Sign up
                            </Button>
                            <Copyright sx={{ mt: 5 }} />
                        </Box>
                    </Box>
                </Grid>
            </Grid>
        </ThemeProvider>
    </>);
}