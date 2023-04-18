import { Alert, AlertTitle } from "@mui/material";
import { Box } from "@mui/system";
import { Div } from "@vkontakte/vkui";

export default function Errors({ errors, title }) {
    return (<Box sx={{ mt: 2 }}>
        <Alert severity="error">
            <AlertTitle>{title}</AlertTitle>
            {
                Object.values(errors)?.map((error, index) => {
                    return (
                        <Div key={index}>
                            {error?.at(0)}
                        </Div>
                    );
                })
            }
        </Alert>
    </Box>);
}