import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../axios-client";
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';
import Box from '@mui/material/Box';
import { Button, FormHelperText, Grid, ListSubheader } from "@mui/material";
import Divider from "@mui/material/Divider";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemText from "@mui/material/ListItemText";
import ExpandLessIcon from '@mui/icons-material/ExpandLess';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';

export default function AccountPage() {
    const { id } = useParams();
    const [accounts, setAccounts] = useState(null);
    const [compaigns, setCompaigns] = useState(null);
    const [chooseAccount, setChooseAccount] = useState('');
    const [openCampaign, setOpenCampaign] = useState(null);
    const [openAdGroups, setOpenAdGroups] = useState(null);
    const [categoryOfCompany, setCategoryOfCompany] = useState('all');

    const categories = [
        {
            type: 'all',
            text: 'Общая статистика',
        },
        {
            type: 'Campaigns',
            text: 'Кампании',
        },
        {
            type: 'adGroups',
            text: 'Группы объявлений',
        },
        {
            type: 'Keywords',
            text: 'Ключевые слова',
        },
        {
            type: 'KeywordBids',
            text: 'Ставки',
        },
    ]

    useEffect(() => {
        let payload = {};
        if (id) {
            payload = {
                id: id
            }
        }
        axiosClient.post('/account/information', payload)
            .then(({ data }) => {
                const { accounts, compaigns } = data;
                setAccounts(accounts);
                setCompaigns(compaigns);
                if (id) {
                    setChooseAccount(id);
                } else {
                    setChooseAccount(Object.keys(accounts)?.filter(accountID => {
                        return accounts[accountID]["selected"] == "selected";
                    })?.at(0))
                }
            }).catch((error) => {
            })
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
                                return (<ListItem key={text} disablePadding selected={categoryOfCompany === type} onClick={() => setCategoryOfCompany(type)}>
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
                    <Box mt={2}>
                        <List
                            width={"100%"}
                            component="nav"
                            aria-labelledby="nested-list-subheader"
                            subheader={
                                <ListSubheader component="div" id="nested-list-subheader">
                                    Древовидная структура всех показателей кампании
                                </ListSubheader>
                            }
                        >
                            {compaigns && Object.values(compaigns.result)?.map(campaign => {
                                return (<>
                                    <ListItem button onClick={() => (openCampaign && openCampaign === campaign.Id) ? setOpenCampaign(null) : setOpenCampaign(campaign.Id)}>
                                        <ListItemText primary={campaign.Name} />
                                        {openCampaign === campaign.Id ? <ExpandLessIcon /> : <ExpandMoreIcon />}
                                    </ListItem>
                                    <List style={{
                                        display: openCampaign === campaign.Id ? 'block' : 'none',
                                        marginLeft: "15px"
                                    }}>
                                        {Object.values(campaign.adGroups)?.map(adGroup => {
                                            return (<>
                                                <ListItem button onClick={() => (openAdGroups && openAdGroups === adGroup.Id) ? setOpenAdGroups(null) : setOpenAdGroups(adGroup.Id)}>
                                                    <ListItemText primary={adGroup.Name} />
                                                    {openAdGroups === adGroup.Id ? <ExpandLessIcon /> : <ExpandMoreIcon />}
                                                </ListItem>
                                                <List style={{
                                                    display: openAdGroups === adGroup.Id ? 'block' : 'none',
                                                    marginLeft: "30px"
                                                }}>
                                                    {Object.values(adGroup.keywords)?.map(keyword => {
                                                        return (<ListItem button>
                                                            <ListItemText primary={keyword.Keyword} />
                                                        </ListItem>);
                                                    })}
                                                </List>
                                            </>);
                                        })}
                                    </List>
                                </>);
                            })}
                        </List>
                    </Box>
                </Grid>
            </Grid>
        </Box>
    </>);
}