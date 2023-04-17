import React, { useState } from "react";
import IconButton from "@mui/material/IconButton";
import MenuIcon from "@mui/icons-material/Menu";
import Box from "@mui/material/Box";
import Drawer from "@mui/material/Drawer";
import CloseIcon from "@mui/icons-material/Close";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import HomeIcon from '@mui/icons-material/Home';
import InputIcon from '@mui/icons-material/Input';
import HowToRegIcon from '@mui/icons-material/HowToReg';

export default function SideMenu() {
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

  return (
    <Box sx={{
      zIndex: 'modal',
      position: "fixed"
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
          <Box sx={{ mb: 2 }}>
            <ListItemButton>
              <ListItemIcon>
                <HomeIcon sx={{ color: "primary.black" }} fontSize="large" />
              </ListItemIcon>
              <ListItemText primary="Main" />
            </ListItemButton>
            <ListItemButton>
              <ListItemIcon>
                <HowToRegIcon sx={{ color: "primary.black" }} fontSize='large' />
              </ListItemIcon>
              <ListItemText primary="SignUp" />
            </ListItemButton>
            <ListItemButton>
              <ListItemIcon>
                <InputIcon sx={{ color: "primary.black" }} fontSize='large' />
              </ListItemIcon>
              <ListItemText primary="Login" />
            </ListItemButton>
          </Box>
        </Box>
      </Drawer>
    </Box>
  );
}
