import React, { useEffect } from 'react';

import Post from '../models/Post';
import Subject from '../models/Subject';

export default function PostScreen() {

    useEffect(() => {
        Post.withFilter({address: 'HN', offerMin: 10, subjects: [1,2,3,4]}).get().then((post) => {
            console.log(post);
        });

        Subject.withSearch('gray').get().then((subject) => {
            console.log(subject);
        });

    }, [0]);


    return (
        <div>

        </div>
    );
}

