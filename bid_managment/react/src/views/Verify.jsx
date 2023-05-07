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
import { Alert, IconButton, Skeleton, Snackbar } from "@mui/material";
import RefreshIcon from '@mui/icons-material/Refresh';

export default function Verify() {
    const theme = createTheme();
    const [errors, setErrors] = useState(null);
    const [sendSuccess, setSendSuccess] = useState(false);
    const [showLoader, setShowLoader] = useState(false);
    const navigate = useNavigate();

    const handleSubmit = (event) => {
        setShowLoader(true);
        event.preventDefault();
        const data = new FormData(event.currentTarget);
        const payload = {
            two_factor_code: data.get("two_factor_code"),
        }
        axiosClient.post('/verify', payload)
            .then(async ({ data }) => {
                setShowLoader(false);
                navigate("/main")
            })
            .catch((error) => {
                setShowLoader(false);
                setErrors(error?.data?.errors)
            })
    }

    const getNewCode = (event) => {
        setShowLoader(true);
        event.preventDefault();
        axiosClient.get('verify/resend')
            .then(() => {
                setShowLoader(false);
                setSendSuccess(true);
            })
            .catch((error) => {
                setShowLoader(false);
                setErrors({
                    'two_factor_code': ['error']
                })
            })
    }

    return (<>
        <Snackbar
            autoHideDuration={4000}
            anchorOrigin={{
                vertical: 'top',
                horizontal: 'right',
            }}
            open={sendSuccess}
            onClose={() => setSendSuccess(false)}
            key={'top' + 'right'}
        >
            <Alert severity="success" onClick={() => setSendSuccess(false)} sx={{ width: '100%' }}>
                <Typography component="h1">
                    New code sended
                </Typography>
            </Alert>
        </Snackbar>
        <ThemeProvider theme={theme}>
            <Box
                sx={{
                    my: 8,
                    mx: 4,
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                }}
            >
                {showLoader && <Spinner />}
                <Typography component="h1" variant="h5">
                    Two factor code
                </Typography>
                <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 1 }}>
                    {errors && <Errors errors={errors} title="Некорректный код" />}
                    <TextField
                        margin="normal"
                        required
                        fullWidth
                        id="two_factor_code"
                        label="Code"
                        name="two_factor_code"
                        autoComplete="two_factor_code"
                        autoFocus
                        error={errors && Object.keys(errors)?.includes('two_factor_code')}
                        helperText={errors && Object.keys(errors)?.includes('two_factor_code') ? "Incorrect entity" : ''}
                    />
                    <Button
                        type="submit"
                        fullWidth
                        variant="contained"
                        sx={{ mt: 3, mb: 2 }}
                    >
                        Submit
                    </Button>
                    <Button
                        variant="outlined"
                        fullWidth
                        onClick={getNewCode}
                    >
                        Get new code
                    </Button>
                    <Copyright sx={{ mt: 5 }} />
                </Box>
            </Box>
        </ThemeProvider>
    </>);
}