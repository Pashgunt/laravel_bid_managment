import React, { Fragment, useState } from "react";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import Typography from '@mui/material/Typography';
import { Box } from "@mui/system";
import { Button, Grid, IconButton, Modal, TextField } from "@mui/material";
import AddIcon from '@mui/icons-material/Add';
import NewAccountModal from "../elements/modals/NewAccountModal.jsx";
import AccountCard from "../elements/AccountCard.jsx";

export default function Main() {
    const [openModal, setOpenModal] = useState(false)

    const { accounts } = useStateContext();

    return (<>
        <NewAccountModal openModal={openModal} setOpenModal={setOpenModal} />
        <Box sx={{
            mt: 2,
            px: 2
        }}>
            <Grid container spacing={1} alignItems={'end'} mb={2}>
                <Grid item>
                    <Typography variant="h5">
                        Все аккаунты Direct
                    </Typography>
                </Grid>
                <Grid item>
                    <IconButton onClick={() => setOpenModal(true)}>
                        <AddIcon fontSize="small" sx={{
                            color: 'primary.black'
                        }} />
                    </IconButton>
                </Grid>
            </Grid>
            {
                accounts ? <Grid container rowSpacing={4}>{accounts.map((account, index) => {
                    return <Fragment key={index}><AccountCard
                        account={account}
                    /></Fragment>;
                })}</Grid> : ''
            }
        </Box>
    </>);
}