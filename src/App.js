// App.js
import * as React from "react";
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle'
import { Routes, Route, Link ,BrowserRouter} from "react-router-dom";
import Dashboard from "./components/admin/Dahboard";
import Login from "./components/admin/Login";
import axios from 'axios'
import Navbar from "./layouts/admin/Masterlayout";
import Adminprivateroute from "./Adminprivateroute";
import { Navigate } from "react-router";
import ViewRespo from "./components/admin/Respo/ViewRespo";
import AddRespo from "./components/admin/Respo/AddRespo";
import UpdateRespo from "./components/admin/Respo/UpdateRespo";
import ViewFiliere from "./components/admin/Filiere/ViewFiliere";
import AddFiliere from "./components/admin/Filiere/AddFiliere";
axios.defaults.baseURL = "http://localhost:8000/"
axios.defaults.headers.post["Accept"] = "application/json"
axios.defaults.headers.post["Content-Type"] = "application/json"
axios.defaults.withCredentials = true;
axios.interceptors.request.use(function (config) {
    const token = localStorage.getItem("auth_token")
    config.headers.Authorization = token ? `Bearer ${token}` : '';
    return config;
})


function App() {
    const userState = localStorage.getItem("role")
    var auth = ''
    
    if( userState === "Admin"){
        auth = "/admin"
    }
    if(userState  === "Delegate"){
        auth = '/delegate'
    }
    if(userState === "User"){
        auth = "/documents"
    }
  return (
  
      <BrowserRouter>
      <Routes>
      <Route path="login" element={auth ? <Navigate replace to={auth}  />  : <Login/>} />
        <Route path="admin" element={<Adminprivateroute/>} >
    
        <Route path="" element={<Dashboard />} />
        <Route path="view_respo" element={<ViewRespo/>}/>
        <Route path="add_respo" element={<AddRespo/>}/>
        <Route path="update_respo/:id" element={<UpdateRespo/>}/>

        <Route path="view_filieres" element={<ViewFiliere/>}/>
        <Route path="add_filiere" element={<AddFiliere/>}/>

        </Route>
      </Routes>
      </BrowserRouter>
  );
}

export default App;