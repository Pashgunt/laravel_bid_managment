import { useStateContext } from "../contexts/ContextProvider.jsx";
import Card from '@mui/material/Card';
import { Avatar, Grid, IconButton, Typography } from "@mui/material";
import ExitToAppIcon from '@mui/icons-material/ExitToApp';
import axiosClient from "../axios-client.js";

export default function Profile() {
    const { user, setUser, setToken } = useStateContext()

    const handleLogout = () => {
        axiosClient.post('/user/logout')
            .then(({ data }) => {
                setUser(null)
                setToken(null)
            })
            .catch((error) => {
                try {
                    console.log(error);
                } catch (error) {
                }
            })
    }

    return (<Card sx={{
        maxWidth: '50%',
        minWidth: '200px',
        position: 'absolute',
        top: 20,
        right: 20
    }}>
        <Grid container spacing={2} p={2} justifyContent={"space-between"} alignItems="center">
            <Grid item sx={8}>
                <Grid container spacing={2}>
                    <Grid item>
                        <Avatar>H</Avatar>
                    </Grid>
                    <Grid item xs={{
                        display:"none"
                    }}>
                        <Typography component={"h1"}>
                            {user?.name}
                        </Typography>
                        <Typography variant="caption" display="block" gutterBottom>
                            {user?.email}
                        </Typography>
                    </Grid>
                </Grid>
            </Grid>
            <Grid item sx={4}>
                <IconButton onClick={handleLogout}>
                    <ExitToAppIcon fontSize="medium" color="primary.black" />
                </IconButton>
            </Grid>
        </Grid>
    </Card>);
}