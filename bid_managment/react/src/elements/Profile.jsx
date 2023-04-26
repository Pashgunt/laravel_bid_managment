import { useStateContext } from "../contexts/ContextProvider.jsx";
import Card from '@mui/material/Card';
import { Avatar, Grid, IconButton, Skeleton, Typography } from "@mui/material";
import ExitToAppIcon from '@mui/icons-material/ExitToApp';
import axiosClient from "../axios-client.js";

export default function Profile() {
    const { user, setUser, setToken } = useStateContext()

    const handleLogout = () => {
        axiosClient.post('/logout')
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
        position: 'absolute',
        top: 20,
        right: 20
    }}>
        <Grid container spacing={2} p={2} justifyContent={"space-between"} alignItems="center">
            <Grid item sx={8}>
                <Grid container spacing={2}>
                    <Grid item>
                        {user?.name ? <Avatar>H</Avatar> : <Skeleton variant="circular" width={40} height={40} />}
                    </Grid>
                    <Grid item>
                        {user?.name ? <Typography component={"h1"}>
                            {user?.name}
                        </Typography> : <Skeleton variant="text" sx={{ fontSize: '1.5rem' }} width={150} />}
                        {user?.email ? <Typography variant="caption" display="block" gutterBottom>
                            {user?.email}
                        </Typography> : <Skeleton variant="text" sx={{ fontSize: '1rem' }} width={100} />}
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