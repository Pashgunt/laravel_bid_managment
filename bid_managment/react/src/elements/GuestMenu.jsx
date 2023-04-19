import Box from "@mui/material/Box";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import HomeIcon from '@mui/icons-material/Home';
import { useNavigate } from "react-router-dom";
export default function GuestMenu() {
    const navigate = useNavigate();

    return (<Box sx={{ mb: 2 }}>
        <ListItemButton onClick={() => navigate('/main')}>
            <ListItemIcon>
                <HomeIcon sx={{ color: "primary.black" }} fontSize="large" />
            </ListItemIcon>
            <ListItemText primary="Main" />
        </ListItemButton>
    </Box>);
}