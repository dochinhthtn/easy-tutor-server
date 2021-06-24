import React, { useState } from 'react';
import { Link, Redirect } from 'react-router-dom';

import Auth from '../models/Auth';

export default function LoginForm() {

    const [data, setData] = useState({
        email: '',
        password: '',
    });

    const [error, setError] = useState({
        email: '',
        password: ''
    });

    const [isLoggedIn, setIsLoggedIn] = useState(false);

    let handler = async (event) => {
        event.preventDefault();

        try {
            await Auth.login(data);
            setError({});
            setIsLoggedIn(true);
        } catch (error) {
            console.log(error.response.data);
            setError(error.response.data);
        }
    }

    return (
        <form onSubmit={handler} className="w-50 border rounded p-4 m-auto mt-3">
            <h2 className="text-center">Login to your account</h2>

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
                    type="password"
                    className="form-control"
                    onChange={event => setData({ ...data, password: event.target.value })}
                    value={data.password}
                    placeholder="Password"
                />
                <div className="text-danger">{error.password}</div>
            </div>

            <button className="btn btn-primary btn-block">Login</button>

            {(error.login) ? <div className="alert alert-danger mt-3">{error.login}</div> : ''}

            <div className="text-muted mt-3 text-center">
                Don't have an account? &nbsp;
                <Link to="/register">Register</Link>
            </div>
        </form>
    );
}