import axios from "axios";
import Echo from "./Echo";

import config from "./config";

export default class Auth {
    static currentUser = null;
    static token = '';
    static stateChangedHandlers = [];

    static saveState(currentUser = null, token = '') {
        this.currentUser = currentUser;
        this.token = token;
    
        localStorage.setItem('token', token);
        axios.defaults.headers.common["Authorization"] = token;
        Echo.connector.options.auth.headers["Authorization"] = token;
    
        this.handleStateChanged();
    }

    /**
     * 
     * @param {{email: String, password: String}} loginData 
     * @returns {Object}
     */
    static async login(loginData) {
        let { data } = await axios.post(config.hostName + '/api/auth/login', loginData);
        this.saveState(data.user, data.token);
        return data;
    }

    static async autoLogin() {
        let token = localStorage.getItem('token');
        if (!token) return;
    
        try {
            let { data } = await axios.get(config.hostName + '/api/user/info', {
                headers: {
                    "Authorization": token
                }
            });
            this.saveState(data.user, token);
        } catch (error) {
            console.log(error);
        }
    }

    static async register(registerData) {
        let { data } = await axios.post(config.hostName + '/api/auth/register', registerData);
        return data;
    }

    static logout() {
        this.saveState(null, '');
    }

    static onStateChanged(handler) {
        if (handler instanceof Function) this.stateChangedHandlers.push(handler);
    }

    static handleStateChanged() {
        for (let handler of this.stateChangedHandlers) {
            if (handler instanceof Function) handler(this.currentUser);
        }
    }
}

// const Auth = {
//     currentUser: null,
//     token: '',
//     stateChangedHandlers: []
// };

// Auth.saveState = function (currentUser = null, token = '') {
//     this.currentUser = currentUser;
//     this.token = token;

//     localStorage.setItem('token', token);
//     axios.defaults.headers.common["Authorization"] = token;
//     Echo.connector.options.auth.headers["Authorization"] = token;

//     this.handleStateChanged();
// }

// Auth.login = async function (loginData) {
//     let { data } = await axios.post('/api/auth/login', loginData);
//     this.saveState(data.user, data.token);
//     return data;
// }

// Auth.autoLogin = async function () {
//     let token = localStorage.getItem('token');
//     if (!token) return;

//     try {
//         let { data } = await axios.get('/api/user/info', {
//             headers: {
//                 "Authorization": token
//             }
//         });
//         this.saveState(data.user, token);
//     } catch (error) {
//         console.log(error);
//     }
// }

// Auth.register = async function (registerData) {
//     let { data } = await axios.post('/api/auth/register', registerData);
//     return data;
// }

// Auth.logout = function () {
//     this.saveState(null, '');
// }

// Auth.onStateChanged = function (handler) {
//     if (handler instanceof Function) this.stateChangedHandlers.push(handler);
// }

// Auth.handleStateChanged = function () {
//     for (let handler of this.stateChangedHandlers) {
//         if (handler instanceof Function) handler(this.currentUser);
//     }
// }

// export default Auth;