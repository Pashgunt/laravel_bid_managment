import Box from "@mui/material/Box";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import HomeIcon from '@mui/icons-material/Home';
import InputIcon from '@mui/icons-material/Input';
import HowToRegIcon from '@mui/icons-material/HowToReg';
import { useNavigate } from "react-router-dom";
export default function DefaultMenu() {

    const navigate = useNavigate();

    return (<Box sx={{ mb: 2 }}>
        <ListItemButton onClick={() => navigate('/')}>
            <ListItemIcon>
                <HomeIcon sx={{ color: "primary.black" }} fontSize="large" />
            </ListItemIcon>
            <ListItemText primary="Main" />
        </ListItemButton>
        <ListItemButton onClick={() => navigate('/signup')}>
            <ListItemIcon>
                <HowToRegIcon sx={{ color: "primary.black" }} fontSize='large' />
            </ListItemIcon>
            <ListItemText primary="SignUp" />
        </ListItemButton>
        <ListItemButton onClick={() => navigate('/login')}>
            <ListItemIcon>
                <InputIcon sx={{ color: "primary.black" }} fontSize='large' />
            </ListItemIcon>
            <ListItemText primary="Login" />
        </ListItemButton>
    </Box>);
}