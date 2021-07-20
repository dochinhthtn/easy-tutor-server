import React, { useState } from 'react';

/**
 *
 * @param {{conversation: Object}} props
 */
export default function SendMessageForm(props) {

    const [messageContent, setMessageContent] = useState('');
    const [isSending, setIsSending] = useState(false);

    const handleSendMessage = async (event) => {
        event.preventDefault();

        if (!props.conversation) {
            return;
        }

        if (messageContent.trim() == '') return;
        setIsSending(true)
        let response = await props.conversation.addMessage({ content: messageContent.trim() });
        console.log(response);

        setMessageContent('');
        setIsSending(false);
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

                <button className="btn btn-primary" disabled={isSending || !props.conversation}>Send</button>
            </div>
        </form>
    );
}
