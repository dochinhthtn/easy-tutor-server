import React from 'react';
import ConversationContainer from './ConversationContainer';

/**
 *
 * @param {{active: string, conversations: Array}} props
 */
export default function ConversationList(props) {
    let activeId = props.activeId;
    let conversations = props.conversations;

    return (
        <div>
            {
                conversations.map(function (conversation) {
                    return <ConversationContainer
                        conversation={conversation}
                        active={conversation.id == activeId}
                        key={conversation.id}
                    />
                })
            }
        </div>
    );

}
