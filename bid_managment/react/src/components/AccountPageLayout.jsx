import { useEffect, useState } from "react";
import { Outlet, useNavigate, useParams } from "react-router-dom";
import axiosClient from "../axios-client";
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';
import Box from '@mui/material/Box';
import { Button, FormHelperText, Grid } from "@mui/material";
import Divider from "@mui/material/Divider";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemText from "@mui/material/ListItemText";

export default function AccountPageLayout() {
    const { id } = useParams();
    const [accounts, setAccounts] = useState({});
    const [chooseAccount, setChooseAccount] = useState('');
    const [categoryOfCompany, setCategoryOfCompany] = useState(`${id}`);
    const navigate = useNavigate();

    const categories = [
        {
            type: `${id}`,
            text: 'Общая статистика',
        },
        {
            type: `${id}/campaigns`,
            text: 'Кампании',
        },
        {
            type: `${id}/adgroups`,
            text: 'Группы объявлений',
        },
        {
            type: `${id}/keywords`,
            text: 'Ключевые слова',
        },
        {
            type: `${id}/`,
            text: 'Ставки',
        },
    ]

    useEffect(() => {
        axiosClient.get('/account/list').then(({ data }) => {
            const { accounts } = data;
            setAccounts(accounts);
            setChooseAccount(id);
        }).catch((error) => { })
    }, [id]);

    return (<>
        <Box sx={{
            mt: 5,
            px: 2
        }}>
            <Grid container gap={3}>
                <Grid item xs={2}>
                    <Box
                        aria-label="mailbox folders"
                    >
                        <List>
                            {categories?.map(({ type, text }) => {
                                return (<ListItem key={text} disablePadding selected={categoryOfCompany === type} onClick={() => {
                                    setCategoryOfCompany(type);
                                    navigate(type)
                                }}>
                                    <ListItemButton>
                                        <ListItemText primary={text} />
                                    </ListItemButton>
                                </ListItem>);
                            })};
                        </List>
                    </Box>
                </Grid>
                <Divider orientation="vertical" flexItem />
                <Grid item xs={9}>
                    <Box alignItems={'start'} display={'flex'} gap={2}>
                        <FormControl sx={{ minWidth: 200 }} size={"small"}>
                            <InputLabel id="demo-simple-select-autowidth-label">Accounts</InputLabel>
                            <Select
                                labelId="demo-simple-select-autowidth-label"
                                id="demo-simple-select-autowidth"
                                autoWidth
                                value={chooseAccount}
                                label="Accounts"
                            >
                                <MenuItem value={""}>Choose a account</MenuItem>
                                {accounts && Object.keys(accounts)?.map(accountID => {
                                    return (
                                        <MenuItem value={accounts[accountID]['id']}>
                                            {accounts[accountID]['code']}
                                        </MenuItem>
                                    );
                                })}
                            </Select>
                            <FormHelperText>Choose another account</FormHelperText>
                        </FormControl>
                        <Button variant="contained" size="small">Обновить</Button>
                    </Box>
                    <Outlet />
                </Grid>
            </Grid>
        </Box>
    </>);
}