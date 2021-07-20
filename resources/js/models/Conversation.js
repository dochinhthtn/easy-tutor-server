import axios from "axios";

import Model from "./Model";
import Echo from "./Echo";

export default class Conversation extends Model {
    static get apiPath() {
        return this.host + '/api/conversation'
    }

    static async get(page = 1) {
        let { data } = await axios.get(Conversation.apiPath + '?page=' + page);
        return data.conversations.map(conversation => Conversation.make(conversation));
    }

    async loadMessages(page = 1) {
        if (!this.messages) this.messages = [];
        let { data } = await axios.get(Conversation.apiPath + '/' + this.id + '/message?page=' + page);
        for (let message of data.messages) {
            if (this.messages.find(msg => msg.id == message.id)) continue;
            this.messages.push(message);
        }

        return this.messages;
    }

    async addMessage(input) {
        if (!this.id) throw new Error('Invalid id');
        let { data } = await axios.post(Conversation.apiPath + '/' + this.id + '/message', input);
        return data;
    }

    onNewMessage(callback) {
        if (!this.id) throw new Error('Invalid id');
        Echo.private('conversation.' + this.id).listen('.new-message', (event) => {
            this.messages.unshift(event.message);
            callback(event.message, this);
        });
    }

    static onNewConversation(callback) {
        Echo.private('conversation').listen('.new-conversation', (event) => {
            callback(Conversation.make(event.conversation));
        });
    }
}
