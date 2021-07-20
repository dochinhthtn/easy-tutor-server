import React, { useEffect, useState } from 'react';
import { BrowserRouter, Redirect, Route, Switch } from 'react-router-dom';
import Auth from './models/Auth';

import AuthScreen from './screens/AuthScreen';
import ChatScreen from './screens/ConversationScreen';
import IndexScreen from './screens/IndexScreen';

export default function App(props) {

    const [isLoggedIn, setIsLoggedIn] = useState(false);

    useEffect(() => {
        Auth.onStateChanged((user) => {
            setIsLoggedIn(user != null);
        });
    }, [0]);

    return (
        <BrowserRouter>
            {
                (!isLoggedIn)
                    ? <Route path="/" component={AuthScreen} />
                    : <Route path="/" component={IndexScreen} />

            }
        </BrowserRouter>
    );
}
