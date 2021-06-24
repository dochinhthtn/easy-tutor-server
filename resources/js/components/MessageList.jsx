import React from 'react';

import MessageContainer from './MessageContainer';

/**
 * 
 * @param {{messages: Array<{content: string, userId: string}>, currentUser: {id: string}}} props 
 */
export default function MessageList(props) {
    // console.log(props.messages);
    return (
        <div className="p-3">
            {
                props.messages.slice(0).reverse().map(function (message) {
                    return <MessageContainer
                        key = {message.id}
                        content={message.content}
                        owned={message.userId == props.currentUser.id}
                    />
                })
            }
        </div>
    );
}