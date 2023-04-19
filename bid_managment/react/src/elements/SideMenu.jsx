import React, { useState } from "react";
import IconButton from "@mui/material/IconButton";
import MenuIcon from "@mui/icons-material/Menu";
import Box from "@mui/material/Box";
import Drawer from "@mui/material/Drawer";
import CloseIcon from "@mui/icons-material/Close";
import { useStateContext } from "../contexts/ContextProvider";
import DefaultMenu from "./DefaultMenu";
import GuestMenu from "./GuestMenu";
export default function SideMenu({ position }) {
  const [open, setState] = useState(false);
  const toggleDrawer = (open) => (event) => {
    if (
      event.type === "keydown" &&
      (event.key === "Tab" || event.key === "Shift")
    ) {
      return;
    }
    setState(open);
  };

  const { user, token } = useStateContext();

  return (
    <Box sx={{
      zIndex: 'modal',
      position: position
    }}>
      <IconButton
        edge="start"
        color="inherit"
        aria-label="open drawer"
        onClick={toggleDrawer(true)}
        sx={{
          background: 'rgba(255,255,255,.3)',
          margin: "10px"
        }}
        p={2}
      >
        <MenuIcon fontSize="large" />
      </IconButton>

      <Drawer
        anchor="left"
        open={open}
        onClose={toggleDrawer(false)}
        onOpen={toggleDrawer(true)}
        sx={{
          zIndex: 'tooltip',
        }}
      >
        <Box sx={{
          width: "300px"
        }}>
          <IconButton sx={{
            margin: '10px',
          }}>
            <CloseIcon onClick={toggleDrawer(false)} fontSize='large' />
          </IconButton>
          {!token ? <DefaultMenu /> : <GuestMenu />}
        </Box>
      </Drawer>
    </Box>
  );
}
