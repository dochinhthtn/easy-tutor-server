import React from 'react';
import { Link } from 'react-router-dom';

// let data = [
//     {name: 'Conversation 1', us}
// ];

export default function ConversationContainer(props) {

    let conversation = props.conversation;
    let name = conversation.name ? conversation.name : conversation.users.map(user => user.name).join(',');
    return (
        <div className={"border mb-2 rounded " + ((props.active) ? "bg-light" : "")}>
            <div className="p-2">
                <Link to={"/conversation/" + conversation.id}>{name}</Link>
                <div className="text-muted">{conversation.users.length} users</div>
            </div>
        </div>
    );
}
