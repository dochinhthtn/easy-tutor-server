import React from 'react';
import { Link } from 'react-router-dom';

export default function MainMenu() {

    return (
        <nav className="navbar navbar-expand-sm navbar-light bg-light">
            <div className="container">
                <a href="/" className="navbar-brand">Easy tutor test</a>
                <div className="navbar-nav ml-auto">
                    <Link to="/user" className="navbar-item nav-link">Users</Link>
                    <Link to="/subject" className="navbar-item nav-link">Subjects</Link>
                    <Link to="/post" className="navbar-item nav-link">Posts</Link>
                    <Link to="/conversation" className="navbar-item nav-link">Conversations</Link>
                </div>
            </div>
        </nav>
    );
}
