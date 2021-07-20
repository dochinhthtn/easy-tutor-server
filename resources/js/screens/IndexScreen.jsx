import React, { useEffect, useState } from 'react';
import { Link, Route, Switch } from 'react-router-dom';

import MainMenu from '../components/layout/MainMenu.jsx';
import ConversationScreen from './ConversationScreen.jsx'

export default function IndexScreen() {

    const [data, setData] = useState('');

    return (
        <div>
            <MainMenu />
            <div className="container mt-3">
                <Switch>
                    <Route path="/user"><h1>User page</h1></Route>
                    <Route path="/subject"><h1>Subject page</h1></Route>
                    <Route path="/post"><h1>Post page</h1></Route>
                    <Route path="/conversation/:id?"><ConversationScreen /></Route>
                </Switch>
            </div>
        </div>
    );
}
