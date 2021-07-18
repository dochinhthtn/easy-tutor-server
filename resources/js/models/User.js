import Model from "./Model";

export default class User extends Model{
    /**
     * @override
     */
    static get apiPath() {
        return this.host + '/api/user'
    }
}