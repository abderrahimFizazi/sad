import axios from "axios";
import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import swal from "sweetalert";
import * as Ai from "react-icons/ai"
import moment from "moment";
const ViewRespo = () => {
    const [respoList, setrespoList] = useState([])
    const [loading, setLoading] = useState(true)
    useEffect(() => {
        axios.get("/api/index_respo").then(res => {
            if (res.data.status === 200) {
                setrespoList(res.data.respo)
                setLoading(false)
            }
        })
    }, [])
    var table_html_respo_filiere
    if (loading) {
        return (
            <h4>Responsables list loading...</h4>
        )
    }
    else {
        table_html_respo_filiere = respoList.reverse().map(item => {
            return (
                <tr key={item.id}>
                    <td className="text-center"> <img src={`http://localhost:8000/${item.image}`} alt={`productimage${item.id}`} width="70px" /></td>
                    <td className="text-center">{item.nom} </td>
                    <td className="text-center">{item.prenom} </td>
                    {item.user ? <td className="text-center">{item.user.login} </td>  : <td></td>}
                    <td className="text-center">{item.departement} </td>

                    <td className="text-center"><Link to={`/admin/update_respo/${item.id}`}><Ai.AiOutlineEdit style={{ fill: "green" }} size={25} /></Link></td>
                    <td className="text-center"><Link to="#" onClick={e => deletReso(e, item.id)} style={{ "textDecoration": "none", "color": "red" }}><Ai.AiFillDelete style={{ fill: "red" }} size={25} /> </Link></td>
                    <td>{moment(item.dateCreated).format('MMMM Do')}</td>

                </tr>
            )
        })
        const deletReso = (e, id) => {
            e.preventDefault()
            const thisClicked = e.currentTarget
            swal(" You really want to delete this post", {
                buttons: {
                    cancel: true,
                    deletReso: true,
                },
            }).then(deletReso => {
                if (deletReso) {
                    thisClicked.innerText = "Deleting..."
                    axios.delete(`/api/destroy_respo/${id}`).then(res => {
                        if (res.data.status === 200) {
                            thisClicked.closest("tr").remove()
                        }
                        else if (res.data.status === 404) {
                            thisClicked.innerText = "Deleting..."
                        }
                    })
                }
            });
        }
    }
    return (
        <div className="container px-4">
            <div className="card mt-4">
                <div className="card-header">
                    <h4>
                        <Link to="/admin/add_respo" className="btn btn-secondary btn-small float-end" >Add Responsable</Link>
                        <div> Responsables des filieres</div>

                    </h4>
                </div>
                <div className="card-body">
                    <table className="table table-bordered  table-hover">
                        <thead>
                            <tr>
                            <th> Image </th>
                                <th>Nom </th>
                                <th>Prenom </th>
                                <th> Login </th>
                                <th>Departement </th>
                                <th> Edit </th>
                                <th> Delete </th>
                                <th> Created date </th>
                            </tr>
                        </thead>
                        <tbody>
                            {table_html_respo_filiere}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    )
}
export default ViewRespo;