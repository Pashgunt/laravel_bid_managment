import React, { Fragment, useState } from "react";
import { useStateContext } from "../contexts/ContextProvider.jsx";
import Typography from '@mui/material/Typography';
import { Box } from "@mui/system";
import { Button, Grid, IconButton, Modal, Skeleton, TextField } from "@mui/material";
import AddIcon from '@mui/icons-material/Add';
import NewAccountModal from "../elements/modals/NewAccountModal.jsx";
import AccountCard from "../elements/AccountCard.jsx";

export default function Main() {
    const [openModal, setOpenModal] = useState(false)

    const { accounts } = useStateContext();
    
    return (<>
        <NewAccountModal openModal={openModal} setOpenModal={setOpenModal} />
        <Box sx={{
            mt: 3,
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
                accounts ? <Grid container rowSpacing={4}>{Object.keys(accounts)?.map((accountID) => {
                    return <Fragment key={accountID}><AccountCard
                        account={accounts[accountID]}
                    /></Fragment>;
                })}</Grid> : <>
                    <Skeleton variant="rounded" width={"100%"} height={200} animation="wave" sx={{
                        mb: 3
                    }} />
                    <Skeleton variant="rounded" width={"100%"} height={200} animation="wave" sx={{
                        mb: 3
                    }} />
                    <Skeleton variant="rounded" width={"100%"} height={200} animation="wave" />
                </>
            }
        </Box>
    </>);
}