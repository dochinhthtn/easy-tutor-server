import React, { useEffect } from 'react';

import Post from '../models/Post';
import Rate from '../models/Rate';
import Subject from '../models/Subject';

export default function PostScreen() {

    useEffect(() => {
        // Post.withFilter({ address: 'HN', offerMin: 10, subjects: [1, 2, 3, 4] }).get().then((post) => {
        //     console.log(post);
        // });

        // Subject.withSearch('gray').get().then(subject => {
        //     console.log(subject);
        // });

        Rate.forTutor({id: 4}).makeEvaluate({star: 4, comment: 'ok'}).then(rate => {
            console.log(rate);
        });

        // Rate.forTutor({ id: 4 }).get().then(rates => {
        //     console.log(rates);
        // });

    }, [0]);

    return (
        <div>

        </div>
    );
}

