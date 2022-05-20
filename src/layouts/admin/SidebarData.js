import React from 'react';
import * as FaIcons from "react-icons/fa"
import * as AiIcons from 'react-icons/ai'
import * as BsIcons from 'react-icons/bs'
import * as BiIcons from "react-icons/bi"
export const SidebarData = [{
    title: "Home",
    path: "/",
    icon: <AiIcons.AiFillHome />,
    cName: 'nav-text'
},
{
    title: "Respo filieres",
    path: "/view_respo",
    icon: <BsIcons.BsFillFilePersonFill />,
    cName: 'nav-text'
},
{
    title: "Etudiants",
    path: "/view_etudiants",
    icon: <BsIcons.BsPeopleFill />,
    cName: 'nav-text'
},
{
    title: "Filieres",
    path: "/view_filieres",
    icon: <BiIcons.BiCategoryAlt />,
    cName: 'nav-text'
},

]