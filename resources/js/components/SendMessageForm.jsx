import React, { useState } from 'react';

export default function SendMessageForm(props) {

    const [messageContent, setMessageContent] = useState('');
    const [isSendingMessage, setIsSendingMessage] = useState(false);

    const handleSendMessage = async (event) => {
        event.preventDefault();

        if (!props.conversation) {
            alert("No conversation");
            return;
        }

        if (messageContent.trim() == '') return;
        setIsSendingMessage(true)
        let response = await props.conversation.addMessage({ content: messageContent.trim() });
        console.log(response);

        setMessageContent('');
        setIsSendingMessage(false);
    }

    return (
        <form onSubmit={handleSendMessage}>
            <div className="d-flex">
                <input type="text"
                    className="form-control mr-2"
                    value={messageContent}
                    onChange={(event) => setMessageContent(event.target.value)}
                    placeholder="Enter message"
                />

                <button className="btn btn-primary" disabled={isSendingMessage}>Send</button>
            </div>
        </form>
    );
}