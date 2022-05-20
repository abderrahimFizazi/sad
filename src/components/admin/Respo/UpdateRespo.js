import React, { useEffect } from "react";
import { Link } from "react-router-dom";
import swal from "sweetalert";
import { useState } from "react";
import axios from "axios";
import { Route, useNavigate } from "react-router";
import * as Bs from "react-icons/bs"
import { useParams } from "react-router-dom";
const UpdateRespo = () => {
    const [nom, setNom] = useState('')
    const [prenom, setPrenom] = useState('')
    const [departement, setDepartement] = useState('')
    const [loading, setLoading] = useState(true)
    const [error_list, setError_list] = useState([])
    const {id} = useParams()
    const navigate = useNavigate()

    useEffect(()=>{

        axios.get(`/api/edit_respo/${id}`).then(res => {
            if(res.data.status === 200 ){
                setNom(res.data.respo.nom)
                setPrenom(res.data.respo.prenom)
                setDepartement(res.data.respo.departement)
            }
            else if( res.data.status === 422 ){
                swal("Error" , res.data.message , "error")
                navigate("/admin/view_respo")
            }
            setLoading(false)
        })
    },[id])
  

    const SubmitRespo = (e) => {
        e.preventDefault()
        const data = {
            nom : nom,
            prenom : prenom,
            departement:departement,
        }
        axios.put(`/api/update_respo/${id}`, data).then(res => {
            if(res.data.status === 200 ){
                swal("Success",res.data.message,"success")
                navigate("/admin/view_respo")
            }
            else if(res.data.status === 400){
                setError_list(res.data.errors)
            }
        })
    }

    if (loading) {
        return (
            <h4>Responsables infos loading...</h4>
        )
    }
    return (
        <div className="container-fluid px-4">
            <div className="card">
                <div className="card-header "  >
                    <h1 className="m-1 p-2"> Edit Responsable</h1>
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
                            <label>Departement</label>
                            <input type="text" className="form-control" onChange={e => setDepartement(e.target.value)} value={departement} name="depatement" />
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.departement}</span>

                        </div>

                        <button type="submit" className="btn1  p-2 float-end" style={{ "width": "180px" }} value="Send" >Submit</button>
                    </form>
                </div>
            </div>
        </div>
    )
}
export default UpdateRespo