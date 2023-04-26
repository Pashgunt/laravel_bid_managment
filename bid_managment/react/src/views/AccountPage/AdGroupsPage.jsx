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

export default function AdGroupsPage() {
    const { id } = useParams();
    const [adGroups, setAdGroups] = useState(null);
    const [openAdGroups, setOpenAdGroups] = useState(null);

    useEffect(() => {
        axiosClient.get(`/account/information/${id}/adgroups`)
            .then(({ data }) => {
                let { adGroups } = data;
                if (adGroups) {
                    adGroups = adGroups.result.reduce((accum, sum) => [...accum, sum], [])
                }
                setAdGroups(adGroups);
            }).catch((error) => {
            })
    }, []);

    return (<Box mt={2}>
        <List
            width={"100%"}
            component="nav"
            aria-labelledby="nested-list-subheader"
            subheader={
                adGroups ? <ListSubheader component="div" id="nested-list-subheader">
                    Древовидная структура всех показателей кампании
                </ListSubheader> : <Skeleton variant="text" sx={{ fontSize: '1rem' }} width={300} />
            }
        >
            <List>
                {adGroups ? adGroups?.map(adGroupItems => {
                    return Object.values(adGroupItems)?.map(adGroup => {
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
                    })
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
        </List>
    </Box>);
}