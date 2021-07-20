import axios from "axios";
import Model from "./Model";

export default class Subject extends Model {

    static extendedQuery;

    static get apiPath() {
        return this.host + '/api/subject';
    }

    static withSearch(keyword) {
        this.extendedQuery = 'keyword=' + keyword;
        return this;
    }

    static async get(page = 1) {
        let { data } = await axios.get(Subject.apiPath + '?page=' + page + ((this.extendedQuery) ? '&' + this.extendedQuery : ''));
        console.log(Subject.apiPath + '?page=' + page + ((this.extendedQuery) ? '&' + this.extendedQuery : ''));
        return data.subjects.map(subject => Subject.make(subject));
    }
}
