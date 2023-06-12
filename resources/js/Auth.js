import axios from 'axios';
import VueCookies from 'vue-cookies'
class Auth {
    constructor() {
        this.token = VueCookies.get('token');
        let userData = VueCookies.get('user');
        this.user = userData ? userData : null;

        if (this.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        }
    }
    login(token, user) {
        VueCookies.set('user', user)
        VueCookies.set('token', token)
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        this.token = token;
        this.user = user;
    }
    check() {
        return !!this.token;
    }
    logout() {
        VueCookies.remove('user');
        VueCookies.remove('token');
        this.user = null;
        this.token = null;
    }
}
export default new Auth();