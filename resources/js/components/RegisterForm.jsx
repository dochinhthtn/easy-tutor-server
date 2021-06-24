import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';

import Auth from '../models/Auth';

export default function RegisterForm() {

    const [data, setData] = useState({
        name: '',
        email: '',
        phoneNumber: '',
        password: '',
        passwordConfirmation: '',
        isTutor: false,
    });

    const [error, setError] = useState({
        name: '',
        email: '',
        phoneNumber: '',
        password: '',
        passwordConfirmation: '',
    });

    const [success, setSuccess] = useState(false);

    let handler = async (event) => {
        event.preventDefault();

        try {
            await Auth.register(data);
            setError({});
            setSuccess(true);
        } catch (error) {
            console.log(error.response.data);
            setError(error.response.data);
        }
    }

    return (
        <form onSubmit={handler} className="w-50 border rounded p-4 m-auto mt-3">
            <h2 className="text-center">Create an account</h2>
            <div className="form-group">
                <input
                    type="text"
                    className="form-control"
                    onChange={event => setData({ ...data, name: event.target.value })}
                    value={data.name}
                    placeholder="Name"
                />
                <div className="text-danger">{error.name}</div>
            </div>

            <div className="form-group">
                <input
                    type="text"
                    className="form-control"
                    onChange={event => setData({ ...data, email: event.target.value })}
                    value={data.email}
                    placeholder="Email"
                />
                <div className="text-danger">{error.email}</div>
            </div>

            <div className="form-group">
                <input
                    type="tel"
                    className="form-control"
                    onChange={event => setData({ ...data, phoneNumber: event.target.value })}
                    value={data.phoneNumber}
                    placeholder="Phone number"
                />
                <div className="text-danger">{error.phoneNumber}</div>
            </div>

            <div className="form-group">
                <input
                    type="password"
                    className="form-control"
                    onChange={event => setData({ ...data, password: event.target.value })}
                    value={data.password}
                    placeholder="Password"
                />
                <div className="text-danger">{error.password}</div>
            </div>

            <div className="form-group">
                <input
                    type="password"
                    className="form-control"
                    onChange={event => setData({ ...data, passwordConfirmation: event.target.value })}
                    value={data.passwordConfirmation}
                    placeholder="Password confirmation"
                />
                <div className="text-danger">{error.passwordConfirmation}</div>
            </div>



            <div className="form-group">
                <input
                    type="checkbox"
                    onChange={event => setData({ ...data, isTutor: event.target.checked })}
                    checked={data.isTutor}
                />
                <label>&nbsp;I'm a tutor</label>
            </div>


            <button className="btn btn-primary btn-block">Register</button>

            {(success) ? <div className="alert alert-success mt-3">Register successfully</div> : ''}

            <div className="text-muted mt-3 text-center">
                Already have an account? &nbsp;
                <Link to="/login">Login</Link>
            </div>
        </form>
    );
}