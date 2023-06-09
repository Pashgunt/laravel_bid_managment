import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../../axios-client";
import Box from '@mui/material/Box';
import { ListSubheader, Skeleton } from "@mui/material";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemText from "@mui/material/ListItemText";

export default function KeywordsPage() {
    const { id } = useParams();
    const [keywords, setAdGroups] = useState(null);

    useEffect(() => {
        axiosClient.get(`/account/information/${id}/keywords`)
            .then(({ data }) => {
                let { keywords } = data;
                if (keywords) {
                    keywords = keywords.result.reduce((accum, sum) => [...accum, sum], [])
                }
                setAdGroups(keywords);
            }).catch((error) => {
            })
    }, []);

    return (<Box mt={2}>
        <List
            width={"100%"}
            component="nav"
            aria-labelledby="nested-list-subheader"
            subheader={
                keywords ? <ListSubheader component="div" id="nested-list-subheader">
                    Древовидная структура всех показателей кампании
                </ListSubheader> : <Skeleton variant="text" sx={{ fontSize: '1rem' }} width={300} />
            }
        >
            <List>
                {keywords ? keywords?.map(keywordItems => {
                    return Object.values(keywordItems)?.map(keyword => {
                        return (<>
                            <ListItem button>
                                <ListItemText primary={keyword.Keyword} />
                            </ListItem>
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