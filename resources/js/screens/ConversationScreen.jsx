import React, { useEffect, useState } from 'react';
import { Redirect, useParams } from 'react-router-dom';

import ConversationList from '../components/conversation/ConversationList.jsx';
import MessageList from '../components/conversation/MessageList.jsx';
import SendMessageForm from '../components/conversation/SendMessageForm.jsx';

import Auth from '../models/Auth';
import Conversation from '../models/Conversation';

export default function ChatScreen(props) {

    const currentUser = Auth.currentUser;

    const [conversations, setConversations] = useState([]);
    const [currentConversation, setCurrentConversation] = useState(null);
    const [messages, setMessages] = useState([]);

    let { id } = useParams();

    useEffect(() => {
        Conversation.get().then((conversations) => {
            (async () => {
                for (let conversation of conversations) {
                    conversation.onNewMessage((data) => {
                        if (conversation.id == id) {
                            setCurrentConversation(Object.assign(new Conversation(), conversation));
                        }
                    });
                    await conversation.loadMessages();
                }
                setConversations(conversations);
            })();
        });
    }, [0]);

    useEffect(() => {

        if (!id || conversations.length == 0) {
            setCurrentConversation(null);
            return;
        }

        (async () => {
            let conversation = conversations.find(item => item.id == id);
            setCurrentConversation(conversation);
        })();

    }, [id, conversations]);

    useEffect(() => {
        if (!currentConversation) return;
        setMessages(currentConversation.messages);
    }, [currentConversation]);


    return (
        <div className="chat-screen row" style={{ height: "500px" }}>
            <div className="col-sm-4">
                <ConversationList conversations={conversations} activeId={id} />
            </div>

            <div className="col-sm-8">
                <div style={{ height: 'calc(500px - 50px)', overflowY: 'scroll', marginBottom: '10px' }}>
                    <MessageList messages={messages} currentUser={currentUser} />
                </div>
                <SendMessageForm conversation={currentConversation} />
            </div>
        </div>
    );
}
