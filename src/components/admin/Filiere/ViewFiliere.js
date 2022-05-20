import axios from "axios";
import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import swal from "sweetalert";
import * as Ai from "react-icons/ai"
import moment from "moment";
const ViewFiliere = () => {
    const [filiereList, setfiliereList] = useState([])
    const [loading, setLoading] = useState(true)
    useEffect(() => {
        axios.get("/api/index_filiere").then(res => {
            if (res.data.status === 200) {
                setfiliereList(res.data.filiere)
                setLoading(false)
            }
        })
    }, [])
    var table_html_filiere_list
    if (loading) {
        return (
            <h4>Filieres list loading...</h4>
        )
    }
    else {
        table_html_filiere_list = filiereList.reverse().map(item => {
            return (
                <tr key={item.id}>
                    <td className="text-center">{item.code} </td>
                    <td className="text-center">{item.designation} </td>
                    {item.user ? <td className="text-center">{item.user.nom} {item.user.prenom} </td>  : <td></td>}
                    <td className="text-center"><Link to={`/admin/update_filiere/${item.id}`}><Ai.AiOutlineEdit style={{ fill: "green" }} size={25} /></Link></td>
                    <td className="text-center"><Link to="#" onClick={e => DeleteFiliere(e, item.id)} style={{ "textDecoration": "none", "color": "red" }}><Ai.AiFillDelete style={{ fill: "red" }} size={25} /> </Link></td>
                    <td>{moment(item.dateCreated).format('MMMM Do')}</td>

                </tr>
            )
        })
        const DeleteFiliere = (e, id) => {
            e.preventDefault()
            const thisClicked = e.currentTarget
            swal(" You really want to delete this post", {
                buttons: {
                    cancel: true,
                    DeleteFiliere: true,
                },
            }).then(DeleteFiliere => {
                if (DeleteFiliere) {
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
                        <Link to="/admin/add_filiere" className="btn btn-secondary btn-small float-end" >Add Filiere</Link>
                        <div> Les filieres</div>

                    </h4>
                </div>
                <div className="card-body">
                    <table className="table table-bordered  table-hover">
                        <thead>
                            <tr>
                            <th> Code </th>
                                <th>Designation </th>
                                <th>Responsable </th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Date created</th>
                            </tr>
                        </thead>
                        <tbody>
                            {table_html_filiere_list}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    )
}
export default ViewFiliere;