import React, { useEffect } from "react";
import { Link } from "react-router-dom";
import swal from "sweetalert";
import { useState } from "react";
import axios from "axios";
import { Route, useNavigate } from "react-router";
import * as Bs from "react-icons/bs"
import Random from "../../../assets/admin/Random";
 import emailjs from '@emailjs/browser';

const AddRespo = () => {
    useEffect(() => {
        axios.get("/api/getLastId").then(res => {
            if (res.data.status === 200) {
                setUser_id(res.data.user_id['id'])

            }
        })
    }, [])
    const navigate = useNavigate()
    const [nom, setNom] = useState('')
    const [prenom, setPrenom] = useState('')
    const [user_id, setUser_id] = useState('')
    const [login, setLogin] = useState('')
    const [image, setImage] = useState([])
    const [departement, setDepartement] = useState('')
    const [error_list, setError_list] = useState([])
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')

    const handleImage = (e) => {
        setImage({ image: e.target.files[0] })
        setPassword(Random)

    }
    const SubmitRespo = (e) => {
        e.preventDefault()
        const data = new FormData()
        data.append("image", image.image)
        data.append("nom", nom)
        data.append("prenom", prenom)
        data.append("user_id", user_id)
        data.append("login", login)
        data.append("departement", departement)
        const dataUser = {
            "login" : login,
            "email" : email,
            "password" : password,
            "role" : 1
        }
        axios.post("/api/register" ,dataUser).then(res1 => {
            if (res1.data.status === 200){
                axios.post("/api/store_respo", data).then(res => {
                    if (res.data.status === 200) {

                        emailjs.sendForm('service_wusyzdo', 'template_sexuqy9', e.target, 'hFVxbWiMX6RCjK4zS')
                        .then((result) => {
                            console.log(result)
                            navigate("/admin/view_respo")
                            swal("Success", res.data.message, "success")
                            setError_list('/')

                        }, (error) => {
                            console.log(error.text);
                            swal("Success", "responsable added succesfully but email did'nt", "success")
                            setError_list('/')
                            navigate("/admin/view_respo")

                        });
                        
                    }
                    else if (res.data.status === 400) {
                        setError_list(res.data.errors)
                    }
                })
            } 
            else if (res1.data.status === 400) {
                setError_list(res1.data.errors)
            }
        } 
        )
    }


    return (
        <div className="container-fluid px-4">
            <div className="card">
            <div className="card-header "  >
            <h1 className="m-1 p-2"> Add Responsable</h1>
            <Link to="/admin/view_respo" className="btn  btn-small float-end"><Bs.BsReverseBackspaceReverse style={{ fill: "#008080" }} size={25} /></Link>
            </div>
            <div className="card-body">
            <form onSubmit={SubmitRespo}>
                    <div className="form-group m-3">
                            <label>Nom</label>
                            <input type="text" name="name" onChange={e => setNom(e.target.value)} value={nom} className="form-control" />
                            <span style={{ color: "red" }}>{error_list.nom}</span>
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.nom}</span>

                        </div>
                        <div className="form-group m-3">
                            <label>Presnom</label>
                            <input type="text" name="slug" onChange={e => setPrenom(e.target.value)} className="form-control" value={prenom} />
                            <span style={{ color: "red" }}>{error_list.prenom}</span>
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.prenom}</span>

                        </div>
                        <div className="form-group m-3">
                            <label>Login</label>
                            <input type="text" className="form-control" onChange={e => setLogin(e.target.value)} value={login} name="login"/>
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.login}</span>

                        </div>
                        <div className="form-group m-3">
                            <label>Email</label>
                            <input type="text" className="form-control" onChange={e => setEmail(e.target.value)} value={email} name="email"/>
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.email}</span>

                        </div>
                        <div className="form-group m-3">
                            <label>Departement</label>
                            <input type="text" className="form-control" onChange={e => setDepartement(e.target.value)} value={departement} name="depatement"/>
                        </div>
                        <div className="form-group m-3">
                            <label>Image</label>
                            <input type="file" className="form-control" onChange={handleImage} name="image"/>
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.image}</span>

                        </div>
                <span className="text-muted m-3">En creant un responsable d'une filiere on cree aussi un utilisateur avec le login saisi est une mot de passe qui va etre 
                 envoyee automatiquement par un email !!!
                </span>
                <input type="hidden" className="form-control" value={password} name="password"/>

                <button type="submit" className="btn1  p-2 float-end" style={{"width" : "180px"}}  value="Send" >Submit</button>
            </form>
            </div>
            </div>
        </div>
    )
}
export default AddRespo