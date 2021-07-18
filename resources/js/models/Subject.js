import axios from "axios";
import Model from "./Model";

export default class Subject extends Model {
    static apiPath() {
        return this.host + '/api/subject';
    }

    static async get(page = 1) {
        let { data } = await axios.get(Subject.apiPath + '?page=' + page);
        return data.subjects.map(subject => Subject.make(subject));
    }

    static async search(keyword) {
        let { data } = await axios.get(Subject.apiPath + '/find/' + keyword + '?page=' + page);
        return data.subjects.map(subject => Subject.make(subject));
    }
}