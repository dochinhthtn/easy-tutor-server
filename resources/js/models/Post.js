import axios from "axios";

import Echo from "./Echo";
import Model from "./Model";
import User from './User';

export default class Post extends Model {
    static extendedQuery;

    static get apiPath() {
        return this.host + "/api/post";
    }

    /**
     *
     * @param {{
        * address: String,
        * minOffer: Number,
        * maxOffer: Number,
        * subjects: Array<String>
        * hasApplicant: Boolean
     * }} filter
     */
    static withFilter(filter) {
        let queryArr = [];
        for(let key in filter) {
            queryArr.push(key + '=' + filter[key]);
        }
        this.extendedQuery = queryArr.join('&');
        console.log(this.extendedQuery);
        return this;
    }

    static async get(mode = 'all', page = 1) {
        let actions = {
            'all': '/',
            'recommended': '/recommended',
            'own': '/own'
        };

        let { data } = await axios.get(Post.apiPath + actions[mode] + "?page=" + page + ((this.extendedQuery) ? '&' + this.extendedQuery : ''));
        return data.posts.map(post => Post.make(post));
    }

    /**
     *
     * @param {} user
     * @returns {Object}
     */
    async addApplicant(user) {
        if (!this.id) throw new Error('Invalid id');
        let { data } = await axios.post(`${Post.apiPath}/${this.id}/applicant`, {
            userId: user.id
        });
        return data;
    }

    async setTutor(user = null) {
        if (!this.id) throw new Error('Invalid id');
        let { data } = await axios.post(`${Post.apiPath}/${this.id}/tutor`, {
            action: (user) ? 'accept' : 'decline',
            userId: (user) ? user.id : null
        });

        return data;
    }

    onNewApplicant(callback) {
        Echo.private("post." + this.id).listen(".new-applicant", function (event) {
            callback({
                post: Post.make(event.post),
                applicant: User.make(event.applicant)
            });
        });
    }

}
