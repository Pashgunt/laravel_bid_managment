import { useNavigate, useParams } from "react-router-dom";
import axiosClient from "../axios-client";
import { useStateContext } from "../contexts/ContextProvider";

export default function QrCodeLogin() {
    const { id } = useParams();
    const { setUser, setToken } = useStateContext();

    const navigate = useNavigate('/main');

    if (id) {
        const payload = {
            id: id
        };
        axiosClient.post('/qr_code', payload)
            .then(async ({ data }) => {
                if (Object.keys(data).includes('token')) {
                    setToken(data.token);
                }
                setUser(data.user);
                await new Promise(resolve => setTimeout(resolve, 1000));
                navigate('/main');
            })
            .catch((error) => {
                navigate('login');
            })
    }
}