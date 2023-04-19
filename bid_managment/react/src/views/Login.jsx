import React, { useEffect, useState } from "react";
import axiosClient from "../axios-client.js";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import Link from '@mui/material/Link';
import Typography from '@mui/material/Typography';
import Paper from '@mui/material/Paper';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import Copyright from "../elements/Copyright.jsx";
import { Alert, Snackbar } from "@mui/material";
import Errors from "../elements/Errors.jsx";
import Spinner from "../elements/Spinner.jsx";

export default function Login() {
    const [showSnackbar, setShowSnackbar] = useState(false);
    const [errors, setErrors] = useState(null);
    const [showLoader, setShowLoader] = useState(false);
    const { user, setUser, setToken } = useStateContext();

    useEffect(() => {
        if (user) setShowSnackbar(true);
    }, []);

    const handleSubmit = (event) => {
        setShowLoader(true);
        event.preventDefault();
        const data = new FormData(event.currentTarget);
        const payload = {
            email: data.get("email"),
            password: data.get("password"),
        }
        axiosClient.post('/login', payload)
            .then(async ({ data }) => {
                setUser(data?.user);
                setToken(data?.token);
                setShowLoader(false)
            })
            .catch((error) => {
                setShowLoader(false);
                setErrors(error?.data?.errors)
            })
    }

    const theme = createTheme();

    return (<>
        <ThemeProvider theme={theme}>
            <Grid container component="main" sx={{ height: '100vh' }}>
                <Snackbar
                    autoHideDuration={4000}
                    anchorOrigin={{
                        vertical: 'top',
                        horizontal: 'right',
                    }}
                    open={showSnackbar}
                    onClose={() => setShowSnackbar(false)}
                    key={'top' + 'right'}
                >
                    <Alert onClose={() => setShowSnackbar(false)} severity="success" sx={{ width: '100%' }}>
                        <Typography component="h1">
                            You are success registered on our service! Please Login
                        </Typography>
                    </Alert>
                </Snackbar>
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
                            Sign in
                        </Typography>
                        {errors && <Errors errors={errors} title="При авторизации пользователя произошла ошибка" />}
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
                                defaultValue={user?.email ?? ''}
                                error={errors && Object.keys(errors)?.includes('email')}
                                helperText={errors && Object.keys(errors)?.includes('email') ? "Incorrect entity" : ''}
                            />
                            <TextField
                                margin="normal"
                                required
                                fullWidth
                                name="password"
                                label="Password"
                                type="password"
                                id="password"
                                autoComplete="current-password"
                                error={errors && Object.keys(errors)?.includes('email')}
                                helperText={errors && Object.keys(errors)?.includes('email') ? "Incorrect entity" : ''}
                            />
                            <FormControlLabel
                                control={<Checkbox value="remember" color="primary" />}
                                label="Remember me"
                            />
                            <Button
                                type="submit"
                                fullWidth
                                variant="contained"
                                sx={{ mt: 3, mb: 2 }}
                            >
                                Sign In
                            </Button>
                            <Grid container>
                                <Grid item xs>
                                    <Link href="#" variant="body2">
                                        Forgot password?
                                    </Link>
                                </Grid>
                                <Grid item>
                                    <Link href="/signup" variant="body2">
                                        {"Don't have an account? Sign Up"}
                                    </Link>
                                </Grid>
                            </Grid>
                            <Copyright sx={{ mt: 5 }} />
                        </Box>
                    </Box>
                </Grid>
            </Grid>
        </ThemeProvider>
    </>);
}