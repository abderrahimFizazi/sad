import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import * as FaIcons from "react-icons/fa"
import * as AiIcons from 'react-icons/ai'
import { SidebarData } from './SidebarData';
import "../../assets/admin/Navbar.css"
import { IconContext } from "react-icons"
import { Outlet } from "react-router";
import Navbarmenu from './Navbarmenu';

function Navbar() {
    const [sidebar, setSidebar] = useState(false)
    const showSidebar = () => setSidebar(!sidebar);
    
    return (<>
        <IconContext.Provider value={{ color: '#f1f1f1' }} >
            <div className='navbar' >
                <Link to='#' className='menu-bars2' >
                    <FaIcons.FaBars onClick={showSidebar} /> 
                </Link>
                <Navbarmenu/>
            </div>
            <div className='row' >
                <div className={sidebar ? 'col-md-2 ' : ''}>
                    <nav className={sidebar ? 'nav-menu active' : 'nav-menu'} >
                        <ul className='nav-menu-items' >
                            <li className='navbar-toggle' >
                                <Link to='#' className='menu-bars'  >
                                    <AiIcons.AiOutlineClose onClick={showSidebar} />
                                </Link>
                            </li>
                            {SidebarData.map((item, index) => {
                                return (<li key={index} className={item.cName} >
                                    <Link to={"/admin"+ item.path} > {item.icon}
                                        <span className='icons'> {item.title} </span>
                                    </Link>
                                </li>
                                )
                            })
                            } </ul>
                    </nav>
                </div>
                <div className='col mx-2'>
                    <Outlet/>
                </div>
            </div>
        </IconContext.Provider>
    </>
    );
}
export default Navbar;