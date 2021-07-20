import { get } from "lodash";

export default {
    // host: 'http://127.0.0.1:8000',
    host: 'http://easy-tutor-server.herokuapp.com',
    port: '8000',
    get hostName() {
        return this.host;
    }
}
