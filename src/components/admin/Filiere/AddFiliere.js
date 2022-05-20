import React, { useEffect } from "react";
import { Link } from "react-router-dom";
import swal from "sweetalert";
import { useState } from "react";
import axios from "axios";
import { Route, useNavigate } from "react-router";
import * as Bs from "react-icons/bs"
import "../../../assets/admin/Dropdown.css"

const AddFiliere = () => {
   
    const navigate = useNavigate()
    const [code, setCode] = useState('')
    const [designation, setDesignation] = useState('')
    const [respolist, setRespolist] = useState([])
    const [respo, setRespo] = useState('')
    const [filiere__id, setFilier_id] = useState('')
    const [error_list, setError_list] = useState([])
    const [isOpen, setIsopen] = useState(false)
    const [respoName, setRespoName] = useState('')
    const [loading, setLoading] = useState('')


    useEffect(() => {
        axios.get("/api/index_respo").then(res => {
            if (res.data.status === 200) {
                setRespolist(res.data.respo)
                setLoading(false)
            }
        })
    }, [])

    const Dropdown = () => {
        return (
            <>
                <div
                    className={isOpen ? "dropdown2 active " : "dropdown2"}
                    onClick={() => setIsopen(!isOpen)} >
                    <div className="dropdown2__text">
                        {!respoName ? "Select Responsable*" : respoName}
                    </div>
                    {isOpen ? respolist.map(item => {
                            return (
                                <div className="dropdown2__item" key={item.id} value={item.id} onClick={() => { setRespo(item.id); setRespoName(item.nom + ' ' + item.prenom)}}> {item.nom} {item.prenom}</div>
                            )
                    }) : null
                    }
                </div>
            </>
        )
    }

    const SubmitFiliere = (e) => {
        e.preventDefault()
        const data = new FormData()
        data.append("code", code)
        data.append("designation", designation)
        data.append("id_responsable", respo)


                axios.post("/api/store_filiere", data).then(res => {
                    if (res.data.status === 200) {
                        swal("Success", res.data.message, "success")
                        setError_list('/')
                        navigate("/admin/view_filieres")
                    }
                    else if (res.data.status === 400) {
                        setError_list(res.data.errors)
                    }

        } 
        )
    }


    return (
        <div className="container-fluid px-4">
            <div className="card">
            <div className="card-header "  >
            <h1 className="m-1 p-2"> Add Filiere</h1>
            <Link to="/admin/view_filieres" className="btn  btn-small float-end"><Bs.BsReverseBackspaceReverse style={{ fill: "#008080" }} size={25} /></Link>
            </div>
            <div className="card-body">
            <form onSubmit={SubmitFiliere}>
                    <div className="form-group m-3">
                            <label>Code </label>
                            <input type="text" name="code" onChange={e => setCode(e.target.value)} value={code} className="form-control" />
                            <span style={{ color: "red" }}>{error_list.nom}</span>
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.code}</span>

                        </div>
                        <div className="form-group m-3">
                            <label>Designation </label>
                            <input type="text" name="slug" onChange={e => setDesignation(e.target.value)} className="form-control" value={designation} />
                            <span style={{ color: "red" }}>{error_list.prenom}</span>
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.deignation}</span>

                        </div>
                        <Dropdown/>



                <button type="submit" className="btn1  p-2 float-end" style={{"width" : "180px"}}  value="Send" >Submit</button>
            </form>
            </div>
            </div>
        </div>
    )
}
export default AddFiliere