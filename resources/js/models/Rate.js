import axios from "axios";
import Model from "./Model";

export default class Rate extends Model {

    static tutorId;

    static get apiPath() {
        return this.host + '/api/rate';
    }

    /**
     *
     * @param {{id: String}} tutor
     */
    static forTutor(tutor) {
        this.tutorId = tutor.id;
        return this;
    }

    static async get(page = 1) {
        if (!this.tutorId) this.tutorId = 0;
        let { data } = await axios.get(Rate.apiPath + "/" + this.tutorId + "?page=" + page);
        let rates = data.rates.map(rate => Rate.make(rate));
        rates.avg = data.avg;
        rates.total = data.total;
        return rates;
    }

    /**
     *
     * @param {{star: Number, comment: String}} input
     */
    static async makeEvaluate(input) {
        if (!this.tutorId) this.tutorId = 0;
        let { data } = await axios.post(Rate.apiPath + "/" + this.tutorId, input);
        return Rate.make(data);
    }
}
