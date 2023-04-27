import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import Box from '@mui/material/Box';
import { ListSubheader, Skeleton } from "@mui/material";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemText from "@mui/material/ListItemText";
import ExpandLessIcon from '@mui/icons-material/ExpandLess';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';

export default function AccountPage() {
    const { id } = useParams();
    const [compaigns, setCompaigns] = useState(null);
    const [openCampaign, setOpenCampaign] = useState(null);
    const [openAdGroups, setOpenAdGroups] = useState(null);

    useEffect(() => {
        axiosClient.get(`/account/information/${id}`)
            .then(({ data }) => {
                const { compaigns } = data;
                console.log(compaigns);
                setCompaigns(compaigns);
            }).catch((error) => {
            })
    }, [id]);

    return (<Box mt={2}>
        <List
            width={"100%"}
            component="nav"
            aria-labelledby="nested-list-subheader"
            subheader={
                compaigns ? <ListSubheader component="div" id="nested-list-subheader">
                    Древовидная структура всех показателей кампании
                </ListSubheader> : <Skeleton variant="text" sx={{ fontSize: '1rem' }} width={300} />
            }
        >
            {compaigns ? Object.values(compaigns.result)?.map(campaign => {
                return (<>
                    <ListItem button onClick={() => (openCampaign && openCampaign === campaign.Id) ? setOpenCampaign(null) : setOpenCampaign(campaign.Id)}>
                        <Box width={"100%"}>
                            <div>№{campaign.Id} от {campaign.StartDate}</div>
                            <Box>
                                <div>{campaign.Name}</div>
                            </Box>
                        </Box>
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
            }) : <>
                <Skeleton variant="rounded" width={"100%"} height={50} animation="wave" sx={{
                    mt: 3,
                    mb: 1
                }} />
                <Skeleton variant="rounded" width={"100%"} height={50} animation="wave" sx={{
                    mb: 1
                }} />
                <Skeleton variant="rounded" width={"100%"} height={50} animation="wave" />
            </>}
        </List>
    </Box>);
}