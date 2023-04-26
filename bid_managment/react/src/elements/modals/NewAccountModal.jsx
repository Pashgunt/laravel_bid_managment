import React, { useState } from "react";
import Typography from '@mui/material/Typography';
import { Box } from "@mui/system";
import { Button, Modal, TextField } from "@mui/material";
import axiosClient from "../../axios-client.js";
import Errors from "../../elements/Errors.jsx";

export default function NewAccountModal({
    openModal,
    setOpenModal
}) {
    const [errors, setErrors] = useState(null);

    const styleModal = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        width: 400,
        bgcolor: '#fff',
        border: '2px solid #000',
        boxShadow: 24,
        p: 4,
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        const data = new FormData(event.currentTarget);
        const payload = {
            client_id: data.get("client_id"),
            client_secret: data.get("client_secret"),
        }
        axiosClient.post('/account', payload)
            .then(async ({ data }) => {
                console.log(data);
            })
            .catch((error) => {
                setErrors(error?.data?.errors);
            })
    }

    return (<Modal
        open={openModal}
        onClose={() => setOpenModal(false)}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
    >
        <Box component="form" noValidate onSubmit={handleSubmit} sx={styleModal}>
            <Typography variant="h5">
                Add new account
            </Typography>
            {errors && <Errors errors={errors} title="При создании аккаунта произошла ошибка" />}
            <TextField
                margin="normal"
                required
                fullWidth
                id="client_id"
                label="Client ID"
                name="client_id"
                type="text"
                autoFocus
                error={errors && Object.keys(errors)?.includes('client_id')}
                helperText={errors && Object.keys(errors)?.includes('client_id') ? "Incorrect entity" : ''}
            />
            <TextField
                margin="normal"
                required
                fullWidth
                name="client_secret"
                label="Client Secret"
                type="text"
                id="client_secret"
                error={errors && Object.keys(errors)?.includes('client_id')}
                helperText={errors && Object.keys(errors)?.includes('client_id') ? "Incorrect entity" : ''}
            />
            <Button
                type="submit"
                fullWidth
                variant="contained"
                sx={{ mt: 3, mb: 2 }}
            >
                Add Account
            </Button>
        </Box>
    </Modal>);
}