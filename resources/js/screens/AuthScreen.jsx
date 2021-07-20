import React from 'react';
import { Switch, Route } from 'react-router-dom';

import LoginForm from '../components/auth/LoginForm.jsx';
import RegisterForm from '../components/auth/RegisterForm.jsx';

export default function AuthScreen(props) {
    return (
        <Switch>
            <Route path="/register" component={RegisterForm} exact/>
            <Route path="/" component={LoginForm} />
        </Switch>
    );
}
