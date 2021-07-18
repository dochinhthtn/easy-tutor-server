import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import Conversation from '../models/conversation';
import Post from '../models/Post';

export default function IndexScreen() {

    const [data, setData] = useState('');

    return (
        <div>
            <Link to="/chat/0">Conversations</Link>
            <br />
            <Link to="/chat/0">Post</Link>
        </div>
    );
}