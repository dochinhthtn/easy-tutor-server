import axios from "axios";
import config from "./config";

export default class Model {
    static host = config.hostName;

    get wrapper() {
        return this.constructor.name.toLowerCase();
    }

    static get apiPath() {
        return this.host + "/api/model";
    }

    static async create(input) {
        let { data } = await axios.post(this.apiPath, input);
        return this.make(data);
    }

    async update(input) {
        if (!this.id) throw new Error('Invalid id');
        let { data } = await axios.put(this.apiPath + '/' + this.id, input);
        this.setData(input);
    }

    static async get(page = 1) {
        let { data } = await axios.get(this.apiPath + '?page=' + page);
        return data;
    }

    static async find(id) {
        if (!id) throw new Error('Invalid id');
        let { data } = await axios.get(this.apiPath + '/' + id);
        return this.make(data);
    }

    static make(data) {
        if (!data) return null;
        let model = new this();
        model.setData(data);

        return model;
    }

    setData(data) {
        if (data[this.wrapper]) {
            data = data[this.wrapper];
        }
        
        for (let field in data) {
            this[field] = data[field];
        }
    }
}