import React, { useEffect, useState } from 'react';
import { Redirect, useParams } from 'react-router-dom';

import ConversationContainer from '../components/ConversationContainer';
import ConversationList from '../components/ConversationList';
import MessageContainer from '../components/MessageContainer';
import MessageList from '../components/MessageList';
import SendMessageForm from '../components/SendMessageForm';
import Auth from '../models/Auth';

import Conversation from '../models/Conversation';

export default function ChatScreen(props) {

    const currentUser = Auth.currentUser;
    const params = useParams();
    const [conversations, setConversations] = useState([]);
    const [currentConversation, setCurrentConversation] = useState(null);

    useEffect(() => {

        Conversation.get().then((data) => {
            data.forEach(item => { item.listening = false });
            setConversations(data);
        });

    }, [0]);

    useEffect(() => {
        if(!currentConversation) return;

        for (let conversation of conversations) {
            if(conversation.id == params.id) {
                setCurrentConversation(conversation);
                setCurrentMessages(conversation.messages);
            }

            if (conversation.listening) continue;
            conversation.listening = true;
            conversation.loadMessages();
            conversation.onNewMessage((message, c) => {
                if (currentConversation.id == conversation.id) {
                    setCurrentConversation(conversation);
                    setCurrentMessages(conversation.messages);
                }
                console.log(c);
                console.log(conversation);
            });
        }
    }, [conversations, params]);

    console.log(currentMessages);



    return (
        <div className="chat-screen" style={{ height: "500px" }}>
            <h2>Chat screen</h2>
            <div className="d-flex h-100 w-75 m-auto">
                <div className="w-25 p-2" style={{ height: "100%", overflowY: "scroll" }}>
                    <ConversationList conversations={conversations} activeId={params.id} />
                </div>

                <div className="w-75 p-2 d-flex flex-column justify-content-between">
                    <div style={{ height: "calc(100% - 45px)", overflowY: "scroll" }} className="border rounded">
                        <MessageList messages={currentMessages} currentUser={currentUser} />
                    </div>
                    <SendMessageForm conversation={currentConversation || null} />
                </div>
            </div>
        </div>
    );
}