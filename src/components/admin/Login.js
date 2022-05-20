import axios from "axios"
import React, { useState } from "react"
import { useNavigate } from "react-router"
import ActivityPic from "../../assets/frontend/pic/ensat.jpg"
import "../../assets/frontend/Login.css"
import { Link } from "react-router-dom"
const Login = () => {
    const [login, setLogin] = useState('')
    const [password, setPassword] = useState('')
    const [error_list, setError_list] = useState([])
    const [invalid, setInvalid] = useState('')
    const navigate = useNavigate()
    const submitLogin = (e) => {
    e.preventDefault();
    const data = {
        login: login,
        password: password
    }
    axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post("/api/login", data).then(res => {
            if (res.data.status === 200) {
                localStorage.setItem("auth_token", res.data.token)
                localStorage.setItem("auth_login", res.data.login)
                localStorage.setItem("role", res.data.role)
                navigate('/admin')
            }
            else if (res.data.status === 401) {
                setError_list(res.data.validation_errors)
            }
            else if (res.data.status === 403) {
                setInvalid(res.data.message)
                setError_list('/')
            }
        })
    })
}

    return (
        <>
        <div className="container-fluid">
		<div className="row main-content bg-success text-center">
			<div className="col-md-4 text-center company__info">
				<span className="company__logo"></span>
			</div>
			<div className="col-md-8 col-xs-12 col-sm-12 login_form ">
				<div className="container-fluid">
					<div className="row">
						<h2>Log In</h2>
					</div>
					<div className="row">
						<form control="" className="form-group" onSubmit={submitLogin}>
                        <div style={{ "color": "red" }}>{invalid}</div>
							<div className="row">
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.login}</span>
								<input type="text" className="form__input" placeholder="Login" value={login} onChange={e => setLogin(e.target.value)} />
                            </div>
							<div className="row">
                            <span className="text-danger fw-light d-flex justify-content-start">{error_list.password}</span>
								<span className="fa fa-lock"></span> 
								<input type="password" className="form__input" placeholder="Password"value={password} onChange={e => setPassword(e.target.value)} />
                            </div>
							<div className="row">
								<label htmlFor="remember_me">Remember Me! <input type="checkbox" />

                                </label>
							</div>
							<div className="row  d-flex justify-content-center">
								<input type="submit" value="Submit" className="btn1 "/>
							</div>
						</form>
					</div>
					<div className="row "  >
						<Link to="#" className="d-flex justify-content-end" >Forgot my password</Link>
					</div>
				</div>
			</div>
		</div>
	</div>

    </>
    

            )
}
export default Login