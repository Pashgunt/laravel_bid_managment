import { CircularProgress } from "@mui/material";
import { Box } from "@mui/system";

export default function Spinner() {
    return (<Box sx={{
        width: "100%",
        height: "100vh",
        background: "rgba(0,0,0,.75)",
        position: "absolute",
        top: 0,
        left: 0,
        zIndex: 2,
        display: "flex",
        justifyContent: "center",
        alignItems: "center"
    }}>
        <CircularProgress size={75} />
    </Box>);
}